<template>
  <div 
    class="alert-element"
    :class="alertClasses"
    :style="alertStyles"
    @click.stop="$emit('click', element)"
  >
    <div class="alert-icon">
      <span v-if="alertVariant === 'success'">✓</span>
      <span v-else-if="alertVariant === 'danger'">⚠</span>
      <span v-else-if="alertVariant === 'warning'">⚠</span>
      <span v-else-if="alertVariant === 'info'">ℹ</span>
      <span v-else>ℹ</span>
    </div>
    <div class="alert-body">
      <div v-if="element.title" class="alert-title">{{ element.title }}</div>
      <div class="alert-content">{{ element.content }}</div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { isTransparentBackground, resolveBackgroundColor } from '../../composables/useElementStyles'

const props = defineProps({
  element: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['click'])

const alertVariant = computed(() => props.element.variant || props.element.alertType || 'info')

const alertClasses = computed(() => `alert-${alertVariant.value}`)

const alertStyles = computed(() => {
  const type = alertVariant.value
  const colors = {
    success: { bg: '#d4edda', border: '#c3e6cb', color: '#155724' },
    danger: { bg: '#f8d7da', border: '#f5c6cb', color: '#721c24' },
    warning: { bg: '#fff3cd', border: '#ffeaa7', color: '#856404' },
    info: { bg: '#d1ecf1', border: '#bee5eb', color: '#0c5460' }
  }
  
  const color = colors[type] || colors.info
  
  return {
    backgroundColor: isTransparentBackground(props.element.backgroundColor)
      ? 'transparent'
      : resolveBackgroundColor(props.element.backgroundColor, color.bg),
    borderColor: color.border,
    color: color.color,
    padding: props.element.padding || '12px 16px',
    borderRadius: props.element.borderRadius || '4px',
    marginBottom: '16px'
  }
})
</script>

<style scoped>
.alert-element {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  cursor: pointer;
  transition: all 0.2s ease;
  border: 1px solid;
}

.alert-element:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.alert-icon {
  font-size: 18px;
  font-weight: bold;
  flex-shrink: 0;
}

.alert-body {
  flex: 1;
  min-width: 0;
}

.alert-title {
  font-weight: 700;
  font-size: 1rem;
  margin-bottom: 0.35rem;
  line-height: 1.35;
}

.alert-content {
  line-height: 1.55;
  white-space: pre-line;
}

.alert-success {
  background-color: #d4edda;
  border-color: #c3e6cb;
  color: #155724;
}

.alert-danger {
  background-color: #f8d7da;
  border-color: #f5c6cb;
  color: #721c24;
}

.alert-warning {
  background-color: #fff3cd;
  border-color: #ffeaa7;
  color: #856404;
}

.alert-info {
  background-color: #d1ecf1;
  border-color: #bee5eb;
  color: #0c5460;
}
</style>
