<style>
    .filtro_banner:before {
        content: "";
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 45px;
        background: #1F3041;
        width: 100%;
        height: 100%;
        opacity: 0.6;
        top: 0;
        position: absolute;
    }

    td {
        border-top: 1px solid #ddd !important;
        border-bottom: 1px solid #ddd !important;
    }

    .box {
        width: 100%;
        padding: 2em;
        text-align: center;
    }

    .form-check-input:checked {
        background-color: #0E7D4A;
        border-color: #0E7D4A;
    }

    .envio .card {
        border: 1px solid #ccc;
    }

    /* Definir el estilo de borde para la clase card cuando el radio está activado */
    .inputRadio.border-selected {
        border-left: 5px solid #0E7D4A !important;
    }
</style>

<form method="POST" id="formCarrito" enctype="multipart/form-data">
    @csrf
    <div class="d-flex flex-column justify-content-center align-items-center col-12 producto_container mt-4">
        <div class="box_container  d-flex justify-content-between align-items-center flex-wrap flex-row my-2">
            <span style="font-size: 24px;font-weight:500;">Seleccione direcci&oacute;n env&iacute;o</span>
        </div>
        <div
            class="box_container d-flex flex-column flex-md-row justify-content-between align-items-start container-fluid">
            <div class="envio col-6 row">
                <div class="inputRadio card mb-2">
                    <div class="card-body">
                        <div class="form-check d-flex align-items-center">
                            <input onchange="handleRadioClick(this)" class="me-2 form-check-input" checked
                                type="radio" name="envio" id="envio1"
                                value="{{ Auth::guard('cliente')->user()->direccionEntrega }}">
                            <label class="form-check-label" for="envio1">
                                <span>Direccion de entrega</span><br>
                                <span>CUIT / CUIL: {{ Auth::guard('cliente')->user()->cuit }}</span><br>
                                <span>{{ Auth::guard('cliente')->user()->direccionEntrega }}</span>
                            </label>
                        </div>
                    </div>
                </div>



                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar direccion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" id="newAdrres" placeholder="Agregar direccion"
                                    class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button class="btn" type="button" style="width: auto;color: #0E7D4A;"
                                    onclick="clone()">Añadir</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button trigger modal -->
                <button type="button" style="width: auto;color: #0E7D4A;" class="btn" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    + Añadir direcci&oacute;n
                </button>

                <div class="inputRadio card my-2">
                    <div class="card-body">
                        <div class="form-check d-flex align-items-center">
                            <input onchange="handleRadioClick(this)" class="me-2 form-check-input"
                                value="Retiro en el local" type="radio" name="envio" id="envio2">
                            <label class="form-check-label" for="envio2">
                                <span>Retiro por el local</span><br>
                                <span style="color:red;">Una vez confirmado el pedido</span><br>
                                <span>{{ $contactos[0]->direccion }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <span class="pt-2" style="font-size: 24px;font-weight:500;padding: 0;">Observaci&oacute;n sobre el
                    pedido</span>

                <textarea class="form-control" name="observacion" id="observacion"></textarea>
            </div>
            <div class="d-flex flex-column justify-content-center col-6">
                <div class="col-12 box-carrito d-flex flex-column">
                </div>
                <div class="col-12 d-flex flex-column ps-0 ps-md-4">
                    <div style="border-bottom:1px solid #ddd;">
                        <div class="w-100 d-flex justify-content-between p-2">
                            <span style="font-weight:bold">Subtotal</span><span style="font-weight:bold"
                                id="subtotal"></span>
                        </div>
                    </div>
                    <div class="py-4">
                        * Una vez que confirmemos el stock de los productos se te enviara un mail con la factura para
                        proceder a
                        hacer el pago.
                    </div>
                    <br>
                    <div>
                        Cuando realice el pago recuerde informarlo enviándonos un comprobante. Puede informar el pago
                        por
                        WhatsApp al 54 11 48895965

                    </div>
                </div>

            </div>

        </div>
        <div class="d-flex flex-row justify-content-between my-4 box_container">
            <button
                style="border:1px solid #0E7D4A;color:#0E7D4A;font-size:13px;font-weight: bold;width: 163px;border-radius:35px;width:216px;"
                onclick="window.location='{{ route('page.productosCategorias') }}'" class="btn me-4"
                type="button"><b>Volver</b></button>
            <button type="button" onclick="enviar()" class="btn  px-md-3 rounded-pill"
                style="width: 168px;border-radius: 35px!important;background-color: #0E7D4A;color:white;width:216px;font-weight: bold;">
                Enviar
            </button>            
        </div>
    </div>


</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!--Alertify-->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    window.onload = function() {
        // Establecer el borde en el elemento inicialmente seleccionado
        const selectedRadio = document.querySelector('input[name="envio"]:checked');
        if (selectedRadio) {
            const card = selectedRadio.closest('.inputRadio');
            card.classList.add('border-selected');
        }
    }

    function handleRadioClick(radio) {
        var cards = document.querySelectorAll('.inputRadio');
        for (var i = 0; i < cards.length; i++) {
            console.log(cards[i].classList)
            cards[i].classList.remove('border-selected');
        }
        // Obtener el elemento padre div.card
        const card = radio.closest('.inputRadio');

        if (radio.checked) {
            // Agregar la clase adicional para el borde
            card.classList.add('border-selected');
        }
    }

    function clone() {
        let direccion = document.querySelector('#newAdrres').value;

        const button = document.querySelector("button[data-bs-target='#exampleModal']");
        // crear un nuevo elemento div
        const newDiv = document.createElement('div');
        newDiv.classList.add('inputRadio', 'card', 'my-2');

        // agregar el contenido dentro del div
        newDiv.innerHTML = `
    <div class="card-body">
        <div class="form-check d-flex align-items-center">
            <input onchange="handleRadioClick(this)" class="me-2 form-check-input" value="${direccion}" type="radio" name="envio" id="envioNew">
            <label class="form-check-label" for="envioNew">
                <span>Direccion de entrega</span><br>
                <span>CUIT / CUIL: {{ Auth::guard('cliente')->user()->cuit }}</span><br>
                <span>${direccion}</span>
            </label>
        </div>
    </div>
`;

        // insertar el nuevo elemento antes del botón
        button.parentNode.insertBefore(newDiv, button);


    }

    ///ENVIO AJAX
    function enviar() {

        const carrito = localStorage.getItem('carrito');
        let observacion = document.getElementById('observacion').value
        let envio = document.querySelector('input[name="envio"]:checked').value
        data = new FormData();
        data.append('carrito', carrito);
        data.append('observacion', observacion);
        data.append('envio', envio);
        data.append('_token', document.querySelector('[name="_token"]').value);

        $.ajax({
            url: '{{ route('page.carrito.paso.dos.post') }}',
            data: data,
            type: "post",
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(response) {
                console.log(response)
                swal("*Gracias por realizar tu pedido", "", "succes");
            },
            error: function(response) {
                console.log(response);
                swal("Algo salió mal", "", "error");
            }
        });
    };

    function removeItemFromArr(arr, item) {
        var i = arr.indexOf(item);
        arr.splice(i, 1);
    }


    function tabla() {
        tabla = $('.box-carrito');
        var template = '';
        obj_fila = localStorage.getItem('carrito');
        subtotal = 0;
        if (obj_fila != null) {
            obj_fila = jQuery.parseJSON(obj_fila);
            obj_fila = $.makeArray(obj_fila);
            total = 0;

            for (i = 0; i < obj_fila.length; i++) {
                template += `<div class="tablaFila card mb-3 d-flex flex-row" id="fila_${i}"
                data-presentacion="${obj_fila[i]['presentacion']}" data-codigo="${obj_fila[i]['codigo']}"
                style="border-bottom:1px solid #ccc;">`
                template += `<input type="hidden" class="pcodigo" name="codigo[]" value="${obj_fila[i]['codigo']}">`
                template += `<input type="hidden" name="nombre[]" value="${obj_fila[i]['nombre']}">`
                template += `<input type="hidden" name="cantidad[]" value="${obj_fila[i]['cantidad']}">`
                template += `<input type="hidden" class="filaPrecio" name="precio[]" value="${obj_fila[i]['precio']}">`
                template +=
                    `<input type="hidden" class="filaProductoId" name="filaProductoId[]" value="${obj_fila[i]['productoid']}">`
                template += `<div class="col-6 d-flex flex-column mx-2">`
                template += `<div class="filaCodigo"></div>`
                template +=
                    `<div name="div" class="pt-2 pb-2 filaNombre"
            style="font-size: 16px;font-weight:bold;text-transform:uppercase;color:#707070;">${obj_fila[i]['nombre']}
        </div>`
                template += `<div class="pt-2 pb-2"
            style="font-size: 16px;font-weight:bold;text-transform:uppercase;color:#707070;">
            <div>
                <div class="quantity">
                    <span data-cantidad="${obj_fila[i]['unidad']}" data-unidad="${obj_fila[i]['unidad']}"
                        data-precio="${obj_fila[i]['precio']}"
                        class="filaCantidad
                                id="cantidad" data-fila="${i}">
                        ${obj_fila[i]['cantidad']}
                    </span>
                </div>
            </div>
        </div>`
                template += "</div>"
                template += `<div class="col-3 d-flex flex-row justify-content-center">`
                template +=
                    `<div class="pt-2 pb-2 subtotal${i} d-flex justify-content-center align-items-center"
            style="font-size: 16px;font-weight:bold;text-transform:uppercase;color:#707070;" id="cantidadPrecio"
            data-precio="${obj_fila[i]['precio']}">${obj_fila[i]['subtotal']}</div>`
                template += "</div>"
                template += `</div>`
                template += '</div>'

                precio = parseFloat(obj_fila[i]['precio']);
                cantidad = parseFloat(obj_fila[i]['cantidad']);
                //subtotal = parseFloat(obj_fila[i]['subtotal']);
                
                console.log(obj_fila[i]['subtotal'])
                console.log(precio)
                console.log(cantidad)
                subtotal = parseFloat(obj_fila[i]['subtotal'].replace("$ ", ""));
                total += subtotal;
            }
            total = total.toFixed(2)
            $('#subtotal').html("$ " + total)
            $('#total').html("$ " + total)
            tabla.append(template)

            $('#totalhidden').val("$ " + total)

        } else {

        }

    }
    document.onload = tabla();
</script>
