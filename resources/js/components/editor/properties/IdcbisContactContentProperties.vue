<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Contacto IDCBIS</h4>
    <div v-for="(item, i) in element.items" :key="item.id || i" class="border rounded p-2 space-y-2">
      <input v-model="item.icon" type="text" class="field-input" placeholder="📍">
      <input v-model="item.title" type="text" class="field-input" placeholder="Sede">
      <input v-model="item.text" type="text" class="field-input" placeholder="Dirección o teléfono">
      <button type="button" class="text-xs text-red-600" @click="element.items.splice(i, 1)">Quitar</button>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addItem">+ Agregar bloque</button>
  </div>
</template>

<script setup>
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const addItem = () => {
  if (!props.element.items) props.element.items = []
  props.element.items.push({ id: generateId(), icon: '📍', title: 'Nuevo', text: '' })
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
