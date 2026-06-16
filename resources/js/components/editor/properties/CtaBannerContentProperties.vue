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
    <div>
      <label class="block text-xs text-gray-600 mb-1">Fondo (CSS)</label>
      <input v-model="element.background" type="text" placeholder="linear-gradient(...)" class="editor-field-input">
    </div>
    <PropertyRepeater
      :items="element.buttons || []"
      item-label="Botón"
      add-label="Agregar botón"
      @add="addButton"
      @remove="removeButton"
      @move="moveButton"
    >
      <template #default="{ item }">
        <input v-model="item.label" type="text" placeholder="Texto" class="editor-field-input">
        <input v-model="item.url" type="text" placeholder="Enlace" class="editor-field-input">
        <input v-model="item.icon" type="text" placeholder="Icono" class="editor-field-input">
        <select v-model="item.variant" class="editor-field-input">
          <option value="primary">Principal</option>
          <option value="outline">Contorno</option>
        </select>
      </template>
    </PropertyRepeater>
  </div>
</template>

<script setup>
import PropertyRepeater from '../fields/PropertyRepeater.vue'
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const addButton = () => {
  if (!props.element.buttons) props.element.buttons = []
  props.element.buttons.push({ id: generateId(), label: 'Botón', url: '#', variant: 'primary', icon: '' })
}

const removeButton = (index) => props.element.buttons.splice(index, 1)

const moveButton = (index, direction) => {
  const list = props.element.buttons
  const newIndex = index + direction
  if (newIndex < 0 || newIndex >= list.length) return
  const [item] = list.splice(index, 1)
  list.splice(newIndex, 0, item)
}
</script>
