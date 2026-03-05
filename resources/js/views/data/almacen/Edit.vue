<script setup>
    import { reactive, ref } from 'vue'
    import Form from './Form.vue'
    import { required, email, validate } from '../../../libs/validate'
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
    let modal = awesomeModal.loading()
    httpRequest({
        url: window.public_path + '/api/almacen/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.code        = data.code
        form.name        = data.name
        form.description = data.description
        // Object.assign(form.groups, response.data.groups)
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const title = ref('Editar Almacen')
    if (route.meta.copy) {
        title.value = 'Copiar Almacen'
    }
    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("code", form.code);
        form_data.append("name", form.name);
        form_data.append("description", form.description);
        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })
        httpRequest({
            url: window.public_path + '/api/almacen/store/' + route.params.id,
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
                {{ title }}
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
