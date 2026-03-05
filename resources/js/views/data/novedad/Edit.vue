<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({        
        name: '',
        orden: '',
        imagen: 0,
        description: '',        
        texto: '',        
        categoria_id: 1,
        categorias: {},        
    })
    const errors = reactive({
        code: [],
        orden: [],
        name: [],
        imagen: [],
        description: [],
        texto: [],
        categoria_id: [],        
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/novedad/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {        
        form.name = data.name
        form.orden = data.orden
        form.imagenSrc = data.path
        form.description = data.description
        form.texto = data.texto
        form.categoria_id = data.categoria_id        
        // Object.assign(form.groups, data.groups)
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
        form_data.append("imagenSrc", form.imagen);
        form_data.append("description", form.description);        
        form_data.append("texto", form.texto);        
        form_data.append("categoria_id", form.categoria_id);    

        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }

        httpRequest({
            url: window.public_path + '/adm/novedad/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/novedad')
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
                Editar Novedad
            </template>
            <template #buttons>
                <router-link
                    to="/adm/novedad"
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
