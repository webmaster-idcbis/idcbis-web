<template>
  <div class="grid grid-cols-2 gap-3">
    <PropertyField
      v-if="showColor"
      label="Color"
      type="color"
      :model-value="element.color"
      @update:model-value="element.color = $event"
    />
    <PropertyField
      v-if="showSize"
      label="Tamaño"
      :model-value="element.fontSize"
      placeholder="16px"
      hint="Ej: 16px, 1.2rem"
      @update:model-value="element.fontSize = $event"
    />
    <PropertyField
      v-if="showWeight"
      label="Peso"
      type="select"
      :model-value="element.fontWeight || '400'"
      :options="weightOptions"
      @update:model-value="element.fontWeight = $event"
    />
    <PropertyField
      v-if="showAlign"
      label="Alineación"
      type="select"
      :model-value="element.textAlign || 'left'"
      :options="alignOptions"
      @update:model-value="element.textAlign = $event"
    />
  </div>
</template>

<script setup>
import PropertyField from './PropertyField.vue'

defineProps({
  element: { type: Object, required: true },
  showColor: { type: Boolean, default: true },
  showSize: { type: Boolean, default: true },
  showWeight: { type: Boolean, default: true },
  showAlign: { type: Boolean, default: true },
})

const weightOptions = [
  { value: '400', label: 'Normal' },
  { value: '500', label: 'Medio' },
  { value: '600', label: 'Seminegrita' },
  { value: '700', label: 'Negrita' },
]

const alignOptions = [
  { value: 'left', label: 'Izquierda' },
  { value: 'center', label: 'Centro' },
  { value: 'right', label: 'Derecha' },
  { value: 'justify', label: 'Justificado' },
]
</script>
