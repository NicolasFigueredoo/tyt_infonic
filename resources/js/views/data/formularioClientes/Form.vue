<template>
    <div class="grid-3 gap-15">

        <InputText
            label="Pregunta / Label"
            placeholder="Ej: ¿Cuál es tu empresa?"
            v-model="form.label"
            :error="errors.label"
            class="col-3"
        />

        <div class="col-3">
            <label class="input-label">Tipo de campo</label>
            <select v-model="form.tipo" class="input-field select-field">
                <option v-for="t in tipos" :key="t.value" :value="t.value">{{ t.label }}</option>
            </select>
            <span v-if="errors.tipo?.length" class="input-error">{{ errors.tipo[0] }}</span>
        </div>

        <!-- Vincular a campo del sistema -->
        <div class="col-3">
            <label class="input-label">
                Vincular a campo del sistema
                <small>(opcional — para crear el cliente automáticamente)</small>
            </label>
            <select v-model="form.campo_sistema" class="input-field select-field">
                <option value="">— Solo visualización —</option>
                <option v-for="c in camposSistema" :key="c.value" :value="c.value">{{ c.label }}</option>
            </select>
        </div>

        <!-- Placeholder solo para tipos texto -->
        <InputText
            v-if="['text','textarea','email','number','link'].includes(form.tipo)"
            label="Placeholder"
            placeholder="Texto de ayuda dentro del campo"
            v-model="form.placeholder"
            :error="errors.placeholder"
            class="col-3"
        />

        <!-- Opciones texto -->
        <div v-if="['select','checkbox','radio'].includes(form.tipo)" class="col-3">
            <label class="input-label">Opciones <small>(una por línea)</small></label>
            <textarea
                v-model="opcionesLocal"
                class="input-field opciones-textarea"
                rows="6"
                placeholder="Facebook&#10;Instagram&#10;Motores de búsqueda"
                @blur="syncOpciones"
            ></textarea>
            <span v-if="errors.opciones?.length" class="input-error">{{ errors.opciones[0] }}</span>
            <div class="otro-wrap">
                <input type="checkbox" v-model="form.tieneOtro" id="chk-otro" />
                <label for="chk-otro">
                    Agregar opción <strong>"Otro"</strong> con campo de texto libre
                </label>
            </div>
        </div>

        <!-- Imágenes -->
        <div v-if="form.tipo === 'image_choice'" class="col-3">
            <label class="input-label">Imágenes para elegir</label>
            <div class="image-slots">
                <div v-for="(slot, index) in form.imageSlots" :key="index" class="image-slot">
                    <div class="image-preview" v-if="slot.preview">
                        <img :src="slot.preview" :alt="'Imagen ' + (index+1)" />
                    </div>
                    <div class="image-preview placeholder" v-else>
                        <i class="fas fa-image"></i>
                        <span>Imagen {{ index + 1 }}</span>
                    </div>
                    <input type="file" accept="image/*" class="input-field" @change="(e) => onImageChange(e, index)" />
                    <InputText
                        label="Etiqueta (opcional)"
                        :placeholder="'Ej: Logo ' + (index+1)"
                        v-model="slot.label"
                        :error="[]"
                        class="mt-5"
                    />
                </div>
            </div>
            <button type="button" class="btn btn--green mt-10" @click="addSlot" v-if="form.imageSlots.length < 6">
                <i class="fas fa-plus"></i> Agregar imagen
            </button>
            <button type="button" class="btn btn--red mt-10 ml-5" @click="removeSlot" v-if="form.imageSlots.length > 1">
                <i class="fas fa-minus"></i> Quitar última
            </button>
        </div>

        <div class="col-3">
            <label class="input-label">Orden</label>
            <input type="number" class="input-field" v-model="form.orden" placeholder="0" min="0" />
            <span v-if="errors.orden?.length" class="input-error">{{ errors.orden[0] }}</span>
        </div>

        <div class="col-3">
            <label class="input-label">Requerido</label>
            <div class="checkbox-wrap">
                <input type="checkbox" v-model="form.requerido" id="chk-requerido" />
                <label for="chk-requerido">Sí, este campo es obligatorio</label>
            </div>
        </div>

        <div class="col-3">
            <label class="input-label">Activo</label>
            <div class="checkbox-wrap">
                <input type="checkbox" v-model="form.activo" id="chk-activo" />
                <label for="chk-activo">Mostrar en el formulario</label>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    form:   { type: Object, required: true },
    errors: { type: Object, required: true },
})

