<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({        
        orden: '',
        titulo: '',
        ruta: '',    
        imagen: 0,    
        tituloEnglish: ''
     
    })
    const errors = reactive({
        orden: [],
        titulo: [],
        ruta: [],    
        imagen: [],  
        tituloEnglish: []  
         
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("titulo", form.titulo);
        form_data.append("ruta", form.ruta);        
        form_data.append("orden", form.orden);
        form_data.append("imagen", form.imagen);      
        form_data.append("tituloEnglish", form.tituloEnglish);      


        httpRequest({
            url: window.public_path + '/adm/seccionesNaranjas/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/seccionesNaranjas')
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
                Añadir una seccion
            </template>
            <template #buttons>
                <router-link
                    to="/adm/seccionesNaranjas"
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
