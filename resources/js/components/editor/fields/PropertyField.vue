<template>
  <div :class="fullWidth ? '' : ''">
    <label v-if="label" class="block text-xs text-gray-600 mb-1">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    <textarea
      v-if="type === 'textarea'"
      :value="modelValue"
      :rows="rows"
      :placeholder="placeholder"
      class="editor-field-input"
      @input="$emit('update:modelValue', $event.target.value)"
    />
    <select
      v-else-if="type === 'select'"
      :value="modelValue"
      class="editor-field-input"
      @change="$emit('update:modelValue', $event.target.value)"
    >
      <option v-for="opt in options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
    </select>
    <input
      v-else-if="type === 'color'"
      :value="modelValue || '#000000'"
      type="color"
      class="w-full h-10 border border-gray-300 rounded cursor-pointer"
      @input="$emit('update:modelValue', $event.target.value)"
    >
    <input
      v-else-if="type === 'number'"
      :value="modelValue"
      type="number"
      :min="min"
      :step="step"
      :placeholder="placeholder"
      class="editor-field-input"
      @input="$emit('update:modelValue', Number($event.target.value))"
    >
    <input
      v-else
      :value="modelValue"
      :type="type"
      :placeholder="placeholder"
      :maxlength="maxlength"
      class="editor-field-input"
      @input="$emit('update:modelValue', $event.target.value)"
    >
    <p v-if="hint" class="editor-field-hint">{{ hint }}</p>
  </div>
</template>

<script setup>
defineProps({
  label: { type: String, default: '' },
  modelValue: { type: [String, Number], default: '' },
  type: { type: String, default: 'text' },
  placeholder: { type: String, default: '' },
  hint: { type: String, default: '' },
  rows: { type: Number, default: 3 },
  required: { type: Boolean, default: false },
  fullWidth: { type: Boolean, default: true },
  maxlength: { type: Number, default: undefined },
  min: { type: Number, default: undefined },
  step: { type: Number, default: undefined },
  options: { type: Array, default: () => [] },
})

defineEmits(['update:modelValue'])
</script>
