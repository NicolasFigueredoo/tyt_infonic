<template>
    <ul v-if="errors.length > 0" class="input-errors">
        <li v-for="error in errors" :key="error" v-html="error"></li>
    </ul>
</template>

<script setup>
defineProps({
    errors: {
        type: Array,
        required: false,
    },
})
</script>

<style lang="scss" scoped>
    .input-errors {
        color: #FF0000;
        font-weight: 400;
        line-height: 130%;
        opacity: 1;
        margin: 0;
        padding: 3px 0 3px 20px;
        font-size: 14px;
    }
</style>