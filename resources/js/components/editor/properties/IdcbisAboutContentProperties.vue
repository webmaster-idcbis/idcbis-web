<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Sobre nosotros</h4>
    <p class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2">
      Haz clic en el texto o en la imagen del bloque «Somos IDCBIS» en el lienzo.
    </p>
    <div data-editor-focus="about:text" :class="{ 'ring-2 ring-[#0B4F6C] rounded-lg p-2': activeFocus === 'about:text' }" class="space-y-3">
      <input v-model="element.title" type="text" class="field-input" placeholder="Somos IDCBIS">
      <input v-model="element.leaderName" type="text" class="field-input" placeholder="Nombre del líder (opcional)">
      <textarea v-model="element.leaderContact" rows="2" class="field-input" placeholder="Correo y teléfono"></textarea>
      <textarea v-model="element.content" rows="6" class="field-input"></textarea>
    </div>
    <div data-editor-focus="about:image" :class="{ 'ring-2 ring-[#0B4F6C] rounded-lg p-2': activeFocus === 'about:image' }" class="space-y-2">
      <input v-model="element.image" type="text" class="field-input" placeholder="URL imagen">
      <input v-model="element.imageAlt" type="text" class="field-input" placeholder="Texto alternativo">
    </div>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue'
import { scrollToEditorFocus } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const activeFocus = computed(() => props.partFocus?.anchor || '')

watch(() => props.partFocus?.anchor, (anchor) => {
  if (anchor) scrollToEditorFocus(anchor)
}, { immediate: true })
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
