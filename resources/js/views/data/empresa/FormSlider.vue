
<template>
    <div class="grid-3 gap-15">
        <InputText
            label="Año"
            placeholder=""
            v-model="form.orden"
            :error="errors.orden"
            class="col-1"
        />
        <InputText
            label="Titulo"
            placeholder=""
            v-model="form.titulo"
            :error="errors.titulo"
            class="col-1"
        />
        <InputTextarea
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
        <small class="col-3">Tama&ntilde;o recomendado 217 x 141 px</small>
        <img v-bind:src="form.imagenSrc" class="col-3" onerror="this.onerror=null;">
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