<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Código HTML</h4>
    <p class="text-xs text-amber-700 bg-amber-50 border border-amber-100 rounded p-2">
      Pega HTML válido (etiquetas, estilos inline, iframes). Solo para contenido de confianza.
    </p>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Código HTML</label>
      <textarea
        v-model="element.htmlCode"
        rows="10"
        class="field-input font-mono text-xs"
        placeholder="<div class='mi-bloque'>...</div>"
      ></textarea>
    </div>
    <div v-if="element.htmlCode" class="border border-gray-200 rounded p-3 bg-white max-h-40 overflow-auto">
      <p class="text-xs text-gray-500 mb-2">Vista previa:</p>
      <div class="prose prose-sm max-w-none" v-html="element.htmlCode"></div>
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
