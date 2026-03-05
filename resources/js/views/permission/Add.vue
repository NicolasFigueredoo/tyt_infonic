<script setup>
    import { reactive } from 'vue'
    import Form from './Form.vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const form = reactive({
        name: '',
        group_prefix: '',
        guard_name: 'web',
        description: '',
        assistant: 'no',
    })
    const errors = reactive({
        name: [],
        group_prefix: [],
        guard_name: [],
        description: [],
        assistant: [],
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("name",         form.name);
        form_data.append("group_prefix", form.group_prefix);
        form_data.append("guard_name",   form.guard_name);
        form_data.append("description",  form.description);
        form_data.append("assistant",    form.assistant);

        // clear all errors
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })

        httpRequest({
            url: window.public_path + '/adm/permission/store',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            router.push('/adm/permission')
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
                Añadir un Permiso
            </template>
            <template #buttons>
                <router-link
                    to="/permission"
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
        <div class="grid-2 gap-15 mt-15">
            <InputSelect
                label="Asistente"
                placeholder=""
                v-model="form.assistant"
                :options="[
                    { value: 'no', label: 'No' },
                    { value: 'crud-basic', label: 'Generate CRUD (-*)' },
                ]"
                :error="errors.assistant"
                class="col-1"
            >
                <template #option="{ value, label }">
                    <option :value="value">
                        {{ label }}
                    </option>
                </template>
            </InputSelect>
        </div>
    </form>
</template>


<style lang="scss" scoped>
</style>
