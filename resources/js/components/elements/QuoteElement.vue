<template>
  <blockquote
    class="quote-element"
    :style="elementStyles"
    @click.stop="$emit('click', element)"
  >
    <p class="quote-text">{{ element.content || 'Una cita inspiradora o mensaje destacado.' }}</p>
    <footer v-if="element.author" class="quote-author">— {{ element.author }}</footer>
  </blockquote>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles, resolveBackgroundColor } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
})

defineEmits(['click'])

const elementStyles = computed(() => mergeElementStyles(props.element, {
  width: props.element.width || '100%',
  padding: props.element.padding || '20px 24px',
  margin: props.element.margin || '16px 0',
  borderLeft: props.element.borderLeft || '4px solid #005674',
  backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#f8fafc'),
  borderRadius: props.element.borderRadius || '0 8px 8px 0',
  color: props.element.color || '#334155',
  fontStyle: 'italic',
}))
</script>

<style scoped>
.quote-element {
  cursor: pointer;
}

.quote-text {
  margin: 0 0 8px;
  font-size: 1.125rem;
  line-height: 1.6;
}

.quote-author {
  font-size: 0.875rem;
  font-style: normal;
  color: #64748b;
}
</style>
