<template>
    <SectionHeader>
        <template #title>
            Clientes
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
                @click="refreshData"
            >
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
            
            <router-link
                to="/adm/clientes/add"
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
                <th>Empresa</th>
                <th>Nombre</th>
                <th style='text-align: end;'>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table__search d-none">
                <td><i class="fas fa-search-minus table__icon-search"></i></td>
                <td><input type="text" v-model="filters.username" @keyup.enter="applyFilters" /></td>
                
                <td>
                    <div class="btns">
                        <button class="btn btn--green" @click="applyFilters">
                            Buscar <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn--gray" @click="clearFilters">
                            <i class="fas fa-eraser"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr v-for="(item, key) in paginator.data" :key="key">
                <td class="p-0"></td>
                <td>{{ item.empresa }}</td>                
                <td>{{ item.username }}</td>                
                <td class="btns d-flex justify-content-end">
                    <router-link
                        :to="'/adm/clientes/' + item.id + '/edit'"
                        class="btn btn--green"
                    >
                        <i class="fas fa-edit"></i>
                    </router-link>
                    <!-- <router-link
                        :to="'/adm/clientes/' + item.id + '/copy'"
                        class="btn btn--yellow"
                    >
                        <i class="fas fa-copy"></i>
                    </router-link>                     -->
                    <button
                        class="btn btn--red"
                        @click="deleteItem(item.id)"
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

    const paginator = reactive({})
    const exportData = () => {
        alert('Característica no implementada')
    }
    const importData = () => {
        alert('Característica no implementada')
    }

    const filters = reactive({
        username: '',
        empresa: '',
        usernombre: '',
        email: '',
    })

    const appliedFilters = reactive({
        username: '',
        empresa: '',
        usernombre: '',
        email: '',
    })

    const applyFilters = () => {
        appliedFilters.empresa = filters.empresa
        appliedFilters.username = filters.username
        appliedFilters.description = filters.description
        refreshData()
    }

    const clearFilters = () => {
        for (const key in filters) {
            filters[key] = ''
        }
        for (const key in appliedFilters) {
            appliedFilters[key] = ''
        }
        refreshData()
    }

    const deleteItem = (id) => {
        if (confirm('¿Está seguro de eliminar este registro?')) {
            httpRequest({
                url: window.public_path + '/adm/clientes/delete/' + id,
                method: 'GET'
            })
            .then((data) => {
                pagination.syncData()
            })
            .catch((error) => {})
        }
    }


    const syncData = () => {
        let modal = awesomeModal.loading()
        let url = new URL(window.public_path + '/adm/clientes')
        const form = new FormData()
        for (const [key, value] of Object.entries(appliedFilters)) {
            if (value) {
                form.append('filters[' + key + ']', value)
            }
        }
        // fetch using method POST

        fetch(url, {
            method: 'POST',
            body: form,
        })
        .then(response => response.json())
        .then(data => {
            console.log(data)
            Object.assign(paginator, data)
            modal.close()
        })
        .catch(error => {
            modal.close()
            // Código de estado: 401 Unauthorized
            if (error.response.status == 401) {
                console.log('acceso denegado')
                router.push('/adm/login')
                return false
            }
            // Código de estado: 422 Unprocessable Content
            if (error.response.status == 422) {
                Object.assign(errors, error.response.data.errors)
                return false
            }
        })
    }
    const refreshData = () => {
        syncData()
    }
    syncData()
</script>
<style lang="scss" scoped>
    
</style>
