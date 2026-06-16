<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Diferenciales</h4>
    <input v-model="element.sectionTitle" class="field-input" placeholder="Lo que nos">
    <input v-model="element.sectionHighlight" class="field-input" placeholder="diferencia">
    <div v-for="(item, i) in element.items" :key="item.id || i" class="flex gap-2">
      <textarea v-model="item.text" rows="2" class="field-input flex-1" placeholder="Texto del diferencial"></textarea>
      <button type="button" class="text-xs text-red-600 shrink-0" @click="element.items.splice(i, 1)">✕</button>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addItem">+ Diferencial</button>
  </div>
</template>

<script setup>
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const addItem = () => {
  if (!props.element.items) props.element.items = []
  props.element.items.push({ id: generateId(), text: '' })
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
