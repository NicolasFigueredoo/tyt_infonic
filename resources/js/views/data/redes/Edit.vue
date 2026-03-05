<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({        
        name: '',
        link: '',      
        imagen: ''  ,
        orden: ''
    })
    const errors = reactive({        
        name: [],
        link: [],      
        imagen:  [] ,
        orden: []
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/redes/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.name = data.name
        form.orden = data.orden
        form.link = data.link      
        form.imagen = data.path        
  
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })


    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("name", form.name);
        form_data.append("orden", form.orden);
        form_data.append("link", form.link);        
        form_data.append("imagen", form.imagen);        

        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }

        httpRequest({
            url: window.public_path + '/adm/redes/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/redes')
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
                Editar Redes
            </template>
            <template #buttons>
                <router-link
                    to="/adm/redes"
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
