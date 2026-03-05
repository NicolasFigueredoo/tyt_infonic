
<template>
    <h3>Logo:</h3>
    <div class="grid-3 gap-15">


        <InputFileImage
                    label="image"
                    placeholder=""
                    v-model="form.image"
                    :error="errors.image"
                    class="col-1"
        />
        <small class="col-3">Tama&ntilde;o recomendado 90x100 px, Formatos (JPG - PNG)</small>
        <img v-bind:src="form.image" class="col-3" onerror="this.onerror=null;">
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