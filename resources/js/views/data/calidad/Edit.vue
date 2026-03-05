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
        certificado: 0,
        certificadoDos: 0,        
        descripcionCertificado: '',
        descripcionCertificadoDos: '',
        logo:0,
        logoDos:0,
    })
    const errors = reactive({
        descripcion: [],
        imagen: [],
        tituloDescripcion: [],
        certificado: [],
        certificadoDos: [],        
        descripcionCertificado: [],
        descripcionCertificadoDos: [],
        logo:[],
        logoDos:[],
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/calidad/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        console.log(data)
        form.descripcion = data.descripcion
        form.imagenSrc = data.path        
        form.certificadoSrc = data.pathCertificado
        form.certificadoDosSrc = data.pathCertificadoDos
        form.tituloDescripcion = data.tituloDescripcion        
        form.descripcionCertificado = data.descripcionCertificado
        form.descripcionCertificadoDos = data.descripcionCertificadoDos
        form.logoSrc = data.pathLogo
        form.logoDosSrc = data.pathLogoDos
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
        form_data.append("certificadoSrc", form.certificado);
        form_data.append("certificadoDosSrc", form.certificadoDos);        
        form_data.append("tituloDescripcion", form.tituloDescripcion);        
        form_data.append("descripcionCertificado", form.descripcionCertificado);
        form_data.append("descripcionCertificadoDos", form.descripcionCertificadoDos);
        

        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/calidad/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/calidad')
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
                    to="/adm/calidad"
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
