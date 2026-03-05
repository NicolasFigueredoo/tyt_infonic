
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
        <InputText
            label="Password"
            placeholder=""
            v-model="form.password"
            :error="errors.password"
            class="col-3"
        />
        

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