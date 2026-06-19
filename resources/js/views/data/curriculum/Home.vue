<template>
    <SectionHeader>
        <template #title>
            CVs Recibidos
        </template>
    </SectionHeader>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Oferta</th>
                <th>Fecha</th>
                <th>CV</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, key) in paginator.data" :key="key">
                <td>{{ item.nombre }} {{ item.apellido }}</td>
                <td>{{ item.email }}</td>
                <td>{{ item.telefono || '-' }}</td>
                <td>{{ item.oferta_titulo || 'Base general' }}</td>
                <td>{{ item.created_at ? item.created_at.substring(0, 10) : '-' }}</td>
                <td>
                    
                      <a  v-if="item.cv_path"
                        :href="publicPath + '/storage/' + item.cv_path"
                        target="_blank"
                        class="btn btn--green"
                    >
                        <i class="fas fa-file-alt"></i> Ver CV
                    </a>
                    <span v-else>-</span>
                </td>
                <td>
                    <div class="btns">
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
const publicPath = window.public_path

const paginator = reactive({})

const appliedFilters = reactive({
    nombre: '',
})

const deleteItem = (id) => {
    if (confirm('¿Está seguro de eliminar este registro?')) {
        httpRequest({
            url:    window.public_path + '/adm/postulaciones/delete/' + id,
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
    let url = new URL(window.public_path + '/adm/postulaciones')
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