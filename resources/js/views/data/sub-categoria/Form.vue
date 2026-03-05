
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

        <SelectAutocomplete
            label="Tipo de articulo"
            v-model="form.tipo_articulo_id"
            endpoint="/adm/tipo-articulo/list-select"
            :error="errors.tipo_articulo_id"
            class="col-1"
            option-key="id"
            :selectedRaw="form.tipo_articulo"
        >
            <template #option="{ id, name }">
                <div>
                    {{ name }}
                </div>
            </template>
        </SelectAutocomplete>
        
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