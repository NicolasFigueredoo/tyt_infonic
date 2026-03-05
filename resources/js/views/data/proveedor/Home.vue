<template>
    <SectionHeader>
        <template #title>
            Proveedores
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
                @click="refreshData"
            >
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
            <router-link
                to="/proveedor/trash"
                class="btn btn--yellow"
            >
                <i class="fas fa-trash-alt"></i> Papelera
            </router-link>
            <router-link
                to="/proveedor/add"
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
                <th>Pais</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table__search">
                <td><i class="fas fa-search-minus table__icon-search"></i></td>
                <td><input type="text" v-model="filters.name" @keyup.enter="applyFilters" /></td>
                <td><input type="text" v-model="filters.country" @keyup.enter="applyFilters" /></td>
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
                <td>{{ item.name }}</td>
                <td>{{ item.country }}</td>
                <td class="btns">
                    <router-link
                        :to="'/proveedor/' + item.id + '/edit'"
                        class="btn btn--green"
                    >
                        <i class="fas fa-edit"></i>
                    </router-link>
                    <router-link
                        :to="'/proveedor/' + item.id + '/copy'"
                        class="btn btn--yellow"
                    >
                        <i class="fas fa-copy"></i>
                    </router-link>                    
                    <button
                        class="btn btn--red"
                        @click="onDelete(item.id)"
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
        name: '',
        username: '',
        email: '',
    })

    const appliedFilters = reactive({
        name: '',
        username: '',
        email: '',
    })

    const applyFilters = () => {
        appliedFilters.code = filters.code
        appliedFilters.name = filters.name
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
    const syncData = () => {
        let modal = awesomeModal.loading()
        let url = new URL(window.public_path + '/api/proveedor')
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
                router.push('/login')
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
