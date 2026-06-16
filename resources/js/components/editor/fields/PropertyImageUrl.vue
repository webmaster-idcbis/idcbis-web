<template>
  <div class="space-y-2">
    <PropertyField
      :label="label"
      :model-value="modelValue"
      :placeholder="placeholder"
      :hint="hint"
      @update:model-value="$emit('update:modelValue', $event)"
    />
    <div v-if="modelValue" class="rounded border overflow-hidden max-h-32 bg-gray-50">
      <img :src="modelValue" :alt="alt" class="w-full h-full object-cover" @error="imageError = true">
      <p v-if="imageError" class="text-xs text-amber-600 p-2">No se pudo cargar la imagen. Verifica la URL.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import PropertyField from './PropertyField.vue'

const props = defineProps({
  label: { type: String, default: 'URL de imagen' },
  modelValue: { type: String, default: '' },
  placeholder: { type: String, default: '/img/ejemplo.jpg' },
  hint: { type: String, default: 'Pega la ruta o URL completa de la imagen.' },
  alt: { type: String, default: 'Vista previa' },
})

defineEmits(['update:modelValue'])

const imageError = ref(false)
watch(() => props.modelValue, () => { imageError.value = false })
</script>
