<template>
    <SectionHeader>
        <template #title>
            Carrito
        </template>
        <template #buttons>
            <!--
            <button
                class="btn btn--gray"
                @click="exportData"
            >
                <i class="fas fa-download"></i> Exportar
            </button>
            <button
                class="btn btn--gray"
                @click="importData"
            >
                <i class="fas fa-upload"></i> Importar
            </button>
            -->
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
                <td>Carrito</td>
                <td>
                    <div class="btns">
                        <router-link
                            :to="'/adm/carrito/edit'"
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
        urlBase: new URL(window.public_path + '/adm/carrito'),
        filtersKeys: ['code', 'name', 'description']        
    })

    pagination.syncData()

    const showStock = (id) => {
        alert('Cargando stock del artículo ' + id)
    }

    const deleteItem = (id) => {
        if (confirm('¿Está seguro de eliminar este registro?')) {
            httpRequest({
                url: window.public_path + '/adm/carrito/delete/' + id,
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
                url: window.public_path + '/adm/carrito/restore/' + id,
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
