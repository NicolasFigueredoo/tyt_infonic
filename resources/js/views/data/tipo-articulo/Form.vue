
<template>
    <div class="grid-3 gap-15">
        <InputText
            label="Orden"
            placeholder=""
            v-model="form.orden"
            :error="errors.orden"
            class="col-3"
        />
        <InputText
            label="Nombre"
            placeholder=""
            v-model="form.name"
            :error="errors.name"
            class="col-3"
        />

        <InputText
            label="Nombre (Ingles)"
            placeholder=""
            v-model="form.nameEnglish"
            :error="errors.nameEnglish"
            class="col-3"
        />

        <InputText
            label="Code"
            placeholder=""
            v-model="form.code"
            :error="errors.code"
            class="col-3"
        />
        
        <div class="col-3">

<template v-if="!form.principal">

    <label for="categoria">Categoría: </label>
    <select v-model="form.sub_categoria_id" :error="errors.sub_categoria_id" class="form-select" id="categoria">

      <option value="" disabled>Seleccione una categoría</option>
      <option v-for="categoria in form.categorias" :key="categoria.id" :value="categoria.id">
        {{ categoria.name }}
      </option>


    </select>

    
    <small v-if="errors.categoria" class="text-danger">{{ errors.categoria }}</small>
</template>


<template v-if="!form.principal">


    <div class="col-12" style="margin-top: 20px">
        <label for="productos">Productos: </label>
        <multiselect 
            v-model="form.seleccionados" 
            :options="form.productos" 
            track-by="id" 
            label="name" 
            placeholder="Selecciona productos" 
            multiple 
            id="productos"
            :close-on-select="false" 
            :preserve-search="true">
        </multiselect>
    </div>
</template>



    </div>
        <InputFileImage
                    label="Marca"
                    placeholder=""
                    v-model="form.imagenMarca"
                    :error="errors.imagenMarca"
                    class="col-1"
        />
        <small  class="col-3">Tama&ntilde;o recomendado 16 x 200 px</small>
        <img v-bind:src="form.imagenMarca" class="col-3" onerror="this.onerror=null;">

        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-1"
        />
        <small  class="col-3">Tama&ntilde;o recomendado 200 x 200 px</small>
        <img v-bind:src="form.imagenSrc" class="col-3" onerror="this.onerror=null;">

        <div class="form-check">
            <input class="form-check-input" v-model="form.oculto" :error="errors.oculto" type="checkbox" id="oculto">
            <label class="form-check-label" for="oculto">
                Ocultar categoria
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" v-model="form.destacado" :error="errors.destacado" type="checkbox" id="destacado">
            <label class="form-check-label" for="destacado">
                Destacado
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" v-model="form.principal" :error="errors.principal" type="checkbox" id="principal">
            <label class="form-check-label" for="principal">
                Principal
            </label>
        </div>
    </div>
</template>


<script setup>
import { reactive } from "@vue/reactivity";
import { defineProps } from 'vue';
import Multiselect from 'vue-multiselect';

// Definición de propiedades
const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
});

// Opciones para el select
const options = reactive([
    { id: 1, name: 'Producto 1' },
    { id: 2, name: 'Producto 2' },
    { id: 3, name: 'Producto 3' },
    { id: 4, name: 'Producto 4' },
    { id: 5, name: 'Producto 5' },
]);

</script>

<style lang="scss" scoped>
@import 'vue-multiselect/dist/vue-multiselect.min.css';
</style>