<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({
        name: '',
        orden: '',
        oculto: '',
        imagen: 0,
        destacado: '',
        imagenMarca: 0,
        categorias: [],
        productos: [],
        seleccionados: [],
        principal: '',
        sub_categoria_id: '',
        code: '',
        nameEnglish: ''

    })
    const errors = reactive({
        name: [],
        orden: [],
        oculto: [],
        imagen: [],
        destacado: [],
        imagenMarca: [],
        categorias: [],
        productos: [],
        seleccionados: [],
        sub_categoria_id: [],
        principal: [],
        code: [],
        nameEnglish: []
    })

    httpRequest({
        url: window.public_path + '/adm/tipo-articulo/' + 0,
        method: 'GET',
    })
    .then((data) => {
        form.categorias = data.categorias
        form.productos = data.productos

    })   .catch((error) => {
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("name", form.name);
        form_data.append("orden", form.orden);
        form_data.append("oculto", form.oculto);
        form_data.append("imagen", form.imagen);
        form_data.append("destacado", form.destacado);
        form_data.append("imagenMarca", form.imagenMarca);
        form_data.append("sub_categoria_id", form.sub_categoria_id);
        form_data.append("principal", form.principal);
        form_data.append("productos", JSON.stringify(form.seleccionados));
        form_data.append("code", form.code);
        form_data.append("nameEnglish", form.nameEnglish);

        
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/tipo-articulo/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/tipo-articulo')
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
                Añadir Categoria
            </template>
            <template #buttons>
                <router-link
                    to="/tipo-articulo"
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
