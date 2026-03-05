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
        descriptionPrivada: '',
        oculto: '',
        precio: '',        
        'stock-min': '',
        tipo_articulo_id: 1,
        orden: '',
        marca: '',
        nameEnglish: '',
        bultoMinorista:'',
        bultoMayorista: '',
        video: '',
        videoTwo: '',
        slug: ''

    })
    const errors = reactive({
        code: [],
        name: [],
        imagen: [],
        description: [],
        descriptionPrivada: [],
        oculto: [],
        tipo_articulo_id: [],
        precio: [],                
        'stock-min': [],
        orden: [],
        marca: [],
        nameEnglish: [],
           bultoMinorista: [],
        bultoMayorista: [],
           video: [],
        videoTwo: [],
        slug: []
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("code", form.code);
        form_data.append("name", form.name);
        form_data.append("precio", form.precio);        
        form_data.append("imagenSrc", form.imagen);
        form_data.append("description", form.description);
        form_data.append("descriptionPrivada", form.descriptionPrivada);
        form_data.append("description", form.description);
        form_data.append("oculto", form.oculto);
        form_data.append('stock-min', form['stock-min']);
        form_data.append("tipo_articulo_id", form.tipo_articulo_id);    
        form_data.append("orden", form.orden);
        form_data.append("marca", form.marca);
        form_data.append("nameEnglish", form.nameEnglish);
        form_data.append("bultoMinorista", form.bultoMinorista);   
        form_data.append("bultoMayorista", form.bultoMayorista);  
        form_data.append("video", form.video);  
        form_data.append("videoTwo", form.videoTwo); 
        form_data.append("slug", form.slug); 

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
