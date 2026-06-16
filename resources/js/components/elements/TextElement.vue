<template>
  <div 
    :class="['text-element', element.className]"
    :style="elementStyles"
    contenteditable="false"
    @click.stop="$emit('click', element)"
  >
    {{ element.content || 'Texto de ejemplo' }}
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles } from '../../composables/useElementStyles'

const props = defineProps({
  element: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['click'])

const elementStyles = computed(() => mergeElementStyles(props.element, {
  display: props.element.display || 'block',
  width: props.element.width || 'auto',
}))
</script>

<style scoped>
.text-element {
  display: inline-block;
  cursor: pointer;
  min-height: 20px;
  word-wrap: break-word;
}

.text-element:hover {
  outline: 2px dashed #005674;
  outline-offset: 2px;
}
</style>
