<template>
    <div class="campos-wrap">

        <div
            v-for="campo in form.campos_form"
            :key="campo.id"
            :class="['campo-item', campo.tipo === 'image_choice' ? 'campo-full' : 'campo-normal']"
        >
            <div class="campo-label">{{ campo.label }}</div>

            <!-- Email: único campo editable -->
            <template v-if="campo.campo_sistema === 'email'">
                <input type="email" class="campo-input editable" v-model="form.email" />
                <span v-if="errors.email?.length" class="campo-error">{{ errors.email[0] }}</span>
            </template>

            <!-- image_choice -->
            <template v-else-if="campo.tipo === 'image_choice'">
                <div class="imagenes-wrap">
                    <div
                        v-for="(op, i) in campo.opciones"
                        :key="i"
                        class="imagen-card"
                        :class="{ seleccionada: campo.valor_array && campo.valor_array.includes(op.label) }"
                    >
                        <img :src="'/storage/' + op.path" :alt="op.label" />
                        <span class="imagen-label">{{ op.label }}</span>
                        <span v-if="campo.valor_array && campo.valor_array.includes(op.label)" class="check-badge">
                            <i class="fas fa-check"></i>
                        </span>
                    </div>
                </div>
            </template>

            <!-- checkbox -->
            <template v-else-if="campo.tipo === 'checkbox'">
                <div class="badges-wrap">
                    <template v-if="campo.valor_array && campo.valor_array.length">
                        <span v-for="(v, i) in campo.valor_array" :key="i" class="badge">{{ v }}</span>
                    </template>
                    <span v-else class="sin-valor">—</span>
                </div>
            </template>

            <!-- file -->
            <template v-else-if="campo.tipo === 'file'">
                <a v-if="campo.valor" :href="'/storage/' + campo.valor" target="_blank" class="btn-archivo">
                    <i class="fas fa-download"></i> Ver archivo
                </a>
                <span v-else class="sin-valor">Sin archivo</span>
            </template>

            <!-- textarea -->
            <template v-else-if="campo.tipo === 'textarea'">
                <textarea class="campo-input" rows="3" disabled>{{ campo.valor || '' }}</textarea>
            </template>

            <!-- resto -->
            <template v-else>
                <div class="campo-valor">{{ campo.valor || '—' }}</div>
            </template>

        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    form:   { type: Object, required: true },
    errors: { type: Object, required: true },
})
</script>

<style lang="scss" scoped>
.campos-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 0;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 10px;
}

.campo-item {
    padding: 14px 18px;
    border-bottom: 1px solid #f3f4f6;
    border-right: 1px solid #f3f4f6;
    box-sizing: border-box;
    &:last-child { border-bottom: none; }
}

.campo-normal {
    width: 33.333%;
    @media (max-width: 900px) { width: 50%; }
    @media (max-width: 600px) { width: 100%; }
}

.campo-full {
    width: 100%;
    background: #fafafa;
    border-right: none;
}

.campo-label {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #9ca3af;
    margin-bottom: 5px;
}

.campo-valor {
    font-size: .97rem;
    color: #111827;
    font-weight: 500;
    min-height: 22px;
}

.campo-input {
    width: 100%;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 6px 10px;
    font-size: .95rem;
    color: #374151;
    background: #f9fafb;
    box-sizing: border-box;
    outline: none;
    resize: vertical;
    &.editable {
        background: #fff;
        border-color: #F15E40;
        &:focus { box-shadow: 0 0 0 3px rgba(241,94,64,.15); }
    }
    &[disabled] { cursor: default; }
}

.campo-error { color: #ef4444; font-size: .8rem; margin-top: 3px; display: block; }

// Imágenes
.imagenes-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    padding: 6px 0;
}
.imagen-card {
    position: relative;
    width: 130px;
    text-align: center;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    padding: 10px 8px 8px;
    background: #fff;
    opacity: .35;
    transition: opacity .2s, border-color .2s, box-shadow .2s;
    img { width:100%; height:85px; object-fit:contain; }
    &.seleccionada {
        opacity: 1;
        border-color: #F15E40;
        box-shadow: 0 0 0 3px rgba(241,94,64,.18);
    }
}
.imagen-label {
    display: block !important;
    font-size: .78rem;
    font-weight: 600;
    color: #374151;
    margin-top: 6px;
}
.check-badge {
    position: absolute !important;
    top: 6px; right: 6px;
    background: #F15E40;
    color: #fff;
    border-radius: 50%;
    width: 20px; height: 20px;
    display: flex !important;
    align-items: center; justify-content: center;
    font-size: .65rem;
}

// Badges
.badges-wrap { display:flex; flex-wrap:wrap; gap:6px; padding: 2px 0; }
.badge {
    padding: 3px 12px;
    background: #fde8e2;
    color: #c2410c;
    border-radius: 20px;
    font-size: .83rem;
    font-weight: 600;
}

.sin-valor { color:#d1d5db; font-style:italic; font-size:.9rem; }

.btn-archivo {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 14px;
    background: #F15E40;
    color: #fff;
    border-radius: 6px;
    font-size: .85rem;
    text-decoration: none;
    font-weight: 600;
    &:hover { background: #d44e32; }
}
</style>