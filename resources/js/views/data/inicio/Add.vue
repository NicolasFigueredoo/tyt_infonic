<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({
        video: '',
        tituloVideo: '',
        descripcionVideo: '',
        descripcion: '',
        titulo: '',
        imagen: 0,
        descripcionDos: '',
        tituloDos: '',
        imagenDos: 0,
        descripcionDosEnglish: '',
        tituloDosEnglish: '',
        descripcionEnglish: '',
        tituloEnglish: '',
        imagenFooter: ''
    })
    const errors = reactive({
        video: [],
        tituloVideo: [],
        descripcionVideo: [],
        descripcion: [],
        titulo: [],
        imagen: [],
        descripcionDos: [],
        tituloDos: [],
        imagenDos: [],
        descripcionEnglish: [],
        tituloEnglish: [],
        descripcionDosEnglish: [],
        tituloDosEnglish: [],
        imagenFooter: []
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("video", form.video);
        form_data.append("tituloVideo", form.tituloVideo);
        form_data.append("descripcionVideo", form.descripcionVideo);
        form_data.append("descripcion", form.descripcion);
        form_data.append("titulo", form.titulo);
        form_data.append("imagen", form.imagen);
        form_data.append("descripcionDos", form.descripcionDos);
        form_data.append("tituloDos", form.tituloDos);
        form_data.append("imagenDos", form.imagenDos);
        form_data.append("descripcionDosEnglish", form.descripcionDosEnglish);
        form_data.append("tituloDosEnglish", form.tituloDosEnglish);
        form_data.append("descripcionEnglish", form.descripcionEnglish);
        form_data.append("tituloEnglish", form.tituloEnglish);
        form_data.append("imagenFooter", form.imagenFooter);


        
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/inicio/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/inicio')
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
                Añadir Inicio
            </template>
            <template #buttons>
                <router-link
                    to="/inicio"
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
