<template>
    <div class="modal-item">
        <div class="modal-item__overlay" @click.self="data.overlayClick">
            <Loading v-if="data.type == 'loading' || data.type == 'alert'" :data="data"></Loading>
            <CustomComponent v-if="data.type == 'component'" :data="data"></CustomComponent>
        </div>
    </div>
</template>

<script setup>
    import Loading from './Loading.vue'
    import CustomComponent from './CustomComponent.vue'
    const props = defineProps({
        data: {
            type: Object,
            required: true,
        }
    })

</script>


<style lang="scss" scoped>
    .modal-item {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        &__overlay {
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
    }
</style>