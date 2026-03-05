
<template>
    <h3>Articulo:</h3>
    <div class="grid-3 gap-15">
        <InputText
        label="Orden"
        placeholder=""
        v-model="form.orden"
        :error="errors.orden"
        class="col-1"
        />
        <InputText
        label="Texto"
        placeholder=""
        v-model="form.name"
        :error="errors.name"
        class="col-3"
        />
       
        <InputText
        label="Descripcion"
        placeholder=""
        v-model="form.descripcion"
        :error="errors.descripcion"
        class="col-3"
        />
    

        <InputText
        label="Texto (Ingles)"
        placeholder=""
        v-model="form.nameEnglish"
        :error="errors.nameEnglish"
        class="col-3"
        />

        <InputText
        label="Descripcion (Ingles)"
        placeholder=""
        v-model="form.descripcionEnglish"
        :error="errors.descripcionEnglish"
        class="col-3"
        />

    
       

        <InputText
            label="Direccion"
            placeholder=""
            v-model="form.direccion"
            :error="errors.direccion"
            class="col-3"
        />        
        
        <InputEmail
            label="Email"
            placeholder=""
            v-model="form.email"
            :error="errors.email"
            class="col-3"
        />

        <InputNumber
            label="Telefono"
            placeholder=""
            v-model="form.telefono"
            :error="errors.telefono"
            class="col-3"
        />

        <InputNumber
            label="Whatsapp"
            placeholder=""
            v-model="form.wsp"
            :error="errors.wsp"
            class="col-3"
        />

        <InputText
            label="Horario"
            placeholder=""
            v-model="form.horario"
            :error="errors.horario"
            class="col-3"
        /> 
        
    </div>
</template>

<script setup>
    import { reactive, ref } from "@vue/reactivity";

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