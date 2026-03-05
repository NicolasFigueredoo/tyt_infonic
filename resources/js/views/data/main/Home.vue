<script setup>
    import { reactive, ref } from 'vue'
    import { useRoute, useRouter } from 'vue-router'
    const route = useRoute()
    const router = useRouter()

</script>
<template>
    <Main>
        <div class="grid-4 gap-15">
            <!-- <RouterLink to="/adm/empresa" class="col-1 card-module">
                <div class="card-module__icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="card-module__description">
                    Administración y configuración de empresa
                </div>
                <div class="card-module__title">
                    Empresa
                </div>
            </RouterLink> -->
            <!-- <RouterLink to="/adm/articulo" class="col-1 card-module">
                <div class="card-module__icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="card-module__description">
                    Definicón de Artículos
                </div>
                <div class="card-module__title">
                    Articulos
                </div>
            </RouterLink>
            <RouterLink to="/adm/cliente" class="col-1 card-module">
                <div class="card-module__icon">
                    <i class="fas fa-address-card"></i>
                </div>
                <div class="card-module__description">
                    Listado y administración de clientes
                </div>
                <div class="card-module__title">
                    Clientes
                </div>
            </RouterLink>
            
            <RouterLink to="/adm/tipo-articulo" class="col-1 card-module">
                <div class="card-module__icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="card-module__description">
                    Definicón de Tipos de Artículos
                </div>
                <div class="card-module__title">
                    Tipos de Articulos
                </div>
            </RouterLink> -->
            
        </div>
    </Main>
</template>
<style lang="scss" scoped>
    .card-module {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        color: #3f3f3f;
        text-decoration: none;
        transition: all .3s ease;
        box-sizing: border-box;
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 5px;
        overflow: hidden;
        &__icon {
            padding: 35px 20px 20px 20px;
            font-size: 40px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            box-sizing: border-box;
            flex-grow: 1;
        }
        &__description {
            font-size: 15px;
            padding: 10px;
            font-weight: 300;
            white-space: nowrap;
            max-width: 100%;
            box-sizing: border-box;
            text-overflow: ellipsis;
            overflow: hidden;
        }
        &__title {
            padding: 20px 0;
            font-size: 20px;
            text-align: center;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.15);
            border-top: 1px solid #3f3f3f;
            box-sizing: border-box;
        }
        &:hover {
            background-color: #00A651;
            color: #fff;
            transform: scale(1.02);
            .card-module__icon {}
            .card-module__description {}
            .card-module__title {
                background-color: rgba(0, 0, 0, 0.3);
            }
        }
    }
</style>
