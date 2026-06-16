<template>
  <div 
    class="modal-overlay"
    @click="$emit('click', element)"
  >
    <div class="modal-container" :style="modalStyles" @click.stop>
      <div class="modal-header">
        <h3 class="modal-title">{{ element.title }}</h3>
        <button class="modal-close" @click="$emit('close')">×</button>
      </div>
      <div class="modal-content">
        {{ element.content }}
      </div>
      <div class="modal-footer">
        <button class="modal-btn" @click="$emit('close')">Cerrar</button>
      </div>
    </div>
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

const emit = defineEmits(['click', 'close'])

const modalStyles = computed(() => {
  const sizes = {
    small: { width: '400px', height: 'auto' },
    medium: { width: '600px', height: 'auto' },
    large: { width: '800px', height: 'auto' }
  }
  
  const size = sizes[props.element.size || 'medium']
  
  return {
    backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#ffffff'),
    padding: props.element.padding || '24px',
    borderRadius: props.element.borderRadius || '8px',
    boxShadow: '0 10px 25px rgba(0, 0, 0, 0.1)',
    width: size.width,
    height: size.height,
    maxWidth: '90vw'
  }
})
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  cursor: pointer;
}

.modal-container {
  background: white;
  border-radius: 8px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  max-width: 90vw;
  max-height: 90vh;
  overflow-y: auto;
  cursor: default;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 16px;
  border-bottom: 1px solid #e5e7eb;
  margin-bottom: 16px;
}

.modal-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1a202c;
  margin: 0;
}

.modal-close {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #6b7280;
  padding: 0;
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-close:hover {
  color: #374151;
}

.modal-content {
  margin-bottom: 24px;
  color: #4b5563;
  line-height: 1.6;
}

.modal-footer {
  text-align: right;
  padding-top: 16px;
  border-top: 1px solid #e5e7eb;
}

.modal-btn {
  background-color: #3b82f6;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: background-color 0.2s;
}

.modal-btn:hover {
  background-color: #2563eb;
}
</style>
