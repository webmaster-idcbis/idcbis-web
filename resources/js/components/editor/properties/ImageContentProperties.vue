<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">URL de la imagen</label>
      <input v-model="element.src" type="text" placeholder="/img/ejemplo.jpg" class="editor-field-input">
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Texto alternativo</label>
      <input v-model="element.alt" type="text" class="editor-field-input">
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Ancho</label>
        <input v-model="element.width" type="text" placeholder="100%, 300px" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Ajuste</label>
        <select v-model="element.objectFit" class="editor-field-input">
          <option value="cover">Cubrir</option>
          <option value="contain">Contener</option>
          <option value="fill">Llenar</option>
          <option value="none">Original</option>
        </select>
      </div>
    </div>
    <div v-if="element.src" class="rounded border overflow-hidden max-h-28 bg-gray-50">
      <img :src="element.src" :alt="element.alt" class="w-full h-full object-cover">
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>
