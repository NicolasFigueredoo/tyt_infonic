<template>
    <SectionHeader>
        <template #title>
            Clientes
        </template>
        <template #buttons>
            <!--
            <button
                class="btn btn--gray"
                @click="exportData"
            >
                <i class="fas fa-download"></i> Exportar
            </button>
            <button
                class="btn btn--gray"
                @click="importData"
            >
                <i class="fas fa-upload"></i> Importar
            </button>
            -->
            <router-link
                class="btn btn--yellow"
                to="/adm/data"
            >
                <i class="fas fa-arrow-left"></i> Volver
            </router-link>
            <button
                class="btn btn--gray"
                @click="UpdateClientesApi()"
            >
                <i class="fas fa-sync-alt"></i> Actualizar Clientes
            </button>
        </template>
    </SectionHeader>    
    <table>
        <thead>
            <tr class="table__search">
                <td><i class="fas fa-search-minus table__icon-search"></i></td>
                <td><input type="text" v-model="filters.searchQuery" @keyup.enter="applyFilters" /></td>
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
            <tr>
                <th class="p-0"></th>
                <th>Empresas</th>
                <th>Cuenta</th>
                <th style='text-align: end;'>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table__search d-none">
                <td><i class="fas fa-search-minus table__icon-search"></i></td>
                <td><input type="text" v-model="filters.cuenta" @keyup.enter="applyFilters" /></td>
                
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
            <tr v-for="(item, key) in paginator.values" :key="key">                
                <td class="p-0"></td>
                <td>{{ item.razonSocial }}</td>                
                <td>{{ item.cuenta }}</td>                
                <td class="btns d-flex justify-content-end">
    <router-link
        :to="'/adm/clientes/' + item.cuenta + '/edit'"
        class="btn btn--green"
    >
        <i class="fas fa-edit"></i>
    </router-link>
    
    <!-- Botón de activación/desactivación -->
    <button
    style="cursor: pointer;"
        v-if="item.estado == 1"
        @click="toggleUserStatus(item.id)"
        class="btn btn--red"
        :disabled="item.estado == 0"
    >
        <i class="fas fa-ban"></i> Deshabilitar
    </button>
    <button
    style="cursor: pointer;"
        v-if="item.estado == 0"
        @click="toggleUserStatus(item.id)"
        class="btn btn--green"
        :disabled="item.estado == 1"
    >
        <i class="fas fa-check"></i> Habilitar
    </button>
</td>

            </tr>
        </tbody>
    </table>    
    <div class="pagination">
    <button v-if="pageCount > 1" @click="setPage(1)" class="page-button">1</button>
    <span v-if="page > 4">...</span>
    <button v-for="pageNumber in visiblePages" :key="pageNumber" @click="setPage(pageNumber)" class="page-button">
      {{ pageNumber }}
    </button>
    <span v-if="page < pageCount - 3">...</span>
    <button v-if="pageCount > 1" @click="setPage(pageCount)" class="page-button">{{ pageCount }}</button>
  </div>
</template>

<script setup>
    import { reactive, ref } from 'vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()
    const pageCount  = ref()
    const firstVisiblePage   = ref()
    const lastVisiblePage   = ref()
    const visiblePages   = ref([])
    const page = ref(1);
    const paginator = reactive({})
    const exportData = () => {
        alert('Característica no implementada')
    }
    const importData = () => {
        alert('Característica no implementada')
    }

    const filters = reactive({
        searchQuery: '',
        cuenta: '',
        empresa: '',
        usernombre: '',
        email: '',
        descuento: ''
    })

    const appliedFilters = reactive({
        searchQuery: '',
        cuenta: '',
        empresa: '',
        usernombre: '',
        email: '',
        descuento: ''

    })

    const applyFilters = () => {
        appliedFilters.searchQuery = filters.searchQuery;
        appliedFilters.empresa = filters.empresa
        appliedFilters.cuenta = filters.cuenta
        appliedFilters.description = filters.description
        appliedFilters.descuento = filters.descuento

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
                url: window.public_path + '/adm/clientes/delete/' + id,
                method: 'GET'
            })
            .then((data) => {
                pagination.syncData()
            })
            .catch((error) => {})
        }
    }
    const UpdateClientesApi = () => {
        if (confirm('¿Está seguro de actualizar los clientes?')) {
            const url = window.public_path + '/adm/clientes/updateClientes';
            httpRequest({
                url,
                method: 'GET'
            })
            .then((data) => {
                pagination.syncData()
            })
            .catch((error) => {})
        }
    }

    


    const toggleUserStatus = (id) => {
            httpRequest({
                url: window.public_path + '/adm/clientes/habilitar/' + id,
                method: 'GET'
            })
            .then((data) => {
                syncData()
            })
            .catch((error) => {})
        }
    

        const syncData = async () => {
  const modal = awesomeModal.loading();
  try {
    // 1) serializamos filtros + página en query string
    const params = new URLSearchParams();
    params.set('page', page.value);
    for (const [key, value] of Object.entries(appliedFilters)) {
      if (value) {
        params.append(`filters[${key}]`, value);
      }
    }
    if (appliedFilters.searchQuery) {
      // tu controlador usa customerDescription
      params.set('filters[customerDescription]', appliedFilters.searchQuery);
    }

    // 2) llamamos por GET en lugar de POST
    const res  = await fetch(`${window.public_path}/adm/clientes?${params.toString()}`);
    const data = await res.json();

    // 3) asignamos los valores de Laravel
    paginator.values    = data.values;       // items de esta página
    pageCount.value     = data.last_page;    // última página
    setPagination();
  } catch (err) {
    console.error(err);
    // aquí tu manejo de 401/422…
  } finally {
    modal.close();
  }
};

    function setPage(n) {
  page.value = n;
  syncData();
}

function setPagination() {
  visiblePages.value = [];
  const start = Math.max(page.value - 2, 2);
  const end   = Math.min(page.value + 2, pageCount.value - 1);
  for (let i = start; i <= end; i++) {
    visiblePages.value.push(i);
  }
}

    const refreshData = () => {
        syncData()
    }
    syncData()
</script>
<style lang="scss" scoped>
    .pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.page-button {
  padding: 8px 12px;
  margin: 0 4px;
  background-color: #f2f2f2;
  border: none;
  border-radius: 4px;
  color: #333;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.page-button:hover {
  background-color: #e0e0e0;
}

.page-button:focus {
  outline: none;
  box-shadow: 0 0 0 2px #0099ff;
}
</style>
