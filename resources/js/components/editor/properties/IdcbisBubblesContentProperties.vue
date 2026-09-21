<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Investigación (programas)</h4>
    <p class="text-xs text-[#0B4F6C] bg-[#E1F0F5] border border-[#D1E9F2] rounded-lg px-3 py-2">
      Haz clic en el encabezado o en una tarjeta del lienzo para editarla aquí.
    </p>
    <div data-editor-focus="bubbles:header" class="grid grid-cols-2 gap-2" :class="{ 'ring-2 ring-[#0B4F6C] rounded-lg p-2': activeFocus === 'bubbles:header' }">
      <input v-model="element.sectionTitle" type="text" placeholder="Programas de" class="field-input">
      <input v-model="element.sectionHighlight" type="text" placeholder="investigación" class="field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1" for="bubbles-card-color">Color de las tarjetas</label>
      <input
        id="bubbles-card-color"
        v-model="element.cardColor"
        type="color"
        class="w-full h-10 border border-gray-300 rounded cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#005674]"
      >
    </div>
    <div
      v-for="(item, i) in element.items"
      :key="item.id || i"
      :data-editor-focus="bubbleAnchor(item, i)"
      class="border rounded p-2 space-y-2"
      :class="{ 'ring-2 ring-[#0B4F6C]': activeFocus === bubbleAnchor(item, i) }"
    >
      <input v-model="item.title" type="text" class="field-input" placeholder="Título">
      <input v-model="item.description" type="text" class="field-input" placeholder="Descripción">
      <button type="button" class="text-xs text-red-600" @click="element.items.splice(i, 1)">Quitar</button>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addItem">+ Agregar programa</button>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue'
import { generateId } from '../../../utils/pageElementFactory'
import { IDCBIS_THEME } from '../../../config/idcbisTheme'
import { scrollToEditorFocus, buildBubbleFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const activeFocus = computed(() => props.partFocus?.anchor || '')
const bubbleAnchor = (item, index) => buildBubbleFocusAnchor(item.id || `index-${index}`)

watch(() => props.partFocus?.anchor, (anchor) => {
  if (anchor) scrollToEditorFocus(anchor)
}, { immediate: true })

watch(() => props.element.cardColor, (value) => {
  if (!value) props.element.cardColor = IDCBIS_THEME.bubbleColor
}, { immediate: true })

const addItem = () => {
  if (!props.element.items) props.element.items = []
  props.element.items.push({
    id: generateId(),
    title: 'Nuevo programa',
    description: 'Descripción breve.',
  })
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
