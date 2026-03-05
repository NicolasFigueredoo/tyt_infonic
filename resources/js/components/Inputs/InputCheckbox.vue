<script setup>
import { ref, reactive } from "@vue/reactivity";
import { watch } from "@vue/runtime-core";

const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    modelValue: {
        type: [String, Number, Array],
        required: true,
    },
    error: {
        type: Array,
        required: false,
    },
    trueValue: {
        required: false,
        default: true,
    },
    falseValue: {
        required: false,
        default: false,
    },
})
// watch changes in the modelValue prop deep true
// const modelValue = ref(props.modelValue)

const emit = defineEmits(['update:modelValue'])
const typeIsArray = ref(Object.prototype.toString.call(props.modelValue) == '[object Array]')

const handleChange = () => {
    // Si el tipo es array
    if (typeIsArray.value) {
        // Si el valor ya existe en el array
        if (props.modelValue.includes(props.trueValue)) {
            // Eliminar el valor del array
            emit('update:modelValue', props.modelValue.filter((value) => value != props.trueValue))
        } else {
            // Agregar el valor al array
            emit('update:modelValue', [...props.modelValue, props.trueValue])
        }
    } else {
        // Si el tipo no es array
        // Si el valor es igual al trueValue
        if (props.modelValue == props.trueValue) {
            // Asignar el falseValue
            emit('update:modelValue', props.falseValue)
        } else {
            // Asignar el trueValue
            emit('update:modelValue', props.trueValue)
        }
    }
}
/*
if ( typeIsArray ) {
    watch(() => modelValue.value, (value) => {
        emit('update:modelValue', value)
    }, { deep: true })
} else {
    watch(() => modelValue.value, (value) => {
        emit('update:modelValue', value)
    })
}

watch(() => props.modelValue, (value) => {
    // emit('update:modelValue', value)
}, { deep: true })

watch(() => modelValue.value, (value) => {
    emit('update:modelValue', value)
}, { deep: true })

/*
const emit = defineEmits(['update:modelValue'])

const state = reactive({
    checked: props.modelValue.includes(props.value),
    value: props.value
})

const handleChange = (e) => {
    if (e.target.checked) {
        state.checked = true
        emit('update:modelValue', [...props.modelValue, state.value])
    } else {
        state.checked = false
        emit('update:modelValue', props.modelValue.filter(item => item !== state.value))
    }
}
*/
</script>
<template>
    <label class="checkbox" @click="handleChange">
        <!--
            Se separa el caso de que el modelValue sea un array, ya que en ese caso
            se debe agregar o quitar el valor del checkbox al array, en caso contrario
            se debe asignar el valor del checkbox al modelValue.
        -->
            <i class="fas fa-toggle-off" v-if="typeIsArray && !modelValue.includes(trueValue)"></i>
            <i class="fas fa-toggle-off" v-else-if="!typeIsArray && modelValue != trueValue"></i>
            <i class="fas fa-toggle-on" v-else></i>

        <span>{{ label }}</span>
    </label>
</template>

<style lang="scss" scoped>
    .checkbox {
        display: flex;
        border: 1px solid #C4C4C4;
        user-select: none;
        span {
            font-weight: 500;
            font-size: 16px;
            line-height: 19px;
            color: #0C0C0C;
            background-color: #fff;
            margin: 0;
            flex-grow: 1;
            display: flex;
            align-items: center;
            padding: 7.5px;
        }
        input {
            display: none;
        }
        i {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 7.5px;
            background-color: #ededed;
            &.fa-toggle-on {
                color: var(--green);
            }
            &.fa-toggle-off {
                color: #C4C4C4;
            }
        }
    }
</style>