<script setup>
    import { reactive, ref } from 'vue'
    import Form from './Form.vue'
    import { required, email, validate } from '../../../libs/validate'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({
        cuenta: '',
        razonSocial: '',
        direccion: '',
        provincia: '',
        codigoVendedor: '',
        vendedorDescripcion: '',        
        codigoBonificacion: '',
        bonificacionDescripcion: '',
        password: '',
        email:'',
        descuento: '',
        categorias: [],
        seleccionados: []
    })
    const errors = reactive({
        cuenta: [],
        razonSocial: [],
        direccion: [],
        provincia: [],
        codigoVendedor: [],
        vendedorDescripcion: [],        
        codigoBonificacion: [],
        bonificacionDescripcion: [],
        password: [],
        email: [],
        descuento: [],
        categorias: [],
        seleccionados: []


    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/clientes/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        console.log(data.data)
        console.log(window.public_path + '/adm/clientes/' + route.params.id)
        form.cuenta = data.clientes.cuenta
        form.username = data.clientes.razonSocial
        form.razonSocial = data.clientes.razonSocial
        form.direccion = data.clientes.direccion
        form.provincia = data.clientes.provincia
        form.codigoVendedor = data.clientes.codigoVendedor
        form.vendedorDescripcion = data.clientes.vendedorDescripcion
        form.codigoBonificacion = data.clientes.codigoBonificacion
        form.bonificacionDescripcion = data.clientes.bonificacionDescripcion
        form.email = data.clientes.email
        form.descuento = data.clientes.descuento
        form.password = data.clientes.password
        form.categorias = data.categorias
        form.seleccionados = data.seleccionadas.map(id => {
    return form.categorias.find(cat => cat.id === id)
}).filter(Boolean);
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const title = ref('Editar')
    if (route.meta.copy) {
        title.value = 'Copiar'
    }
    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();
        form_data.append("cuenta", form.cuenta);
        form_data.append("razonSocial", form.razonSocial);
        form_data.append("direccion", form.direccion);
        form_data.append("provincia", form.provincia);
        form_data.append("codigoVendedor", form.codigoVendedor);
        form_data.append("vendedorDescripcion", form.vendedorDescripcion);        
        form_data.append("codigoBonificacion", form.codigoBonificacion);
        form_data.append("bonificacionDescripcion", form.bonificacionDescripcion);
        form_data.append("password", form.password);
        form_data.append("email", form.email);
        form_data.append("descuento", form.descuento);
        form_data.append("categorias", JSON.stringify(form.seleccionados));

        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }
        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })
        
            httpRequest({
                url: window.public_path + '/adm/clientes/store/' + route.params.id,
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
                {{ title }}
            </template>
            <template #buttons>
                <router-link
                    to="/adm/clientes"
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
