<template>
    <component :is="data.component" :data="data"></component>
</template>

<script setup>
    const props = defineProps({
        data: {
            type: Object,
            required: true,
        }
    })

    const close = () => {
        props.data.callback.reject('Close on overlay click')
    }
</script>


<style lang="scss" scoped>
</style>