<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    const form = reactive({
        id: '',
        cliente: '',
        pedido: '',
        total: '',
        estado: '',
        fecha: '',
        observacion: '',        
    })
    const errors = reactive({
        id: [],
        cliente: [],
        pedido: [],
        total: [],
        estado: [],
        fecha: [],
        observacion: [],        
    })
    let modal = awesomeModal.loading()

    httpRequest({
        url: window.public_path + '/adm/pedidos/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        form.id = data.id
        form.cliente = data.empresa
        form.pedido = data.carrito
        form.total = data.total
        form.estado = data.estado
        form.fecha = data.fecha
        form.observacion = data.observacion        
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })


    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("estado", form.estado);          

        if (route.meta.copy) {
            form_data.append('__form-input-copy', 1);
        }

        httpRequest({
            url: window.public_path + '/adm/pedidos/store/' + route.params.id,
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/pedidos')
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
                Pedidos
            </template>
            <template #buttons>
                <router-link
                    to="/adm/pedidos"
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
