
<template>
    <h3>Datos Basicos:</h3>
    <div class="grid-2 gap-15">
        <InputText
            label="Nombre"
            placeholder=""
            v-model="form.name"
            :error="errors.name"
            class="col-1"
        />
        <InputText
            label="Nombre de Usuario"
            placeholder=""
            v-model="form.username"
            :error="errors.username"
            class="col-1"
        />
        <InputText
            label="Email"
            placeholder=""
            v-model="form.email"
            :error="errors.email"
            class="col-1"
        />
        <InputText
            label="Contraseña"
            placeholder=""
            v-model="form.password"
            :error="errors.password"
            class="col-1"
        />
    </div>
    <h3>Permisos:</h3>
    <div class="grid-2 gap-15">
        <InputSelect
            label="Es Super Administador (ROOT)"
            placeholder=""
            v-model="form.root"
            :options="[
                { value: 0, label: 'No' },
                { value: 1, label: 'Si' },
            ]"
            :error="errors.root"
            class="col-1"
        >
            <template #option="{ value, label }">
                <option :value="value">
                    {{ label }}
                </option>
            </template>
        </InputSelect>
    </div>    
</template>

<script setup>
    import { reactive } from "@vue/reactivity";

    defineProps({
        form: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
            required: true,
        },
    })


    const groups = reactive({})
    httpRequest({
        url: window.public_path + '/adm/group',
        method: 'GET',
    })
    .then((data) => {
        Object.assign(groups, data)
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })
</script>

<style lang="scss" scoped>
</style>