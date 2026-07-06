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
          <option value="page">Título de página</option>
        </select>
      </div>
    </div>
    <TypographyFields :element="element" />
  </div>
</template>

<script setup>
import TypographyFields from '../fields/TypographyFields.vue'

defineProps({ element: { type: Object, required: true } })
</script>
