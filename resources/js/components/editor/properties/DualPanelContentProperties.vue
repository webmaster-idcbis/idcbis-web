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
      :items="element.panels || []"
      item-label="Panel"
      add-label="Agregar panel"
      @add="addPanel"
      @remove="removePanel"
      @move="movePanel"
    >
      <template #default="{ item }">
        <input v-model="item.title" type="text" placeholder="Título del panel" class="editor-field-input">
        <input v-model="item.icon" type="text" placeholder="Icono" class="editor-field-input">
        <select v-model="item.listStyle" class="editor-field-input">
          <option value="check">Lista con check</option>
          <option value="bullet">Lista con viñetas</option>
        </select>
        <textarea
          :value="(item.items || []).join('\n')"
          rows="3"
          placeholder="Un ítem por línea"
          class="editor-field-input"
          @input="item.items = $event.target.value.split('\n').map((l) => l.trim()).filter(Boolean)"
        />
      </template>
    </PropertyRepeater>
  </div>
</template>

<script setup>
import PropertyRepeater from '../fields/PropertyRepeater.vue'
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const addPanel = () => {
  if (!props.element.panels) props.element.panels = []
  props.element.panels.push({
    id: generateId(),
    title: 'Nuevo panel',
    icon: '•',
    listStyle: 'bullet',
    items: ['Primer ítem'],
  })
}

const removePanel = (index) => props.element.panels.splice(index, 1)

const movePanel = (index, direction) => {
  const list = props.element.panels
  const newIndex = index + direction
  if (newIndex < 0 || newIndex >= list.length) return
  const [item] = list.splice(index, 1)
  list.splice(newIndex, 0, item)
}
</script>
