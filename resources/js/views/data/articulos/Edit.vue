<script setup>
import { reactive } from "vue";
import Form from "./Form.vue";
import { useRoute, useRouter } from "vue-router";


const route = useRoute();
const router = useRouter();

const form = reactive({
    code: "",
    name: "",
    cantidad: "",
    minimo: "",
    precioVigente: "",
    codigoAnterior: "",
    tipoProducto: "",
    imagen: 0,    
    galeria: [],
    description: "",
    descriptionPrivada: "",
    oculto: "",
    galeriaLink: "",
    colores: [],
    "stock-min": "",
    orden: "",
    destacado: "",
    marca:'',
    nameEnglish: '',
    bultoMinorista:'',
    bultoMayorista: '',
            video: '',
        videoTwo: '',
        slug: '',

});
const errors = reactive({
    code: [],
    name: [],
    cantidad: [],
    minimo: [],
    precioVigente: [],
    codigoAnterior: [],
    tipoProducto: [],
    imagen: [],
    colores: [],    
    galeria: [],
    description: [],
    descriptionPrivada: [],
    oculto: [],
    galeriaLink: [],
    coloresLink: [],
    "stock-min": [],
    orden: [],
    destacado: [],
    marca: [],
    nameEnglish: [],
    bultoMinorista: [],
    bultoMayorista: [],
    video: [],
    videoTwo: [],
    slug: [],
});
let modal = awesomeModal.loading();

httpRequest({
    url: window.public_path + "/adm/articulo/" + route.params.id,
    method: "GET",
})
    .then((data) => {
        console.log(data)
        form.id = data.id;
        form.code = data.code;
        form.name = data.name;
        form.cantidad = data.cantidad;
        form.minimo = data.minimo;
        form.precioVigente = data.precioVigente;
        form.codigoAnterior = data.codigoAnterior;
        form.tipoProducto = data.tipoProducto;
        form.imagenSrc = data.path;
        form.description = data.description;
        form.descriptionPrivada = data.descriptionPrivada;
        form.oculto = data.oculto;
        form.galeria = data.pathGaleria;
        form.colores = data.obtenerColores.length > 0 ? data.obtenerColores : [{ color1: '#000', color2: '#000' }];
        form.galeriaLink = data.pathGaleria;
        form.coloresLink = data.pathColores;
        form.destacado = data.destacado;
        form.orden = data.orden;
        form.marca = data.marca;
        form.nameEnglish = data.nameEnglish;
        form.bultoMinorista = data.bultoMinorista;
        form.bultoMayorista = data.bultoMayorista;
        form.video = data.video;
        form.videoTwo = data.videoTwo;
        form.slug = data.slug;

        modal.close();
    })
    .catch((error) => {
        modal.close();
    });

const onSubmit = () => {
    let modal = awesomeModal.loading();
    var form_data = new FormData();    
    form_data.append("orden", form.orden);
    form_data.append("code", form.code);
    form_data.append("name", form.name);
    form_data.append("cantidad", form.cantidad);
    form_data.append("minimo", form.minimo);
    form_data.append("precioVigente", form.precioVigente);
    form_data.append("codigoAnterior", form.codigoAnterior);
    form_data.append("tipoProducto", form.tipoProducto);    
    form_data.append("imagenSrc", form.imagen);   
    form_data.append("nameEnglish", form.nameEnglish);   
    form_data.append("bultoMinorista", form.bultoMinorista);   
    form_data.append("bultoMayorista", form.bultoMayorista);   
    form_data.append("video", form.video);  
    form_data.append("videoTwo", form.videoTwo);  
    form_data.append("slug", form.slug);
    

    if (form.colores) {
        for (var i = 0; i < form.colores.length; i++) {
            let color = form.colores[i];
            let arrColor = {'color1':color.color1,'color2': color.color2}            
            console.log(arrColor)
            console.log(JSON.stringify(arrColor))
            form_data.append("colores[" + i + "]", JSON.stringify(arrColor));
        }
    }
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
    form_data.append("description", form.description);
    form_data.append("descriptionPrivada", form.descriptionPrivada);
    form_data.append("oculto", form.oculto);
    form_data.append("stock-min", form["stock-min"]);
    form_data.append("orden", form.orden);
    form_data.append("destacado", form.destacado);
    form_data.append("marca", form.marca);
    if (route.meta.copy) {
        form_data.append("__form-input-copy", 1);
    }

    httpRequest({
        url:
            window.public_path + "/adm/articulo/store/" + route.params.id,
        method: "POST",
        data: form_data,
        errors: errors,
    })
        .then((data) => {
            modal.close();
            console.log(data)
            router.push("/adm/articulo");
        })
        .catch((error) => {
            console.log(error)
            modal.close();
        });
};
function closeTab() {
    window.close();
}
</script>
<template>
    <form @submit.prevent="onSubmit">
        <SectionHeader>
            <template #title> Editar Articulo </template>
            <template #buttons>                
                <button @click="closeTab()" class="btn btn--yellow">
                    <i class="fas fa-arrow-left"></i> Volver
                </button>
                <button class="btn btn--green" type="submit">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </template>
        </SectionHeader>
        <Form :form="form" :errors="errors" />
    </form>
</template>

<style lang="scss" scoped></style>