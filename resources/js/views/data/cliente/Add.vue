<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({
        username: '',
        apellido: '',
        iva: '',
        direccion: '',
        direccionEntrega: '',
        transporte: '',
        cp: '',
        provincia: '',
        localidad: '',
        orden: '',
        empresa: '',
        phone: '',
        email: '',
        cuit: '',
        password: '',
        descuento: ''
    })
    const errors = reactive({
        username: [],
        apellido: [],
        iva: [],
        direccion: [],
        direccionEntrega: [],
        transporte: [],
        cp: [],
        provincia: [],
        localidad: [],
        orden: [],
        empresa: [],
        phone: [],
        email: [],
        cuit: [],
        password: [],
        descuento: [],

    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("username", form.razonSocial);
        form_data.append("apellido", form.apellido);
        form_data.append("iva", form.iva);
        form_data.append("direccion", form.direccion);
        form_data.append("direccionEntrega", form.direccionEntrega);
        form_data.append("transporte", form.transporte);
        form_data.append("cp", form.cp);
        form_data.append("provincia", form.provincia);
        form_data.append("localidad", form.localidad);
        form_data.append("orden", form.orden);
        form_data.append("empresa", form.empresa);
        form_data.append("phone", form.phone);
        form_data.append("email", form.email);
        form_data.append("cuit", form.cuit);
        form_data.append("password", form.password);
        form_data.append("descuento", form.descuento);

        console.log('pasando por aqui');
        console.log(form.password);
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })
        
            httpRequest({
            url: window.public_path + '/adm/clientes/store',
            method: 'POST',
            data: form_data,
            errors: errors,
            })
            .then((data) => {
                modal.close()
                router.push('/adm/clientes')
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
                Añadir Tipo de Artículo
            </template>
            <template #buttons>
                <router-link
                    to="/clientes"
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
