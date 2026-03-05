
<template>
    <div class="grid-2 gap-15">
        <InputText
            label="Nombre"
            placeholder=""
            v-model="form.name"
            :error="errors.name"
            class="col-1"
        />
        <InputText
            label="Email"
            placeholder=""
            v-model="form.email"
            :error="errors.email"
            class="col-1"
        />
        <InputText
            label="Teléfono"
            placeholder=""
            v-model="form.phone"
            :error="errors.phone"
            class="col-1"
        />
        <InputText
            label="Dirección"
            placeholder=""
            v-model="form.address"
            :error="errors.address"
            class="col-1"
        />
        <InputText
            label="País"
            placeholder=""
            v-model="form.country"
            :error="errors.country"
            class="col-1"
        />
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