
<template>
    <div class="grid-3 gap-15">
        <InputText
            label="Titulo"
            placeholder=""
            v-model="form.tituloDescripcion"
            :error="errors.tituloDescripcion"
            class="col-3"
        />
        <input-textarea
            label="Descripcion"
            placeholder=""
            v-model="form.descripcion"
            :error="errors.descripcion"
            class="col-3"
        />
        
        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-1"
        />

        <img v-bind:src="form.imagenSrc" style="max-width: 100%;" class="col-3" onerror="this.onerror=null;">
    </div>
    <div class="grid-2 gap-15">
        <div class="col-1 grid-1 gap-15">
            <InputFile
                label="Certificado"
                placeholder=""
                v-model="form.certificado"
                :error="errors.certificado"
                class="col-1"
            />

            <InputTextarea
                label="Descripicon"
                placeholder=""
                v-model="form.descripcionCertificado"
                :error="errors.descripcionCertificado"
                class="col-1"
            />
            <InputFileImage
                    label="Logo"
                    placeholder=""
                    v-model="form.logo"
                    :error="errors.logo"
                    class="col-1"
        />
        <small  class="col-3">Tama&ntilde;o recomendado 600 x 400 px</small>
        <img v-bind:src="form.logoSrc" style="max-width: 100%;" class="col-31" onerror="this.onerror=null;">
        </div>
        <div class="col-1 grid-1 gap-15">
            <InputFile
                label="Certificado"
                placeholder=""
                v-model="form.certificadoDos"
                :error="errors.certificadoDos"
                class="col-1"
            />

            <InputTextarea
                label="Descripicon"
                placeholder=""
                v-model="form.descripcionCertificadoDos"
                :error="errors.descripcionCertificadoDos"
                class="col-1"
            />
            <InputFileImage
                    label="Logo"
                    placeholder=""
                    v-model="form.logoDos"
                    :error="errors.logoDos"
                    class="col-1"
        />

        <img v-bind:src="form.logoDosSrc" style="max-width: 100%;" class="col-31" onerror="this.onerror=null;">
        </div>
        
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