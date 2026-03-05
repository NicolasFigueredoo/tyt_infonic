<template>
    <label class="input col-1" :class="{ 'input--error': error.length }">
        <span>{{ label }}</span>
        <textarea
            :placeholder="placeholder"
            :value="modelValue"
            :required="false"
            :disabled="disabled"
            autocomplete="off"            
            @input="$emit('update:modelValue', $event.target.value)"
            style="min-height:150px;"
        ></textarea>
        <ul v-if="error.length > 0" class="input__errors">
            <li v-for="error in error" :key="error" v-html="error"></li>
        </ul>
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
        type: String,
        required: false,
        default: 'text'
    },
})
defineEmits(['update:modelValue'])
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
        input, textarea {
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
				opacity: 0;
			}
        }
        textarea {
            padding-top: 8px;
            padding-bottom: 8px;
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
