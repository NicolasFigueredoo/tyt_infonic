<script setup>
import { RouterLink, RouterView } from "vue-router";
import { ref, inject } from "vue";

const $globalState = inject("$globalState");
</script>

<template>
    <div
        class="side-bar__wrapper side-bar__wrapper--relative side-bar__wrapper--left side-bar__wrapper--show"
    >
        <div class="side-bar">
            <router-link class="side-bar__logo" to="/adm/">
                <img
                    :src="pathAsset('/images/logoProd.png')"
                    alt="TyT"
                    style="width: 80px; height: auto"
                />
            </router-link>
            <div class="side-bar__menu">
                <details class="side-bar__item">
                    <summary style="cursor: pointer">Inicio</summary>
                    <RouterLink class="side-bar__item" to="/adm/sliders">
                        <i class="fas fa-images"></i>
                        <span>Slider</span>
                    </RouterLink>
                    <RouterLink class="side-bar__item" to="/adm/inicio">
                        <i class="fas fa-pen"></i>
                        <span>Contenido</span>
                    </RouterLink>
                    <RouterLink class="side-bar__item" to="/adm/logosNuevos">
                        <i class="fas fa-images"></i>
                        <span>Logos</span>
                    </RouterLink>
                </details>

                <details class="side-bar__item">
                    <summary style="cursor: pointer">Metricas</summary>
                    <RouterLink class="side-bar__item" to="/adm/metricas">
                        <i class="fas fa-chart-bar"></i>
                        <span>Grafico productos</span>
                    </RouterLink>
                    <RouterLink
                        class="side-bar__item"
                        to="/adm/metricas/pedidos"
                    >
                        <i class="fas fa-chart-line"></i>
                        <span>Grafico pedidos</span>
                    </RouterLink>
                    <RouterLink
                        class="side-bar__item"
                        to="/adm/metricas/referrer"
                    >
                        <i class="fas fa-chart-pie"></i>
                        <span>Grafico clientes</span>
                    </RouterLink>
                </details>

                <RouterLink class="side-bar__item" to="/adm/empresa">
                    <i class="fas fa-pen"></i>
                    <span>¿Quienes somos?</span>
                </RouterLink>

                <details class="side-bar__item">
                    <summary style="cursor: pointer">Productos</summary>

                    <RouterLink class="side-bar__item" to="/adm/tipo-articulo">
                        <i class="fas fa-box-open"></i>
                        <span>Categoria</span>
                    </RouterLink>
                    <RouterLink
                        class="side-bar__item d-none"
                        to="/adm/sub-categoria"
                    >
                        <i class="fas fa-box-open"></i>
                        <span>Sub Categoria</span>
                    </RouterLink>
                    <RouterLink class="side-bar__item" to="/adm/articulo">
                        <i class="fas fa-box-open"></i>
                        <span>Articulos</span>
                    </RouterLink>
                </details>

                <!-- <RouterLink class="side-bar__item" to="/adm/tutoriales">
                    <i class="fab fa-youtube-square"></i>
                    <span>Tutoriales</span>
                </RouterLink> -->

                <details class="side-bar__item">
                    <summary style="cursor: pointer">Contenido</summary>
                    <RouterLink class="side-bar__item" to="/adm/contacto">
                        <i class="fas fa-pen"></i>
                        <span>Contactos</span>
                    </RouterLink>
                    <RouterLink class="side-bar__item" to="/adm/carrito">
                        <i class="fas fa-pen"></i>
                        <span>Carrito</span>
                    </RouterLink>
                    <RouterLink class="side-bar__item" to="/adm/modal">
                        <i class="fas fa-pen"></i>
                        <span>Modal Inicio</span>
                    </RouterLink>

                    <RouterLink
                        class="side-bar__item"
                        to="/adm/seccionesNaranjas"
                    >
                        <i class="fas fa-pen"></i>
                        <span>Iconos</span>
                    </RouterLink>

                    <RouterLink class="side-bar__item" to="/adm/redes">
                        <i class="fas fa-pen"></i>
                        <span>Redes</span>
                    </RouterLink>
                </details>

                <RouterLink class="side-bar__item" to="/adm/clientes">
                    <i class="fas fa-address-card"></i>
                    <span>Clientes</span>
                </RouterLink>

                <RouterLink class="side-bar__item" to="/adm/clientestemp">
                    <i class="fas fa-address-card"></i>
                    <span>Clientes temporales</span>
                </RouterLink>

                <RouterLink
                    class="side-bar__item"
                    to="/adm/clientespotenciales"
                >
                    <i class="fas fa-address-card"></i>
                    <span>Clientes potenciales</span>
                </RouterLink>

                <RouterLink class="side-bar__item" to="/adm/listaPrecios">
                    <i class="fa-solid fa-bars"></i>
                    <span>Lista de precios</span>
                </RouterLink>

                <RouterLink class="side-bar__item" to="/adm/pedidos">
                    <i class="fas fa-boxes"></i>
                    <span>Pedidos</span>
                </RouterLink>

                <RouterLink class="side-bar__item" to="/adm/metadatos">
                    <i class="fas fa-address-card"></i>
                    <span>Metadatos</span>
                </RouterLink>

                <!--
                <RouterLink class="side-bar__item" to="/adm/data">
                    <i class="fas fa-database"></i>
                    <span>Maestros / Catálogos</span>
                </RouterLink>
                -->
                <!-- <RouterLink class="side-bar__item" to="/adm/stock">
                    <i class="fas fa-inbox"></i>
                    <span>Stock</span>
                </RouterLink>
                <RouterLink class="side-bar__item" to="/adm/upload">
                    <i class="fas fa-upload"></i>
                    <span>Subir Archivos</span>
                </RouterLink> 
                -->

                <RouterLink class="side-bar__item" to="/adm/user">
                    <i class="fas fa-address-card"></i>
                    <span>Usuarios</span>
                </RouterLink>

                <RouterLink class="side-bar__item" to="/adm/formclientes">
                    <i class="fas fa-address-card"></i>
                    <span>Formulario clientes</span>
                </RouterLink>
                <RouterLink class="side-bar__item" to="/adm/data/archivosmedia">
                    <i class="fas fa-photo-video"></i>
                    <span>Archivos multimedia</span>
                </RouterLink>

                <!-- <RouterLink class="side-bar__item" to="/adm/configurations">
                    <i class="fas fa-cogs"></i>
                    <span>Configuración</span>
                </RouterLink> -->
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
/* Fuerza a que cada <details> con la clase side-bar__item se muestre en columna */
.side-bar__menu details.side-bar__item {
    display: flex;
    flex-direction: column;
    align-items: start;
}

