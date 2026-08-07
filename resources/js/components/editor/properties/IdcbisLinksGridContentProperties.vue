<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Enlaces y recursos</h4>
    <input v-model="element.sectionTitle" class="field-input" placeholder="Recursos">
    <input v-model="element.sectionHighlight" class="field-input" placeholder="y enlaces">
    <input v-model="element.sectionSubtitle" class="field-input" placeholder="Subtítulo">

    <div class="grid grid-cols-2 gap-2">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Color del texto</label>
        <input :value="element.color || '#ffffff'" type="color" class="w-full h-9 border rounded cursor-pointer" @input="element.color = $event.target.value">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Color del resaltado</label>
        <input :value="element.highlightColor || '#C4A140'" type="color" class="w-full h-9 border rounded cursor-pointer" @input="element.highlightColor = $event.target.value">
      </div>
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Fondo de las tarjetas</label>
      <input v-model="element.cardBackground" class="field-input" placeholder="rgba(255,255,255,0.1) o #ffffff">
    </div>
    <div class="grid grid-cols-2 gap-2">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Texto de tarjetas</label>
        <input v-model="element.cardTextColor" class="field-input" placeholder="#ffffff">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Título de tarjetas</label>
        <input v-model="element.cardTitleColor" class="field-input" placeholder="#0b4f6c">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Borde de tarjetas</label>
        <input v-model="element.cardBorder" class="field-input" placeholder="1px solid #e5e7eb">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Sombra de tarjetas</label>
        <input v-model="element.cardBoxShadow" class="field-input" placeholder="0 8px 30px rgba(11,79,108,0.08)">
      </div>
    </div>
    <p class="text-xs text-gray-500 italic">
      El fondo de la sección (color, gradiente o imagen), bordes y sombras se editan en «Estilo visual».
    </p>
    <div v-for="(link, i) in element.links" :key="link.id || i" class="border rounded p-2 space-y-2">
      <input v-model="link.icon" class="field-input" placeholder="Emoji o ruta SVG">
      <input v-model="link.label" class="field-input" placeholder="Título">
      <input v-model="link.url" class="field-input" placeholder="URL">
      <input v-model="link.description" class="field-input" placeholder="Descripción">
      <button type="button" class="text-xs text-red-600" @click="element.links.splice(i, 1)">Quitar</button>
    </div>
    <button type="button" class="w-full py-2 text-sm border border-dashed rounded" @click="addLink">+ Enlace</button>
  </div>
</template>

<script setup>
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const addLink = () => {
  if (!props.element.links) props.element.links = []
  props.element.links.push({ id: generateId(), icon: '🔗', label: '', url: '', description: '' })
}
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
