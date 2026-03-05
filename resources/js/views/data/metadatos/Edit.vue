<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({        
        name: '',
        descripcion: '',
        keyword: '',
        seccion: '',
    })
    const errors = reactive({        
        name: [],
        descripcion: [],
        keyword: [],
        seccion: [],
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/metadatos/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.name = data.name
        form.descripcion = data.descripcion
        form.keyword = data.keyword
        form.seccion = data.seccion
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
        form_data.append("descripcion", form.descripcion);
        form_data.append("keyword", form.keyword);
        form_data.append("seccion", form.seccion);

        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }

        httpRequest({
            url: window.public_path + '/adm/metadatos/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/metadatos')
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
                Editar Contacto
            </template>
            <template #buttons>
                <router-link
                    to="/adm/metadatos"
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
