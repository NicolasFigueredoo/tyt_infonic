
<template>
    <div class="grid-3 gap-15">
        <!-- <InputFile
            label="Video"
            placeholder=""
            v-model="form.video"
            :error="errors.video"
            class="col-3"
        /> -->
        <!-- <InputText
            label="Titulo Video"
            placeholder=""
            v-model="form.tituloVideo"
            :error="errors.tituloVideo"
            class="col-3"
        /> -->
        <!-- <InputText
        label="Descripcion Video"
            placeholder=""
            v-model="form.descripcionVideo"
            :error="errors.descripcionVideo"
            class="col-3"
            /> -->
        <h4>Banner</h4>
        <InputText
            label="Titulo"
            placeholder=""
            v-model="form.titulo"
            :error="errors.titulo"
            class="col-3"
        />
        <InputTextarea
            label="Descripcion"
            placeholder=""
            v-model="form.descripcion"
            :error="errors.descripcion"
            class="col-3"
        />

        <InputText
            label="Titulo (Ingles)"
            placeholder=""
            v-model="form.tituloEnglish"
            :error="errors.tituloEnglish"
            class="col-3"
        />
        <InputTextarea
            label="Descripcion (Ingles)"
            placeholder=""
            v-model="form.descripcionEnglish"
            :error="errors.descripcionEnglish"
            class="col-3"
        />

        <p>Tamaño recomendado para la imagen 750x500 px</p>

        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-1"
        />

        <img style="width: 250px; height: 250px;" v-bind:src="form.imagenSrc" class="col-3" onerror="this.onerror=null;">

        <p>Boton principal</p>
        <InputText
            label="Titulo"
            placeholder=""
            v-model="form.botonPrincipal"
            :error="errors.botonPrincipal"
            class="col-3"
        />
        <InputText
            label="Titulo (Ingles)"
            placeholder=""
            v-model="form.botonPrincipalEnglish"
            :error="errors.botonPrincipalEnglish"
            class="col-3"
        />
        <InputText
            label="Link"
            placeholder=""
            v-model="form.botonPrincipalLink"
            :error="errors.botonPrincipalLink"
            class="col-3"
        />

        <P>Boton secundario</P>
        <InputText
            label="Titulo"
            placeholder=""
            v-model="form.botonSecundario"
            :error="errors.botonSecundario"
            class="col-3"
        />
        <InputText
            label="Titulo (Ingles)"
            placeholder=""
            v-model="form.botonSecundarioEnglish"
            :error="errors.botonSecundarioEnglish"
            class="col-3"
        />
        <InputText
            label="Link"
            placeholder=""
            v-model="form.botonSecundarioLink"
            :error="errors.botonSecundarioLink"
            class="col-3"
        />

    </div>
    <h4>Banner 2</h4>
    <div class="grid-3 gap-15">
        <InputText
            label="Titulo"
            placeholder=""
            v-model="form.tituloDos"
            :error="errors.tituloDos"
            class="col-3"
        />
        <InputTextarea
            label="Descripcion"
            placeholder=""
            v-model="form.descripcionDos"
            :error="errors.descripcionDos"
            class="col-3"
        />
        <InputText
            label="Titulo (Ingles)"
            placeholder=""
            v-model="form.tituloDosEnglish"
            :error="errors.tituloDosEnglish"
            class="col-3"
        />
        <InputTextarea
            label="Descripcion (Ingles)"
            placeholder=""
            v-model="form.descripcionDosEnglish"
            :error="errors.descripcionDosEnglish"
            class="col-3"
        />

        <p>Tamaño recomendado para la imagen 750x500 px</p>
        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagenDos"
                    :error="errors.imagenDos"
                    class="col-1"
        />

        <img style="width: 250px; height: 250px;" v-bind:src="form.imagenSrcDos" class="col-3" onerror="this.onerror=null;">

        <p>Boton principal</p>

        <InputText
            label="Titulo"
            placeholder=""
            v-model="form.botonPrincipalDos"
            :error="errors.botonSecundario"
            class="col-3"
        />
        <InputText
            label="Titulo (Ingles)"
            placeholder=""
            v-model="form.botonPrincipalDosEnglish"
            :error="errors.botonPrincipalDosEnglish"
            class="col-3"
        />
        <InputText
            label="Link"
            placeholder=""
            v-model="form.botonPrincipalDosLink"
            :error="errors.botonPrincipalDosLink"
            class="col-3"
        />


    </div>

    <h4>Imagen del footer</h4>
    <p>Tamaño recomendado para la imagen 1500x650px</p>

    <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagenFooter"
                    :error="errors.imagenFooter"
                    class="col-1"
        />

        <img v-bind:src="form.imagenFooter" class="col-3" onerror="this.onerror=null;">




    <h4>Quiero ser cliente</h4>

    <div class="grid-3 gap-15">
        <InputText
            label="link:"
            placeholder=""
            v-model="form.quieroCliente"
            :error="errors.quieroCliente"
            class="col-3"
        />
   
    </div>



</template>

<script setup>
    import { reactive } from "@vue/reactivity";

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

</script>

<style lang="scss" scoped>
</style>