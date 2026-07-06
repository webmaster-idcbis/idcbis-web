<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Servicios IDCBIS</h4>
    <p class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2">
      Haz clic en el encabezado o en una tarjeta del lienzo para editarla aquí.
    </p>

    <div data-editor-focus="services:header" class="grid grid-cols-2 gap-2" :class="{ 'ring-2 ring-[#0B4F6C] rounded-lg p-2': activeFocus === 'services:header' }">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Título sección</label>
        <input v-model="element.sectionTitle" type="text" class="field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Palabra destacada</label>
        <input v-model="element.sectionHighlight" type="text" class="field-input">
      </div>
      <div class="col-span-2">
        <label class="block text-xs text-gray-600 mb-1">Subtítulo</label>
        <input v-model="element.sectionSubtitle" type="text" class="field-input">
      </div>
    </div>

    <div
      v-for="(card, i) in element.cards"
      :key="card.id || i"
      :data-editor-focus="cardAnchor(card, i)"
      class="border rounded p-3 space-y-2 bg-gray-50"
      :class="{ 'ring-2 ring-[#0B4F6C]': activeFocus === cardAnchor(card, i) }"
    >
      <div class="flex justify-between items-center">
        <span class="text-xs font-medium">Tarjeta {{ i + 1 }}</span>
        <button type="button" class="text-xs text-red-600" @click="removeCard(i)">Quitar</button>
      </div>
      <input v-model="card.title" type="text" placeholder="Título" class="field-input">
      <textarea v-model="card.description" rows="2" placeholder="Descripción" class="field-input"></textarea>
      <input v-model="card.image" type="text" placeholder="URL imagen" class="field-input">
      <input v-model="card.tag" type="text" placeholder="#ETIQUETA" class="field-input">
      <input v-model="card.url" type="text" placeholder="Enlace" class="field-input">
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded hover:bg-gray-50" @click="addCard">
      + Agregar tarjeta
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
const cardAnchor = (card, index) => buildServiceCardFocusAnchor(card.id || `index-${index}`)

watch(() => props.partFocus?.anchor, (anchor) => {
  if (anchor) scrollToEditorFocus(anchor)
}, { immediate: true })

const addCard = () => {
  if (!props.element.cards) props.element.cards = []
  props.element.cards.push({
    id: generateId(),
    title: 'Nuevo servicio',
    description: 'Descripción del servicio.',
    image: '',
    tag: '#IDCBIS',
    url: '#',
  })
}

const removeCard = (index) => {
  props.element.cards.splice(index, 1)
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
