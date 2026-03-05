
<template>
    <h3>Novedad:</h3>
    <div class="grid-3 gap-15">        
        <InputText
            label="Orden"
            placeholder=""
            v-model="form.orden"
            :error="errors.orden"
            class="col-1"
        />
        <InputText
            label="Nombre"
            placeholder=""
            v-model="form.name"
            :error="errors.name"
            class="col-1"
        />
        <SelectAutocomplete
            label="Categorias"
            v-model="form.categoria_id"
            endpoint="/adm/novedad-categoria/list-select"
            :error="errors.categoria_id"
            class="col-1"
            option-key="id"
            :selectedRaw="form.novedad_categoria"
        >
            <template #option="{ id, name }">
                <div>
                    {{ name }}
                </div>
            </template>
        </SelectAutocomplete>
        
        <InputText
            label="Descripción"
            placeholder=""
            v-model="form.description"
            :error="errors.description"
            class="col-3"
        />
        <InputTextarea
            label="Texto"
            placeholder=""
            v-model="form.texto"
            :error="errors.texto"
            class="col-3"
        />

        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-1"
        />
        <small  class="col-3">Tama&ntilde;o recomendado 808 x 489 px</small>
        <img v-bind:src="form.imagenSrc" class="col-3" style="max-width: 100%;" onerror="this.onerror=null;">
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