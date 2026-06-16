<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Cifras IDCBIS</h4>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Color de fondo</label>
      <input v-model="element.backgroundColor" type="color" class="w-full h-10 border rounded">
    </div>
    <div v-for="(item, i) in element.items" :key="item.id || i" class="grid grid-cols-2 gap-2 border rounded p-2">
      <input v-model="item.value" type="text" placeholder="+3.000" class="field-input">
      <input v-model="item.label" type="text" placeholder="donaciones/año" class="field-input">
      <button type="button" class="col-span-2 text-xs text-red-600" @click="element.items.splice(i, 1)">Quitar</button>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addItem">+ Agregar cifra</button>
  </div>
</template>

<script setup>
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const addItem = () => {
  if (!props.element.items) props.element.items = []
  props.element.items.push({ id: generateId(), value: '0', label: 'nueva métrica' })
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
