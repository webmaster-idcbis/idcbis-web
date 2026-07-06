<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Contenido</label>
      <textarea v-model="element.content" rows="4" class="editor-field-input" />
    </div>
    <TypographyFields :element="element" />
  </div>
</template>

<script setup>
import TypographyFields from '../fields/TypographyFields.vue'

defineProps({ element: { type: Object, required: true } })
</script>
