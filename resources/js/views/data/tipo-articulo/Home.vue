<template>
    <SectionHeader>
        <template #title> Categorias </template>
        <template #buttons>
            <router-link class="btn btn--yellow" to="/adm/data">
                <i class="fas fa-arrow-left"></i> Volver
            </router-link>
            <button class="btn btn--gray" @click="sincronizar">
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
            <router-link to="/adm/tipo-articulo/add" class="btn btn--green">
                <i class="fas fa-plus"></i> Añadir
            </router-link>
        </template>
    </SectionHeader>
    <table>
        <thead>
            <tr>
                <th>Orden</th>
                <th>Nombre</th>
                <th>Oculto</th>
                <th>Destacado</th>
                <th style="text-align: end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table__search">
                <td>
                    <input
                        type="text"
                        placeholder="NOMBRE"
                        v-model="filters.name"
                        @keyup.enter="applyFilters"
                    />
                </td>
                <td></td>
                <td></td>
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
                <td>{{ item.orden }}</td>
                <td>{{ item.name }}</td>
                <td v-if="item.oculto == 'true'">
                    <button @click="ocultar(item.id)">
                        <i class="far fa-eye-slash"></i>
                    </button>
                </td>
                <td v-else>
                    <button @click="ocultar(item.id)">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
                <td>
                    <i v-if="item.destacado == 'true'" class="fas fa-check"></i>
                </td>
                <td class="btns d-flex justify-content-end">
                    <router-link
                        :to="'/adm/tipo-articulo/' + item.id + '/edit'"
                        class="btn btn--green"
                    >
                        <i class="fas fa-edit"></i>
                    </router-link>
                    <button class="btn btn--red" @click="deleteItem(item.id)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import { reactive } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const paginator = reactive({});

const filters = reactive({ name: "", username: "", email: "" });
const appliedFilters = reactive({ name: "", username: "", email: "" });

const applyFilters = () => {
    appliedFilters.code = filters.code;
    appliedFilters.name = filters.name;
    appliedFilters.description = filters.description;
    refreshData();
};

const clearFilters = () => {
    for (const key in filters) filters[key] = "";
    for (const key in appliedFilters) appliedFilters[key] = "";
    refreshData();
};

const deleteItem = (id) => {
    if (confirm("¿Está seguro de eliminar este registro?")) {
        httpRequest({
            url: window.public_path + "/adm/tipo-articulo/delete/" + id,
            method: "GET",
        })
            .then(() => refreshData())
            .catch(() => {});
    }
};

const syncData = () => {
    let modal = awesomeModal.loading();
    let url = new URL(window.public_path + "/adm/tipo-articulo");
    const form = new FormData();
    for (const [key, value] of Object.entries(appliedFilters)) {
        if (value) form.append("filters[" + key + "]", value);
    }
    fetch(url, { method: "POST", body: form })
        .then((response) => response.json())
        .then((data) => {
            Object.assign(paginator, data);
            modal.close();
        })
        .catch((error) => {
            modal.close();
            console.error(error);
        });
};

const ocultar = (id) => {
    httpRequest({
        url: window.public_path + "/adm/tipo-articulo/ocultar/" + id,
        method: "GET",
    })
        .then(() => syncData())
        .catch(() => {});
};

const refreshData = () => syncData();

const sincronizar = () => {
    let modal = awesomeModal.loading("Sincronizando con el ERP, por favor espere...");
    fetch(window.public_path + "/adm/tipo-articulo/sincronizar", {
        method: "GET",
    })
        .then((response) => {
            if (!response.ok) throw new Error("Error del servidor: " + response.status);
            return response.json();
        })
        .then((data) => {
            modal.close();
            syncData();
            alert("Sincronización completada correctamente");
        })
        .catch((error) => {
            modal.close();
            alert("Error al sincronizar: " + error.message);
            console.error(error);
        });
};

syncData();
</script>

<style lang="scss" scoped></style>