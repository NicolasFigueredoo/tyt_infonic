<script setup>
    import { getCurrentInstance, reactive } from 'vue'
    import Form from './Form.vue'
    import { required, email, validate } from '../../libs/validate'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({
        name: '',
        guard_name: 'web',
        description: '',
        permissions: [],
    })

    const errors = reactive({
        name: [],
        guard_name: [],
        description: [],
        permissions: [],
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/group/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.name        = data.name
        form.guard_name  = data.guard_name
        form.description = data.description
        Object.assign(form.permissions, data.permissions)
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("name",        form.name);
        form_data.append("guard_name",  form.guard_name);
        form_data.append("description", form.description);
        form_data.append("permissions", form.permissions);
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/group/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/group')
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
                    to="/group"
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
