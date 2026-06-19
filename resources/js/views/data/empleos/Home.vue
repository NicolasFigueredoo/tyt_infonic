<template>
    <SectionHeader>
        <template #title>
            Ofertas Laborales
        </template>
        <template #buttons>
            <router-link to="/adm/data/empleos/add" class="btn btn--green">
                <i class="fas fa-plus"></i> Nueva oferta
            </router-link>
        </template>
    </SectionHeader>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Ubicación</th>
                <th>Fecha de publicación</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, key) in paginator.data" :key="key">
                <td>{{ item.titulo }}</td>
                <td>{{ item.ubicacion }}</td>
                <td>{{ item.fecha_publicacion }}</td>
                <td>{{ item.activo ? 'Sí' : 'No' }}</td>
                <td>
                    <div class="btns">
                        <router-link
                            :to="'/adm/data/empleos/' + item.id + '/edit'"
                            class="btn btn--green"
                        >
                            <i class="fas fa-edit"></i>
                        </router-link>
                        <button class="btn btn--red" @click="deleteItem(item.id)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const paginator = reactive({})

const appliedFilters = reactive({
    titulo: '',
})

const deleteItem = (id) => {
    if (confirm('¿Está seguro de eliminar este registro?')) {
        httpRequest({
            url:    window.public_path + '/adm/empleos/delete/' + id,
            method: 'GET',
        })
        .then(() => {
            syncData()
        })
        .catch(() => {})
    }
}

const syncData = () => {
    let modal = awesomeModal.loading()
    let url = new URL(window.public_path + '/adm/empleos')
    const form = new FormData()
    for (const [key, value] of Object.entries(appliedFilters)) {
        if (value) {
            form.append('filters[' + key + ']', value)
        }
    }

    fetch(url, {
        method: 'POST',
        body:   form,
    })
    .then(response => response.json())
    .then(data => {
        Object.assign(paginator, data)
        modal.close()
    })
    .catch(error => {
        modal.close()
        if (error.response && error.response.status == 401) {
            router.push('/adm/login')
        }
    })
}

syncData()
</script>

<style lang="scss" scoped>
</style>