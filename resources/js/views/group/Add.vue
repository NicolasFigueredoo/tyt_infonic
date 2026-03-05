<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
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
            url: window.public_path + '/adm/group/store',
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
                Añadir un Permiso
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
