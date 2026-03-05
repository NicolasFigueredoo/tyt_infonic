<template>
    <SectionHeader>
        <template #title>
            Articulos Suelas
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
                to="/adm/articuloSuelas/add"
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
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>                
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table__search d-none">
                <td><i class="fas fa-search-minus table__icon-search"></i></td>
                <td></td>
                <td><input type="text" v-model="pagination.filters.code" @keyup.enter="pagination.applyFilters" /></td>
                <td><input type="text" v-model="pagination.filters.name" @keyup.enter="pagination.applyFilters" /></td>
                <td><input type="text" v-model="pagination.filters.description" @keyup.enter="pagination.applyFilters" /></td>
                <td></td>
                <td>
                    <div class="btns">
                        <button class="btn btn--green" @click="pagination.applyFilters">
                            Buscar <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn--gray" @click="pagination.clearFilters">
                            <i class="fas fa-eraser"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr v-for="(item, key) in pagination.paginator.data" :key="key">
                <td class="p-0"></td>
                <td>{{ item.id }}</td>
                <td>{{ item.code }}</td>
                <td>{{ item.name }}</td>                
                <td>
                    <div class="btns">
                        <router-link
                            :to="'/adm/articuloSuelas/' + item.id + '/edit'"
                            class="btn btn--green"
                        >
                            <i class="fas fa-edit"></i>
                        </router-link>
                        <router-link
                            :to="'/adm/articuloSuelas/' + item.id + '/copy'"
                            class="btn btn--yellow"
                        >
                            <i class="fas fa-copy"></i>
                        </router-link>
                        <button
                            class="btn btn--gray"
                            @click="showStock(item.id)"
                        >
                            <i class="fas fa-box"></i>
                        </button>                
                        <button
                            class="btn btn--red"
                            @click="deleteItem(item.id)"
                            v-if="!pagination.trash.value"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                        <button
                            class="btn btn--red"
                            @click="restoreItem(item.id)"
                            v-else
                        >
                            <i class="fas fa-trash-restore"></i>
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
        urlBase: new URL(window.public_path + '/adm/articuloSuelas'),
        filtersKeys: ['code', 'name', 'description']        
    })

    pagination.syncData()

    const showStock = (id) => {
        alert('Cargando stock del artículo ' + id)
    }

    const deleteItem = (id) => {
        if (confirm('¿Está seguro de eliminar este registro?')) {
            httpRequest({
                url: window.public_path + '/adm/articuloSuelas/delete/' + id,
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
                url: window.public_path + '/adm/articuloSuelas/restore/' + id,
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
