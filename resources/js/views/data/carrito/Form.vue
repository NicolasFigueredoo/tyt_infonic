
<template>
    <h3>Carrito:</h3>
    <div class="grid-3 gap-15">
        <InputTextarea
            label="Informacion importante"
            placeholder=""
            v-model="form.informacion"
            :error="errors.informacion"
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