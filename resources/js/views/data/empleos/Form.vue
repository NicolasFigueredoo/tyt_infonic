<template>
    <div class="grid-3 gap-15">
        <InputText
            label="Título del puesto"
            placeholder="Ej: Vendedor comercial"
            v-model="form.titulo"
            :error="errors.titulo"
            class="col-3"
        />

        <input-textarea
            label="Descripción"
            placeholder=""
            v-model="form.descripcion"
            :error="errors.descripcion"
            class="col-3"
        />

        <input-textarea
            label="Requisitos"
            placeholder=""
            v-model="form.requisitos"
            :error="errors.requisitos"
            class="col-3"
        />

        <InputText
            label="Ubicación"
            placeholder="Ej: Buenos Aires, Argentina"
            v-model="form.ubicacion"
            :error="errors.ubicacion"
            class="col-3"
        />

        <InputText
            label="Fecha de publicación"
            placeholder=""
            type="date"
            v-model="form.fecha_publicacion"
            :error="errors.fecha_publicacion"
            class="col-1"
        />

      <div class="col-1">
    <label style="font-size:14px; font-weight:600; margin-bottom:4px; display:block;">Activo</label>
    <select
        v-model="form.activo"
        style="width:100%; border:1px solid #ccc; border-radius:4px; padding:8px 12px; font-size:14px;"
    >
        <option :value="1">Sí</option>
        <option :value="0">No</option>
    </select>
    <span v-if="errors.activo && errors.activo.length" style="color:red; font-size:12px;">{{ errors.activo[0] }}</span>
</div>
    </div>
</template>

<script setup>
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