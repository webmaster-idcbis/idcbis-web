<template>
  <div class="space-y-4">
    <p class="text-xs text-gray-500 bg-blue-50 border border-blue-100 rounded p-2">
      Arrastra elementos al contenedor o haz clic en un hijo del canvas para editarlo.
    </p>

    <div class="flex flex-wrap gap-1">
      <button type="button" class="editor-preset-btn" @click="applyPreset('row-center')">↔ Fila centrada</button>
      <button type="button" class="editor-preset-btn" @click="applyPreset('column-center')">↕ Columna</button>
      <button type="button" class="editor-preset-btn" @click="applyPreset('row-between')">⇔ Espaciado</button>
      <button type="button" class="editor-preset-btn" @click="applyPreset('grid-2')">▦ 2 cols</button>
      <button type="button" class="editor-preset-btn" @click="applyPreset('grid-3')">▦ 3 cols</button>
      <button type="button" class="editor-preset-btn" @click="applyPreset('section-full')">▬ Ancho completo</button>
      <button type="button" class="editor-preset-btn" @click="applyPreset('section-boxed')">▣ Centrada</button>
    </div>

    <label class="flex items-center gap-2 text-sm text-gray-700">
      <input v-model="element.fullBleed" type="checkbox" class="rounded">
      Ancho completo (sin bordes)
    </label>

    <div>
      <label class="block text-xs text-gray-600 mb-1">Disposición</label>
      <select
        v-model="element.display"
        class="editor-field-input"
      >
        <option value="flex">Flexbox</option>
        <option value="grid">Grid</option>
        <option value="block">Bloque</option>
      </select>
    </div>

    <template v-if="element.display === 'flex'">
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Dirección</label>
          <select v-model="element.flexDirection" class="editor-field-input">
            <option value="row">Fila (horizontal)</option>
            <option value="column">Columna (vertical)</option>
            <option value="row-reverse">Fila invertida</option>
            <option value="column-reverse">Columna invertida</option>
          </select>
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Ajuste (wrap)</label>
          <select v-model="element.flexWrap" class="editor-field-input">
            <option value="nowrap">Sin salto</option>
            <option value="wrap">Con salto</option>
            <option value="wrap-reverse">Salto invertido</option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Alinear horizontal</label>
          <select v-model="element.justifyContent" class="editor-field-input">
            <option value="flex-start">Inicio</option>
            <option value="center">Centro</option>
            <option value="flex-end">Final</option>
            <option value="space-between">Espaciado</option>
            <option value="space-around">Alrededor</option>
            <option value="space-evenly">Uniforme</option>
          </select>
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Alinear vertical</label>
          <select v-model="element.alignItems" class="editor-field-input">
            <option value="stretch">Estirar</option>
            <option value="flex-start">Inicio</option>
            <option value="center">Centro</option>
            <option value="flex-end">Final</option>
            <option value="baseline">Línea base</option>
          </select>
        </div>
      </div>
    </template>

    <template v-if="element.display === 'grid'">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Columnas (ej: repeat(3, 1fr))</label>
        <input
          v-model="element.gridTemplateColumns"
          type="text"
          placeholder="repeat(3, 1fr)"
          class="editor-field-input"
        >
      </div>
    </template>

    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Espacio (gap)</label>
        <input v-model="element.gap" type="text" placeholder="16px" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Alto mínimo</label>
        <input v-model="element.minHeight" type="text" placeholder="120px" class="editor-field-input">
      </div>
    </div>

    <div>
      <label class="block text-xs text-gray-600 mb-1">Padding interno</label>
      <input v-model="element.padding" type="text" placeholder="20px" class="editor-field-input">
    </div>

    <div class="pt-2 border-t border-gray-200">
      <div class="flex items-center justify-between mb-2">
        <span class="text-xs font-medium text-gray-700">
          Elementos hijos ({{ children.length }})
        </span>
      </div>

      <p v-if="children.length === 0" class="text-xs text-gray-400 italic py-2">
        Sin elementos. Arrastra componentes al contenedor.
      </p>

      <div v-for="(child, index) in children" :key="child.id" class="flex items-center gap-2 mb-2 p-2 bg-gray-50 rounded border border-gray-200">
        <span class="flex-1 text-xs text-gray-700">{{ childLabel(child) }}</span>
        <button
          type="button"
          class="px-2 py-0.5 text-xs bg-blue-50 text-blue-700 border border-blue-200 rounded hover:bg-blue-100"
          @click="$emit('select-child', child)"
        >
          Editar
        </button>
        <button
          type="button"
          :disabled="index === 0"
          @click="$emit('move-child', { index, direction: -1 })"
          class="px-2 py-0.5 text-xs border rounded disabled:opacity-40"
        >↑</button>
        <button
          type="button"
          :disabled="index === children.length - 1"
          @click="$emit('move-child', { index, direction: 1 })"
          class="px-2 py-0.5 text-xs border rounded disabled:opacity-40"
        >↓</button>
        <button
          type="button"
          @click="$emit('remove-child', index)"
          class="px-2 py-0.5 text-xs text-red-600 border border-red-200 rounded"
        >✕</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { paletteTypeLabels } from '../../../config/pageElementPalette'

const props = defineProps({
  element: { type: Object, required: true },
})

defineEmits(['select-child', 'move-child', 'remove-child'])

const children = computed(() => props.element.children || [])
const childLabel = (child) => paletteTypeLabels[child.type] || child.type

const applyPreset = (preset) => {
  const el = props.element
  switch (preset) {
    case 'row-center':
      el.display = 'flex'
      el.flexDirection = 'row'
      el.flexWrap = 'wrap'
      el.justifyContent = 'center'
      el.alignItems = 'center'
      el.gap = '12px'
      break
    case 'column-center':
      el.display = 'flex'
      el.flexDirection = 'column'
      el.justifyContent = 'center'
      el.alignItems = 'center'
      el.gap = '16px'
      break
    case 'row-between':
      el.display = 'flex'
      el.flexDirection = 'row'
      el.flexWrap = 'wrap'
      el.justifyContent = 'space-between'
      el.alignItems = 'center'
      el.gap = '12px'
      break
    case 'grid-2':
      el.display = 'grid'
      el.gridTemplateColumns = 'repeat(2, 1fr)'
      el.gap = '16px'
      break
    case 'grid-3':
      el.display = 'grid'
      el.gridTemplateColumns = 'repeat(3, 1fr)'
      el.gap = '16px'
      break
    case 'section-full':
      el.fullBleed = true
      el.sectionBoxed = false
      el.display = 'flex'
      el.flexDirection = 'column'
      el.gap = '24px'
      el.padding = '4rem 2rem'
      el.border = 'none'
      el.borderRadius = '0'
      el.width = '100%'
      break
    case 'section-boxed':
      el.fullBleed = false
      el.sectionBoxed = true
      el.maxWidth = '1400px'
      el.display = 'flex'
      el.flexDirection = 'column'
      el.gap = '24px'
      el.padding = '3rem 2rem'
      el.border = 'none'
      break
  }
}
</script>

