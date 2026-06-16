<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Hero IDCBIS</h4>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Línea superior (ligera)</label>
      <input v-model="element.titleLight" type="text" class="field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Título principal</label>
      <input v-model="element.titleBold" type="text" class="field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Subtítulo</label>
      <textarea v-model="element.subtitle" rows="2" class="field-input"></textarea>
    </div>
    <div class="grid grid-cols-2 gap-2">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Botón 1 texto</label>
        <input v-model="element.button1Text" type="text" class="field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Botón 1 enlace</label>
        <input v-model="element.button1Url" type="text" class="field-input" placeholder="/servicios">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Botón 2 texto</label>
        <input v-model="element.button2Text" type="text" class="field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Botón 2 enlace</label>
        <input v-model="element.button2Url" type="text" class="field-input">
      </div>
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Imagen hero (URL)</label>
      <input v-model="element.heroImage" type="text" class="field-input" placeholder="https://...">
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
