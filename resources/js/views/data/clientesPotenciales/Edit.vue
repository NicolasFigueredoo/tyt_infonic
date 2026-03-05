<script setup>
import { reactive, ref } from 'vue'
import Form from './Form.vue'
import { useRoute, useRouter } from 'vue-router'

const route  = useRoute()
const router = useRouter()

const form = reactive({
    email:       '',
    campos_form: [],
})
const errors = reactive({ email: [] })

let modal = awesomeModal.loading()

httpRequest({
    url:    window.public_path + '/adm/clientespotenciales/' + route.params.id,
    method: 'GET',
})
.then((data) => {
    form.email       = data.email
    form.campos_form = data.campos_form ?? []
    modal.close()
})
.catch(() => modal.close())

const onSubmit = () => {
    let modal = awesomeModal.loading()
    var fd = new FormData()
    fd.append('email', form.email)

    errors.email.splice(0)

    httpRequest({
        url:    window.public_path + '/adm/clientespotenciales/store/' + route.params.id,
        method: 'POST',
        data:   fd,
        errors: errors,
    })
    .then(() => { modal.close(); router.push('/adm/clientespotenciales') })
    .catch(() => modal.close())
}
</script>

<template>
    <form @submit.prevent="onSubmit">
        <SectionHeader>
            <template #title>Editar cliente potencial</template>
            <template #buttons>
                <router-link to="/adm/clientespotenciales" class="btn btn--yellow">
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