<template>
    <div ref="rootElement" class="rootElement">
        <span v-if="label">{{ label }}</span>
        <div class="select-autocomplete">
            <button class="select-autocomplete__button" @click="click" type="button">
                <span class="select-autocomplete__text" v-if="state.selected">
                    <slot v-bind="state.selected" name="option"></slot>
                </span>
                <span class="select-autocomplete__text" v-else>Seleccionar</span>
                <i class="fas fa-angle-down" style="margin-left: auto;"></i>
            </button>
            <div class="select-autocomplete__dropdown" v-if="displayOptions">
                <input
                    type="search"
                    class="select-autocomplete__search"
                    v-model="state.search"
                    @keyup.enter="submit"
                    @keyup="submit"
                    @keypress.enter.native.prevent
                    placeholder="Buscar..."
                    ref="inputSearch"
                    @keydown.down="nextFocus"
                >
                <div class="select-autocomplete__options" v-if="state.state == 'ready'">
                    <button
                        class="select-autocomplete__option"
                        @click="select(null)"
                        @keyup.enter="select(null)"
                        @keydown.down="nextFocus"
                        @keydown.up="previousFocus"
                        type="button"
                        v-if="allowNull"
                    >
                        Ninguno
                    </button>
                    <button
                        class="select-autocomplete__option"
                        @click="select(option)"
                        @keyup.enter="select(option)"
                        @keydown.down="nextFocus"
                        @keydown.up="previousFocus"
                        v-for="(option, key) in paginator.data"
                        :key="key"
                        type="button"
                    >
                        <slot v-bind="option" name="option"></slot>
                    </button>
                </div>
                <div class="select-autocomplete__options" v-if="state.state == false">
                    <div class="select-autocomplete__option">Ingrese y presione enter para buscar</div>
                </div>
                <div class="select-autocomplete__options" v-if="state.state == 'no-results'">
                    <div class="select-autocomplete__option">No hay resultados</div>
                </div>
                <div class="select-autocomplete__options" v-if="state.state == 'loading'">
                    <div class="select-autocomplete__option"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>
                </div>
            </div>
        </div>
        <InputErrors :errors="error" />
    </div>
</template>

<script setup>
import { reactive, ref, watch, onMounted } from 'vue'

const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
    },
    modelValue: {
        type: [Object, String, Number, Boolean, Array],
        required: true,
    },
    error: {
        type: Array,
        required: false,
    },
    options: {
        type: Array,
        required: false,
    },
    endpoint: {
        type: String,
        required: false,
    },
    optionKey: {
        type: String,
        required: false,
        default: null,
    },
    selectedRaw: {
        type: Object,
        required: false,
        default: null,
    },
    allowNull: {
        type: Boolean,
        required: false,
        default: true,
    },
})
const emit = defineEmits(['update:modelValue'])

const displayOptions = ref(false)
const paginator = reactive({
    data: []
})
const inputSearch = ref(null)
window.inputSearch = inputSearch
const rootElement = ref(null)
const state = reactive({
    state: 'ready',
    options: [],
    selected: null,
    search: ''
})

document.addEventListener('click', (e) => {
    // console.log(e.target, this.$el)
    // this.$el ya no se puede utilizar en vue 3 en su lugar
    // se debe utilizar ref
    if (rootElement.value.contains(e.target)) {
        return;
    }
    displayOptions.value = false;
});
// this.state = 'ready'
window.addEventListener('keydown', (e) => {
    // console.log(e.which, e.code, e.key);
    if ( ["Escape"].includes( e.code ) ) {
        displayOptions.value = false;
        window.preventScrollWithArrow = displayOptions.value
        // this.$forceUpdate();
    }
}, false)

const syncData = () => {
    // let modal = awesomeModal.loading()
    let url = new URL(window.public_path + props.endpoint)
    const form = new FormData()
    form.append('search', state.search)
    /*
    for (const [key, value] of Object.entries(appliedFilters)) {
        if (value) {
            form.append('filters[' + key + ']', value)
        }
    }
    */
    // fetch using method POST

    fetch(url, {
        method: 'POST',
        body: form,
    })
    .then(response => response.json())
    .then(data => {
        // console.clear()
        // console.log('aqui vamos')
        // chequear si es un array
        if (
            Object.prototype.toString.call(data) == '[object Array]'
        ) {
            // console.log('es un array')
            paginator.data = data
        }

        // chequear si es un objeto y no un array y si existe el metodo data.data data.next_page_url
        if (
            Object.prototype.toString.call(data) == '[object Object]'
            && data.hasOwnProperty('data')
            && data.hasOwnProperty('next_page_url')
        ) {
            // console.log('es un objeto')
            Object.assign(paginator, data)
        }
        find(props.modelValue)
        // modal.close()
    })
    .catch(error => {
        // console.clear()
        // console.log('Aqui ocurrio un error')
        // console.log(error)
        // modal.close()
        // Código de estado: 401 Unauthorized
        if (error.response.status == 401) {
            console.log('acceso denegado')
            router.push('/adm/login')
            return false
        }
        // Código de estado: 422 Unprocessable Content
        if (error.response.status == 422) {
            Object.assign(errors, error.response.data.errors)
            return false
        }
    })
}
const refreshData = () => {
    syncData()
}
syncData()

