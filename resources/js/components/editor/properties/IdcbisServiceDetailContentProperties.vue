<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Servicios detallados</h4>
    <input v-model="element.sectionTitle" class="field-input" placeholder="Título sección">
    <input v-model="element.sectionHighlight" class="field-input" placeholder="Palabra destacada">
    <input v-model="element.sectionSubtitle" class="field-input" placeholder="Subtítulo">
    <div v-for="(item, i) in element.items" :key="item.id || i" class="border rounded p-3 space-y-2 bg-gray-50">
      <div class="flex justify-between">
        <span class="text-xs font-medium">Servicio {{ i + 1 }}</span>
        <button type="button" class="text-xs text-red-600" @click="element.items.splice(i, 1)">Quitar</button>
      </div>
      <input v-model="item.title" class="field-input" placeholder="Nombre del servicio">
      <textarea v-model="item.summary" rows="2" class="field-input" placeholder="Resumen"></textarea>
      <textarea v-model="item.audience" rows="3" class="field-input" placeholder="¿Para quién es?"></textarea>
      <textarea v-model="item.access" rows="4" class="field-input" placeholder="¿Cómo se accede?"></textarea>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addItem">+ Agregar servicio</button>
  </div>
</template>

<script setup>
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const addItem = () => {
  if (!props.element.items) props.element.items = []
  props.element.items.push({ id: generateId(), title: '', summary: '', audience: '', access: '' })
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
