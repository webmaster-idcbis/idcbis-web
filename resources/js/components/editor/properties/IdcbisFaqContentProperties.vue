<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Preguntas frecuentes</h4>
    <input v-model="element.sectionTitle" class="field-input" placeholder="Preguntas">
    <input v-model="element.sectionHighlight" class="field-input" placeholder="frecuentes">
    <div v-for="(item, i) in element.items" :key="item.id || i" class="border rounded p-2 space-y-2">
      <input v-model="item.question" class="field-input" placeholder="Pregunta">
      <textarea v-model="item.answer" rows="3" class="field-input" placeholder="Respuesta"></textarea>
      <button type="button" class="text-xs text-red-600" @click="element.items.splice(i, 1)">Quitar</button>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addItem">+ Pregunta</button>
  </div>
</template>

<script setup>
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const addItem = () => {
  if (!props.element.items) props.element.items = []
  props.element.items.push({ id: generateId(), question: '', answer: '' })
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
