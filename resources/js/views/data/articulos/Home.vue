<template>
    <SectionHeader>
        <template #title>
            Articulos
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
                @click="UpdateArticulosApi()"
            >
                <i class="fas fa-sync-alt"></i> Actualizar Articulos
            </button>
            <button
                class="btn btn--gray d-none"
                @click="pagination.value.syncData()"
            >
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
            
        </template>
    </SectionHeader>
    <div v-if="loading" class="modal">
        <div class="modal-content">
            <p>Cargando...</p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Orden</th>
                <th></th>
                <th>Código</th>
                <th>Nombre</th>
                <th></th>
                <th>Oculto</th>
                <th>Destacado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table__search">                
                <td></td>
                <td></td>
                <td><input type="text" placeholder="CODIGO" v-model="pagination.filters.code" @keyup.enter="pagination.applyFilters" /></td>
                <td><input type="text" placeholder="NOMBRE" v-model="pagination.filters.name" @keyup.enter="pagination.applyFilters" /></td>
                <td><input type="text" placeholder="DESCRIPCION" v-model="pagination.filters.description" @keyup.enter="pagination.applyFilters" /></td>
                <td><input type="checkbox" v-model="pagination.filters.oculto" @keyup.enter="pagination.applyFilters" /></td>
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
                    <td><img v-if="item.path" v-bind:src="item.path" style="max-width: 150px;"></td>
                    <td>{{ item.code }}</td>
                    <td>{{ item.name }}</td>
                    <td></td>
                    <td v-if="item.oculto == 'true'"><button @click="ocultar(item.id)"><i class="far fa-eye-slash"></i></button></td>
                    <td v-else><button @click="ocultar(item.id)"><i class="fas fa-eye"></i></button></td>
                    <td><i v-if="item.destacado == 'true'" class="fas fa-check"></i></td>
                    <td>
                        <div class="btns">
                            <router-link
                                :to="'/adm/articulo/' + item.id + '/edit'"
                                class="btn btn--green"
                                target="_blank"
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
    import { ref, vModelRadio, watch } from 'vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    const dataPage = ref(null)
    const flag = ref(null)
    const loading = ref(false);
    const pagination = dataPaginator({
        urlBase: new URL(window.public_path + '/adm/articulo'),
        filtersKeys: ['code', 'name', 'description','oculto', 'orden']        
    })
    
    
    pagination.syncData()  

    const deleteItem = (id) => {
        if (confirm('¿Está seguro de eliminar este registro?')) {
            httpRequest({
                url: window.public_path + '/adm/articulo/delete/' + id,
                method: 'GET'
            })
            .then((data) => {                
                pagination.syncData()
            })
            .catch((error) => {})
        }
    }
    const ocultar = (id) => {        
        httpRequest({
            url: window.public_path + '/adm/articulo/ocultar/' + id,
            method: 'GET'
        })
        .then((data) => {
            console.log(data)
            pagination.syncData()
        })
        .catch((error) => {})        
    }
    const UpdateArticulosApi = () => {
        if (confirm('¿Está seguro de actualizar los articulos?')) {
            loading.value = true;
            httpRequest({
            url: window.public_path + '/adm/articulo/updateArticulos/adios',
            method: 'GET'
        })
        .then((data) => {
            console.log(data)
            // pagination.syncData()
        })
        .catch((error) => {
            console.log(error)
        })
        .finally(() => {
            loading.value = false;
        });
        }
    }
</script>
<style lang="scss" scoped>
    .modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro semi-transparente */
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.modal p {
    text-align: center;
    font-size: 16px;
    color: #333;
}
</style>
