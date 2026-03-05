<script setup>
    import { reactive, ref } from 'vue'
    import Form from './FormSlider.vue'
    import { required, email, validate } from '../../../libs/validate'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({
        descripcion: '',
        titulo: '',
        orden: '',
        imagen: 0,        
    })
    const errors = reactive({
        descripcion: [],
        titulo: [],
        orden: [],
        imagen: [],        
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/empresa/slider/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        console.log(data)
        form.descripcion = data.descripcion
        form.titulo = data.titulo
        form.orden = data.orden
        form.imagenSrc = data.path        
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const title = ref('Editar')
    if (route.meta.copy) {
        title.value = 'Copiar'
    }
    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("descripcion", form.descripcion);
        form_data.append("titulo", form.titulo);
        form_data.append("orden", form.orden);
        form_data.append("imagenSrc", form.imagen);        

        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/empresa/slider/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/empresa/slider')
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
                    to="/adm/empresa/slider"
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
