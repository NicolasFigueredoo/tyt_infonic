
<template>
    <div class="grid-3 gap-15">
        <InputText
            label="Cuenta"
            placeholder=""
            v-model="form.cuenta"
            :error="errors.cuenta"
            class="col-3"
            disabled
        />
        <InputText
            label="Razon Social"
            placeholder=""
            v-model="form.razonSocial"
            :error="errors.razonSocial"
            class="col-3"
            disabled
        />
        <InputEmail
            label="Email"
            placeholder=""
            v-model="form.email"
            :error="errors.email"
            class="col-3"
        />
        <InputText
            label="Direccion"
            placeholder=""
            v-model="form.direccion"
            :error="errors.direccion"
            class="col-3"
            disabled
        />
        <InputText
            label="Provincia"
            placeholder=""
            v-model="form.provincia"
            :error="errors.provincia"
            class="col-3"
            disabled
        />
        <InputText
            label="Codigo Vendedor"
            placeholder=""
            v-model="form.codigoVendedor"
            :error="errors.codigoVendedor"
            class="col-3"
            disabled
        />
        <InputText
            label="Vendedor Descripcion"
            placeholder=""
            v-model="form.vendedorDescripcion"
            :error="errors.vendedorDescripcion"
            class="col-3"
            disabled
        />
        <InputText
            label="Codigo Bonificacion"
            placeholder=""
            v-model="form.codigoBonificacion"
            :error="errors.codigoBonificacion"
            class="col-3"
            disabled
        />
        <InputText
            label="Bonificacion Descripcion"
            placeholder=""
            v-model="form.bonificacionDescripcion"
            :error="errors.bonificacionDescripcion"
            class="col-3"
            disabled
        />

        <InputNumber
            label="Descuento"
            placeholder=""
            v-model="form.descuento"
            :error="errors.descuento"
            class="col-3"
            
        />
        <InputPassword
            label="Clave"
            placeholder=""
            v-model="form.password"
            :error="errors.password"
            class="col-3"
        />

        <div class="col-12" style="margin-top: 20px">
        <label for="productos">Categorias a visualizar por el cliente: </label>
        <multiselect 
            v-model="form.seleccionados" 
            :options="form.categorias" 
            track-by="id" 
            label="name" 
            placeholder="Selecciona categorias" 
            multiple 
            id="categorias"
            :close-on-select="false" 
            :preserve-search="true">
        </multiselect>
    </div>
    </div>
</template>

<script setup>
    import { reactive } from "@vue/reactivity";
    import Multiselect from 'vue-multiselect';

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
</style>