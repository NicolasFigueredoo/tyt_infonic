<script setup>
import { reactive } from "vue";
import Form from "./Form.vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const form = reactive({
    titulo: "",
    descripcion: "",
    requisitos: "",
    ubicacion: "",
    fecha_publicacion: "",
    activo: 1,
});

const errors = reactive({
    titulo: [],
    descripcion: [],
    requisitos: [],
    ubicacion: [],
    fecha_publicacion: [],
    activo: [],
});

let modal = awesomeModal.loading();

httpRequest({
    url: window.public_path + "/adm/empleos/" + route.params.id,
    method: "GET",
})
    .then((data) => {
        form.titulo = data.titulo;
        form.descripcion = data.descripcion;
        form.requisitos = data.requisitos;
        form.ubicacion = data.ubicacion;
        form.fecha_publicacion = data.fecha_publicacion;
        form.activo = data.activo ? 1 : 0;
        modal.close();
    })
    .catch(() => {
        modal.close();
    });

const onSubmit = () => {
    let modal = awesomeModal.loading();

    var form_data = new FormData();
    form_data.append("titulo", form.titulo);
    form_data.append("descripcion", form.descripcion);
    form_data.append("requisitos", form.requisitos);
    form_data.append("ubicacion", form.ubicacion);
    form_data.append("fecha_publicacion", form.fecha_publicacion);
    form_data.append("activo", form.activo ? 1 : 0);

    Object.keys(errors).forEach((key) => {
        errors[key].splice(0, errors[key].length);
    });

    httpRequest({
        url: window.public_path + "/adm/empleos/store/" + route.params.id,
        method: "POST",
        data: form_data,
        errors: errors,
    })
        .then(() => {
            modal.close();
            router.push("/adm/data/empleos");
        })
        .catch(() => {
            modal.close();
        });
};
</script>

<template>
    <form @submit.prevent="onSubmit">
        <SectionHeader>
            <template #title> Editar Oferta Laboral </template>
            <template #buttons>
                <router-link to="/adm/data/empleos" class="btn btn--yellow">
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
