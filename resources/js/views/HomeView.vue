<script setup>
import GraficoProductos from './data/metricas/Home.vue'
import GraficoPedidos from './data/metricas/HomePedidos.vue'
import GraficoCliente from './data/metricas/HomeReferrer.vue'

</script>

<template>
  <Main>
    <h1>Bienvenido a la aplicación</h1>
    <div class="charts-grid mt-4">
      <GraficoProductos :showHeader="false" />
      <GraficoPedidos :showHeader="false"/>
      <GraficoCliente :showHeader="false"/>

    </div>
  </Main>
</template>

<style scoped>
.charts-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(800px, 1fr));
  gap: 20px;
}
</style>
