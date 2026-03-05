<template>
    <SectionHeader>
        <template #title>Archivos Media</template>
        <template #buttons>
            <router-link to="/adm/data/archivosmedia/add" class="btn btn--green">
                <i class="fas fa-plus"></i> Nuevo archivo
            </router-link>
        </template>
    </SectionHeader>

    <table>
        <thead>
            <tr>
                <th>Preview</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Peso</th>
                <th>URL pública</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, key) in pagination.paginator.data" :key="key">
                <td style="width:70px">
                    <div class="preview-cell">
                        <img v-if="item.tipo === 'imagen'" :src="item.url_publica" />
                        <div v-else-if="item.tipo === 'video'" class="preview-icon video"><i class="fas fa-film"></i></div>
                        <div v-else-if="item.tipo === 'pdf'"  class="preview-icon pdf"><i class="fas fa-file-pdf"></i></div>
                        <div v-else class="preview-icon otro"><i class="fas fa-file"></i></div>
                    </div>
                </td>
                <td>{{ item.nombre }}</td>
                <td><span :class="['tipo-badge', 'tipo-' + item.tipo]">{{ item.tipo }}</span></td>
                <td>{{ formatSize(item.size) }}</td>
                <td>
                    <div class="url-cell">
                        <span class="url-text">{{ item.url_publica }}</span>
                        <button
                            class="btn-copy"
                            :class="{ copied: copiedId === item.id }"
                            @click="copyUrl(item)"
                            :title="copiedId === item.id ? '¡Copiado!' : 'Copiar URL'"
                        >
                            <i :class="copiedId === item.id ? 'fas fa-check' : 'fas fa-copy'"></i>
                        </button>
                    </div>
                </td>
                <td>
                    <div class="btns">
                        <a :href="item.url_publica" target="_blank" class="btn btn--blue" title="Ver archivo">
                            <i class="fas fa-eye"></i>
                        </a>
                        <router-link :to="'/adm/data/archivosmedia/' + item.id + '/edit'" class="btn btn--green" title="Editar">
                            <i class="fas fa-edit"></i>
                        </router-link>
                        <button class="btn btn--red" @click="deleteItem(item.id)" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <Paginator :paginator="pagination.paginator" @change="pagination.syncData" />
</template>

<script setup>
import { ref } from 'vue'

const copiedId = ref(null)

const pagination = dataPaginator({
    urlBase:     new URL(window.public_path + '/adm/archivosmedia'),
    filtersKeys: ['nombre', 'tipo'],
})
pagination.syncData()

const copyUrl = (item) => {
    navigator.clipboard.writeText(item.url_publica).then(() => {
        copiedId.value = item.id
        setTimeout(() => copiedId.value = null, 2000)
    })
}

const formatSize = (bytes) => {
    if (!bytes) return '—'
    if (bytes < 1024)    return bytes + ' B'
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB'
    return (bytes / 1048576).toFixed(1) + ' MB'
}

const deleteItem = (id) => {
    if (!confirm('¿Eliminar este archivo? Esta acción no se puede deshacer.')) return
    httpRequest({
        url:    window.public_path + '/adm/archivosmedia/delete/' + id,
        method: 'GET',
    }).then(() => pagination.syncData())
}
</script>

<style lang="scss" scoped>
.preview-cell {
    width: 60px; height: 50px;
    display: flex; align-items: center; justify-content: center;
    img { width:100%; height:100%; object-fit:cover; border-radius:4px; }
}
.preview-icon {
    width:44px; height:44px; border-radius:6px;
    display:flex; align-items:center; justify-content:center;
    font-size:1.3rem; color:#fff;
    &.video { background:#6366f1; }
    &.pdf   { background:#ef4444; }
    &.otro  { background:#9ca3af; }
}
.tipo-badge {
    padding: 3px 10px; border-radius: 20px; font-size: .78rem; font-weight: 700; text-transform: uppercase;
    &.tipo-imagen { background:#d1fae5; color:#065f46; }
    &.tipo-video  { background:#ede9fe; color:#4c1d95; }
    &.tipo-pdf    { background:#fee2e2; color:#991b1b; }
    &.tipo-otro   { background:#f3f4f6; color:#374151; }
}
.url-cell { display: flex; align-items: center; gap: 8px; max-width: 320px; }
.url-text {
    font-size: .78rem; color: #6b7280;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 260px;
}
.btn-copy {
    flex-shrink: 0; border: none; background: #f3f4f6; border-radius: 6px;
    width: 30px; height: 30px; cursor: pointer; display:flex; align-items:center; justify-content:center;
    color: #374151; transition: background .2s;
    &:hover  { background: #e5e7eb; }
    &.copied { background: #d1fae5; color: #065f46; }
}
</style>