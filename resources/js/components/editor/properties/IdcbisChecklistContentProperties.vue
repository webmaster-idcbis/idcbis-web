<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Lista de requisitos</h4>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Título</label>
      <input v-model="element.title" type="text" class="editor-field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Subtítulo</label>
      <textarea v-model="element.subtitle" rows="2" class="editor-field-input" />
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Texto del botón</label>
      <input v-model="element.ctaText" type="text" class="editor-field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Enlace del botón</label>
      <input v-model="element.ctaUrl" type="text" class="editor-field-input" placeholder="tel:+5713649620">
    </div>
    <PropertyRepeater
      :items="element.items || []"
      item-label="Requisito"
      add-label="Agregar requisito"
      @add="addItem"
      @remove="removeItem"
      @move="moveItem"
    >
      <template #default="{ item }">
        <textarea v-model="item.text" rows="2" class="editor-field-input" placeholder="Texto del requisito" />
      </template>
    </PropertyRepeater>
  </div>
</template>

<script setup>
import PropertyRepeater from '../fields/PropertyRepeater.vue'
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const addItem = () => {
  if (!props.element.items) props.element.items = []
  props.element.items.push({ id: generateId(), text: 'Nuevo requisito' })
}

const removeItem = (index) => props.element.items.splice(index, 1)

const moveItem = (index, direction) => {
  const list = props.element.items
  const newIndex = index + direction
  if (newIndex < 0 || newIndex >= list.length) return
  const [item] = list.splice(index, 1)
  list.splice(newIndex, 0, item)
}
</script>
