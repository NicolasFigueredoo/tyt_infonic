<script setup>
    import SideBar from '../SideBar/index.vue'
    import TopBar from '../TopBar/index.vue'
    import { useRoute, useRouter } from 'vue-router'
    import { reactive, ref, watch, watchEffect } from 'vue'

    const route = useRoute()
    const router = useRouter()
    const validRoutes = reactive([])
    window.route = route
    window.router = router

    window.validRoutes = validRoutes

    watchEffect(() => {
        validRoutes.splice(0, validRoutes.length)
        route.matched.forEach((item) => {
            if (item.meta && item.meta.displayName) {
                validRoutes.push(item)
            }
        })
    })
</script>

<template>
    <div class="main-app">
        <TopBar></TopBar>
        <div class="main-content">
            <div class="main-content__content">
                <div class="breadcrumb">
                    <span v-for="(matched, idx) in validRoutes" :key="idx">
                        <template v-if="idx < validRoutes.length - 1">
                            <RouterLink :to="matched.path" class="breadcrumb__item">{{ matched.meta.displayName }}</RouterLink>
                            <span class="breadcrumb__divider" v-if="idx != Object.keys(validRoutes).length - 1"> / </span>
                        </template>
                        <template v-else>
                            <span class="breadcrumb__item">{{ matched.meta.displayName }}</span>
                        </template>
                    </span>
                </div>  
                <slot></slot>
            </div>
            <SideBar></SideBar>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .main-content {
        display: flex;
        flex-direction: row;
        flex-grow: 1;
        position: relative;
        height: calc(100vh - 60px);
    }
    .main-content__content {
        flex-grow: 1;
        background-color: #ecf0f1;
        position: relative;
        order: 2;
        overflow-y: auto;
        padding: 40px 32px;
    }
    .breadcrumb {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-sizing: border-box;
        padding: 5px 32px;
        background-color: transparent;
        &__item {
            color: var(--darkgray);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all .3s ease;
        }
        &__divider {
            color: var(--darkgray);
            font-size: 14px;
            font-weight: 500;
            margin: 0 5px;
            line-height: 13px;
        }
    }

</style>
