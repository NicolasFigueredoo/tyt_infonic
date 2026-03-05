export const required = (value) => {

    // si es null, false, undefined, devuelve false
    if (value) {
        return false;
    }

    // si el largo es 0, devuelve false
    if (value.length > 0) {
        return false;
    }

    // si no es ninguno de los anteriores, devuelve el mensaje
    return 'Este campo es requerido';
}

export const email = (value) => {
    // si el null, false, undefined, devuelve true, ya que no puedo validarlo
    // no puedo obligar a que ingrese un email
    // debo validar que el valor sea un email
    if ( !value || value.length === 0 ) {
        return false;
    }

    // Defino la expresion regular para validar un email
    const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (regex.test(value)) {
        return false;
    }

    return 'Este campo debe ser un email válido';
}


export const validate = (form, validations, errors) => {
    let valid = true;
    Object.keys(validations).forEach((key) => {
        errors[key].splice(0, errors[key].length);
        validations[key].forEach((validation) => {
            const error = validation(form[key]);
            if (error) {
                errors[key].push(error);
                valid = false;
            }
        });
    });
    return valid;
}