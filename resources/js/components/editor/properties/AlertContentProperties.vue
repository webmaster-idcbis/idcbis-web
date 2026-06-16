<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Alerta</h4>
    <input v-model="element.title" type="text" class="field-input" placeholder="Título (opcional, ej. pregunta FAQ)">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Mensaje</label>
      <textarea v-model="element.content" rows="3" class="field-input"></textarea>
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Tipo</label>
      <select v-model="element.variant" class="field-input">
        <option value="info">Info</option>
        <option value="success">Éxito</option>
        <option value="warning">Advertencia</option>
        <option value="danger">Error</option>
      </select>
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
