
<template>
    <h3>Articulo:</h3>
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
        <InputText
            label="Link"
            placeholder=""
            v-model="form.link"
            :error="errors.link"
            class="col-3"
        />
        <InputFileImage
                    label="Imagen"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-1"
        />
        <small  class="col-3">Tama&ntilde;o recomendado 65 x 64 px</small>
        <img v-bind:src="form.imagen" class="col-3" onerror="this.onerror=null;">
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