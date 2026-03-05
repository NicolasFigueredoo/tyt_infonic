<template>
    <label class="input col-1" :class="{ 'input--error': error.length }">
        <span v-if="label">{{ label }}</span>
        <input
            :type="type"
            :placeholder="placeholder"
            :value="modelValue"
            :required="false"
            :disabled="disabled"
            autocomplete="off"
            v-on:change="$emit('change', $event.target.value)"
            v-on:keypress="$emit('change', $event.target.value)"
            v-on:keyup="$emit('change', $event.target.value)"
            :min="min"
            :max="max"
            @input="$emit('update:modelValue', $event.target.value)"
        >
        <InputErrors :errors="error" />
    </label>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
    },
    modelValue: {
        type: String,
        required: true,
    },
    disabled: {
        type: Boolean,
        required: false,
        default: false
    },
    error: {
        type: Array,
        required: false,
    },
    type: {
        type: Number,
        required: false,
        default: 'tel'
    },
    min: {
        required: false,
        default: null
    },
    max: {
        required: false,
        default: null
    },
})
defineEmits(['update:modelValue', 'change'])
</script>

<style lang="scss" scoped>
	label[class*="input"] {
        display: block;
        span {
            font-weight: 500;
            font-size: 16px;
            line-height: 19px;
            color: #0C0C0C;
            margin-bottom: 9px;
            display: block;
        }
        input {
            width: 100%;
            height: 48px;
            border: 1px solid #C4C4C4;
            border-radius: 4px;
            padding: 0 15px;
            box-sizing: border-box;
			&:-webkit-autofill,
			&:-webkit-autofill:hover, 
			&:-webkit-autofill:focus, 
			&:-webkit-autofill:active{
				-webkit-box-shadow: 0 0 0 30px white inset !important;
			}
			&:focus, &:valid, &:not(:placeholder-shown) {
				outline: none;
				& + span {
					top: 5px;
					font-size: 12px;
					color: #656565;
					opacity: 0.8;
				}
			}
            &:focus {
                box-shadow: 0 0 2px 1px rgba(#00a651, .5);
            }
			&::-webkit-input-placeholder {
				opacity: 1;
			}
        }
        .input__errors {
            color: #FF0000;
            font-weight: 400;
            line-height: 130%;
            opacity: 1;
            margin: 0;
            padding: 3px 0 3px 20px;
            font-size: 14px;
        }

        &.input--error {
            color: #FF0000;
            input {
                border: 1px solid #FF0000;
                &:focus {
                    box-shadow: 0 0 2px 1px rgba(#FF0000, .5);
                }
            }
        }
    }
</style>
