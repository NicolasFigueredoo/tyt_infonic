<script setup>
import { ref, inject } from 'vue'

const dropdownShow = ref(false)
const dropdown = ref(null)
window.addEventListener('click', (e) => {
    if (dropdown.value && !dropdown.value.contains(e.target)) {
        dropdownShow.value = false
    } else {
        dropdownShow.value = true
    }
})
window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        dropdownShow.value = false
    }
})
</script>

<template>
    <button class="dropdown" ref="dropdown">
        <div class="dropdown__button">
            <slot name="button"></slot>
        </div>
        <div class="dropdown__menu" v-show="dropdownShow">
            <slot></slot>
        </div>
    </button>
</template>


<style lang="scss">
    .dropdown {
        position: relative;
        background-color: transparent;
        border: none;
        outline: none;
        &__button {
            display: flex;
            cursor: pointer;
            gap: 4.5px;
            background-color: transparent;
            border: none;
            outline: none;
        }
        &__menu {
            position: absolute;
            display: flex;
            flex-direction: column;
            top: 100%;
            background: #FFF;
            left: 0;
            right: 0;
            border: 1px solid #d9d9d9;
            border-bottom: none;
        }
        &__item {
            display: flex;
            cursor: pointer;
            gap: 4.5px;
            justify-content: flex-start;

            background: #FFF;
            border: none;
            outline: none;
            box-shadow: none;

            border-bottom: 1px solid #d9d9d9;

            text-decoration: none;
            color: #000;

            overflow: hidden;
            white-space: nowrap;
            padding: 10px 15px;
            &:hover {
                background-color: #f5f5f5;
            }
            &:active {
                background-color: #d9d9d9;
            }
        }
    }
</style>