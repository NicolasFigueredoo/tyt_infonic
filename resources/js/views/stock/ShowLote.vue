<template>
    <div class="container modal">
        <div class="modal__header">
            <h1 class="controls__title">Mostrando Lote {{ data.rawData.lote_id }}</h1>
            <div class="modal__close" @click="close"><i class="fas fa-times"></i></div>
        </div>
        <div class="modal__body">
            <div class="modal__buttons">
                <button
                    class="btn btn--rounded btn--black-outline"
                    type="submit"
                >
                    <i class="fas fa-hand-scissors"></i>
                    Separar un lote
                </button>
                <button
                    class="btn btn--rounded btn--black-outline"
                    type="submit"
                >
                    <i class="fas fa-hand-holding"></i>
                    Unificar lotes
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { reactive, ref } from 'vue'

    const props = defineProps({
        data: {
            type: Object,
            required: true,
        }
    })

    const close = () => {
        props.data.callback.reject('Close on overlay click')
    }
    props.data.rawData
</script>


<style lang="scss" scoped>
    .modal {
        background-color: #ffffff;
        padding: 0;
        // min-height: calc(100% - 30px);
        margin-top: 15px;
        margin-bottom: 15px;

        max-height: calc(100vh - 30px);
        overflow: auto;
        &__header {
            padding: 30px 24px 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        &__close {
            cursor: pointer;
            font-size: 25px;
            transition: all 0.3s ease;
            color: #656565;
            &:hover {
                color: #000;
            }
        }
        &__body {
            padding: 0 24px 42px 24px;
        }
        &__buttons {
            display: flex;
            gap: 15px;
            margin-left: auto;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
    }
    .modal {
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
    .item {
        &__label {
            font-weight: 400;
            font-size: 16px;
            line-height: 19px;
            color: #919191;
            margin-bottom: 7.5px;
        }
        &__value {
            font-weight: 500;
            font-size: 16px;
            line-height: 19px;
            color: #0C0C0C;
        }
    }
</style>