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
        talle: '',
        color: [],
        ficha: 0,
        galeria: [],
        description: '',
        'stock-min': '',        
    })
    const errors = reactive({
        code: [],
        name: [],
        imagen: [],
        talle: [],
        color: [],
        ficha: [],
        galeria: [],
        description: [],        
        'stock-min': [],
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("code", form.code);
        form_data.append("name", form.name);
        form_data.append("imagenSrc", form.imagen);
        form_data.append("talle", form.talle);        
        form_data.append("fichaHref", form.ficha);
        for (var i = 0; i < form.galeria.length; i++ ){
            let file = form.galeria[i];
            form_data.append('galeria[' + i + ']', file);
        }

        for (var i = 0; i < form.color.length; i++ ){
            let file = form.color[i];
            form_data.append('color[' + i + ']', file);
        }
        form_data.append("description", form.description);
        form_data.append('stock-min', form['stock-min']);        

        httpRequest({
            url: window.public_path + '/adm/articuloSuelas/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/articuloSuelas')
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
                    to="/adm/articuloSuelas"
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