/* Si es necesario, también puedes forzar a los elementos internos (los RouterLink) a ocupar el 100% */
.side-bar__menu details.side-bar__item > a {
    display: flex;
}

.side-bar {
    display: flex;
    flex-direction: column;
    min-width: 300px;
    max-width: 300px;
    background-color: #fff;
    height: 100%;
    position: relative;
    &__wrapper {
        flex-grow: 1;
        overflow: hidden;
        transition: all 0.5s ease;
        &--relative {
            position: relative;
        }
        &--absolute {
            position: absolute;
            bottom: 0;
            top: 0;
        }
        &--left {
            order: 1;
        }
        &--right {
            order: 3;
        }
        &--absolute#{&}--left {
            left: 0;
        }
        &--absolute#{&}--right {
            right: 0;
        }
        &--show {
            width: 300px;
            min-width: 300px;
            max-width: 300px;
        }
        &--hide {
            width: 0;
            min-width: 0;
            max-width: 300px;
            flex-grow: 0;
        }
    }
    &__logo {
        padding: 17px 0;
        text-align: center;
        img {
            height: 87px;
            max-width: 100%;
        }
    }
    &__menu {
        display: flex;
        flex-direction: column;
        width: 100%;
        padding-bottom: 45px;
        overflow-y: scroll;
        // scrollbar
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
        &::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera*/
        }
    }
    &__item {
        display: flex;
        align-items: center;
        padding: 15px 38px;
        color: #000;
        text-decoration: none;
        i {
            margin-right: 10px;
            color: #656565;
            width: 30px;
            justify-content: flex-end;
            align-items: center;
            display: flex;
        }
        &.router-link-active,
        &:hover {
            background-color: #c4c4c4;
            color: #0c814a;
            i {
                color: #0c814a;
            }
        }
    }
    &__control {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 45px;
        border-top: 1px solid #d1d1d1;
        display: flex;
        background-color: #000;
    }
    &__button {
        flex-grow: 1;
        border: none;
        background-color: transparent;
        color: #9d9d9d;
        cursor: pointer;
        i {
            font-size: 20px;
        }
        &:hover {
            color: #0e7d4a;
        }
    }
}
</style>