const click = () => {
    displayOptions.value = !displayOptions.value;
    window.preventScrollWithArrow = displayOptions.value
    if (displayOptions.value) {
        setTimeout(() => {
            inputSearch.value.focus();
        }, 100);
    } else {
    }
}

const nextFocus = (e) => {
    // Utilizo keydown en lugar dekeyup porque keydown funciona como longpress
    let options = document.activeElement;
    // check if element is input or button
    if ( options.tagName == 'INPUT' ) {
        let next = options.nextElementSibling.children[0];
        if (next) {
            next.focus();
        }
    }
    if ( options.tagName == 'BUTTON' ) {
        let next = options.nextElementSibling
        if (next) {
            next.focus();
        }
    }
}

const previousFocus = (e) => {
    let options = document.activeElement;
    if ( options.tagName == 'BUTTON' ) {
        // check if is first button
        if (options.previousElementSibling) {
            options.previousElementSibling.focus();
        } else {
            inputSearch.value.focus();
        }
        /*
        let previous = options.parentNode.previousElementSibling
        if (previous) {
            previous.focus();
        }
        */
    }
}

const select = (option) => {
    // console.clear()
    if (props.optionKey == null) {
        /*
        console.table({
            key: props.optionKey,
            value: option
        });
        */
    } else {
        /*
        console.table({
            key: props.optionKey,
            value: option[props.optionKey]
        });
        */
    }
    if (props.selectedRaw) {
        Object.assign(props.selectedRaw, option)
    }
    // emit('update:selectedRaw', option)
    // console.log(option)
    window.preventScrollWithArrow = false;
    displayOptions.value = false;
    if ( option != null ) {
        state.selected = option;
        emit('update:modelValue', option[props.optionKey])
    } else {
        state.selected = null;
        emit('update:modelValue', null)
    }
    // this.$forceUpdate();
}

const submit = (e) => {
    e.preventDefault()
    e.stopPropagation();
    syncData()
}
const find = (optionKey) => {
    // find value in options and select it
    paginator.data.find((option) => {
        if (option[props.optionKey] == optionKey) {
            select(option)
            return true
        }
    })
    /*
    let url = new URL(window.public_path + props.endpoint)
    const form = new FormData()
    form.append('optionKey', optionKey)

    fetch(url, {
        method: 'POST',
        body: form,
    })
    .then(response => response.json())
    .then(data => {
        state.selected = data
        // modal.close()
    })
    .catch(error => {
        // modal.close()
        // Código de estado: 401 Unauthorized
        if (error.response.status == 401) {
            console.log('acceso denegado')
            router.push('/adm/login')
            return false
        }
        // Código de estado: 422 Unprocessable Content
        if (error.response.status == 422) {
            Object.assign(errors, error.response.data.errors)
            return false
        }
    })
    */
}
onMounted(() => {
    if (props.modelValue) {
        find(props.modelValue)
    }
})

watch(() => props.modelValue, (value) => {
    find(value)
})


</script>



<style lang="scss" scoped>
    .rootElement {
        &>span {
            font-weight: 500;
            font-size: 16px;
            line-height: 19px;
            color: #0C0C0C;
            margin-bottom: 9px;
            display: block;
        }
    }
    .select-autocomplete {
        position: relative;
        //z-index: 1;
        width: 100%;
        max-width: 100%;
        &__text {
            white-space: nowrap;
            overflow: hidden;
            max-width: calc(100% - 50px);
            position: absolute;
            text-overflow: ellipsis;
        }
        &__button {
            background: #FFFFFF;
            border: 1px solid #C1C1C1;
            border-radius: 4px;
            width: 100%;
            height: 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        &__dropdown {
            position: absolute;
            top: 41px;
            left: 0;
            width: 100%;
            background: #FFFFFF;
            border: 1px solid #C1C1C1;
            border-radius: 0 0 8px 8px;
            z-index: 999;
        }
        &__search {
            width: 100%;
            height: 40px;
            border: none;
            border-bottom: 1px solid #C1C1C1;
            padding: 0 20px;
            font-size: 16px;
            line-height: 48px;
            color: #000000;
            outline: none;
            // margin-top: 8px;
            font-size: 14px;
        }
        &__options {
            overflow-y: auto;
            max-height: 300px;
        }
        &__option {
            padding: 0 15px;
            font-size: 14px;
            line-height: 34px;
            color: #000000;
            cursor: pointer;
            white-space: nowrap;
            border-bottom: 1px solid #C1C1C1;
            user-select: none;
            border: none;
            width: 100%;
            outline: none;
            background-color: #fff;
            text-align: left;
            border: 2px solid transparent;
            &:hover {
                background-color: #F5F5F5;
            }
            &:focus {
                border: 2px solid #C61D91;
            }
        }
    }
</style>