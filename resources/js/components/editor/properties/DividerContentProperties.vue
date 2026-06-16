<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Línea divisoria</h4>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Estilo de línea</label>
      <select v-model="element.borderStyle" class="field-input">
        <option value="1px solid #e5e7eb">Fina gris</option>
        <option value="2px solid #e5e7eb">Gruesa gris</option>
        <option value="2px solid #005674">Gruesa azul</option>
        <option value="1px dashed #cbd5e1">Punteada</option>
      </select>
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Margen vertical</label>
      <input v-model="element.margin" type="text" placeholder="24px 0" class="field-input">
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
