
<template>
    <div class="grid-3 gap-15">
        <InputText
            label="Orden"
            placeholder=""
            v-model="form.orden"
            :error="errors.orden"
            class="col-3"
        />
        <InputText
            label="Nombre"
            placeholder=""
            v-model="form.name"
            :error="errors.name"
            class="col-3"
        />
        <InputFileImage
                    label="Marca"
                    placeholder=""
                    v-model="form.imagenMarca"
                    :error="errors.imagenMarca"
                    class="col-1"
        />
        <small  class="col-3">Tama&ntilde;o recomendado 16 x 200 px</small>
        <img v-bind:src="form.imagenMarca" class="col-3" onerror="this.onerror=null;">

        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-1"
        />
        <small  class="col-3">Tama&ntilde;o recomendado 200 x 200 px</small>
        <img v-bind:src="form.imagenSrc" class="col-3" onerror="this.onerror=null;">

        <div class="form-check">
            <input class="form-check-input" v-model="form.oculto" :error="errors.oculto" type="checkbox" id="oculto">
            <label class="form-check-label" for="oculto">
                Ocultar categoria
            </label>
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