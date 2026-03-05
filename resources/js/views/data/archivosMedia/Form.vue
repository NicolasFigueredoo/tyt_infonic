<template>
    <div class="grid-3 gap-15">

        <InputText
            label="Nombre descriptivo"
            placeholder="Ej: Catálogo 2024, Videos.."
            v-model="form.nombre"
            :error="errors.nombre"
            class="col-3"
        />

        <div class="col-3">
            <label class="input-label">Tipo</label>
            <select v-model="form.tipo" class="input-field select-field">
                <option value="imagen">Imagen</option>
                <option value="video">Video</option>
                <option value="pdf">PDF</option>
                <option value="otro">Otro</option>
            </select>
            <span v-if="errors.tipo?.length" class="input-error">{{ errors.tipo[0] }}</span>
        </div>

        <!-- Upload -->
        <div class="col-3">
            <label class="input-label">
                Archivo
                <small v-if="form.isEdit">(opcional — dejá vacío para no cambiar el archivo)</small>
            </label>

            <div
                class="drop-zone"
                :class="{ 'drop-zone--over': isDragging, 'drop-zone--filled': preview }"
                @dragover.prevent="isDragging = true"
                @dragleave="isDragging = false"
                @drop.prevent="onDrop"
                @click="$refs.fileInput.click()"
            >
                <!-- Preview imagen -->
                <img v-if="preview && form.tipo === 'imagen'" :src="preview" class="dz-preview-img" />

                <!-- Preview video -->
                <video v-else-if="preview && form.tipo === 'video'" :src="preview" class="dz-preview-img" controls />

                <!-- Preview PDF / otro -->
                <div v-else-if="preview" class="dz-preview-file">
                    <i :class="form.tipo === 'pdf' ? 'fas fa-file-pdf' : 'fas fa-file'"></i>
                    <span>{{ form.archivoNombre }}</span>
                </div>

                <!-- Placeholder -->
                <div v-else class="dz-placeholder">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Arrastrá el archivo acá o <strong>hacé click</strong> para elegir</span>
                    <small>Imágenes, videos, PDF, etc.</small>
                </div>
            </div>

            <input
                ref="fileInput"
                type="file"
                style="display:none"
                @change="onFileChange"
            />
            <span v-if="errors.archivo?.length" class="input-error">{{ errors.archivo[0] }}</span>
        </div>

        <!-- URL generada (solo en edición o post-guardado) -->
        <div v-if="form.url_publica" class="col-3 url-resultado">
            <label class="input-label">URL pública del archivo</label>
            <div class="url-box">
                <span class="url-text">{{ form.url_publica }}</span>
                <button type="button" class="btn-copy" :class="{ copied: urlCopiada }" @click="copiarUrl">
                    <i :class="urlCopiada ? 'fas fa-check' : 'fas fa-copy'"></i>
                    {{ urlCopiada ? '¡Copiado!' : 'Copiar' }}
                </button>
                <a :href="form.url_publica" target="_blank" class="btn-ver">
                    <i class="fas fa-external-link-alt"></i> Ver
                </a>
            </div>
        </div>

        <div class="col-3">
            <label class="input-label">Activo</label>
            <div class="checkbox-wrap">
                <input type="checkbox" v-model="form.activo" id="chk-activo" />
                <label for="chk-activo">Archivo activo</label>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    form:   { type: Object, required: true },
    errors: { type: Object, required: true },
})

const isDragging = ref(false)
const preview    = ref(props.form.url_publica || null)
const urlCopiada = ref(false)

const onFileChange = (e) => {
    const file = e.target.files[0]
    if (!file) return
    setFile(file)
}

const onDrop = (e) => {
    isDragging.value = false
    const file = e.dataTransfer.files[0]
    if (!file) return
    setFile(file)
}

const setFile = (file) => {
    props.form.archivo      = file
    props.form.archivoNombre = file.name
    preview.value = URL.createObjectURL(file)

    // Auto-detectar tipo según extensión
    const ext = file.name.split('.').pop().toLowerCase()
    if (['jpg','jpeg','png','gif','webp','svg'].includes(ext)) props.form.tipo = 'imagen'
    else if (['mp4','mov','avi','webm'].includes(ext))          props.form.tipo = 'video'
    else if (ext === 'pdf')                                      props.form.tipo = 'pdf'
    else                                                         props.form.tipo = 'otro'
}

const copiarUrl = () => {
    navigator.clipboard.writeText(props.form.url_publica).then(() => {
        urlCopiada.value = true
        setTimeout(() => urlCopiada.value = false, 2000)
    })
}
</script>

<style lang="scss" scoped>
.select-field { width:100%; display:block; height:38px; cursor:pointer; }
.checkbox-wrap {
    display:flex; align-items:center; gap:8px; margin-top:6px;
    input[type="checkbox"] { width:16px; height:16px; cursor:pointer; }
}
.drop-zone {
    border: 2px dashed #d1d5db; border-radius: 10px;
    min-height: 160px; display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition: border-color .2s, background .2s;
    background: #fafafa; overflow: hidden;
    &:hover, &--over { border-color: #F15E40; background: #fff5f3; }
    &--filled { border-style: solid; border-color: #F15E40; }
}
.dz-placeholder {
    display:flex; flex-direction:column; align-items:center; gap:8px;
    color:#9ca3af; text-align:center; padding:20px;
    i { font-size:2.5rem; color:#d1d5db; }
    small { font-size:.8rem; color:#d1d5db; }
}
.dz-preview-img {
    width:100%; max-height:260px; object-fit:contain;
}
.dz-preview-file {
    display:flex; flex-direction:column; align-items:center; gap:10px;
    padding:20px; color:#374151;
    i { font-size:3rem; color:#F15E40; }
    span { font-size:.9rem; word-break:break-all; text-align:center; }
}
.url-resultado { margin-top:4px; }
.url-box {
    display:flex; align-items:center; gap:8px;
    background:#f9fafb; border:1px solid #e5e7eb;
    border-radius:8px; padding:10px 14px;
}
.url-text {
    flex:1; font-size:.85rem; color:#374151;
    word-break:break-all;
}
.btn-copy {
    flex-shrink:0; display:flex; align-items:center; gap:5px;
    padding:6px 12px; border:none; border-radius:6px;
    background:#f3f4f6; color:#374151; cursor:pointer; font-size:.82rem;
    transition:background .2s;
    &:hover  { background:#e5e7eb; }
    &.copied { background:#d1fae5; color:#065f46; }
}
.btn-ver {
    flex-shrink:0; display:flex; align-items:center; gap:5px;
    padding:6px 12px; border-radius:6px;
    background:#F15E40; color:#fff; text-decoration:none; font-size:.82rem;
    &:hover { background:#d44e32; }
}
</style>