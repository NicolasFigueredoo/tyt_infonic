<script setup>
    import { reactive, ref } from 'vue'
    import Form from './Form.vue'
    import { required, email, validate } from '../../../libs/validate'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({
        descripcion: '',
        imagen: 0,
        tituloDescripcion: '',
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
        descripcionEnglish: '',
        imagenNavbar:''
    })
    const errors = reactive({
        descripcion: [],
        imagen: [],
        tituloDescripcion: [],
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
        descripcionEnglish: [],
        imagenNavbar: []
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/empresa/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        console.log(data)
        form.descripcion = data.descripcion
        form.imagenSrc = data.path
        form.logoSrc = data.pathLogo
        form.logoDosSrc = data.pathLogoDos
        form.logoTresSrc = data.pathLogoTres
        form.tituloDescripcion = data.tituloDescripcion
        form.titulo = data.titulo
        form.tituloDos = data.titulo_dos
        form.tituloTres = data.titulo_tres
        form.descripcionLogo = data.descripcion_logo
        form.descripcionLogoDos = data.descripcion_logo_dos
        form.descripcionLogoTres = data.descripcion_logo_tres
        form.imagenNavbar = data.pathNavbar

        form.descripcionEnglish = data.descripcionEnglish
        form.tituloEnglish = data.tituloEnglish
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const title = ref('Editar Categoria')
    if (route.meta.copy) {
        title.value = 'Copiar Categoria'
    }
    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("descripcion", form.descripcion);
        form_data.append("imagenSrc", form.imagen);
        form_data.append("logoSrc", form.logo);
        form_data.append("logoDosSrc", form.logoDos);
        form_data.append("logoTresSrc", form.logoTres);
        form_data.append("tituloDescripcion", form.tituloDescripcion);
        form_data.append("titulo", form.titulo);
        form_data.append("tituloDos", form.tituloDos);
        form_data.append("tituloTres", form.tituloTres);
        form_data.append("descripcionLogo", form.descripcionLogo);
        form_data.append("descripcionLogoDos", form.descripcionLogoDos);
        form_data.append("descripcionLogoTres", form.descripcionLogoTres);

        form_data.append("imagenNavbar", form.imagenNavbar);

        form_data.append("tituloEnglish", form.tituloEnglish);
        form_data.append("descripcionEnglish", form.descripcionEnglish);

        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/empresa/store/' + route.params.id,
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
                {{ title }}
            </template>
            <template #buttons>
                <router-link
                    to="/adm/empresa"
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
