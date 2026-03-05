
<template>
    <div class="grid-3 gap-15">
        <InputText
            label="Titulo"
            placeholder=""
            v-model="form.titulo"
            :error="errors.titulo"
            class="col-3"
        />
        <input-textarea
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
        <input-textarea
            label="Descripcion (Ingles)"
            placeholder=""
            v-model="form.descripcionEnglish"
            :error="errors.descripcionEnglish"
            class="col-3"
        />
        
        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-1"
        />
        <small class="col-3">Tama&ntilde;o recomendado 600 x 480 px</small>
        <img v-bind:src="form.imagenSrc" style="max-width: 100%;" class="col-3" onerror="this.onerror=null;">


        <InputFileImage
                    label="Image navbar"
                    placeholder=""
                    v-model="form.imagenNavbar"
                    :error="errors.imagenNavbar"
                    class="col-1"
        />
        <small class="col-3">Tama&ntilde;o recomendado 600 x 480 px</small>
        <img v-bind:src="form.imagenNavbar" style="max-width: 100%;" class="col-3" onerror="this.onerror=null;">
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