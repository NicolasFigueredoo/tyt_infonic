<script>
import { borrarImg }  from './function.js'
</script>

<template>
    <h3>Articulo:</h3>
    <div class="grid-3 gap-15">
        <InputText
            label="Código"
            placeholder=""
            v-model="form.code"
            :error="errors.code"
            class="col-1"
        />
        <InputText
            label="Nombre"
            placeholder=""
            v-model="form.name"
            :error="errors.name"
            class="col-1"
        />

        <InputText
            label="Talle"
            placeholder=""
            v-model="form.talle"
            :error="errors.talle"
            class="col-1"
        />
        
        <InputText
            label="Descripción"
            placeholder=""
            v-model="form.description"
            :error="errors.description"
            class="col-3"
        />

        <InputFile
                    label="Ficha"
                    placeholder=""
                    v-model="form.ficha"
                    :error="errors.ficha"
                    class="col-1"
        />
        
        <a v-if="form.fichaHref != null" :herf="form.fichaHref" target="_blank" class="col-3" >Ver ficha</a>
        
        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-3"
        />
        
        <img v-if="form.imagenSrc" v-bind:src="form.imagenSrc" class="col-3" onerror="this.onerror=null;">
        
        <InputFileImageMultiple
                    label="Colores"
                    placeholder=""
                    v-model="form.color"
                    :error="errors.color"
                    class="col-3"
                    ref="color"
        />
        
        <div v-for="(item, i) in form.coloresLink" :key="i">
            <img  :id="'color'+i" v-bind:src="item" class="col-1" style="max-width: 250px;" onerror="this.onerror=null;">
            <button class="btn btn-danger" type="button" @click="borrarImg('color',i)" :id="'colorbtn'+i">Eliminar</button>
        </div>
        <input v-for="(item, i) in form.coloresLink" :key="i" type="hidden" name="coloresLink[]" :value="item" :id="'colorHidden'+i">
        

        <InputFileImageMultiple
                    label="Galeria de imagenes"
                    placeholder=""
                    v-model="form.galeria"
                    :error="errors.galeria"
                    class="col-3"
                    ref="galeria"
        />
        
        <div v-for="(item, i) in form.galeriaLink" :key="i">
            <img  :id="'img'+i" v-bind:src="item" class="col-1" style="max-width: 250px;" onerror="this.onerror=null;">
            <button class="btn btn-danger" type="button" @click="borrarImg('img',i)" :id="'imgbtn'+i">Eliminar</button>
        </div>
        <input v-for="(item, i) in form.galeriaLink" :key="i" type="hidden" name="galeriaLink[]" :value="item" :id="'imgHidden'+i">
        <!-- <a v-for="(item, i) in form.galeriaLink" :key="i" v-bind:href="'/adm/articuloSuelas/deleteImg/'+item">Borrar</a> -->
        
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