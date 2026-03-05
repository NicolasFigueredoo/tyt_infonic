<template>
    <SectionHeader>
        <template #title>
            Slider
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
                to="/adm/inicio"
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
                to="/adm/inicio/slider/add"
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
                <th>Titulo</th>                
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
                <td>{{ item.orden }}</td>                

                <td class="pl-3" style="padding: 10px;">
    <template v-if="isImage(item.path)">
        <img :src="item.path" class="col-1" style="width: 100px; height: auto;" @error="onError">
    </template>
    <template v-else>
        <svg fill="#000000" height="50" width="50" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 220 220" xml:space="preserve">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path d="M220,46.444l-64.289,45.498V38.87H0v142.26h155.711v-53.071l64.288,45.497L220,46.444z M135.798,73.562H19.915V57.884 h115.883V73.562z"></path>
            </g>
        </svg>
    </template>
</td>
              
                <td>{{ item.titulo }}</td>                
                <td>
                    <div class="btns">
                        <router-link
                            :to="'/adm/inicio/slider/' + item.id + '/edit'"
                            class="btn btn--green"
                        >
                            <i class="fas fa-edit"></i>
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
        urlBase: new URL(window.public_path + '/adm/inicio/slider'),
        filtersKeys: ['code', 'name', 'description']        
    })

    pagination.syncData()

    const showStock = (id) => {
        alert('Cargando stock del artículo ' + id)
    }

    const isImage = (path) => {
        return /\.(jpg|jpeg|png|gif|bmp|webp)$/i.test(path)
    }

    const deleteItem = (id) => {
        if (confirm('¿Está seguro de eliminar este registro?')) {
            httpRequest({
                url: window.public_path + '/adm/inicio/slider/delete/' + id,
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
                url: window.public_path + '/adm/inicio/slider/restore/' + id,
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
