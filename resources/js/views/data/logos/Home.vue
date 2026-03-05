<template>
    <SectionHeader>
        <template #title>
            Logos
        </template>
        <template #buttons>
   
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
            
  
        </template>
    </SectionHeader>
    <table>
        <thead>
            <tr>
                <th class="p-0"></th>    
                <th>Imagen</th>                            
                <th>Titulo</th>     
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>            
            <tr v-for="(item, key) in pagination.paginator.data" :key="key">
                <td class="p-0"></td>               
                <td class="p-3" style="background-color: dimgray;"><img v-bind:src="item.path" class="col-1" style="width: 100px;height: auto;" onerror="this.onerror=null;"></td>   
                <td>{{ item.seccion }}</td>

                <td>
                    <div class="btns">
                        <router-link
                            :to="'/adm/logosNuevos/' + item.id + '/edit'"
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
        urlBase: new URL(window.public_path + '/adm/logosNuevos'),
        filtersKeys: ['seccion']        
        })
    console.log(pagination)


    pagination.syncData()



    const showStock = (id) => {
        alert('Cargando stock del artículo ' + id)
    }

    const deleteItem = (id) => {
        if (confirm('¿Está seguro de eliminar este registro?')) {
            httpRequest({
                url: window.public_path + '/adm/logosNuevos/delete/' + id,
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
                url: window.public_path + '/adm/logosNuevos/restore/' + id,
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
