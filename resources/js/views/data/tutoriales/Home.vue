<template>
    <SectionHeader>
        <template #title>
            Tutoriales
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
            <button
                class="btn btn--gray"
                @click="pagination.syncData()"
            >
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
            
            <router-link
                to="/adm/tutoriales/add"
                class="btn btn--green"
            >
                <i class="fas fa-plus"></i> Añadir
            </router-link>
        </template>
    </SectionHeader>
    <table>
        <thead>
            <tr>
                <th class="p-0"></th>                
                <th>Orden</th>                
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, key) in pagination.paginator.data" :key="key">
                <td class="p-0"></td>                
                <td>{{ item.orden }}</td>                
                <td>
                    <div class="btns">
                        <router-link
                            :to="'/adm/tutoriales/' + item.id + '/edit'"
                            class="btn btn--green"
                        >
                            <i class="fas fa-edit"></i>
                        </router-link>
                        <router-link
                            :to="'/adm/tutoriales/' + item.id + '/copy'"
                            class="btn btn--yellow"
                        >
                            <i class="fas fa-copy"></i>
                        </router-link>                                      
                        <button
                            class="btn btn--red"
                            @click="deleteItem(item.id)"
                            v-if="!pagination.trash.value"
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
    import { reactive, ref } from 'vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    
    // todo lo anterior se puede abstractar en un mixin, para reutilizarlo en otros componentes
    // ejemplo:
    const pagination = dataPaginator({
        urlBase: new URL(window.public_path + '/adm/tutoriales'),
        filtersKeys: ['orden']
    })

    pagination.syncData()

    const showStock = (id) => {
        alert('Cargando stock del artículo ' + id)
    }

    const deleteItem = (id) => {
        if (confirm('¿Está seguro de eliminar este registro?')) {
            httpRequest({
                url: window.public_path + '/adm/tutoriales/delete/' + id,
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
                url: window.public_path + '/adm/tutoriales/restore/' + id,
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
