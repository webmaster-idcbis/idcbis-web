<template>
  <component
    :is="tag"
    :class="['heading-element', element.className, { 'heading-section': element.variant === 'section' }]"
    :style="elementStyles"
    @click.stop="$emit('click', element)"
  >
    {{ element.content || 'Título de sección' }}
  </component>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
})

defineEmits(['click'])

const tag = computed(() => {
  const level = props.element.level || 'h2'
  return ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'].includes(level) ? level : 'h2'
})

const elementStyles = computed(() => mergeElementStyles(props.element, {
  display: 'block',
  width: props.element.width || '100%',
  color: props.element.color || '#111827',
  fontWeight: props.element.fontWeight || '700',
  textAlign: props.element.textAlign || 'left',
  margin: props.element.margin || '0 0 16px',
}))
</script>

<style scoped>
.heading-element {
  cursor: pointer;
  line-height: 1.2;
}

.heading-section {
  font-family: var(--font-idcbis);
  font-size: 2.5rem !important;
  color: #1a237e !important;
  text-align: center !important;
  position: relative;
  display: block;
  width: fit-content;
  max-width: 100%;
  margin-left: auto !important;
  margin-right: auto !important;
  margin-bottom: 1rem !important;
  padding-bottom: 1.5rem;
}

.heading-section::after {
  content: '';
  position: absolute;
  width: 120px;
  height: 5px;
  background: linear-gradient(to right, #d32f2f, #00acc1);
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 5px;
}
</style>
