<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Estilo de lista</label>
      <select v-model="element.listStyle" class="editor-field-input">
        <option value="bullet">Viñetas</option>
        <option value="number">Numerada</option>
      </select>
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Elementos (uno por línea)</label>
      <textarea
        :value="itemsText"
        rows="5"
        class="editor-field-input"
        @input="updateItems"
      />
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Color</label>
        <input v-model="element.color" type="color" class="w-full h-9 border border-gray-300 rounded cursor-pointer">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Tamaño</label>
        <input v-model="element.fontSize" type="text" placeholder="16px" class="editor-field-input">
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({ element: { type: Object, required: true } })

const itemsText = computed(() => (props.element.items || []).join('\n'))

const updateItems = (e) => {
  props.element.items = e.target.value
    .split('\n')
    .map((s) => s.trim())
    .filter(Boolean)
}
</script>
