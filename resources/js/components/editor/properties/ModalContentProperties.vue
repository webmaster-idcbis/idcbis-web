<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Título</label>
      <input v-model="element.title" type="text" class="editor-field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Contenido</label>
      <textarea v-model="element.content" rows="3" class="editor-field-input" />
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Tamaño</label>
      <select v-model="element.size" class="editor-field-input">
        <option value="small">Pequeño</option>
        <option value="medium">Mediano</option>
        <option value="large">Grande</option>
      </select>
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>
