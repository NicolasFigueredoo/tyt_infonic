<script setup>
    import { reactive, ref } from 'vue'
    import { useRoute, useRouter } from 'vue-router'
    const route = useRoute()
    const router = useRouter()
    const tipo_articulo_id = ref(1)

    const pagination = dataPaginator({
        urlBase: new URL(window.public_path + '/adm/stock/articulo'),
        filtersKeys: ['code', 'name', 'description']        
    })
    pagination.syncData()

</script>
<template>
    <SectionHeader>
        <template #title>
            Stock
        </template>
        <template #buttons>
            <div class="grid-2 gap-15">
                <InputText
                    :label="null"
                    placeholder="Buscar por código"
                    v-model="pagination.filters.code"
                    :error="[]"
                    @keyup.enter="pagination.applyFilters"
                />
                <SelectAutocomplete
                    :label="null"
                    v-model="tipo_articulo_id"
                    endpoint="/api/tipo-articulo/list-select"
                    :error="[]"
                    option-key="id"
                    :allowNull="false"
                >
                    <template #option="{ id, name }">
                        <div>
                            {{ name }}
                        </div>
                    </template>
                </SelectAutocomplete>
            </div>
            <router-link
                to="/articulo"
                class="btn btn--gray"
            >
                <i class="fas fa-boxes"></i>
                Catalogo de articulos
            </router-link>
        </template>
    </SectionHeader>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Kilos</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, key) in pagination.paginator.data" :key="key">
                <td>{{ item.id }}</td>
                <td>{{ item.code }}</td>
                <td>{{ item.name }}</td>
                <td>{{ $filters.toCurrency(item.stock_cantidad_total, 0) }}</td>
                <td>{{ $filters.toCurrency(item.stock_peso_total, 0) }}</td>
                <td>
                    <div class="btns">
                        <router-link
                            :to="'/stock/' + item.id + '/show'"
                            class="btn btn--green-outline"
                        >
                            <i class="fas fa-eye"></i>
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
<style lang="scss" scoped>

</style>
