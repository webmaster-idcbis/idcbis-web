<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Espacio</h4>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Alto del espacio</label>
      <input v-model="element.height" type="text" placeholder="40px, 80px" class="field-input">
    </div>
    <div class="flex flex-wrap gap-1">
      <button type="button" class="preset-btn" @click="element.height = '24px'">Pequeño</button>
      <button type="button" class="preset-btn" @click="element.height = '48px'">Mediano</button>
      <button type="button" class="preset-btn" @click="element.height = '96px'">Grande</button>
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
.preset-btn { padding: 0.25rem 0.5rem; font-size: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.25rem; }
</style>
