<script setup>
    import { reactive } from 'vue'
    import { useRoute, useRouter } from 'vue-router'
    import ShowLote from './ShowLote.vue'
    import AddPosition from './AddPosition.vue'
    const route = useRoute()
    const router = useRouter()
    
    const articulo = reactive({
        logs: [],
        stock: [],
        tipo: {},
    })

    let modal = awesomeModal.loading()
    httpRequest({
        url: window.public_path + '/adm/stock/articulo/' + route.params.id,
        method: 'GET',
    })
    .then((data) => {
        Object.assign(articulo, data)
        modal.close()
    })
    .catch((error) => {
        modal.close()
    })

    const showLote = (lote_id) => {
        awesomeModal.open({
            type: 'component',
            component: ShowLote,
            lote_id,
        })
    }

    const addPosition = () => {
        awesomeModal.open({
            type: 'component',
            component: AddPosition,
            articulo_id: articulo.id,
        })
    }

</script>
<template>
    <SectionHeader>
        <template #title>
            Stock / {{ articulo.name }}
        </template>
        <template #buttons>
            <router-link
                to="/stock"
                class="btn btn--rounded btn--yellow-outline"
            >
                <i class="fas fa-arrow-left"></i> Volver
            </router-link>
            <button
                class="btn btn--rounded btn--black-outline"
                type="submit"
                @click="addPosition"
            >
                <i class="fas fa-th"></i>
                Añadir posición
            </button>
            <button
                class="btn btn--circle btn--grayred-outline"
                type="submit"
            >
                <i class="far fa-comment-dots"></i>
            </button>
        </template>
    </SectionHeader>
    <h3>Stock disponible</h3>
    <table>
        <thead>
            <tr>
                <th>Medida mts</th>
                <th>Cantidad</th>
                <th>Kilos</th>
                <th>Almacén</th>
                <th>Ubicación</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="position in articulo.stock" :key="position.id">
                <td v-if="position.medida">{{ $filters.toCurrency(position.medida / 1000, 2) }}</td>
                <td v-else>No Asignado</td>
                <td>{{ position.cantidad }}</td>
                <td v-if="position.medida">{{ $filters.toCurrency(articulo.kilos_por_metro * (position.medida / 1000), 2) }}</td>
                <td v-else>No se puede calcular</td>
                <td>{{ position.almacen.name }}</td>
                <td>{{ position.ubicacion }}</td>
                <td>
                    <div class="btns">
                        <button
                            @click="showLote(position.id)"
                            class="btn btn--circle btn--gray-outline"
                        >
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <hr class="my-30">

    <div style="background-color: #FFF; padding: 10px 35px 35px 35px;">
        <h3>Actividad</h3>
        <table style="border: none;">
            <tbody>
                <tr v-for="log in articulo.logs" :key="log.id">
                    <td style="color: #656565;">{{ log.created_at_human }} - {{ log.user.name }}</td>
                    <td>{{ log.message }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<style lang="scss" scoped>
</style>
