<script setup>
import { inject } from '@vue/runtime-core'
import { RouterLink, RouterView } from 'vue-router'
import Modal from './components/Modal/index.vue'
const $globalState = inject('$globalState')
</script>

<template>
    <RouterView v-if="$globalState.render"></RouterView>
    <Modal></Modal>
</template>

<style lang="scss" scoped>
    .main-app {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        position: relative;
    }
</style>