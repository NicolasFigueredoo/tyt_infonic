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
        certificado: 0,
        certificadoDos: 0,                
        descripcionCertificado: '',
        descripcionCertificadoDos: '',        
    })
    const errors = reactive({
        descripcion: [],        
        tituloDescripcion: [],
        imagen: [],
        certificado: [],
        certificadoDos: [],
        descripcionCertificado: [],
        descripcionCertificadoDos: [],        
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("descripcion", form.descripcion);
        form_data.append("imagenSrc", form.imagen);
        
        form_data.append("tituloDescripcion", form.tituloDescripcion);
        form_data.append("certificadoSrc", form.certificado);
        form_data.append("certificadoDosSrc", form.certificadoDos);        
        form_data.append("descripcionCertificado", form.descripcionCertificado);
        form_data.append("descripcionCertificadoDos", form.descripcionCertificadoDos);        

        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/calidad/store',
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
                Añadir Empresa
            </template>
            <template #buttons>
                <router-link
                    to="/calidad"
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
