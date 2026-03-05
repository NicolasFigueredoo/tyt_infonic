vue
<template>
    <div class="box__tabla">
        <div class="box__estado">
            <label>Cliente:</label>
            <span>{{ form.cliente }}</span>
        </div>
        <div class="box__estado" style="margin-top: 15px;margin-bottom: 15px;">
            <label>Fecha:</label>
            <span>{{ form.fecha }}</span>
        </div>
        <div class="box__estado">
            <label>Pedido N°:</label>
            <span>{{ form.id }}</span>
        </div>
    </div>
    <div class="box__estado">
        <label for="estado">Estado:</label>
        <select v-model="form.estado" id="estado">
            <option value="PENDIENTE">PENDIENTE</option>
            <option value="COMPLETO">COMPLETO</option>
        </select>
    </div>
    <div class="box__tabla">
    <div style="width: 100%;">
        <h3>Articulos:</h3>
    </div>
    <table>
      <thead>
        <tr>
          <th>Código</th>
          <th>Cantidad</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in form.pedido" :key="index">
          <td>{{ item.codigo }}</td>
          <td>{{ item.cantidad }}</td>
          <td>{{ item.nombre }}</td>
          <td>{{ item.precio }}</td>
          <td>{{ item.subtotal }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="box__estado" style="margin-top: 35px;">
    <label><b>TOTAL: </b></label><span>$ {{form.total}}</span>
  </div>
</template>
 <script setup>
  import { defineProps } from 'vue'
   const props = defineProps({
    form: {
      type: Object,
      required: true,
    },
    errors: {
      type: Object,
      required: true,
    },
  })
</script>
 <style lang="scss" scoped>
 .box__estado{
    display: flex;
    flex-flow: row;
    justify-content: start;
    align-items: center;
 }
 .box__tabla{
    display: flex;
    flex-flow: column;
    justify-content: start;
    align-items: center;
    font-size: 23px;
 }
 table{
    width: 100%;
 }
</style>