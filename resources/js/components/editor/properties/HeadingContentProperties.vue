<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Texto</label>
      <input v-model="element.content" type="text" class="editor-field-input">
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Nivel</label>
        <select v-model="element.level" class="editor-field-input">
          <option value="h1">H1 — Principal</option>
          <option value="h2">H2 — Sección</option>
          <option value="h3">H3 — Subsección</option>
          <option value="h4">H4</option>
        </select>
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Estilo visual</label>
        <select v-model="element.variant" class="editor-field-input">
          <option value="">Normal</option>
          <option value="section">Título de sección (decorado)</option>
        </select>
      </div>
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Color</label>
        <input v-model="element.color" type="color" class="w-full h-9 border border-gray-300 rounded cursor-pointer">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Tamaño</label>
        <input v-model="element.fontSize" type="text" placeholder="2rem" class="editor-field-input">
      </div>
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Peso</label>
        <select v-model="element.fontWeight" class="editor-field-input">
          <option value="400">Normal</option>
          <option value="600">Seminegrita</option>
          <option value="700">Negrita</option>
        </select>
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Alineación</label>
        <select v-model="element.textAlign" class="editor-field-input">
          <option value="left">Izquierda</option>
          <option value="center">Centro</option>
          <option value="right">Derecha</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>
