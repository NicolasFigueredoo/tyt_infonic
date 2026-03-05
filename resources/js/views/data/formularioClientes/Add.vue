<script setup>
import { reactive } from 'vue'
import Form from './Form.vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = reactive({
    label:        '',
    tipo:         'text',
    campo_sistema: '',
    placeholder:  '',
    opciones:     [],
    orden:        0,
    requerido:    false,
    activo:       true,
    tieneOtro:    false,
    imageSlots:   [
        { file: null, preview: null, label: '', existing: null },
        { file: null, preview: null, label: '', existing: null },
        { file: null, preview: null, label: '', existing: null },
    ],
})

const errors = reactive({
    label: [], tipo: [], placeholder: [], opciones: [], orden: [],
})

const onSubmit = () => {
    let modal = awesomeModal.loading()
    var fd = new FormData()

    fd.append('label',         form.label)
    fd.append('tipo',          form.tipo)
    fd.append('campo_sistema', form.campo_sistema ?? '')
    fd.append('placeholder',   form.placeholder)
    fd.append('orden',         form.orden)
    fd.append('requerido',     form.requerido ? 1 : 0)
    fd.append('activo',        form.activo    ? 1 : 0)
    fd.append('tiene_otro',    form.tieneOtro ? 1 : 0)

    if (['select', 'checkbox', 'radio'].includes(form.tipo)) {
        form.opciones.forEach(op => fd.append('opciones[]', op))
    }

    if (form.tipo === 'image_choice') {
        form.imageSlots.forEach((slot, i) => {
            if (slot.file) fd.append('imagenes[' + i + ']', slot.file)
            fd.append('imagen_labels[' + i + ']', slot.label ?? '')
        })
    }

    Object.keys(errors).forEach(k => errors[k].splice(0))

    httpRequest({
        url:    window.public_path + '/adm/formclientes/store',
        method: 'POST',
        data:   fd,
        errors: errors,
    })
    .then(() => { modal.close(); router.push('/adm/formclientes') })
    .catch(() => modal.close())
}
</script>

<template>
    <form @submit.prevent="onSubmit">
        <SectionHeader>
            <template #title>Nuevo campo del formulario</template>
            <template #buttons>
                <router-link to="/adm/formclientes" class="btn btn--yellow">
                    <i class="fas fa-arrow-left"></i> Volver
                </router-link>
                <button class="btn btn--green" type="submit">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </template>
        </SectionHeader>
        <Form :form="form" :errors="errors" />
    </form>
</template>
<style lang="scss" scoped></style>