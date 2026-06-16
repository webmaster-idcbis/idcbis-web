<template>
  <div class="space-y-3">
    <PropertyRepeater
      :items="element.items || []"
      item-label="Cifra"
      add-label="Agregar cifra"
      @add="addItem"
      @remove="removeItem"
      @move="moveItem"
    >
      <template #default="{ item }">
        <input v-model="item.icon" type="text" placeholder="Icono (emoji)" class="editor-field-input">
        <input v-model="item.value" type="text" placeholder="Valor" class="editor-field-input">
        <input v-model="item.label" type="text" placeholder="Etiqueta" class="editor-field-input">
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
  props.element.items.push({ id: generateId(), icon: '✓', value: '0', label: 'Nueva cifra' })
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
