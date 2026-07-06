<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Investigación (burbujas)</h4>
    <p class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2">
      Haz clic en el encabezado o en una burbuja del lienzo para editarla aquí.
    </p>
    <div data-editor-focus="bubbles:header" class="grid grid-cols-2 gap-2" :class="{ 'ring-2 ring-[#0B4F6C] rounded-lg p-2': activeFocus === 'bubbles:header' }">
      <input v-model="element.sectionTitle" type="text" placeholder="Programas de" class="field-input">
      <input v-model="element.sectionHighlight" type="text" placeholder="investigación" class="field-input">
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
      <input v-model="item.color" type="color" class="w-full h-8">
      <button type="button" class="text-xs text-red-600" @click="element.items.splice(i, 1)">Quitar</button>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addItem">+ Agregar burbuja</button>
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

const addItem = () => {
  if (!props.element.items) props.element.items = []
  const i = props.element.items.length
  props.element.items.push({
    id: generateId(),
    title: 'Nuevo programa',
    description: 'Descripción breve.',
    color: IDCBIS_THEME.bubbleColors[i % IDCBIS_THEME.bubbleColors.length],
  })
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
