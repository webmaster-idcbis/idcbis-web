<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Título</label>
      <input v-model="element.title" type="text" class="editor-field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Subtítulo</label>
      <textarea v-model="element.subtitle" rows="2" class="editor-field-input" />
    </div>
    <PropertyRepeater
      :items="element.items || []"
      item-label="Pregunta"
      add-label="Agregar pregunta"
      @add="addItem"
      @remove="removeItem"
      @move="moveItem"
    >
      <template #default="{ item }">
        <input v-model="item.question" type="text" placeholder="Pregunta" class="editor-field-input">
        <textarea v-model="item.answer" rows="2" placeholder="Respuesta" class="editor-field-input" />
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
  props.element.items.push({ id: generateId(), question: '¿Pregunta?', answer: 'Respuesta.' })
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
