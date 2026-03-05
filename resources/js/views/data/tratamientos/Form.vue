
<template>
    <h3>Articulo:</h3>
    <div class="grid-3 gap-15">
        <InputText
            label="Nombre"
            placeholder=""
            v-model="form.name"
            :error="errors.name"
            class="col-1"
        />
        <InputText
            label="Descripción"
            placeholder=""
            v-model="form.description"
            :error="errors.description"
            class="col-2"
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