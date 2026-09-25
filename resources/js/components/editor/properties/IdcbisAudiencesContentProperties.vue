<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Perfiles de acceso</h4>
    <p class="text-xs text-slate-600 bg-slate-50 border border-slate-200 rounded p-2">
      Acceso complementario. No reemplaza el menú. Cada tarjeta lleva a una página existente.
    </p>
    <div data-editor-focus="audiences:header" class="space-y-2">
      <input v-model="element.sectionTitle" type="text" placeholder="Título" class="field-input">
      <textarea v-model="element.sectionSubtitle" rows="2" placeholder="Subtítulo" class="field-input"></textarea>
    </div>
    <div
      v-for="(card, index) in cards"
      :key="card.id || index"
      :data-editor-focus="cardAnchor(card, index)"
      class="border rounded-lg p-3 space-y-2 bg-gray-50"
      :class="{ 'ring-2 ring-[#0B4F6C]': activeFocus === cardAnchor(card, index) }"
    >
      <input v-model="card.title" type="text" placeholder="Soy Donante" class="field-input">
      <input v-model="card.description" type="text" placeholder="Descripción breve" class="field-input">
      <input v-model="card.url" type="text" placeholder="/banco-de-sangre" class="field-input">
      <input v-model="card.icon" type="text" placeholder="droplet" class="field-input">
      <input v-model="card.linkText" type="text" placeholder="Ir a mi sección" class="field-input">
    </div>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue'
import { scrollToEditorFocus, buildAudienceFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const cards = computed(() => props.element.cards || [])
const activeFocus = computed(() => props.partFocus?.anchor || '')
const cardAnchor = (card, index) => buildAudienceFocusAnchor(card.id || `index-${index}`)

watch(() => props.partFocus?.anchor, (anchor) => {
  if (anchor?.startsWith('audience:') || anchor === 'audiences:header') scrollToEditorFocus(anchor)
}, { immediate: true })
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
