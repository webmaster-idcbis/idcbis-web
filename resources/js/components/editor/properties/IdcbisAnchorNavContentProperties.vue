<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Navegación por anclas</h4>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Nombre accesible</label>
      <input v-model="element.label" type="text" class="field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Texto de volver arriba</label>
      <input v-model="element.backLabel" type="text" class="field-input">
    </div>
    <div
      v-for="(link, i) in element.links"
      :key="link.id || i"
      :data-editor-focus="linkAnchor(link, i)"
      class="border rounded p-3 space-y-2 bg-gray-50"
      :class="{ 'ring-2 ring-[#0B4F6C]': activeFocus === linkAnchor(link, i) }"
    >
      <div class="flex justify-between items-center">
        <span class="text-xs font-medium">Enlace {{ i + 1 }}</span>
        <button type="button" class="text-xs text-red-600" @click="removeLink(i)">Quitar</button>
      </div>
      <input v-model="link.label" type="text" placeholder="Etiqueta" class="field-input">
      <input v-model="link.url" type="text" placeholder="#seccion" class="field-input">
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded hover:bg-gray-50" @click="addLink">
      + Agregar enlace
    </button>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue'
import { generateId } from '../../../utils/pageElementFactory'
import { scrollToEditorFocus, buildAnchorNavFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const activeFocus = computed(() => props.partFocus?.anchor || '')
const linkAnchor = (link, index) => buildAnchorNavFocusAnchor(link.id || `index-${index}`)

watch(() => props.partFocus?.anchor, (anchor) => {
  if (anchor) scrollToEditorFocus(anchor)
}, { immediate: true })

const addLink = () => {
  if (!props.element.links) props.element.links = []
  props.element.links.push({
    id: generateId(),
    label: 'Sección',
    url: '#seccion',
  })
}

const removeLink = (index) => {
  props.element.links.splice(index, 1)
}
</script>

<style scoped>
.field-input { width: 100%; }
</style>
