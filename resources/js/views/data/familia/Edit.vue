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
        oculto: '',
        imagen: 0,
        imagenMarca: 0
    })
    const errors = reactive({
        name: [],
        orden: [],
        oculto: [],
        imagen: [],
        imagenMarca: []
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/familia/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.name = data.name
        form.orden = data.orden
        form.oculto = data.oculto
        form.imagenSrc = data.path
        form.imagenMarca = data.secondary_path

        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const title = ref('Editar Familia')
    if (route.meta.copy) {
        title.value = 'Copiar Familia'
    }
    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("name", form.name);
        form_data.append("orden", form.orden);
        form_data.append("oculto", form.oculto);
        form_data.append("imagenSrc", form.imagen);
        form_data.append("imagenMarca", form.imagenMarca);

        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/familia/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/familia')
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
                    to="/adm/familia"
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
