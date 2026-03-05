<template>
  <div>
    <!-- Mostrar el encabezado solo si showHeader es true -->
    <SectionHeader v-if="showHeader">
      <template #title>
        Productos: Añadidos y Removidos
      </template>
      <template #buttons>
        <router-link class="btn btn--yellow" to="/adm/data">
          <i class="fas fa-arrow-left"></i> Volver
        </router-link>
      </template>
    </SectionHeader>

    <!-- Filtros -->
    <div class="filtros" v-if="showHeader">
      <label for="clienteSelect">Cliente:</label>
      <select id="clienteSelect" v-model="selectedCliente">
        <option value="">Todos</option>
        <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
          {{ cliente.name }}
        </option>
      </select>

      <label for="fechaDesde">Desde:</label>
      <input id="fechaDesde" type="date" v-model="fechaDesde" />

      <label for="fechaHasta">Hasta:</label>
      <input id="fechaHasta" type="date" v-model="fechaHasta" />

      <button @click="fetchData">Filtrar</button>
    </div>

    <!-- Contenedor del gráfico -->
    <div ref="chartRef" style="width: 100%; height: 400px;"></div>
  </div>
</template>

<script setup>
import { ref, onMounted, defineProps } from 'vue';
import axios from 'axios';
import * as echarts from 'echarts';

const props = defineProps({
  showHeader: { type: Boolean, default: true }
});

const selectedCliente = ref('');
const fechaDesde = ref('');
const fechaHasta = ref('');
const clientes = ref([]);

// Datos del gráfico
const categories = ref([]);
const addSeries = ref([]);
const removeSeries = ref([]);

const chartRef = ref(null);

function fetchClientes() {
  axios.get(window.public_path + '/adm/metricas/clientes', {
    params: { tipo_evento: 'add_to_cart' }
  })
    .then(response => {
      clientes.value = response.data;
    })
    .catch(error => console.error('Error al obtener clientes:', error));
  }

function fetchData() {
  const params = {};
  if (selectedCliente.value) {
    params.cliente_id = selectedCliente.value;
  }
  if (fechaDesde.value && fechaHasta.value) {
    params.fecha_desde = fechaDesde.value;
    params.fecha_hasta = fechaHasta.value;
  }

  axios.get(window.public_path + '/adm/metricas/datos', { params })
    .then(response => {
      categories.value = response.data.categories;
      addSeries.value = response.data.addSeries;
      removeSeries.value = response.data.removeSeries;
      renderChart();
    })
    .catch(error => console.error('Error al obtener datos:', error));
}
function renderChart() {
  const chartDom = chartRef.value;
  const myChart = echarts.init(chartDom);

  const option = {
    title: {
      text: 'PRODUCTOS AÑADIDOS Y REMOVIDOS',
      left: 'left',
      textStyle: { fontSize: 16, fontWeight: 500, color: '#000' }
    },
    tooltip: {
      trigger: 'axis',
      axisPointer: { type: 'cross', label: { backgroundColor: '#6a7985' } }
    },
    toolbox: {
  feature: {
    saveAsImage: { title: 'Descargar' },
    dataView:    { title: 'Ver Datos', readOnly: false },
    magicType:   {
      type: ['line', 'bar'],
      title: { line: 'Línea', bar: 'Barras' }
    },
    restore:     { title: 'Reiniciar' },
    dataZoom:    {
      title: { zoom: 'Zoom', back: 'Revertir Zoom' }
    }
  },
  right: 20
},

    legend: {
      data: ['Añadidos', 'Removidos'],
      top: 30
    },
    grid: {
      left: '5%', right: '5%', bottom: '15%', containLabel: true
    },
    xAxis: {
      type: 'category',
      data: categories.value,
      axisLine: { lineStyle: { color: '#000' } },
      axisLabel: { rotate: 45, interval: 0, fontSize: 11 }
    },
    yAxis: {
      type: 'value',
      axisLine: { show: false },
      splitLine: { lineStyle: { type: 'dashed', color: '#eee' } }
    },
    series: [
      {
        name: 'Añadidos',
        type: 'bar',
        data: addSeries.value,
        barWidth: '40%',
        itemStyle: {
          borderRadius: [6, 6, 0, 0],
          color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
            { offset: 0, color: '#76C7C0' },
            { offset: 1, color: '#25877D' }
          ]),
          shadowColor: 'rgba(0, 0, 0, 0.1)',
          shadowBlur: 8
        },
        emphasis: { scale: true }
      },
      {
        name: 'Removidos',
        type: 'bar',
        data: removeSeries.value,
        barWidth: '40%',
        itemStyle: {
          borderRadius: [6, 6, 0, 0],
          color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
            { offset: 0, color: '#FF5252' },
            { offset: 1, color: '#D32F2F' }
          ]),
          shadowColor: 'rgba(0, 0, 0, 0.1)',
          shadowBlur: 8
        },
        emphasis: { scale: true }
      }
    ],
    animationDuration: 800
  };

  myChart.setOption(option);
}


onMounted(() => {
  const today = new Date().toISOString().slice(0, 10);
  fechaDesde.value = new Date(new Date().getFullYear(), new Date().getMonth(), 1)
                      .toISOString().slice(0, 10);
  fechaHasta.value = today;

  fetchClientes();
  fetchData();
});
</script>

<style scoped>
.filtros {
  margin-bottom: 20px;
  display: flex;
  gap: 10px;
  align-items: center;
}
.filtros label {
  font-weight: bold;
}
</style>
