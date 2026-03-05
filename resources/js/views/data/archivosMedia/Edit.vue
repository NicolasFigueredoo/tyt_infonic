<script setup>
import { reactive } from 'vue'
import Form from './Form.vue'
import { useRoute, useRouter } from 'vue-router'

const route  = useRoute()
const router = useRouter()

const form = reactive({
    nombre:        '',
    tipo:          'imagen',
    activo:        true,
    archivo:       null,
    archivoNombre: '',
    url_publica:   null,
    isEdit:        true,
})

const errors = reactive({ nombre: [], tipo: [], archivo: [] })

let modal = awesomeModal.loading()

httpRequest({
    url:    window.public_path + '/adm/archivosmedia/' + route.params.id,
    method: 'GET',
})
.then((data) => {
    form.nombre      = data.nombre
    form.tipo        = data.tipo
    form.activo      = !!data.activo
    form.url_publica = data.url_publica
    modal.close()
})
.catch(() => modal.close())

const onSubmit = () => {
    let modal = awesomeModal.loading()
    var fd = new FormData()

    fd.append('nombre', form.nombre)
    fd.append('tipo',   form.tipo)
    fd.append('activo', form.activo ? 1 : 0)
    if (form.archivo) fd.append('archivo', form.archivo)

    Object.keys(errors).forEach(k => errors[k].splice(0))

    httpRequest({
        url:    window.public_path + '/adm/archivosmedia/store/' + route.params.id,
        method: 'POST',
        data:   fd,
        errors: errors,
    })
    .then((data) => {
        form.url_publica = data.url_publica
        modal.close()
        router.push('/adm/data/archivosmedia')
    })
    .catch(() => modal.close())
}
</script>

<template>
    <form @submit.prevent="onSubmit">
        <SectionHeader>
            <template #title>Editar archivo</template>
            <template #buttons>
                <router-link to="/adm/data/archivosmedia" class="btn btn--yellow">
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