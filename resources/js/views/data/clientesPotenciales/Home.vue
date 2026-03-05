<template>
    <SectionHeader>
        <template #title>
            Clientes potenciales
        </template>
        <template #buttons>
            <router-link
                class="btn btn--yellow"
                to="/adm/data"
            >
                <i class="fas fa-arrow-left"></i> Volver
            </router-link>
        </template>
    </SectionHeader>
    <table>
        <thead>
            <tr>
                <th class="p-0">Fecha</th>
                <th class="p-0">Nombre</th>
                <th>Razon Social</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, key) in pagination.paginator.data" :key="key">
                <td>{{ formatDate(item.created_at) }}</td>
                <td>{{ item.nombre }} {{ item.apellido }}</td>
                <td>{{ item.razonSocial }}</td>
                <td>{{ item.email }}</td>
                <td>
                    <div class="btns">
                        <router-link
                            :to="'/adm/clientespotenciales/' + item.id + '/edit'"
                            class="btn btn--green"
                        >
                            <i class="fas fa-edit"></i>
                        </router-link>
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
import { reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

// Función de paginación
const pagination = dataPaginator({
    urlBase: new URL(window.public_path + '/adm/clientespotenciales'),
    filtersKeys: ['email', 'razonsocial'],
});

pagination.syncData();

// Método para formatear fechas (solo día/mes/año)
const formatDate = (date) => {
    const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
    return new Date(date).toLocaleDateString('es-ES', options);
};

// Función para eliminar elementos
const deleteItem = (id) => {
    if (confirm('¿Está seguro de eliminar este registro?')) {
        httpRequest({
            url: window.public_path + '/adm/clientespotenciales/delete/' + id,
            method: 'GET',
        })
        .then(() => {
            pagination.syncData();
        })
        .catch((error) => {
            console.error(error);
        });
    }
};
</script>

<style lang="scss" scoped>
/* Agrega estilos personalizados aquí si es necesario */
</style>
