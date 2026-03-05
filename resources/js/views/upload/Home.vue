<template>
    <Main>
        <form @submit.prevent="onSubmit">
            <SectionHeader>
                <template #title>
                    Subir Archivo
                </template>
                <template #buttons>
                    <button
                        class="btn btn--green"
                        type="submit"
                    >
                        <i class="fas fa-save"></i> Enviar y Procesar
                    </button>
                </template>
            </SectionHeader>
            <h3>Archivo a subir:</h3>
            <div class="grid-1 gap-15">
                <InputSelect
                    label="Tipo de Archivo"
                    placeholder=""
                    v-model="form.tipo_archivo"
                    :options="[
                        { value: 'control_stock', label: 'Control de Stock' },
                        { value: 'lista_perfiles', label: 'Lista perfiles' },
                    ]"
                    :error="errors.tipo_archivo"
                    class="col-1"
                >
                    <template #option="{ value, label }">
                        <option :value="value">
                            {{ label }}
                        </option>
                    </template>
                </InputSelect>
                <InputFile
                    label="Archivo"
                    placeholder=""
                    v-model="form.archivo"
                    :error="errors.archivo"
                    class="col-1"
                />
            </div>
        </form>
    </Main>
</template>

<script setup>
    import { reactive } from 'vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({
        tipo_archivo: 'lista_perfiles',
        archivo: null,
    })
    const errors = reactive({
        tipo_archivo: [],
        archivo: [],
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();
        console.log(form.archivo)
        form_data.append("tipo_archivo", form.tipo_archivo);
        form_data.append("archivo", form.archivo);


        httpRequest({
            url: window.public_path + '/adm/upload/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            //modal.close()
            console.log(data)
            router.push('/adm/upload')
        })
        .catch((error) => {
            console.log(error)
            //modal.close()
        })
    }
</script>
<style lang="scss" scoped>
    
</style>
