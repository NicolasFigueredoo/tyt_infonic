<template>
    <div class="loading" @click.self="data.overlayClick">
        <div class="loading__container">
            <div class="loading__icon" v-html="data.icon" :style="'color: ' + data.iconColor"></div>
            <div class="loading__title" v-html="data.title"></div>
            <div class="loading__message" v-html="data.message"></div>
        </div>
    </div>
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
    .loading {
        margin: auto;
        max-width: 400px;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        &__container {
            width: 100%;
            display: flex;
            background-color: #ffffff;
            border-radius: 0;
            padding: 35px 20px;
            flex-direction: column;
            text-align: center;
        }
        &__icon {
            font-size: 44px;
            margin-bottom: 20px;
        }
        &__title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        &__message {
            font-size: 14px;
        }
    }
    // first load animation
    .loading__container {
        animation: loading .5s ease-in-out;
        @keyframes loading {
            0% {
                transform: translate(0px, 1000px) scale(.3);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }
    }
</style>