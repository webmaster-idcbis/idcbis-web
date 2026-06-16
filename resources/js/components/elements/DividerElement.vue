<template>
  <hr
    class="divider-element"
    :style="dividerStyles"
    @click.stop="$emit('click', element)"
  >
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
})

defineEmits(['click'])

const dividerStyles = computed(() => mergeElementStyles(props.element, {
  width: props.element.width || '100%',
  border: 'none',
  borderTop: props.element.borderStyle || '2px solid #e5e7eb',
  margin: props.element.margin || '24px 0',
}))
</script>

<style scoped>
.divider-element {
  cursor: pointer;
}
</style>
