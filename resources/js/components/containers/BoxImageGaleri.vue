<template>
    <label class="input col-1" :class="{ 'input--error': error.length }">
        <span v-if="label">{{ label }}</span>
        <input
            :type="'file'"
            :required="false"
            :disabled="disabled"
            v-on:change="onFileChange($event)"
        >
        <InputErrors :errors="error" />
    </label>
</template>

<script setup>

</script>

<style lang="scss" scoped>

</style>