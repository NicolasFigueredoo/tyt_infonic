<script setup>
    import { reactive, ref } from 'vue'
    import Form from './Form.vue'
    import { required, email, validate } from '../../../libs/validate'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({
        name: '',
        email: '',
        phone: '',
        address: '',
        country: '',
    })
    const errors = reactive({
        name: [],
        email: [],
        phone: [],
        address: [],
        country: [],
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/api/proveedor/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.name  = data.name
        form.email = data.email
        form.phone = data.phone
        form.address = data.address
        form.country = data.country
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const title = ref('Editar Proveedor')
    if (route.meta.copy) {
        title.value = 'Copiar Proveedor'
    }
    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("name", form.name);
        form_data.append("email", form.email);
        form_data.append("phone", form.phone);
        form_data.append("address", form.address);
        form_data.append("country", form.country);

        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/api/proveedor/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/proveedor')
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
                    to="/proveedor"
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
