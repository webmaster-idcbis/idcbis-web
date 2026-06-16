<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Sobre nosotros</h4>
    <input v-model="element.title" type="text" class="field-input" placeholder="Somos IDCBIS">
    <input v-model="element.leaderName" type="text" class="field-input" placeholder="Nombre del líder (opcional)">
    <textarea v-model="element.leaderContact" rows="2" class="field-input" placeholder="Correo y teléfono"></textarea>
    <textarea v-model="element.content" rows="6" class="field-input"></textarea>
    <input v-model="element.image" type="text" class="field-input" placeholder="URL imagen">
    <input v-model="element.imageAlt" type="text" class="field-input" placeholder="Texto alternativo">
  </div>
</template>

<script setup>
defineProps({ element: { type: Object, required: true } })
</script>

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
