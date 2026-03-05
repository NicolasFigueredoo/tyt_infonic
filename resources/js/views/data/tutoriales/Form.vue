
<template>
    <h3>Articulo:</h3>
    <div class="grid-3 gap-15">
        <InputText
            label="Orden"
            placeholder=""
            v-model="form.orden"
            :error="errors.orden"
            class="col-1"
        />        
        
        <InputText
            label="Link video"
            placeholder=""
            v-model="form.link"
            :error="errors.link"
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