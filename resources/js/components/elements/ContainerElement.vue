<template>
  <div
    :class="['container-element', element.className, { 'container-preview': preview, 'container-empty': !hasChildren }]"
    :style="containerStyles"
    @click.stop="onContainerClick"
    @drop.prevent="onDrop"
    @dragover.prevent="onDragOver"
    @dragenter.prevent="onDragEnter"
    @dragleave="onDragLeave"
  >
    <div
      v-for="(child, index) in (element.children || [])"
      :key="child.id"
      class="element-wrapper"
      :class="{ 'is-selected': selectedElementId === child.id }"
      :style="getChildStyles(child)"
      @click.stop="onChildClick(child)"
    >
      <component
        :is="getComponentType(child.type)"
        :element="child"
        :preview="preview"
        :is-selected="selectedElementId === child.id"
        :selected-element-id="selectedElementId"
        @select="onChildClick"
        @click="onChildClick"
        @add-child="(payload) => emit('add-child', payload)"
        @delete-child="(payload) => emit('delete-child', payload)"
        @duplicate-child="(payload) => emit('duplicate-child', payload)"
        @move-child="(payload) => emit('move-child', payload)"
      />

      <div v-if="!preview && selectedElementId === child.id" class="element-controls">
        <button type="button" @click.stop="emit('delete-child', { containerId: element.id, index })" class="control-btn delete">🗑️</button>
        <button type="button" @click.stop="emit('duplicate-child', { containerId: element.id, child })" class="control-btn duplicate">📋</button>
      </div>
    </div>

    <div v-if="!preview && !hasChildren" class="container-empty-hint">
      Arrastra elementos aquí
    </div>

    <div v-if="!preview && isDragOver" class="drop-indicator">
      <span>➕ Soltar elemento aquí</span>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { usePageElements } from '../../composables/usePageElements'
import { getContainerChildWrapperStyles, resolveBackgroundColor } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  isSelected: { type: Boolean, default: false },
  selectedElementId: { type: String, default: null },
  preview: { type: Boolean, default: false },
})

const emit = defineEmits(['select', 'delete', 'duplicate', 'delete-child', 'duplicate-child', 'add-child', 'click', 'move-child'])

const { getComponentType } = usePageElements()
const isDragOver = ref(false)

const hasChildren = computed(() => (props.element.children || []).length > 0)

const containerStyles = computed(() => {
  const el = props.element
  const styles = {
    display: el.display || 'flex',
    flexDirection: el.flexDirection || 'column',
    flexWrap: el.flexWrap || 'nowrap',
    justifyContent: el.justifyContent || 'flex-start',
    alignItems: el.alignItems || 'stretch',
    gap: el.gap || '16px',
    width: el.width || '100%',
    minHeight: el.minHeight || '120px',
    padding: el.padding || '20px',
    margin: el.margin || '0',
    backgroundColor: resolveBackgroundColor(el.backgroundColor, '#f8f9fa'),
    borderRadius: el.borderRadius || '8px',
    position: 'relative',
    boxSizing: 'border-box',
  }

  if (el.display === 'grid') {
    styles.gridTemplateColumns = el.gridTemplateColumns || 'repeat(auto-fit, minmax(200px, 1fr))'
  }

  if (el.fullBleed && props.preview) {
    styles.border = 'none'
    styles.borderRadius = el.borderRadius || '0'
    styles.width = '100%'
  } else if (el.sectionBoxed !== false && props.preview) {
    styles.maxWidth = el.maxWidth || '1400px'
    styles.marginLeft = 'auto'
    styles.marginRight = 'auto'
    styles.border = 'none'
  }

  if (!props.preview) {
    styles.border = el.border || '2px dashed #cbd5e1'
  } else if (el.border === 'none') {
    styles.border = 'none'
  }

  return styles
})

const getChildStyles = (child) => getContainerChildWrapperStyles(child, props.element)

const onContainerClick = () => {
  if (!props.preview) emit('select', props.element)
}

const onChildClick = (payload) => {
  if (props.preview) return
  const target = payload?.id ? payload : null
  if (target?.id) emit('select', target)
}

const onDragOver = () => {
  if (!props.preview) isDragOver.value = true
}

const onDragEnter = () => {
  if (!props.preview) isDragOver.value = true
}

const onDragLeave = (event) => {
  if (event.target === event.currentTarget) isDragOver.value = false
}

const onDrop = (event) => {
  if (props.preview) return
  event.stopPropagation()
  isDragOver.value = false
  const elementType = event.dataTransfer.getData('elementType') || event.dataTransfer.getData('text/plain')
  if (elementType) {
    emit('add-child', { type: elementType, containerId: props.element.id })
  }
}
</script>

<style scoped>
.container-element {
  position: relative;
  transition: outline 0.15s ease;
}

.container-element:not(.container-preview):hover {
  outline: 2px dashed #005674;
  outline-offset: 2px;
}

.container-preview {
  border: none !important;
}

.element-wrapper {
  position: relative;
  min-width: 0;
}

.element-wrapper.is-selected {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
  border-radius: 4px;
}

.container-preview .element-wrapper.is-selected {
  outline: none;
}

.container-empty-hint {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 80px;
  color: #94a3b8;
  font-size: 0.875rem;
  pointer-events: none;
}

.drop-indicator {
  position: absolute;
  inset: 0;
  background: rgba(0, 86, 116, 0.08);
  border: 2px dashed #005674;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #005674;
  font-weight: 500;
  font-size: 0.875rem;
  pointer-events: none;
  z-index: 5;
}

.element-controls {
  position: absolute;
  top: -10px;
  right: -10px;
  display: flex;
  gap: 4px;
  z-index: 10;
}

.control-btn {
  width: 24px;
  height: 24px;
  border-radius: 4px;
  border: none;
  cursor: pointer;
  font-size: 10px;
}

.control-btn.delete { background: #dc3545; color: white; }
.control-btn.duplicate { background: #28a745; color: white; }
</style>
