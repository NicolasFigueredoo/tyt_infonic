<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({        
        imagen: '',        
        activo: '',
        link: ''
    })
    const errors = reactive({        
        imagen: [],        
        activo: [],
        link: []
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/modal/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.imagenSrc = data.path        
        form.activo = data.orden
        form.link = data.mapa
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })


    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("imagenSrc", form.imagen);
        form_data.append("activo", form.activo);
        form_data.append("link", form.link);

        httpRequest({
            url: window.public_path + '/adm/modal/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/modal')
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
                Editar Modal
            </template>
            <template #buttons>
                <router-link
                    to="/adm/modal"
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
