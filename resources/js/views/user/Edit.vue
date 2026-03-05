<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { required, email, validate } from '../../libs/validate'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({
        name: '',
        username: '',
        email: '',
        password: '',
        root: 0,
        groups: [],
    })

    const errors = reactive({
        name: [],
        username: [],
        email: [],
        password: [],
        root: [],
        groups: [],
    })
    let modal = awesomeModal.loading()
    httpRequest({
        url: window.public_path + '/adm/user/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.name     = data.name
        form.username = data.username
        form.email    = data.email
        Object.assign(form.groups, data.groups)
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("name",     form.name);
        form_data.append("username", form.username);
        form_data.append("email",    form.email);
        form_data.append("password", form.password);
        form_data.append("root",     form.root);
        form_data.append("groups",   form.groups);
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })
        httpRequest({
            url: window.public_path + '/adm/user/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/user')
        })
        .catch((error) => {
            modal.close()
        })

    }
</script>
<template>
    <form @submit.prevent="onSubmit">
        <SectionHeader>
            <template #title>
                Editar Usuario
            </template>
            <template #buttons>
                <router-link
                    to="/adm/user"
                    class="btn btn--yellow"
                >
                    <i class="fas fa-arrow-left"></i> Volver
                </router-link>
                <button
                    class="btn btn--green"
                    type="submit"
                >
                    <i class="fas fa-save"></i> Guardar
                </button>
            </template>
        </SectionHeader>
        <Form
            :form="form"
            :errors="errors"
        />
    </form>
</template>


<style lang="scss" scoped>
</style>
