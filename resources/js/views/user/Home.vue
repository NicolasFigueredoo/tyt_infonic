<template>
    <SectionHeader>
        <template #title>
            Usuarios
        </template>
        <template #buttons>
            <button
                class="btn btn--gray"
                @click="refreshData"
            >
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>            
            <router-link
                to="/adm/user/add"
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
                <th>Nombre de Usuario</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>            
            <tr v-for="(item, key) in paginator.data" :key="key">
                <td class="p-0"></td>
                <td>{{ item.name }}</td>
                <td>{{ item.username }}</td>
                <td>{{ item.email }}</td>
                <td class="btns">
                    <router-link
                        :to="'/adm/user/' + item.id + '/edit'"
                        class="btn btn--green"
                    >
                        <i class="fas fa-edit"></i>
                    </router-link>                    
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
        appliedFilters.name = filters.name
        appliedFilters.username = filters.username
        appliedFilters.email = filters.email
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
                url: window.public_path + '/adm/user/delete/' + id,
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
        let url = new URL(window.public_path + '/adm/user')
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
