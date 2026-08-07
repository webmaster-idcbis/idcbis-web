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
        <input v-model="item.question" type="text" placeholder="Pregunta / título de sección" class="editor-field-input">
        <textarea v-model="item.answer" rows="3" placeholder="Respuesta / texto" class="editor-field-input" />
        <input v-model="item.image" type="text" placeholder="URL de imagen (opcional, ej. organigrama)" class="editor-field-input">
        <input v-model="item.imageAlt" type="text" placeholder="Texto alternativo de la imagen" class="editor-field-input">
        <div v-for="(link, li) in item.links || []" :key="link.id || li" class="border rounded p-2 space-y-1">
          <input v-model="link.label" type="text" placeholder="Título del enlace" class="editor-field-input">
          <input v-model="link.url" type="text" placeholder="URL" class="editor-field-input">
          <input v-model="link.description" type="text" placeholder="Descripción (opcional)" class="editor-field-input">
          <button type="button" class="text-xs text-red-600" @click="item.links.splice(li, 1)">Quitar enlace</button>
        </div>
        <button type="button" class="w-full py-1.5 text-xs border border-dashed rounded" @click="addLink(item)">+ Enlace</button>
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

const addLink = (item) => {
  if (!item.links) item.links = []
  item.links.push({ id: generateId(), label: '', url: '', description: '' })
}

const moveItem = (index, direction) => {
  const list = props.element.items
  const newIndex = index + direction
  if (newIndex < 0 || newIndex >= list.length) return
  const [item] = list.splice(index, 1)
  list.splice(newIndex, 0, item)
}
</script>
