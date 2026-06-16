<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Enlaces y recursos</h4>
    <input v-model="element.sectionTitle" class="field-input" placeholder="Recursos">
    <input v-model="element.sectionHighlight" class="field-input" placeholder="y enlaces">
    <input v-model="element.sectionSubtitle" class="field-input" placeholder="Subtítulo">
    <div v-for="(link, i) in element.links" :key="link.id || i" class="border rounded p-2 space-y-2">
      <input v-model="link.icon" class="field-input" placeholder="Emoji">
      <input v-model="link.label" class="field-input" placeholder="Título">
      <input v-model="link.url" class="field-input" placeholder="URL">
      <input v-model="link.description" class="field-input" placeholder="Descripción">
      <button type="button" class="text-xs text-red-600" @click="element.links.splice(i, 1)">Quitar</button>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addLink">+ Enlace</button>
  </div>
</template>

<script setup>
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const addLink = () => {
  if (!props.element.links) props.element.links = []
  props.element.links.push({ id: generateId(), icon: '🔗', label: '', url: '', description: '' })
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
