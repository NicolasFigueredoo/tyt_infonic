
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
            label="Titulo"
            placeholder=""
            v-model="form.titulo"
            :error="errors.titulo"
            class="col-3"
        />
        <InputTextarea
            label="Descripcion"
            placeholder=""
            v-model="form.descripcion"
            :error="errors.descripcion"
            class="col-3"
        />

        <InputText
            label="Titulo (Ingles)"
            placeholder=""
            v-model="form.tituloEnglish"
            :error="errors.tituloEnglish"
            class="col-3"
        />
        <InputTextarea
            label="Descripcion (Ingles)"
            placeholder=""
            v-model="form.descripcionEnglish"
            :error="errors.descripcionEnglish"
            class="col-3"
        />

        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.imagen"
                    :error="errors.imagen"
                    class="col-1"
        />
        
        <small class="col-3">Tama&ntilde;o recomendado 1366 x 626 px  (png,jpg, jpeg, mp4,mov)</small>


        <template v-if="isImage(form.imagenSrc)">
            <img v-bind:src="form.imagenSrc" class="col-3" style="max-width: 100%;" onerror="this.onerror=null;">
        </template>
    <template v-else>
        <svg fill="#000000" height="50" width="50" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 220 220" xml:space="preserve">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path d="M220,46.444l-64.289,45.498V38.87H0v142.26h155.711v-53.071l64.288,45.497L220,46.444z M135.798,73.562H19.915V57.884 h115.883V73.562z"></path>
            </g>
        </svg>
    </template>
    </div>
</template>

<script setup>
    import { reactive } from "@vue/reactivity";
    
    const isImage = (path) => {
        return /\.(jpg|jpeg|png|gif|bmp|webp)$/i.test(path)
    }
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