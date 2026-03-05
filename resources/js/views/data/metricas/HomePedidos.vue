<template>
  <SectionHeader v-if="showHeader">
    <template #title>
      Metrica
    </template>
    <template #buttons>
      <router-link class="btn btn--yellow" to="/adm/data">
        <i class="fas fa-arrow-left"></i> Volver
      </router-link>
    </template>
  </SectionHeader>

  <!-- Filtros: Select para Cliente y Rango de Fechas -->
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
</template>

<script setup>
import { ref, onMounted, watch, nextTick, defineProps } from 'vue';
import axios from 'axios';
import * as echarts from 'echarts/core';
import { BarChart } from 'echarts/charts';
import {
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  GridComponent,
  ToolboxComponent
} from 'echarts/components';
import { CanvasRenderer } from 'echarts/renderers';

// Registrar sólo lo que usamos
echarts.use([
  BarChart,
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  GridComponent,
  ToolboxComponent,
  CanvasRenderer
]);

// Para los gradientes
const { graphic } = echarts;

const props = defineProps({
  showHeader: { type: Boolean, default: true }
});

const selectedCliente = ref('');
const fechaDesde = ref('');
const fechaHasta = ref('');
const clientes = ref([]);

const dates = ref([]);
const cancelSeries = ref([]);

const chartRef = ref(null);
let myChart = null;

function fetchClientes() {
  return axios.get(window.public_path + '/adm/metricas/clientes', {
    params: { tipo_evento: 'pedido_cancelado' }
  })
  .then(res => { clientes.value = res.data })
  .catch(err => console.error(err));
}

function fetchData() {
  const params = {};
  if (selectedCliente.value) params.cliente_id = selectedCliente.value;
  if (fechaDesde.value && fechaHasta.value) {
    params.fecha_desde = fechaDesde.value;
    params.fecha_hasta = fechaHasta.value;
  }

  return axios.get(window.public_path + '/adm/metricas/pedidos', { params })
    .then(res => {
      dates.value        = res.data.dates;
      cancelSeries.value = res.data.cancelSeries;
    })
    .catch(err => console.error(err));
}

// Re-render al actualizar datos
watch([dates, cancelSeries], () => {
  nextTick(renderChart);
});

function renderChart() {
  if (!chartRef.value) return;
  if (!myChart) {
    myChart = echarts.init(chartRef.value);
  } else {
    myChart.clear();
  }

  const option = {
    title: {
      text: 'PEDIDOS CANCELADOS',
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
      data: ['Pedidos Cancelados'],
      top: 30,
      textStyle: { color: '#000' }
    },
    grid: {
      left: '5%', right: '5%', bottom: '15%', containLabel: true
    },
    xAxis: {
      type: 'category',
      data: dates.value,
      axisLine: { lineStyle: { color: '#ccc' } },
      axisLabel: { rotate: 45, interval: 0, fontSize: 11, color: '#000' }
    },
    yAxis: {
      type: 'value',
      axisLine: { show: false },
      splitLine: { lineStyle: { type: 'dashed', color: '#eee' } }
    },
    series: [
      {
        name: 'Pedidos Cancelados',
        type: 'bar',
        data: cancelSeries.value,
        barWidth: '40%',
        itemStyle: {
          borderRadius: [6, 6, 0, 0],
          color: graphic.LinearGradient(0, 0, 0, 1, [
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

onMounted(async () => {
  // Rango: primer día del mes hasta hoy
  const today = new Date().toISOString().slice(0, 10);
  fechaDesde.value = new Date(new Date().getFullYear(), new Date().getMonth(), 1)
                      .toISOString().slice(0, 10);
  fechaHasta.value = today;

  await fetchClientes();
  await fetchData();
});
</script>

<style scoped>
.filtros {
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.filtros label {
  font-weight: bold;
}
</style>
