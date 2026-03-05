<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({
        code: '',
        name: '',
        imagen: 0,
        description: '',
        precio: '',
        unidad: '',
        cantidad: '',
        'stock-min': '',
        tipo_articulo_id: 1,
    })
    const errors = reactive({
        code: [],
        name: [],
        imagen: [],
        description: [],
        tipo_articulo_id: [],
        precio: [],
        unidad: [],
        cantidad: [],
        'stock-min': [],
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("code", form.code);
        form_data.append("name", form.name);
        form_data.append("precio", form.precio);
        form_data.append("unidad", form.unidad);
        form_data.append("cantidad", form.cantidad);
        form_data.append("imagenSrc", form.imagen);
        form_data.append("description", form.description);
        form_data.append('stock-min', form['stock-min']);
        form_data.append("tipo_articulo_id", form.tipo_articulo_id);    

        httpRequest({
            url: window.public_path + '/adm/articulo/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/articulo')
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
                    to="/adm/articulo"
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