const tipos = [
    { value: 'text',         label: 'Texto corto' },
    { value: 'textarea',     label: 'Texto largo' },
    { value: 'email',        label: 'Email' },
    { value: 'number',       label: 'Número' },
    { value: 'select',       label: 'Lista desplegable (select)' },
    { value: 'checkbox',     label: 'Casillas múltiples (checkbox)' },
    { value: 'radio',        label: 'Opción única (radio)' },
    { value: 'file',         label: 'Subir imagen/archivo' },
    { value: 'link',         label: 'Link / URL' },
    { value: 'image_choice', label: 'Elección por imagen' },
]

const camposSistema = [
    { value: 'empresa',         label: 'Empresa' },
    { value: 'razonSocial',     label: 'Razón Social' },
    { value: 'nombre',          label: 'Nombre' },
    { value: 'apellido',        label: 'Apellido' },
    { value: 'nombreEmpresa',   label: 'Nombre de Empresa' },
    { value: 'email',           label: 'Email' },
    { value: 'cuit',            label: 'CUIT' },
    { value: 'dni',             label: 'DNI' },
    { value: 'telefono',        label: 'Teléfono / Celular' },
    { value: 'iva',             label: 'IVA' },
    { value: 'direccion',       label: 'Dirección' },
    { value: 'numero',          label: 'Número de calle' },
    { value: 'localidad',       label: 'Localidad' },
    { value: 'provincia',       label: 'Provincia' },
    { value: 'cp',              label: 'Código Postal' },
    { value: 'transporte',      label: 'Transporte' },
    { value: 'direccionEntrega',label: 'Dirección de entrega' },
    { value: 'numeroEntrega',   label: 'Número entrega' },
    { value: 'localidadEntrega',label: 'Localidad entrega' },
    { value: 'provinciaEntrega',label: 'Provincia entrega' },
    { value: 'cpEntrega',       label: 'CP entrega' },
]

// Opciones texto
const opcionesLocal = ref(
    Array.isArray(props.form.opciones) ? props.form.opciones.join('\n') : ''
)
watch(() => props.form.opciones, (val) => {
    if (Array.isArray(val)) opcionesLocal.value = val.join('\n')
})
const syncOpciones = () => {
    props.form.opciones = opcionesLocal.value
        .split('\n').map(o => o.trim()).filter(o => o.length > 0)
}

// Inicializar imageSlots cuando cambia a image_choice
watch(() => props.form.tipo, (val, oldVal) => {
    if (val === 'image_choice' && oldVal !== undefined && (!props.form.imageSlots || props.form.imageSlots.length === 0)) {
        props.form.imageSlots = [
            { file: null, preview: null, label: '', existing: null },
            { file: null, preview: null, label: '', existing: null },
            { file: null, preview: null, label: '', existing: null },
        ]
    }
})

const onImageChange = (e, index) => {
    const file = e.target.files[0]
    if (!file) return
    props.form.imageSlots[index].file    = file
    props.form.imageSlots[index].preview = URL.createObjectURL(file)
}
const addSlot    = () => props.form.imageSlots.push({ file: null, preview: null, label: '', existing: null })
const removeSlot = () => props.form.imageSlots.pop()
</script>

<style lang="scss" scoped>
.select-field { width:100%; display:block; height:38px; cursor:pointer; }
.opciones-textarea { width:100%; display:block; resize:vertical; font-family:inherit; line-height:1.5; box-sizing:border-box; }
.otro-wrap {
    display:flex; align-items:flex-start; gap:8px; margin-top:10px;
    padding:10px 12px; background:#f0f7ff; border:1px solid #c3dafe; border-radius:6px;
    input[type="checkbox"] { width:16px; height:16px; margin-top:2px; flex-shrink:0; cursor:pointer; }
    label { cursor:pointer; font-size:.9rem; line-height:1.4; }
}
.checkbox-wrap {
    display:flex; align-items:center; gap:8px; margin-top:6px;
    input[type="checkbox"] { width:16px; height:16px; cursor:pointer; }
}
.image-slots { display:flex; flex-wrap:wrap; gap:16px; margin-top:8px; }
.image-slot  { width:180px; display:flex; flex-direction:column; gap:6px; }
.image-preview {
    width:180px; height:120px; border:2px dashed #ccc; border-radius:6px;
    overflow:hidden; display:flex; align-items:center; justify-content:center; background:#f9f9f9;
    img { width:100%; height:100%; object-fit:contain; }
    &.placeholder { flex-direction:column; gap:6px; color:#aaa; font-size:.8rem; i { font-size:2rem; } }
}
.mt-5 { margin-top:5px; } .mt-10 { margin-top:10px; } .ml-5 { margin-left:5px; }
</style>