
<template>
    <div class="grid-2 gap-15">
        <InputText
            label="Nombre"
            placeholder=""
            v-model="form.name"
            :error="errors.name"
            class="col-1"
        />
        <InputText
            label="Guard"
            placeholder=""
            v-model="form.guard_name"
            :error="errors.guard_name"
            class="col-1"
        />
        <InputText
            label="Descripción"
            placeholder=""
            v-model="form.description"
            :error="errors.description"
            class="col-1"
        />
    </div>
    <h3>Permisos:</h3>
    <div class="grid-3 gap-15" v-if="permissions.data && permissions.data.length > 0">
        <InputCheckbox
            v-for="(item, key) in permissions.data"
            :key="key"
            :label="item.description"
            :value="item.id"
            v-model="form.permissions"
        />
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

    const permissions = reactive({})

    httpRequest({
        url: window.public_path + '/adm/permission',
        method: 'GET',
    })
    .then((data) => {
        Object.assign(permissions, data)
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

</script>

<style lang="scss" scoped>
</style>