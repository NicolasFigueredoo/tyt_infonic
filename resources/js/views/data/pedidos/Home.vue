<template>
    <SectionHeader>
        <template #title> Pedidos </template>
        <template #buttons>            
            <router-link class="btn btn--yellow" to="/adm/data">
                <i class="fas fa-arrow-left"></i> Volver
            </router-link>
            <button class="btn btn--gray" @click="pagination.syncData()">
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
        </template>
    </SectionHeader>
    <table>
        <thead>
            <tr>
                <th class="p-0"></th>
                <th>#</th>
                <th>Estado</th>
                <th>Cliente</th>
                <th>Fecha</th>                
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>            
            <tr v-for="(item, key) in pagination.paginator.data" :key="key">
                <td class="p-0"></td>
                <td>{{ item.id }}</td>
                <td>{{ item.estado }}</td>
                <td>{{ item.empresa}}</td>
                <td>{{ item.fecha }}</td>                
                <td>
                    <div class="btns">
                        <router-link
                            :to="'/adm/pedidos/' + item.id + '/edit'"
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
        </tbody>
    </table>
    <Paginator
        :paginator="pagination.paginator"
        @change="pagination.syncData"
    />
</template>

<script setup>
import { reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

const route = useRoute();
const router = useRouter();

// todo lo anterior se puede abstractar en un mixin, para reutilizarlo en otros componentes
// ejemplo:
const pagination = dataPaginator({
    urlBase: new URL(window.public_path + "/adm/pedidos"),
    filtersKeys: ["code", "name", "description"],
});

pagination.syncData();
const deleteItem = (id) => {
    if (confirm("¿Está seguro de eliminar este registro?")) {
        httpRequest({
            url: window.public_path + "/adm/pedidos/delete/" + id,
            method: "GET",
        })
            .then((data) => {
                pagination.syncData();
            })
            .catch((error) => {});
    }
};

const restoreItem = (id) => {
    if (confirm("¿Está seguro de restaurar este registro?")) {
        httpRequest({
            url: window.public_path + "/adm/pedidos/restore/" + id,
            method: "GET",
        })
            .then((data) => {
                pagination.syncData();
            })
            .catch((error) => {});
    }
};
</script>
<style lang="scss" scoped></style>
