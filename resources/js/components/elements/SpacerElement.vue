<template>
  <div
    class="spacer-element"
    :style="spacerStyles"
    @click.stop="$emit('click', element)"
  >
    <span v-if="!preview" class="spacer-label">{{ element.height || '40px' }}</span>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { resolveBackgroundColor } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const spacerStyles = computed(() => ({
  height: props.element.height || '40px',
  width: '100%',
  backgroundColor: resolveBackgroundColor(
    props.element.backgroundColor,
    props.preview ? 'transparent' : 'rgba(0,0,0,0.03)',
  ),
  border: props.preview ? 'none' : '1px dashed #e2e8f0',
  borderRadius: '4px',
  position: 'relative',
}))
</script>

<style scoped>
.spacer-element {
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.spacer-label {
  font-size: 10px;
  color: #94a3b8;
}
</style>
