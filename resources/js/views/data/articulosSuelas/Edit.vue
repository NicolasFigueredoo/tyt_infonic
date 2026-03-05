<script setup>
import { reactive } from "vue";
import Form from "./Form.vue";
import { useRoute, useRouter } from "vue-router";


const route = useRoute();
const router = useRouter();

const form = reactive({
    code: "",
    name: "",
    imagen: 0,
    color: 0,
    ficha: 0,
    talle: "",
    galeria: [],
    description: "",
    galeriaLink: "",
    coloresLink: "",
    "stock-min": "",
});
const errors = reactive({
    code: [],
    name: [],
    imagen: [],
    color: [],
    ficha: [],
    talle: [],
    galeria: [],
    description: [],
    galeriaLink: [],
    coloresLink: [],
    "stock-min": [],
});
let modal = awesomeModal.loading();

httpRequest({
    url: window.public_path + "/adm/articuloSuelas/" + route.params.id,
    method: "GET",
})
    .then((data) => {
        form.code = data.code;
        form.name = data.name;
        form.imagenSrc = data.path;
        form.description = data.description;
        form.fichaHref = data.pathFicha;
        form.talle = data.talle;
        form.galeria = data.pathGaleria;
        form.color = data.pathColores;
        form.galeriaLink = data.pathGaleria;
        form.coloresLink = data.pathColores;
        // Object.assign(form.groups, data.groups)
        modal.close();
    })
    .catch((error) => {
        modal.close();
    });

const onSubmit = () => {
    let modal = awesomeModal.loading();
    var form_data = new FormData();

    form_data.append("code", form.code);
    form_data.append("name", form.name);
    form_data.append("imagenSrc", form.imagen);
    console.log(form.ficha);
    form_data.append("fichaHref", form.ficha);
    if (form.galeria) {
        for (var i = 0; i < form.galeria.length; i++) {
            let file = form.galeria[i];
            form_data.append("galeria[" + i + "]", file);
        }
    }
    if (form.galeriaLink) {        
        for (var i = 0; i < form.galeriaLink.length; i++) {
            let img = document.getElementById('imgHidden'+i);
            if(img){                
                img = img.value;
                form_data.append("galeriaLink[" + i + "]", img);
            }
        }
    }

    if (form.color) {
        for (var i = 0; i < form.color.length; i++) {
            let file = form.color[i];
            form_data.append("color[" + i + "]", file);
        }
    }
    if (form.coloresLink) {        
        for (var i = 0; i < form.coloresLink.length; i++) {
            let img = document.getElementById('colorHidden'+i);
            if(img){                
                img = img.value;
                form_data.append("coloresLink[" + i + "]", img);
            }
        }
    }

    form_data.append("talle", form.talle);
    form_data.append("description", form.description);
    form_data.append("stock-min", form["stock-min"]);

    if (route.meta.copy) {
        form_data.append("__form-input-copy", 1);
    }

    httpRequest({
        url:
            window.public_path + "/adm/articuloSuelas/store/" + route.params.id,
        method: "POST",
        data: form_data,
        errors: errors,
    })
        .then((data) => {
            modal.close();
            router.push("/adm/articuloSuelas");
        })
        .catch((error) => {
            modal.close();
        });
};
</script>
<template>
    <form @submit.prevent="onSubmit">
        <SectionHeader>
            <template #title> Editar Articulo </template>
            <template #buttons>
                <router-link to="/adm/articuloSuelas" class="btn btn--yellow">
                    <i class="fas fa-arrow-left"></i> Volver
                </router-link>
                <button class="btn btn--green" type="submit">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </template>
        </SectionHeader>
        <Form :form="form" :errors="errors" />
    </form>
</template>

<style lang="scss" scoped></style>