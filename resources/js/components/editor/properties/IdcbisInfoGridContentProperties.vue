<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Información práctica</h4>
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
      item-label="Dato"
      add-label="Agregar dato"
      @add="addItem"
      @remove="removeItem"
      @move="moveItem"
    >
      <template #default="{ item }">
        <select v-model="item.icon" class="editor-field-input">
          <option value="MapPin">Ubicación</option>
          <option value="Clock">Horario</option>
          <option value="Phone">Teléfono</option>
          <option value="Mail">Correo</option>
        </select>
        <input v-model="item.title" type="text" class="editor-field-input" placeholder="Título">
        <textarea v-model="item.text" rows="3" class="editor-field-input" placeholder="Detalle" />
        <input v-model="item.linkLabel" type="text" class="editor-field-input" placeholder="Texto del enlace">
        <input v-model="item.link" type="text" class="editor-field-input" placeholder="https://maps.google.com o tel:">
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
  props.element.items.push({
    id: generateId(),
    icon: 'MapPin',
    title: 'Nuevo dato',
    text: '',
    link: '',
    linkLabel: '',
  })
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
