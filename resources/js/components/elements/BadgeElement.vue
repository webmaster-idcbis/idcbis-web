<template>
  <span 
    class="badge-element"
    :style="badgeStyles"
    @click="$emit('click', element)"
  >
    {{ element.content }}
  </span>
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

const badgeStyles = computed(() => {
  return {
    backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#007bff'),
    color: props.element.color || '#ffffff',
    padding: props.element.padding || '4px 8px',
    borderRadius: props.element.borderRadius || '12px',
    fontSize: props.element.fontSize || '12px',
    fontWeight: '600',
    display: 'inline-block',
    cursor: 'pointer',
    transition: 'all 0.2s ease'
  }
})
</script>

<style scoped>
.badge-element:hover {
  transform: scale(1.05);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}
</style>
