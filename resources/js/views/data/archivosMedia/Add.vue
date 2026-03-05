<script setup>
import { reactive } from 'vue'
import Form from './Form.vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = reactive({
    nombre:        '',
    tipo:          'imagen',
    activo:        true,
    archivo:       null,
    archivoNombre: '',
    url_publica:   null,
    isEdit:        false,
})

const errors = reactive({ nombre: [], tipo: [], archivo: [] })

const onSubmit = () => {
    let modal = awesomeModal.loading()
    var fd = new FormData()

    fd.append('nombre', form.nombre)
    fd.append('tipo',   form.tipo)
    fd.append('activo', form.activo ? 1 : 0)
    if (form.archivo) fd.append('archivo', form.archivo)

    Object.keys(errors).forEach(k => errors[k].splice(0))

    httpRequest({
        url:    window.public_path + '/adm/archivosmedia/store',
        method: 'POST',
        data:   fd,
        errors: errors,
    })
    .then((data) => {
        modal.close()
        form.url_publica = data.url_publica
        awesomeModal.alert(
            '¡Archivo subido! URL generada:<br><br><strong>' + data.url_publica + '</strong>',
            () => router.push('/adm/data/archivosmedia')
        )
    })
    .catch(() => modal.close())
}
</script>

<template>
    <form @submit.prevent="onSubmit">
        <SectionHeader>
            <template #title>Nuevo archivo</template>
            <template #buttons>
                <router-link to="/adm/data/archivosmedia" class="btn btn--yellow">
                    <i class="fas fa-arrow-left"></i> Volver
                </router-link>
                <button class="btn btn--green" type="submit">
                    <i class="fas fa-save"></i> Guardar y obtener URL
                </button>
            </template>
        </SectionHeader>
        <Form :form="form" :errors="errors" />
    </form>
</template>

<style lang="scss" scoped></style>