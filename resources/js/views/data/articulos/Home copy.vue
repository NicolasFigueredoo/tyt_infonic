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
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Código</th>
                <th>Nombre</th>
                <th></th>
                <th>Oculto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table__search">                
                <td></td>
                <td><input type="text" placeholder="CODIGO" v-model="pagination.filters.code" @keyup.enter="pagination.applyFilters" /></td>
                <td><input type="text" placeholder="NOMBRE" v-model="pagination.filters.name" @keyup.enter="pagination.applyFilters" /></td>
                <td><input type="text" placeholder="DESCRIPCION" v-model="pagination.filters.description" @keyup.enter="pagination.applyFilters" /></td>
                <td><input type="checkbox" v-model="pagination.filters.oculto" @keyup.enter="pagination.applyFilters" /></td>
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
            <template v-if="!dataPage">
                <tr v-for="(item, key) in pagination.paginator.data" :key="key">                    
                    <td><img v-if="item.path" v-bind:src="item.path" style="max-width: 150px;"></td>
                    <td>{{ item.code }}</td>
                    <td>{{ item.name }}</td>
                    <td></td>
                    <td v-if="item.oculto == 'true'"><button @click="ocultar(item.id)"><i class="far fa-eye-slash"></i></button></td>
                    <td v-else><button @click="ocultar(item.id)"><i class="fas fa-eye"></i></button></td>
                    <td>
                        <div class="btns">
                            <router-link
                                :to="'/adm/articulo/' + item.id + '/edit'"
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
            </template>
            <template v-else>
                <tr v-for="(item, key) in dataPage" :key="key">
                    <td><img v-if="item.path" v-bind:src="item.path" style="max-width: 150px;"></td>
                    <td>{{ item.code }}</td>
                    <td>{{ item.name }}</td>
                    <td></td>
                    <td v-if="item.oculto == 'true'"><button @click="ocultar(item.id)"><i class="far fa-eye-slash"></i></button></td>
                    <td v-else><button @click="ocultar(item.id)"><i class="fas fa-eye"></i></button></td>
                    <td>
                        <div class="btns">
                            <router-link
                                :to="'/adm/articulo/' + item.id + '/edit'"
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
            </template>
        </tbody>
    </table>    
    <Paginator        
        :paginator="pagination.paginator"
        @change="pagination.syncData"        
    />
</template>

<script setup>
    import { ref, watch } from 'vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    const dataPage = ref(null)
    const flag = ref(null)
    // todo lo anterior se puede abstractar en un mixin, para reutilizarlo en otros componentes
    // ejemplo:
    const pagination = dataPaginator({
        urlBase: new URL(window.public_path + '/adm/articulo'),
        filtersKeys: ['code', 'name', 'description','oculto']        
    })
    
    watch( pagination.paginator, (newValue, oldValue) => {
        flag.value++;        
        if(newValue.current_page != 1){
            const jsonData = JSON.stringify(newValue.data);
            localStorage.setItem('data', jsonData);
            localStorage.setItem('page', newValue.current_page);            
            dataPage.value = newValue.data
            console.log('pagination')
            console.log(pagination)
            console.log('pagination.paginator')
            console.log(pagination.paginator)
            console.log('pagination.paginator.current_page')
            console.log(pagination.paginator.current_page)
            console.log('data')
            console.log(newValue.data)
        }
        if(flag.value > 2 && newValue.current_page == 1){
            dataPage.value = newValue.data           
        }
        const elements = document.querySelectorAll('.modal-item');            
        elements.forEach(element => {
            element.remove();
        });
    });
    if(localStorage.getItem('data') !== null) {
        const page = localStorage.getItem('data');
        if(page){
            const json_page = JSON.parse(page)
            dataPage.value = json_page
            localStorage.removeItem('page')
            localStorage.removeItem('data')
            flag.value = 1;
        }
    }else{        
        pagination.syncData()  
    }
    
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
            httpRequest({
                url: window.public_path + '/adm/articulo/updateArticulos',
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
