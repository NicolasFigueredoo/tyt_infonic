<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({        
        name: '',
        descripcion:'',
        orden: '',
        direccion: '',
        email: '',
        telefono: '',
        wsp: '',
        horario: '',
        
        
    })
    const errors = reactive({
        name: [],
        orden: [],
        direccion: [],
        email: [],
        telefono: [],
        wsp: [],        
        horario: [],  
        descripcion: [],        
      
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("name", form.name);
        form_data.append("orden", form.orden);
        form_data.append("direccion", form.direccion);
        form_data.append("email", form.email);
        form_data.append("telefono", form.telefono);
        form_data.append("wsp", form.wsp);
        form_data.append("horario", form.horario);
        form_data.append("descripcion", form.descripcion);


        httpRequest({
            url: window.public_path + '/adm/contacto/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/contacto')
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
                    to="/adm/contacto"
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
