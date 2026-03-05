<script setup>
    import { reactive } from 'vue'
    import Form from './FormSlider.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({
        descripcion: '',
        descripcionEnglish: '',
        tituloEnglish: '',
        titulo: '',
        orden: '',
        imagen: 0,
    })
    const errors = reactive({
        descripcion: [],
        titulo: [],
        orden: [],
        imagen: [],
        descripcionEnglish: [],
        tituloEnglish: [],
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("descripcion", form.descripcion);
        form_data.append("titulo", form.titulo);
        form_data.append("orden", form.orden);
        form_data.append("imagenSrc", form.imagen);
        form_data.append("descripcionEnglish", form.descripcionEnglish);
        form_data.append("tituloEnglish", form.tituloEnglish);
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/inicio/slider/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {

            console.log(data)
            modal.close()
            router.push('/adm/inicio/slider')
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
                    to="/adm/inicio/slider"
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
