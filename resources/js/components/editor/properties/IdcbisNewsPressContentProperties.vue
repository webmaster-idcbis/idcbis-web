<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Noticias y prensa</h4>
    <input v-model="element.sectionTitle" type="text" class="field-input" placeholder="Título">
    <textarea v-model="element.sectionSubtitle" rows="2" class="field-input" placeholder="Subtítulo"></textarea>
    <input v-model="element.podcastTitle" type="text" class="field-input" placeholder="Título del podcast">
    <textarea v-model="element.podcastDescription" rows="2" class="field-input" placeholder="Descripción del podcast"></textarea>
    <input v-model="element.podcastUrl" type="text" class="field-input" placeholder="URL de Spotify o YouTube">
    <input v-model="element.episodeTitle" type="text" class="field-input" placeholder="Último episodio">
    <input v-model="element.buttonText" type="text" class="field-input" placeholder="Ver todas las noticias">
    <input v-model="element.buttonUrl" type="text" class="field-input" placeholder="/noticias">
  </div>
</template>

<script setup>
defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
