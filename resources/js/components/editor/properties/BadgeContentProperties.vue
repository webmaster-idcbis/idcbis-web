<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Texto</label>
      <input v-model="element.content" type="text" class="editor-field-input">
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Color texto</label>
        <input v-model="element.color" type="color" class="w-full h-9 border border-gray-300 rounded cursor-pointer">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Fondo</label>
        <input v-model="element.backgroundColor" type="color" class="w-full h-9 border border-gray-300 rounded cursor-pointer">
      </div>
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Tamaño</label>
        <input v-model="element.fontSize" type="text" placeholder="12px" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Bordes redondeados</label>
        <input v-model="element.borderRadius" type="text" placeholder="12px" class="editor-field-input">
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>
