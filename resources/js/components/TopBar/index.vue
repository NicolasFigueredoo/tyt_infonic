<script setup>
    import { ref, inject } from 'vue'
    const $globalState = inject('$globalState')
</script>

<template>
    <div class="top-bar">
   
        <div class="top-bar__title">
            TyT administrador
        </div>
        <div class="top-bar__menu">
            <Dropdown class="top-bar__item" v-if="$globalState.auth.status == 'success'">
                <template #button>
                    <i class="fas fa-user-circle"></i>
                    <span>{{ $globalState.auth.user.name }}</span>
                    <i class="fas fa-caret-down"></i>
                </template>
                <router-link class="dropdown__item" to="/user">
                    <i class="fas fa-user"></i>
                    Perfil
                </router-link>
                <button class="dropdown__item" @click="logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar sesión
                </button>
            </Dropdown>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .top-bar {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        padding: 0 20px;
        height: 60px;
        background-color: #000;
        color: #fff;
        &__button {
            background-color: transparent;
            border: none;
            outline: none;
            box-shadow: none;
            display: inline-block;
            height: 100%;
            cursor: pointer;
            color: white;
            padding: 0 14px;
            &:hover {
                background-color: rgba(0, 0, 0, 0.1);
            }
        }
        &__title {
        }
        &__menu {
            margin-left: auto;
            z-index: 1;
        }
        &__item {
            display: flex;
            padding: 0 14px;
            height: 100%;
            color: white;
            text-decoration: none;
            gap: 4.5px;
            cursor: pointer;
        }
    }
</style>