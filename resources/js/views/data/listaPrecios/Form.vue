
<template>
    <h3>ListaPrecios:</h3>
    <div class="grid-3 gap-15">

        <InputText
            label="Orden"
            placeholder=""
            v-model="form.orden"
            :error="errors.orden"
            class="col-6"
        />

        <InputText
            label="Titulo"
            placeholder=""
            v-model="form.titulo"
            :error="errors.titulo"
            class="col-6"
        />

        <InputText
            label="Titulo (EN)"
            placeholder=""
            v-model="form.tituloEnglish"
            :error="errors.tituloEnglish"
            class="col-6"
        />

        <InputText
            label="Link"
            placeholder=""
            v-model="form.link"
            :error="errors.link"
            class="col-6"
        />


        <InputFileImage
                    label="Archivo"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-6"
        />
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
</script>

<style lang="scss" scoped>
</style>