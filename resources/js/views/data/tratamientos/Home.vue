<template>
    <SectionHeader>
        <template #title>
            Tratamientos
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
                to="/data"
            >
                <i class="fas fa-arrow-left"></i> Volver
            </router-link>
            <button
                class="btn btn--gray"
                @click="pagination.syncData()"
            >
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
            <button
                class="btn btn--yellow"
                @click="pagination.trash.value = true"
                v-if="!pagination.trash.value"
            >
                <i class="fas fa-trash-alt"></i> Papelera
            </button>
            <button
                class="btn btn--yellow"
                @click="pagination.trash.value = false"
                v-if="pagination.trash.value"
            >
                <i class="fas fa-undo"></i>
                Salir de la Papelera
            </button>
            <router-link
                to="/tratamiento/add"
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
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table__search">
                <td><i class="fas fa-search-minus table__icon-search"></i></td>
                <td><input type="text" v-model="pagination.filters.name" @keyup.enter="pagination.applyFilters" /></td>
                <td><input type="text" v-model="pagination.filters.description" @keyup.enter="pagination.applyFilters" /></td>
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
                <td>{{ item.name }}</td>
                <td>{{ item.description }}</td>
                <td>
                    <div class="btns">
                        <router-link
                            :to="'/tratamiento/' + item.id + '/edit'"
                            class="btn btn--green"
                        >
                            <i class="fas fa-edit"></i>
                        </router-link>
                        <router-link
                            :to="'/tratamiento/' + item.id + '/copy'"
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
        urlBase: new URL(window.public_path + '/api/tratamiento'),
        filtersKeys: ['code', 'name', 'description']        
    })

    pagination.syncData()

    const showStock = (id) => {
        alert('Cargando stock del artículo ' + id)
    }

    const deleteItem = (id) => {
        if (confirm('¿Está seguro de eliminar este registro?')) {
            httpRequest({
                url: window.public_path + '/api/tratamiento/delete/' + id,
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
                url: window.public_path + '/api/tratamiento/restore/' + id,
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
