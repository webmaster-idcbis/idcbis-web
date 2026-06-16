<template>
  <div 
    class="table-element"
    :style="tableStyles"
    @click="$emit('click', element)"
  >
    <table class="table">
      <thead>
        <tr>
          <th 
            v-for="header in element.headers" 
            :key="header"
            class="table-header"
          >
            {{ header }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr 
          v-for="(row, index) in element.rows" 
          :key="index"
          class="table-row"
        >
          <td 
            v-for="(cell, cellIndex) in row" 
            :key="cellIndex"
            class="table-cell"
          >
            {{ cell }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { resolveBackgroundColor } from '../../composables/useElementStyles'

const props = defineProps({
  element: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['click'])

const tableStyles = computed(() => {
  return {
    backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#ffffff'),
    padding: props.element.padding || '0',
    borderRadius: props.element.borderRadius || '4px',
    boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
    marginBottom: '16px',
    overflow: 'auto'
  }
})
</script>

<style scoped>
.table-element {
  cursor: pointer;
  transition: all 0.2s ease;
}

.table-element:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.875rem;
}

.table-header {
  background-color: #f8f9fa;
  color: #495057;
  font-weight: 600;
  text-align: left;
  padding: 12px;
  border-bottom: 2px solid #dee2e6;
}

.table-row:nth-child(even) {
  background-color: #f8f9fa;
}

.table-row:hover {
  background-color: #e9ecef;
}

.table-cell {
  padding: 12px;
  border-bottom: 1px solid #dee2e6;
  color: #495057;
}
</style>
