
<template>
    <h3>Modal:</h3>
    <div class="grid-3 gap-15">
        <p>tamaño recomandado 500x600 px</p>
        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-3"
        />

        <InputText
            label="link:"
            placeholder=""
            v-model="form.link"
            :error="errors.link"
            class="col-3"
        />
        
        <img v-if="form.imagenSrc" v-bind:src="form.imagenSrc" class="col-3" onerror="this.onerror=null;">
    </div>
    <div class="form-check">
  <input class="form-check-input" type="checkbox" id="flexCheckDefault" v-model="form.activo" :error="errors.activo">
  <label class="form-check-label" for="flexCheckDefault">
    Activar
  </label>
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