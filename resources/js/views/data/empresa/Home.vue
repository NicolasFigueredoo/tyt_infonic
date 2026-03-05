<template>
    <SectionHeader>
        <template #title>
            Empresa
        </template>
        
    </SectionHeader>
    <div v-for="(item, key) in paginator.data" :key="key">
        <div class="btns d-flex justify-content-end p-4">
            <router-link
                :to="'/adm/empresa/' + item.id + '/edit'"
                class="btn btn--green"
            >
                <i class="fas fa-edit"></i>
            </router-link>
        </div>

        <div class="grid-2 gap-15">
            <div class="col-1">
                {{ item.descripcion }}
            </div>
            <div class="col-1">
                <img v-bind:src="item.path" class="col-3" style="width:70%" onerror="this.onerror=null;">
            </div>
        </div>
    
   
    </div>    
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
                url: window.public_path + '/adm/empresa/delete/' + id,
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
        let url = new URL(window.public_path + '/adm/empresa')
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
