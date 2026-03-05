
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
            label="Grupo"
            placeholder=""
            v-model="form.group_prefix"
            :error="errors.group_prefix"
            class="col-1"
        />
        <InputText
            label="Guard"
            placeholder=""
            v-model="form.guard_name"
            :error="errors.guard_name"
            class="col-1"
        />
        <InputText
            label="Descripción"
            placeholder=""
            v-model="form.description"
            :error="errors.description"
            class="col-1"
        />
    </div>
</template>

<script setup>
    defineProps({
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