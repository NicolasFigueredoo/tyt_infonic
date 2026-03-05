<template>
    <h3>Articulo:</h3>
    <div class="grid-3 gap-15">
        <InputText
            label="Tipo articulo"
            placeholder=""
            v-model="form.tipoProducto"
            :error="errors.tipoProducto"
            class="col-1"
        />
        <InputText
            label="Código anterior"
            placeholder=""
            v-model="form.codigoAnterior"
            :error="errors.codigoAnterior"
            class="col-1"
        />
        <InputText
            label="Código"
            placeholder=""
            v-model="form.code"
            :error="errors.code"
            class="col-1"
        />
        <InputText
            label="Nombre"
            placeholder=""
            v-model="form.name"
            :error="errors.name"
            class="col-1"
        />
        <InputText
            label="Nombre (Ingles)"
            placeholder=""
            v-model="form.nameEnglish"
            :error="errors.nameEnglish"
            class="col-1"
        />
        <InputNumber
            label="Precio Vigente"
            placeholder=""
            v-model="form.precioVigente"
            :error="errors.precioVigente"
            class="col-1"
        />
        <InputNumber
            label="Stock"
            placeholder=""
            v-model="form.cantidad"
            :error="errors.cantidad"
            class="col-1"
        />
        <InputNumber
            label="Cantidad minima"
            placeholder=""
            v-model="form.minimo"
            :error="errors.minimo"
            class="col-1"
        />
        <InputNumber
            label="Bulto minorista"
            placeholder=""
            v-model="form.bultoMinorista"
            :error="errors.bultoMinorista"
            class="col-1"
        />
        <InputNumber
            label="Bulto mayorista"
            placeholder=""
            v-model="form.bultoMayorista"
            :error="errors.bultoMayorista"
            class="col-1"
        />
        <InputText
            label="Orden"
            placeholder=""
            v-model="form.orden"
            :error="errors.orden"
            class="col-1"
        />

        <InputText
            label="Marca"
            placeholder=""
            v-model="form.marca"
            :error="errors.marca"
            class="col-1"
        />

        <InputText
            label="Nombre URL (slug)"
            placeholder=""
            v-model="form.slug"
            :error="errors.slug"
            class="col-3"
        />
        <div class="form-check">
            <input class="form-check-input" v-model="form.destacado" :error="errors.destacado" type="checkbox" id="destacado">
            <label class="form-check-label" for="destacado">
                Destacado
            </label>
        </div>
        <InputTextarea
            label="Descripción"
            placeholder=""
            v-model="form.description"
            :error="errors.description"
            class="col-3"
        />
        <InputTextarea
            label="Descripción Privada"
            placeholder=""
            v-model="form.descriptionPrivada"
            :error="errors.descriptionPrivada"
            class="col-3"
        />     
        
        
        <InputTextarea
            label="Link video 1"
            placeholder=""
            v-model="form.video"
            :error="errors.video"
            class="col-3"
        />   

        <InputTextarea
            label="Link video 2"
            placeholder=""
            v-model="form.videoTwo"
            :error="errors.videoTwo"
            class="col-3"
        />  

        <p>tamaño recomendado de imagen 250x250 formatos: png, jpg, jpeg</p>
        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-3"
        />
        
        <img v-if="form.imagenSrc" v-bind:src="form.imagenSrc" class="col-3" onerror="this.onerror=null;">


        <p>tamaño recomendado de imagen 250x250 formatos: png, jpg, jpeg</p>

        <InputFileImageMultiple
                    label="Galeria de imagenes"
                    placeholder=""
                    v-model="form.galeria"
                    :error="errors.galeria"
                    class="col-3"
                    ref="galeria"
        />        
        <div v-for="(item, i) in form.galeriaLink" :key="i"  style="max-width: 250px;">
            <img  :id="'img'+i" v-bind:src="item" class="col-1" style="max-width: 250px;" onerror="this.onerror=null;">
            <button type="button" @click="deleteImg(form.id,i)">Borrar</button>
            <input type="hidden" name="galeriaLink[]" :value="item" :id="'imgHidden'+i">
        </div>
        <div class="col-3">
            <fieldset>                
                <legend>Colores</legend>
                <div v-for="(color, index) in form.colores" :key="index">
                    <input type="color" class="mx-5" v-model="color.color1" :error="errors.colores && errors.colores[index]?.color1">
                    <input type="color" class="mx-5" v-model="color.color2" :error="errors.colores && errors.colores[index]?.color2">
                    <button @click="removeColor(index)">Eliminar</button>
                </div>                
                <button type="button" @click="addColor">Agregar Color</button>
            </fieldset>
        </div>        
    </div>
    <div class="form-check">
        <input class="form-check-input" v-model="form.oculto" :error="errors.oculto" type="checkbox" id="oculto">
        <label class="form-check-label" for="oculto">
            Ocultar categoria
        </label>
    </div>
</template>

<script setup>
    import { reactive, ref } from "@vue/reactivity";

    const props = defineProps({
        form: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
            required: true,
        },
    })
    const addColor = () => {
      props.form.colores.push({ color1: "", color2: "" });
    };
    const deleteImg = (id,index) => {
        console.log('aa')
        httpRequest({
            url: window.public_path + '/adm/articulo/deleteImg/' + id + '/' + index,
            method: 'GET'
        })
        .then((data) => {
            window.location.reload ()
            console.log(data)
        })
        .catch((error) => {
            console.log(error)
        })           
    }
</script>

<style lang="scss" scoped>
</style>