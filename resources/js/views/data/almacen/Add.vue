<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({
        code: '',
        name: '',
        description: '',
    })
    const errors = reactive({
        code: [],
        name: [],
        description: [],
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("code", form.code);
        form_data.append("name", form.name);
        form_data.append("description", form.description);
    

        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })
        httpRequest({
            url: window.public_path + '/api/almacen/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/almacen')
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
                Añadir Almacen
            </template>
            <template #buttons>
                <router-link
                    to="/almacen"
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
