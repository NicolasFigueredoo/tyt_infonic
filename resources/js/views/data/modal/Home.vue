<template>
    <SectionHeader>
        <template #title>
            Modal
        </template>
        <template #buttons>
            <router-link
                class="btn btn--yellow"
                to="/adm/data"
            >
                <i class="fas fa-arrow-left"></i> Volver
            </router-link> 
        </template>
    </SectionHeader>
    <table>        
        <tbody>            
            <tr v-for="(item, key) in pagination.paginator.data" :key="key">
                <td class="p-0"></td>               
                <td>Modal</td>
                <td>
                    <div class="btns">
                        <router-link
                            :to="'/adm/modal/edit'"
                            class="btn btn--green"
                        >
                            <i class="fas fa-edit"></i>
                        </router-link>                        
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
    import { reactive, ref } from 'vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    // todo lo anterior se puede abstractar en un mixin, para reutilizarlo en otros componentes
    // ejemplo:
    const pagination = dataPaginator({
        urlBase: new URL(window.public_path + '/adm/modal'),
        filtersKeys: ['code', 'name', 'description']        
    })

    pagination.syncData()

    const showStock = (id) => {
        alert('Cargando stock del artículo ' + id)
    }

    const deleteItem = (id) => {
        if (confirm('¿Está seguro de eliminar este registro?')) {
            httpRequest({
                url: window.public_path + '/adm/modal/delete/' + id,
                method: 'GET'
            })
            .then((data) => {
                pagination.syncData()
            })
            .catch((error) => {})
        }
    }

    const restoreItem = (id) => {
        if (confirm('¿Está seguro de restaurar este registro?')) {
            httpRequest({
                url: window.public_path + '/adm/modal/restore/' + id,
                method: 'GET'
            })
            .then((data) => {
                pagination.syncData()
            })
            .catch((error) => {})
        }
    }
</script>
<style lang="scss" scoped>
    
</style>
