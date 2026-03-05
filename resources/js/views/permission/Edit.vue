<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { required, email, validate } from '../../libs/validate'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({
        name: '',
        group_prefix: '',
        guard_name: 'web',
        description: '',
    })

    const errors = reactive({
        name: [],
        group_prefix: [],
        guard_name: [],
        description: [],
    })
    let modal = awesomeModal.loading()
    httpRequest({
        url: window.public_path + '/adm/permission/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.name         = data.name
        form.group_prefix = data.group_prefix
        form.guard_name   = data.guard_name
        form.description  = data.description
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("name",        form.name);
        form_data.append("group_prefix",       form.group_prefix);
        form_data.append("guard_name",  form.guard_name);
        form_data.append("description", form.description);
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/permission/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/permission')
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
                    to="/permission"
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
