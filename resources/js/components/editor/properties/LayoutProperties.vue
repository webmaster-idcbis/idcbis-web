<template>
  <div class="space-y-3">
    <div v-if="parentContainer" class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded p-2">
      Dentro de contenedor · dirección {{ parentContainer.flexDirection || 'column' }}
    </div>

    <div class="flex flex-wrap gap-1">
      <button
        v-for="preset in quickPresets"
        :key="preset.id"
        type="button"
        class="px-2 py-1 text-xs border border-gray-300 rounded hover:bg-gray-50"
        @click="applyPreset(preset.id)"
      >
        {{ preset.label }}
      </button>
    </div>

    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Ancho</label>
        <input v-model="element.width" type="text" placeholder="auto, 100%, 200px" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Alto</label>
        <input v-model="element.height" type="text" placeholder="auto, 80px" class="editor-field-input">
      </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Ancho máximo</label>
        <input v-model="element.maxWidth" type="text" placeholder="100%, 600px" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Display</label>
        <select v-model="element.display" class="editor-field-input">
          <option value="">Por defecto</option>
          <option value="block">Bloque</option>
          <option value="inline-block">Inline-block</option>
          <option value="inline-flex">Inline-flex</option>
          <option value="flex">Flex</option>
        </select>
      </div>
    </div>

    <label class="flex items-center gap-2 text-sm text-gray-700">
      <input v-model="element.alignCenter" type="checkbox" class="rounded">
      Centrar horizontalmente
    </label>

    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Padding</label>
        <input v-model="element.padding" type="text" placeholder="12px 24px" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Margin</label>
        <input v-model="element.margin" type="text" placeholder="0 auto" class="editor-field-input">
      </div>
    </div>

    <div v-if="parentContainer?.display === 'flex'">
      <p class="text-xs font-medium text-gray-700 mb-2">Dentro del contenedor (flex)</p>
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Flex (atajo)</label>
          <select v-model="element.flex" class="editor-field-input">
            <option value="">Automático</option>
            <option value="0 0 auto">Tamaño contenido</option>
            <option value="1 1 auto">Crecer</option>
            <option value="1 1 0">Igual ancho</option>
          </select>
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Alineación propia</label>
          <select v-model="element.alignSelf" class="editor-field-input">
            <option value="">Por defecto</option>
            <option value="auto">Auto</option>
            <option value="flex-start">Inicio</option>
            <option value="center">Centro</option>
            <option value="flex-end">Final</option>
            <option value="stretch">Estirar</option>
          </select>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-3 mt-2">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Orden</label>
          <input v-model.number="element.order" type="number" class="editor-field-input">
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Base flex</label>
          <input v-model="element.flexBasis" type="text" placeholder="auto, 50%" class="editor-field-input">
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  element: { type: Object, required: true },
  parentContainer: { type: Object, default: null },
})

const quickPresets = computed(() => {
  const base = [
    { id: 'auto', label: 'Ancho auto' },
    { id: 'full', label: 'Ancho 100%' },
    { id: 'center', label: 'Centrar' },
    { id: 'inline', label: 'En línea' },
  ]
  if (props.parentContainer?.flexDirection === 'row' || props.parentContainer?.flexDirection === 'row-reverse') {
    return [...base, { id: 'sideBySide', label: 'Lado a lado' }]
  }
  return base
})

const applyPreset = (id) => {
  const el = props.element
  switch (id) {
    case 'auto':
      el.width = 'auto'
      el.display = 'inline-block'
      el.alignCenter = false
      el.flex = '0 0 auto'
      break
    case 'full':
      el.width = '100%'
      el.display = 'block'
      el.alignCenter = false
      el.flex = '1 1 100%'
      break
    case 'center':
      el.alignCenter = true
      el.width = el.width || 'fit-content'
      el.display = 'block'
      if (props.parentContainer) el.alignSelf = 'center'
      break
    case 'inline':
      el.width = 'auto'
      el.display = 'inline-block'
      el.flex = '0 0 auto'
      break
    case 'sideBySide':
      el.width = 'auto'
      el.display = 'inline-block'
      el.flex = '0 0 auto'
      el.alignSelf = 'center'
      break
  }
}
</script>
