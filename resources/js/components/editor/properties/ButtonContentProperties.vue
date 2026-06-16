<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Texto</label>
      <input v-model="element.content" type="text" class="editor-field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Enlace (URL)</label>
      <input
        v-model="element.href"
        type="text"
        placeholder="/pagina, #seccion o https://..."
        class="editor-field-input"
      >
      <p v-if="element.href" class="text-xs text-gray-500 mt-1">
        En la página publicada abrirá: <span class="font-medium text-indigo-600">{{ element.href }}</span>
      </p>
    </div>
    <label class="flex items-center gap-2 text-xs text-gray-700">
      <input v-model="element.openInNewTab" type="checkbox" class="rounded">
      Abrir en nueva pestaña
    </label>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Color del texto</label>
        <input v-model="element.color" type="color" class="w-full h-9 border border-gray-300 rounded cursor-pointer">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Color de fondo</label>
        <label class="flex items-center gap-2 text-xs text-gray-700 mb-2">
          <input v-model="noBackground" type="checkbox" class="rounded">
          Sin fondo
        </label>
        <input
          v-if="!noBackground"
          v-model="element.backgroundColor"
          type="color"
          class="w-full h-9 border border-gray-300 rounded cursor-pointer"
        >
      </div>
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Tamaño de texto</label>
        <input v-model="element.fontSize" type="text" placeholder="16px" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Bordes redondeados</label>
        <input v-model="element.borderRadius" type="text" placeholder="6px" class="editor-field-input">
      </div>
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Relleno interno</label>
      <input v-model="element.padding" type="text" placeholder="10px 20px" class="editor-field-input">
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
