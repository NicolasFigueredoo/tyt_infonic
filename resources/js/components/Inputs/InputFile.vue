<template>
    <label class="col-1" :class="{ 'input--error': error.length }">
        <span v-if="label">{{ label }}</span>
        <input
            :type="'file'"
            :required="false"
            :disabled="disabled"
            accept="video/*"
            class="form-control"
            v-on:change="onFileChange($event)"
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
    modelValue: {
        type: [String, Number, File, Blob, null],
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
})
const emit = defineEmits(['update:modelValue', 'change'])

const onFileChange = (event) => {
    const file = event.target.files[0]
    console.log(file)
    emit('update:modelValue', file)
    emit('change', file)
}
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