<template>
    <SectionHeader>
        <template #title>
            Grupos
        </template>
        <template #buttons>
            <button
                class="btn btn--gray"
                @click="pagination.syncData()"
            >
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
            <router-link
                to="/group/trash"
                class="btn btn--yellow"
            >
                <i class="fas fa-trash-alt"></i> Papelera
            </router-link>
            <router-link
                to="/group/add"
                class="btn btn--green"
            >
                <i class="fas fa-plus"></i> Añadir
            </router-link>
        </template>
    </SectionHeader>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Guard</th>
                <th>Descipción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, key) in pagination.paginator.data" :key="key">
                <td>{{ item.name }}</td>
                <td>{{ item.guard_name }}</td>
                <td>{{ item.description }}</td>
                <td class="btns">
                    <router-link
                        :to="'/group/' + item.id + '/edit'"
                        class="btn btn--green"
                    >
                        <i class="fas fa-edit"></i>
                    </router-link>
                    <button
                        class="btn btn--red"
                        @click="onDelete(item.id)"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
    import { reactive } from 'vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const exportData = () => {
        alert('Característica no implementada')
    }
    const importData = () => {
        alert('Característica no implementada')
    }


    const pagination = dataPaginator({
        urlBase: new URL(window.public_path + '/adm/group'),
        filtersKeys: []        
    })
    pagination.syncData()

</script>
<style lang="scss" scoped>
    
</style>
