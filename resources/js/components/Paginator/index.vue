<template>
    <!-- Paginator -->
    <div class="paginator">
        <div class="paginator__info">
            Mostrando
            <strong>
                {{ paginator.from }}
            </strong>
            a
            <strong>
                {{ paginator.to }}
            </strong>
            de
            <strong>
                {{ paginator.total }}
            </strong>
            registros,
            se muestran <strong>{{ paginator.per_page }}</strong> por página.
        </div>
        <div class="paginator__buttons">
            <button
                v-for="(link, key) in paginator.links"
                :key="key"
                :disabled="link.active"
                @click="$emit('change', link.url)"
                v-html="link.label"
                target="_blanck"
            >
            </button>
        </div>
    </div>
</template>
<script setup>
import { defineProps } from 'vue'

defineProps({
    paginator: {
        type: Object,
        required: true
    }
})
</script>

<style lang="scss" scoped>
.paginator {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;

    &__info {
        font-size: 0.9rem;
        color: #666;
    }

    &__buttons {
        display: flex;
        justify-content: flex-end;
        align-items: center;

        button {
            border: none;
            background-color: transparent;
            color: #666;
            font-size: 0.9rem;
            cursor: pointer;
            margin-left: 10px;
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.2s ease-in-out;

            &:hover {
                background-color: #e5e5e5;
            }

            &[disabled] {
                color: #ccc;
                cursor: not-allowed;
                &:hover {
                    background-color: transparent;
                }
            }
        
        }
    }
}
</style>