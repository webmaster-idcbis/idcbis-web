<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Color de fondo</label>
      <label class="flex items-center gap-2 text-xs text-gray-700 mb-2">
        <input
          v-model="noBackground"
          type="checkbox"
          class="rounded"
        >
        Sin fondo (transparente)
      </label>
      <input
        v-if="!noBackground"
        v-model="element.backgroundColor"
        type="color"
        class="w-full h-9 border border-gray-300 rounded cursor-pointer"
      >
      <p v-else class="text-xs text-gray-500 italic">El elemento no tendrá color de fondo.</p>
    </div>

    <div>
      <label class="block text-xs text-gray-600 mb-1">Imagen de fondo (URL)</label>
      <input
        v-model="element.backgroundImage"
        type="text"
        placeholder="/img/fondo.jpg"
        class="editor-field-input"
      >
      <button
        v-if="element.backgroundImage"
        type="button"
        class="mt-1 text-xs text-gray-500 hover:text-gray-800 underline"
        @click="element.backgroundImage = ''"
      >
        Quitar imagen de fondo
      </button>
    </div>

    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Borde</label>
        <input v-model="element.border" type="text" placeholder="1px solid #ccc" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Radio del borde</label>
        <input v-model="element.borderRadius" type="text" placeholder="8px" class="editor-field-input">
      </div>
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Sombra</label>
      <input v-model="element.boxShadow" type="text" placeholder="0 2px 8px rgba(0,0,0,0.1)" class="editor-field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Clases CSS extra</label>
      <input v-model="element.className" type="text" placeholder="mi-clase" class="editor-field-input">
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { isTransparentBackground } from '../../../composables/useElementStyles'

const props = defineProps({ element: { type: Object, required: true } })

const noBackground = computed({
  get: () => isTransparentBackground(props.element.backgroundColor),
  set: (value) => {
    if (value) {
      props.element.backgroundColor = 'transparent'
    } else if (isTransparentBackground(props.element.backgroundColor)) {
      props.element.backgroundColor = ''
    }
  },
})
</script>
