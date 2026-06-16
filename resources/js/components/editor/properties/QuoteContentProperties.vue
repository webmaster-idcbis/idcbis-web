<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Cita</h4>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Texto de la cita</label>
      <textarea v-model="element.content" rows="3" class="field-input"></textarea>
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Autor (opcional)</label>
      <input v-model="element.author" type="text" placeholder="Nombre" class="field-input">
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
