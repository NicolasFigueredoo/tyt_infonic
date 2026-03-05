<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({
        descripcion: '',
        
        tituloDescripcion: '',
        imagen: 0,
        logo: 0,
        logoDos: 0,
        logoTres: 0,
        titulo: '',
        tituloDos: '',
        tituloTres: '',
        descripcionLogo: '',
        descripcionLogoDos: '',
        descripcionLogoTres: '',
             tituloEnglish: '',
        descripcionEnglish: ''
    })
    const errors = reactive({
        descripcion: [],
        
        tituloDescripcion: [],
        imagen: [],
        logo: [],
        logoDos: [],
        logoTres: [],
        titulo: [],
        tituloDos: [],
        tituloTres: [],
        descripcionLogo: [],
        descripcionLogoDos: [],
        descripcionLogoTres: [],
             tituloEnglish: [],
        descripcionEnglish: []
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("descripcion", form.descripcion);
        form_data.append("imagenSrc", form.imagen);
        
        form_data.append("tituloDescripcion", form.tituloDescripcion);
        form_data.append("logoSrc", form.logo);
        form_data.append("logoDosSrc", form.logoDos);
        form_data.append("logoTresSrc", form.logoTres);
        form_data.append("titulo", form.titulo);
        form_data.append("tituloDescripcion", form.tituloDescripcion);        
        form_data.append("tituloDos", form.tituloDos);
        form_data.append("tituloTres", form.tituloTres);
        form_data.append("descripcionLogo", form.descripcionLogo);
        form_data.append("descripcionLogoDos", form.descripcionLogoDos);
        form_data.append("descripcionLogoTres", form.descripcionLogoTres);

        form_data.append("tituloEnglish", form.tituloEnglish);
        form_data.append("descripcionEnglish", form.descripcionEnglish);
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/empresa/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/empresa')
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
                Añadir Empresa
            </template>
            <template #buttons>
                <router-link
                    to="/empresa"
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
