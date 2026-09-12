<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Portafolio de tejidos</h4>
    <p class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2">
      Haz clic en el encabezado o en una tarjeta del lienzo para editarla aquí.
    </p>

    <div data-editor-focus="catalog:header" class="grid grid-cols-2 gap-2" :class="{ 'ring-2 ring-[#0B4F6C] rounded-lg p-2': activeFocus === 'catalog:header' }">
      <div>
        <label class="block text-xs text-gray-600 mb-1" for="tissue-catalog-title">Título sección</label>
        <input id="tissue-catalog-title" v-model="element.sectionTitle" type="text" class="field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1" for="tissue-catalog-highlight">Palabra destacada</label>
        <input id="tissue-catalog-highlight" v-model="element.sectionHighlight" type="text" class="field-input">
      </div>
      <div class="col-span-2">
        <label class="block text-xs text-gray-600 mb-1" for="tissue-catalog-subtitle">Subtítulo</label>
        <textarea id="tissue-catalog-subtitle" v-model="element.sectionSubtitle" rows="2" class="field-input"></textarea>
      </div>
      <div class="col-span-2">
        <label class="block text-xs text-gray-600 mb-1" for="tissue-catalog-library">URL biblioteca digital</label>
        <input id="tissue-catalog-library" v-model="element.libraryUrl" type="url" class="field-input" placeholder="https://...">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1" for="tissue-catalog-library-label">Texto del botón</label>
        <input id="tissue-catalog-library-label" v-model="element.libraryLabel" type="text" class="field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1" for="tissue-catalog-email">Correo de solicitud</label>
        <input id="tissue-catalog-email" v-model="element.requestEmail" type="email" class="field-input">
      </div>
      <div class="col-span-2">
        <label class="block text-xs text-gray-600 mb-1" for="tissue-catalog-pdf">URL del PDF</label>
        <input id="tissue-catalog-pdf" v-model="element.pdfUrl" type="url" class="field-input">
      </div>
    </div>

    <div
      v-for="(item, i) in element.items"
      :key="item.id || i"
      :data-editor-focus="cardAnchor(item, i)"
      class="border rounded p-3 space-y-2 bg-gray-50"
      :class="{ 'ring-2 ring-[#0B4F6C]': activeFocus === cardAnchor(item, i) }"
    >
      <div class="flex justify-between items-center">
        <span class="text-xs font-medium">Tejido {{ i + 1 }}</span>
        <button type="button" class="text-xs text-red-600 min-h-11 px-2" @click="removeItem(i)">Quitar</button>
      </div>
      <input v-model="item.title" type="text" placeholder="Título" class="field-input">
      <input v-model="item.category" type="text" placeholder="Categoría (osteomuscular, ocular, piel, membrana)" class="field-input">
      <input v-model="item.tag" type="text" placeholder="Etiqueta de preservación" class="field-input">
      <textarea v-model="item.summary" rows="2" placeholder="Resumen" class="field-input"></textarea>
      <input v-model="item.image" type="text" placeholder="URL imagen" class="field-input">
      <input v-model="item.imageAlt" type="text" placeholder="Texto alternativo de la imagen" class="field-input">
      <textarea v-model="item.preservation" rows="2" placeholder="Preservación" class="field-input"></textarea>
      <textarea v-model="item.conservation" rows="2" placeholder="Conservación" class="field-input"></textarea>
      <textarea v-model="item.applicationsText" rows="3" placeholder="Aplicaciones (una por línea)" class="field-input" @input="syncList(item, 'applications', item.applicationsText)"></textarea>
      <textarea v-model="item.presentationsText" rows="3" placeholder="Presentaciones (una por línea)" class="field-input" @input="syncList(item, 'presentations', item.presentationsText)"></textarea>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded hover:bg-gray-50 min-h-11" @click="addItem">
      + Agregar tejido
    </button>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue'
import { generateId } from '../../../utils/pageElementFactory'
import { scrollToEditorFocus, buildServiceCardFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const activeFocus = computed(() => props.partFocus?.anchor || '')
const cardAnchor = (item, index) => buildServiceCardFocusAnchor(item.id || `index-${index}`)

watch(() => props.partFocus?.anchor, (anchor) => {
  if (anchor) scrollToEditorFocus(anchor)
}, { immediate: true })

watch(() => props.element.items, (items) => {
  (items || []).forEach((item) => {
    if (!item.applicationsText && Array.isArray(item.applications)) {
      item.applicationsText = item.applications.join('\n')
    }
    if (!item.presentationsText && Array.isArray(item.presentations)) {
      item.presentationsText = item.presentations.join('\n')
    }
  })
}, { immediate: true })

const syncList = (item, key, value) => {
  item[key] = String(value || '')
    .split('\n')
    .map((line) => line.trim())
    .filter(Boolean)
}

const addItem = () => {
  if (!props.element.items) props.element.items = []
  props.element.items.push({
    id: generateId(),
    title: 'Nuevo tejido',
    category: 'osteomuscular',
    tag: '',
    summary: '',
    image: '',
    imageAlt: '',
    preservation: '',
    conservation: '',
    applications: [],
    presentations: [],
    applicationsText: '',
    presentationsText: '',
  })
}

const removeItem = (index) => {
  props.element.items.splice(index, 1)
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
.field-input:focus { outline: none; box-shadow: 0 0 0 2px #005674; }
</style>
