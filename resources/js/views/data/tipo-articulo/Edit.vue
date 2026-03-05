<script setup>
    import { reactive, ref } from 'vue'
    import Form from './Form.vue'
    import { required, email, validate } from '../../../libs/validate'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({
        name: '',
        code: '',
        orden: '',
        oculto: '',
        imagen: 0,
        principal:'',
        destacado: '',
        imagenMarca: 0,
        categoria: '',
        sub_categoria_id: '',
        categorias: [],
        productos: [],
        seleccionados: [],
        nameEnglish: ''

    })
    const errors = reactive({
        name: [],
        code: [],
        orden: [],
        oculto: [],
        principal: [],
        productos: [],
        imagen: [],
        destacado: [],
        imagenMarca: [],
        sub_categoria_id: [],
        categorias: [],
        seleccionados: [],
        nameEnglish: []
    })

    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/tipo-articulo/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.name = data.item.name
        form.code = data.item.code
        form.orden = data.item.orden
        form.imagenSrc = data.item.path
        form.imagenMarca = data.item.secondary_path
        form.sub_categoria_id = data.item.sub_categoria_id
        form.categorias = data.categorias
        form.productos = data.productos
        form.seleccionados = data.articulosVinculados
        form.principal = (data.item.principal === 'true');;
        form.destacado = (data.item.destacado === 'true');;
        form.oculto = (data.item.oculto === 'true');
        form.nameEnglish = data.item.nameEnglish;

        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const title = ref('Editar Categoria')
    if (route.meta.copy) {
        title.value = 'Copiar Categoria'
    }
    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("name", form.name);
        form_data.append("orden", form.orden);
        form_data.append("oculto", form.oculto);
        form_data.append("imagenSrc", form.imagen);
        form_data.append("destacado", form.destacado);
        form_data.append("imagenMarca", form.imagenMarca);
        form_data.append("sub_categoria_id", form.sub_categoria_id);
        form_data.append("productos", JSON.stringify(form.seleccionados));
        form_data.append("principal", form.principal);
        form_data.append("code", form.code);
        form_data.append("nameEnglish", form.nameEnglish);

        
        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/tipo-articulo/store/' + route.params.id,
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
                {{ title }}
            </template>
            <template #buttons>
                
                <router-link
                    to="/adm/tipo-articulo"
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
