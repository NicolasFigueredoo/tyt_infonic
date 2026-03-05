<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({        
        orden: '',
        name: '',
        imagen: 0,
        description: '',
        short: '',        
    })
    const errors = reactive({        
        orden: [],
        name: [],
        imagen: [],
        description: [],
        short: [],        
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();
        
        form_data.append("name", form.name);        
        form_data.append("orden", form.orden);        
        form_data.append("imagenSrc", form.imagen);
        form_data.append("description", form.description);
        form_data.append("short", form.short);        

        httpRequest({
            url: window.public_path + '/adm/informacionTecnica/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/informacionTecnica')
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
                Añadir un Articulo
            </template>
            <template #buttons>
                <router-link
                    to="/adm/informacionTecnica"
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
