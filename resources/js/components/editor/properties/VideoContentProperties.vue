<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Video</h4>
    <p class="text-xs text-gray-500">Pega un enlace de YouTube o Vimeo.</p>
    <div>
      <label class="block text-xs text-gray-600 mb-1">URL del video</label>
      <input
        v-model="element.videoUrl"
        type="text"
        placeholder="https://www.youtube.com/watch?v=..."
        class="field-input"
      >
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
