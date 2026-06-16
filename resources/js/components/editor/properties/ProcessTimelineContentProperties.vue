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
      :items="element.steps || []"
      item-label="Paso"
      add-label="Agregar paso"
      @add="addStep"
      @remove="removeStep"
      @move="moveStep"
    >
      <template #default="{ item }">
        <input v-model="item.title" type="text" placeholder="Título del paso" class="editor-field-input">
        <textarea v-model="item.description" rows="2" placeholder="Descripción" class="editor-field-input" />
      </template>
    </PropertyRepeater>
  </div>
</template>

<script setup>
import PropertyRepeater from '../fields/PropertyRepeater.vue'
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const addStep = () => {
  if (!props.element.steps) props.element.steps = []
  props.element.steps.push({ id: generateId(), title: 'Nuevo paso', description: 'Descripción.' })
}

const removeStep = (index) => props.element.steps.splice(index, 1)

const moveStep = (index, direction) => {
  const list = props.element.steps
  const newIndex = index + direction
  if (newIndex < 0 || newIndex >= list.length) return
  const [item] = list.splice(index, 1)
  list.splice(newIndex, 0, item)
}
</script>
