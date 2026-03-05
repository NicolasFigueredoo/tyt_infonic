
<template>
    <div class="grid-3 gap-15">
        <InputText
            label="Nombre"
            placeholder=""
            v-model="form.nombre"
            :error="errors.nombre"
            class="col-3"            
        />
        <InputText
            label="Apellido"
            placeholder=""
            v-model="form.apellido"
            :error="errors.apellido"
            class="col-3"            
        />
        <InputText
            label="Razon Social"
            placeholder=""
            v-model="form.razonSocial"
            :error="errors.razonSocial"
            class="col-3"            
        />
        <InputText
            label="CUIT"
            placeholder=""
            v-model="form.cuit"
            :error="errors.cuit"
            class="col-3"            
        />
        <InputText
            label="Telefono"
            placeholder=""
            v-model="form.phone"
            :error="errors.phone"
            class="col-3"            
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
        />
        <InputNumbre
            label="Codigo Postal"
            placeholder=""
            v-model="form.cp"
            :error="errors.cp"
            class="col-3"            
        />
        <InputText
            label="Localidad"
            placeholder=""
            v-model="form.localidad"
            :error="errors.localidad"
            class="col-3"            
        />
        <InputText
            label="Provincia"
            placeholder=""
            v-model="form.provincia"
            :error="errors.provincia"
            class="col-3"            
        />
        <InputPassword
            label="Contraseña"
            placeholder=""
            v-model="form.password"
            :error="errors.password"
            class="col-3"            
        />
        <div class="col-3">
            <label for="start">Tiempo de uso:</label>    
            <input type="date" id="tiempo" class="form-control" v-model="form.tiempo"  :min="new Date().toISOString().split('T')[0]" />
        </div>
    </div>
</template>

<script setup>
    import { reactive } from "@vue/reactivity";

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