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
    <label class="flex items-center gap-2 text-xs text-gray-700">
      <input v-model="element.showHero" type="checkbox" class="rounded">
      Mostrar cabecera
    </label>
    <label class="flex items-center gap-2 text-xs text-gray-700">
      <input v-model="element.showNote" type="checkbox" class="rounded">
      Mostrar nota al pie
    </label>
    <p class="text-xs text-gray-500 leading-relaxed">
      El mapa se organiza en tarjetas y grupos. Los enlaces se generan desde
      <code class="text-[11px]">siteSitemap.js</code>. Puedes personalizar título, subtítulo y visibilidad de la cabecera.
    </p>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>
