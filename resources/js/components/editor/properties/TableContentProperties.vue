<template>
  <div class="space-y-3">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Encabezados (separados por coma)</label>
      <input
        :value="headersText"
        type="text"
        class="editor-field-input"
        placeholder="Nombre, Email, Rol"
        @input="updateHeaders"
      >
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Filas (una por línea, celdas separadas por | )</label>
      <textarea
        :value="rowsText"
        rows="6"
        class="editor-field-input font-mono text-xs"
        placeholder="Juan|juan@mail.com|Admin&#10;María|maria@mail.com|Usuario"
        @input="updateRows"
      />
      <p class="text-xs text-gray-500 mt-1">Ejemplo: <code class="bg-gray-100 px-1 rounded">Ana|ana@idcbis.org|Activo</code></p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({ element: { type: Object, required: true } })

const headersText = computed(() => (props.element.headers || []).join(', '))

const rowsText = computed(() =>
  (props.element.rows || []).map((row) => (Array.isArray(row) ? row.join('|') : row)).join('\n')
)

const updateHeaders = (event) => {
  props.element.headers = event.target.value
    .split(',')
    .map((s) => s.trim())
    .filter(Boolean)
}

const updateRows = (event) => {
  props.element.rows = event.target.value
    .split('\n')
    .map((line) => line.trim())
    .filter(Boolean)
    .map((line) => line.split('|').map((cell) => cell.trim()))
}
</script>
