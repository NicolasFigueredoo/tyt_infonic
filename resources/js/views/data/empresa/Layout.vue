<template>
    <Main>
        <router-view v-slot="{ Component }">
            <keep-alive :exclude="['Edit', 'Add', 'Home','EditSlider', 'AddSlider', 'HomeSlider']">
                <component :is="Component" />
            </keep-alive>
        </router-view>
    </Main>
</template>

<style lang="scss" scoped>
</style>