<template>
  <div
    class="html-element"
    :style="wrapperStyles"
    @click.stop="$emit('click', element)"
  >
    <div v-if="!preview" class="html-editor-badge">HTML personalizado</div>
    <div
      v-if="hasContent"
      class="html-render"
      v-html="element.htmlCode"
    />
    <div v-else class="html-empty" :class="{ 'html-empty--editor': !preview }">
      {{ preview ? '' : 'Agrega código HTML en el panel de propiedades →' }}
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const hasContent = computed(() => !!(props.element.htmlCode || '').trim())

const wrapperStyles = computed(() => mergeElementStyles(props.element, {
  width: props.element.width || '100%',
  padding: props.element.padding || (props.preview ? '0' : '12px'),
}))
</script>

<style scoped>
.html-element {
  position: relative;
  min-height: 40px;
  cursor: pointer;
}

.html-empty--editor {
  border: 2px dashed #cbd5e1;
  border-radius: 8px;
  background: #fffbeb;
}

.html-editor-badge {
  position: absolute;
  top: 4px;
  right: 4px;
  font-size: 10px;
  background: #f59e0b;
  color: white;
  padding: 2px 6px;
  border-radius: 4px;
  z-index: 2;
}

.html-render {
  width: 100%;
}

.html-render :deep(img) {
  max-width: 100%;
  height: auto;
}

.html-empty {
  color: #94a3b8;
  font-size: 0.875rem;
  text-align: center;
  padding: 24px;
}
</style>
