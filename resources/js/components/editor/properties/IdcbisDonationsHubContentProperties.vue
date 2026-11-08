<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Portal de donaciones</h4>
    <p class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2">
      Cada camino abre la página del servicio correspondiente.
    </p>

    <div data-editor-focus="hub:hero" class="space-y-2" :class="focusClass('hub:hero')">
      <label class="block text-xs text-gray-600">Rótulo</label>
      <input v-model="element.eyebrow" type="text" class="field-input">
      <label class="block text-xs text-gray-600">Título</label>
      <input v-model="element.title" type="text" class="field-input">
      <label class="block text-xs text-gray-600">Texto de apoyo</label>
      <textarea v-model="element.subtitle" rows="3" class="field-input"></textarea>
    </div>

    <div
      v-for="(path, i) in element.paths"
      :key="path.id || i"
      :data-editor-focus="pathAnchor(i)"
      class="border rounded p-3 space-y-2 bg-gray-50"
      :class="{ 'ring-2 ring-[#0B4F6C]': activeFocus === pathAnchor(i) }"
    >
      <div class="flex justify-between items-center">
        <span class="text-xs font-medium">Camino {{ i + 1 }}</span>
        <button type="button" class="text-xs text-red-600" @click="element.paths.splice(i, 1)">Quitar</button>
      </div>
      <input v-model="path.kicker" type="text" placeholder="Rótulo" class="field-input">
      <input v-model="path.title" type="text" placeholder="Título" class="field-input">
      <textarea v-model="path.description" rows="3" placeholder="Descripción" class="field-input"></textarea>
      <input v-model="path.cta" type="text" placeholder="Texto del enlace" class="field-input">
      <input v-model="path.url" type="text" placeholder="/banco-de-sangre" class="field-input">
      <input v-model="path.image" type="text" placeholder="Imagen" class="field-input">
      <label class="block text-xs text-gray-600">Datos cortos, separados por |</label>
      <input :value="factsText(path)" type="text" class="field-input" @input="setFacts(path, $event.target.value)">
      <label class="block text-xs text-gray-600">Tono</label>
      <select v-model="path.tone" class="field-input">
        <option value="sangre">Sangre</option>
        <option value="tejidos">Tejidos</option>
      </select>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addPath">+ Camino</button>

    <div data-editor-focus="hub:values" class="space-y-2" :class="focusClass('hub:values')">
      <label class="block text-xs text-gray-600">Título de principios</label>
      <input v-model="element.valuesTitle" type="text" class="field-input">
      <div v-for="(value, i) in element.values" :key="value.id || i" class="space-y-2 border rounded p-2">
        <div class="flex justify-between">
          <span class="text-xs font-medium">Principio {{ i + 1 }}</span>
          <button type="button" class="text-xs text-red-600" @click="element.values.splice(i, 1)">Quitar</button>
        </div>
        <input v-model="value.title" type="text" placeholder="Título" class="field-input">
        <textarea v-model="value.text" rows="2" placeholder="Texto" class="field-input"></textarea>
      </div>
      <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addValue">+ Principio</button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const activeFocus = computed(() => props.partFocus?.anchor || null)
const pathAnchor = (index) => `hub:path:${index}`
const focusClass = (anchor) => ({
  'ring-2 ring-[#0B4F6C] rounded-lg p-2': activeFocus.value === anchor,
})

const factsText = (path) => (Array.isArray(path.facts) ? path.facts.join(' | ') : '')

const setFacts = (path, value) => {
  path.facts = String(value)
    .split('|')
    .map((item) => item.trim())
    .filter(Boolean)
}

const addPath = () => {
  if (!props.element.paths) props.element.paths = []
  props.element.paths.push({
    id: generateId(),
    tone: 'sangre',
    kicker: 'Nuevo camino',
    title: 'Donar',
    description: '',
    facts: [],
    cta: 'Conocer este camino',
    url: '/',
    image: '',
  })
}

const addValue = () => {
  if (!props.element.values) props.element.values = []
  props.element.values.push({ id: generateId(), title: 'Principio', text: '' })
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
