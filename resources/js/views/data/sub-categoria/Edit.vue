<script setup>
    import { reactive, ref } from 'vue'
    import Form from './Form.vue'
    import { required, email, validate } from '../../../libs/validate'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({
        name: '',
        orden: '',
        tipo_articulo_id: 1,
    })
    const errors = reactive({
        name: [],
        orden: [],
        tipo_articulo_id: [],
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/sub-categoria/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.name = data.name
        form.orden = data.orden
        form.tipo_articulo_id = data.tipo_articulo_id
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const title = ref('Editar Sub Categoria')
    if (route.meta.copy) {
        title.value = 'Copiar Sub Categoria'
    }
    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("name", form.name);
        form_data.append("orden", form.orden);
        form_data.append("tipo_articulo_id", form.tipo_articulo_id);

        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/sub-categoria/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/sub-categoria')
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
                    to="/adm/sub-categoria"
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
