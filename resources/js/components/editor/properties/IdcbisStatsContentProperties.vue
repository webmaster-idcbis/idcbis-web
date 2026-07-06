<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Cifras IDCBIS</h4>
    <p class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2">
      Haz clic en una cifra del lienzo para editarla aquí.
    </p>
    <div data-editor-focus="stats:settings">
      <label class="block text-xs text-gray-600 mb-1">Color de fondo</label>
      <input v-model="element.backgroundColor" type="color" class="w-full h-10 border rounded">
    </div>
    <div
      v-for="(item, i) in element.items"
      :key="item.id || i"
      :data-editor-focus="statAnchor(item, i)"
      class="grid grid-cols-2 gap-2 border rounded p-2"
      :class="{ 'ring-2 ring-[#0B4F6C]': activeFocus === statAnchor(item, i) }"
    >
      <input v-model="item.value" type="text" placeholder="+3.000" class="field-input">
      <input v-model="item.label" type="text" placeholder="donaciones/año" class="field-input">
      <button type="button" class="col-span-2 text-xs text-red-600" @click="element.items.splice(i, 1)">Quitar</button>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addItem">+ Agregar cifra</button>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue'
import { generateId } from '../../../utils/pageElementFactory'
import { scrollToEditorFocus, buildStatFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const activeFocus = computed(() => props.partFocus?.anchor || '')
const statAnchor = (item, index) => buildStatFocusAnchor(item.id || `index-${index}`)

watch(() => props.partFocus?.anchor, (anchor) => {
  if (anchor) scrollToEditorFocus(anchor)
}, { immediate: true })

const addItem = () => {
  if (!props.element.items) props.element.items = []
  props.element.items.push({ id: generateId(), value: '0', label: 'nueva métrica' })
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
