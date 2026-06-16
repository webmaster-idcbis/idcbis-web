<template>
  <component
    :is="listTag"
    :class="['list-element', element.className]"
    :style="elementStyles"
    @click.stop="$emit('click', element)"
  >
    <li v-for="(item, i) in items" :key="i">{{ item }}</li>
  </component>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
})

defineEmits(['click'])

const items = computed(() => {
  if (Array.isArray(props.element.items) && props.element.items.length) {
    return props.element.items
  }
  return ['Primer elemento', 'Segundo elemento', 'Tercer elemento']
})

const listTag = computed(() => (props.element.listStyle === 'number' ? 'ol' : 'ul'))

const elementStyles = computed(() => mergeElementStyles(props.element, {
  width: props.element.width || '100%',
  padding: props.element.padding || '0 0 0 20px',
  color: props.element.color || '#374151',
  fontSize: props.element.fontSize || '16px',
  lineHeight: '1.6',
}))
</script>

<style scoped>
.list-element {
  cursor: pointer;
}

.list-element li {
  margin-bottom: 8px;
}
</style>
