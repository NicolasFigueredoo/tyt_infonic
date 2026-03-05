<template>
    <div class="container modal">
        <div class="modal__header">
            <h2 class="controls__title">Añadir posición de un artículo dentro del almacén</h2>
            <div class="modal__close" @click="close"><i class="fas fa-times"></i></div>
        </div>
        <div class="modal__body">
            <div class="grid-2 gap-15">
                <SelectAutocomplete
                    label="Almacén"
                    v-model="form.almacen_id"
                    endpoint="/api/almacen/list-select"
                    :error="errors.almacen_id"
                    :allowNull="false"
                    class="col-1"
                    option-key="id"
                >
                    <template #option="{ id, name }">
                        <div>
                            {{ name }}
                        </div>
                    </template>
                </SelectAutocomplete>
                <InputText
                    label="Ubicación"
                    placeholder=""
                    v-model="form.ubicacion"
                    :error="errors.ubicacion"
                    class="col-1"
                />
                <InputText
                    label="Cantidad"
                    placeholder=""
                    v-model="form.cantidad"
                    :error="errors.cantidad"
                    class="col-1"
                    type="number"
                />
                <InputText
                    label="Peso"
                    placeholder=""
                    v-model="form.peso"
                    :error="errors.peso"
                    class="col-1"
                    type="number"
                />
                <InputText
                    label="Observaciones"
                    placeholder=""
                    v-model="form.observaciones"
                    :error="errors.observaciones"
                    class="col-2"
                />
                
                <div class="modal__buttons col-2">
                    <button
                        class="btn btn--rounded btn--lightblue"
                        type="submit"
                        @click="onSubmit"
                    >
                        <i class="fas fa-plus"></i>
                        Añadir posición
                    </button>
                </div>
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

    const form = reactive({
        almacen_id: 1,
        ubicacion: '',
        cantidad: 0,
        peso: 0,
        observaciones: '',
    })
    const errors = reactive({
        almacen_id: [],
        ubicacion: [],
        cantidad: [],
        peso: [],
        observaciones: [],
    })

    const onSubmit = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("articulo_id", props.data.rawData.articulo_id);
        form_data.append("almacen_id", form.almacen_id);
        form_data.append("ubicacion", form.ubicacion);
        form_data.append("cantidad", form.cantidad);
        form_data.append("peso", form.peso);
        form_data.append("observaciones", form.observaciones);    

        httpRequest({
            url: window.public_path + '/adm/stock/position/add',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            window.location.reload()
        })
        .catch((error) => {
            modal.close()
        })
    }

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
        min-height: calc(100vh - 30px);
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