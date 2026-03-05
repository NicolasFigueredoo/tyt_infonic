<script setup>
    import { reactive, ref } from 'vue'
    import Form from './Form.vue'
    import { required, email, validate } from '../../../libs/validate'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({
        video: '',
        tituloVideo: '',
        descripcionVideo: '',
        descripcion: '',
        titulo: '',
        descripcionEnglish: '',
        tituloEnglish: '',
        imagen: 0,
        descripcionDos: '',
        tituloDos: '',
        descripcionDosEnglish: '',
        tituloDosEnglish: '',
        imagenDos: 0,
        quieroCliente: '',
        imagenFooter:'',
        botonPrincipal: '',
        botonPrincipalEnglish: '',
        botonPrincipalLink: '',
        botonSecundario: '',
        botonSecundarioEnglish: '',
        botonSecundarioLink: '',
        botonPrincipalDos: '',
        botonPrincipalDosEnglish: '',
        botonPrincipalDosLink: ''
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
        quieroCliente: [],
        descripcionEnglish: [],
        tituloEnglish: [],
        descripcionDosEnglish: [],
        tituloDosEnglish: [],
        imagenFooter:[],
        botonPrincipal: [],
        botonPrincipalEnglish: [],
        botonPrincipalLink: [],
        botonSecundario: [],
        botonSecundarioEnglish: [],
        botonSecundarioLink: [],
        botonPrincipalDos: [],
        botonPrincipalDosEnglish: [],
        botonPrincipalDosLink: []
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/inicio/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.video = data.video
        form.tituloVideo = data.tituloVideo
        form.descripcionVideo = data.descripcionVideo
        form.descripcion = data.descripcion
        form.titulo = data.titulo
        form.imagenSrc = data.path
        form.descripcionDos = data.descripcionDos
        form.tituloDos = data.tituloDos
        form.imagenSrcDos = data.pathDos
        form.quieroCliente = data.quieroCliente

        form.descripcionDosEnglish = data.descripcionDosEnglish
        form.tituloDosEnglish = data.tituloDosEnglish
        form.descripcionEnglish = data.descripcionEnglish
        form.tituloEnglish = data.tituloEnglish
        form.imagenFooter = data.pathTres

        form.botonPrincipal = data.botonPrincipal
        form.botonPrincipalEnglish = data.botonPrincipalEnglish
        form.botonPrincipalLink = data.botonPrincipalLink

        form.botonSecundario = data.botonSecundario
        form.botonSecundarioEnglish = data.botonSecundarioEnglish
        form.botonSecundarioLink = data.botonSecundarioLink

        form.botonPrincipalDos = data.botonPrincipalDos
        form.botonPrincipalDosEnglish = data.botonPrincipalDosEnglish
        form.botonPrincipalDosLink = data.botonPrincipalDosLink

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

        form_data.append("video", form.video);
        form_data.append("tituloVideo", form.tituloVideo);
        form_data.append("descripcionVideo", form.descripcionVideo);
        form_data.append("descripcion", form.descripcion);
        form_data.append("titulo", form.titulo);
        form_data.append("imagenSrc", form.imagen);
        form_data.append("descripcionDos", form.descripcionDos);
        form_data.append("tituloDos", form.tituloDos);
        form_data.append("imagenSrcDos", form.imagenDos);
        form_data.append("quieroCliente", form.quieroCliente);
        form_data.append("descripcionDosEnglish", form.descripcionDosEnglish);
        form_data.append("tituloDosEnglish", form.tituloDosEnglish);
        form_data.append("descripcionEnglish", form.descripcionEnglish);
        form_data.append("tituloEnglish", form.tituloEnglish);
        form_data.append("imagenFooter", form.imagenFooter);

        form_data.append("botonPrincipal", form.botonPrincipal);
        form_data.append("botonPrincipalEnglish", form.botonPrincipalEnglish);
        form_data.append("botonPrincipalLink", form.botonPrincipalLink);

        form_data.append("botonSecundario", form.botonSecundario);
        form_data.append("botonSecundarioEnglish", form.botonSecundarioEnglish);
        form_data.append("botonSecundarioLink", form.botonSecundarioLink);

        form_data.append("botonPrincipalDos", form.botonPrincipalDos);
        form_data.append("botonPrincipalDosEnglish", form.botonPrincipalDosEnglish);
        form_data.append("botonPrincipalDosLink", form.botonPrincipalDosLink);

        
        
        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/inicio/store/' + route.params.id,
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
                {{ title }}
            </template>
            <template #buttons>
                <router-link
                    to="/adm/inicio"
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
