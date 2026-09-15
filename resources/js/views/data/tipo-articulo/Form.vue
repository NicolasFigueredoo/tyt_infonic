<template>
    <div class="grid-3 gap-15">
        <InputText
            label="Orden"
            placeholder=""
            v-model="form.orden"
            :error="errors.orden"
            class="col-3"
        />
        <InputText
            label="Nombre"
            placeholder=""
            v-model="form.name"
            :error="errors.name"
            class="col-3"
        />

        <InputText
            label="Nombre (Ingles)"
            placeholder=""
            v-model="form.nameEnglish"
            :error="errors.nameEnglish"
            class="col-3"
        />

        <InputText
            label="Code"
            placeholder=""
            v-model="form.code"
            :error="errors.code"
            class="col-3"
        />

        <div class="col-3">
            <template v-if="!form.principal">
                <label for="categoria">Categoría: </label>
                <select
                    v-model="form.sub_categoria_id"
                    :error="errors.sub_categoria_id"
                    class="form-select"
                    id="categoria"
                >
                    <option value="" disabled>Seleccione una categoría</option>
                    <option
                        v-for="categoria in form.categorias"
                        :key="categoria.id"
                        :value="categoria.id"
                    >
                        {{ categoria.name }}
                    </option>
                </select>

                <small v-if="errors.categoria" class="text-danger">{{
                    errors.categoria
                }}</small>
            </template>

            <template v-if="!form.principal">
                <div class="col-12" style="margin-top: 20px">
                    <label for="productos">Productos: </label>
                    <multiselect
                        v-model="form.seleccionados"
                        :options="form.productos"
                        track-by="id"
                        label="name"
                        placeholder="Buscar y agregar productos"
                        multiple
                        id="productos"
                        :close-on-select="false"
                        :preserve-search="true"
                        :show-labels="false"
                    >
                        <template #selection="{ values, isOpen }">
                            <span
                                v-if="values.length && !isOpen"
                                class="multiselect__single"
                            >
                                {{ values.length }} producto{{ values.length === 1 ? "" : "s" }} seleccionado{{ values.length === 1 ? "" : "s" }}
                            </span>
                        </template>
                    </multiselect>

                    <small
                        v-if="form.seleccionados && form.seleccionados.length"
                        class="text-muted d-block mt-2"
                    >
                        Arrastr&aacute; los productos para definir el orden en que se muestran.
                    </small>
                    <div class="chips-sortable">
                        <span
                            v-for="(producto, index) in form.seleccionados"
                            :key="producto.id"
                            class="chip"
                            :class="{
                                'chip--dragging': dragIndex === index,
                                'chip--over': overIndex === index && dragIndex !== index,
                            }"
                            draggable="true"
                            @dragstart="onDragStart(index, $event)"
                            @dragenter.prevent="overIndex = index"
                            @dragover.prevent
                            @drop.prevent="onDrop(index)"
                            @dragend="onDragEnd"
                            :title="producto.name"
                        >
                            <span class="chip__handle">&#8942;&#8942;</span>
                            <span class="chip__text">{{ producto.name }}</span>
                            <button
                                type="button"
                                class="chip__remove"
                                @click.stop="quitar(index)"
                                title="Quitar"
                            >
                                &times;
                            </button>
                        </span>
                    </div>
                </div>
            </template>
        </div>
        <InputFileImage
            label="Marca"
            placeholder=""
            v-model="form.imagenMarca"
            :error="errors.imagenMarca"
            class="col-1"
        />
        <small class="col-3">Tama&ntilde;o recomendado 16 x 200 px</small>
        <img
            v-bind:src="form.imagenMarca"
            class="col-3"
            onerror="this.onerror=null;"
        />

        <InputFileImage
            label="Image"
            placeholder=""
            v-model="form.imagen"
            :error="errors.imagen"
            class="col-1"
        />
        <button
            v-if="form.imagenSrc"
            type="button"
            class="btn btn-sm btn-outline-danger"
            @click="
                form.imagen = 0;
                form.imagenSrc = null;
            "
            title="Quitar imagen"
        >
             Eliminar imagen
        </button>

        <small class="col-3">Tama&ntilde;o recomendado 200 x 200 px</small>
        <img
            v-bind:src="form.imagenSrc"
            class="col-3"
            onerror="this.onerror=null;"
        />

        <div class="form-check">
            <input
                class="form-check-input"
                v-model="form.oculto"
                :error="errors.oculto"
                type="checkbox"
                id="oculto"
            />
            <label class="form-check-label" for="oculto">
                Ocultar categoria
            </label>
        </div>
        <div class="form-check">
            <input
                class="form-check-input"
                v-model="form.destacado"
                :error="errors.destacado"
                type="checkbox"
                id="destacado"
            />
            <label class="form-check-label" for="destacado"> Destacado </label>
        </div>

        <div class="form-check">
            <input
                class="form-check-input"
                v-model="form.principal"
                :error="errors.principal"
                type="checkbox"
                id="principal"
            />
            <label class="form-check-label" for="principal"> Principal </label>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps } from "vue";
import Multiselect from "vue-multiselect";

// Definición de propiedades
const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
});

// Reordenamiento por arrastre de los productos seleccionados
const dragIndex = ref(null);
const overIndex = ref(null);

const onDragStart = (index, event) => {
    dragIndex.value = index;
    event.dataTransfer.effectAllowed = "move";
    // Firefox necesita datos para iniciar el arrastre
    event.dataTransfer.setData("text/plain", String(index));
};

const onDrop = (index) => {
    if (dragIndex.value === null || dragIndex.value === index) {
        onDragEnd();
        return;
    }
    const lista = props.form.seleccionados;
    const [movido] = lista.splice(dragIndex.value, 1);
    lista.splice(index, 0, movido);
    onDragEnd();
};

const onDragEnd = () => {
    dragIndex.value = null;
    overIndex.value = null;
};

const quitar = (index) => {
    props.form.seleccionados.splice(index, 1);
};
</script>

<style lang="scss" scoped>
@import "vue-multiselect/dist/vue-multiselect.min.css";

.chips-sortable {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 8px;
}

.chip {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border-radius: 5px;
    background: #41b883;
    color: #fff;
    font-size: 13px;
    line-height: 1;
    cursor: grab;
    user-select: none;
    border: 2px solid transparent;
    transition: opacity 0.15s, border-color 0.15s;

    &:active {
        cursor: grabbing;
    }

    &--dragging {
        opacity: 0.4;
    }

    &--over {
        border-color: #1b6b4a;
        background: #2f9c6c;
    }

    &__handle {
        opacity: 0.7;
        letter-spacing: -3px;
        font-size: 12px;
    }

    &__text {
        white-space: nowrap;
    }

    &__remove {
        border: none;
        background: transparent;
        color: #fff;
        font-size: 16px;
        line-height: 1;
        padding: 0 0 0 4px;
        cursor: pointer;
        opacity: 0.8;

        &:hover {
            opacity: 1;
        }
    }
}
</style>
