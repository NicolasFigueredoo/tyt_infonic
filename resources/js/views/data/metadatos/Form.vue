
<template>
    <h3>Articulo:</h3>
    <div class="grid-3 gap-15">
        <InputText
        label="Seccion"
        placeholder=""
        v-model="form.seccion"
        :error="errors.seccion"
        class="col-1"
        />
        <InputText
        label="Keyword"
        placeholder=""
        v-model="form.keyword"
        :error="errors.keyword"
        class="col-3"
        />
        <InputText
            label="Descripcion"
            placeholder=""
            v-model="form.descripcion"
            :error="errors.descripcion"
            class="col-3"
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