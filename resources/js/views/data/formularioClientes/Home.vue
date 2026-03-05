<template>
    <SectionHeader>
        <template #title>
            Formulario de clientes — Campos
        </template>
        <template #buttons>
            <router-link class="btn btn--yellow" to="/adm/data">
                <i class="fas fa-arrow-left"></i> Volver
            </router-link>
            <router-link class="btn btn--green" to="/adm/formclientes/add">
                <i class="fas fa-plus"></i> Nuevo campo
            </router-link>
        </template>
    </SectionHeader>

    <table>
        <thead>
            <tr>
                <th>Orden</th>
                <th>Pregunta / Label</th>
                <th>Tipo</th>
                <th>Requerido</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, key) in pagination.paginator.data" :key="key">
                <td>{{ item.orden }}</td>
                <td>{{ item.label }}</td>
                <td>
                    <span class="badge">{{ labelTipo(item.tipo) }}</span>
                </td>
                <td>
                    <i :class="item.requerido ? 'fas fa-check text-green' : 'fas fa-times text-red'"></i>
                </td>
                <td>
                    <i :class="item.activo ? 'fas fa-check text-green' : 'fas fa-times text-red'"></i>
                </td>
                <td>
                    <div class="btns">
                        <router-link
                            :to="'/adm/formclientes/' + item.id + '/edit'"
                            class="btn btn--green"
                        >
                            <i class="fas fa-edit"></i>
                        </router-link>
                        <button
                            class="btn btn--red"
                            type="button"
                            @click="deleteItem(item.id)"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <Paginator
        :paginator="pagination.paginator"
        @change="pagination.syncData"
    />
</template>

<script setup>
const pagination = dataPaginator({
    urlBase: new URL(window.public_path + '/adm/formclientes'),
    filtersKeys: ['label'],
})

pagination.syncData()

const tiposMap = {
    text:     'Texto corto',
    textarea: 'Texto largo',
    email:    'Email',
    number:   'Número',
    select:   'Select',
    checkbox: 'Checkbox',
    radio:    'Radio',
    file:     'Archivo',
    link:     'Link / URL',
}

const labelTipo = (tipo) => tiposMap[tipo] ?? tipo

const deleteItem = (id) => {
    if (!confirm('¿Eliminar este campo del formulario?')) return

    httpRequest({
        url:    window.public_path + '/adm/formclientes/delete/' + id,
        method: 'GET',
    })
    .then(() => pagination.syncData())
    .catch((error) => console.error(error))
}
</script>

<style lang="scss" scoped>
.badge {
    background: #e8f0fe;
    color: #1a56db;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 500;
}
.text-green { color: #22c55e; }
.text-red   { color: #ef4444; }
</style>