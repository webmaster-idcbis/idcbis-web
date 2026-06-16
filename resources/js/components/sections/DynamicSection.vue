<template>
  <div 
    :class="['dynamic-section', section.className]"
    :style="sectionStyles"
    @click="handleSectionClick"
    @drop="handleDrop"
    @dragover="handleDragOver"
    @dragenter="handleDragEnter"
    @dragleave="handleDragLeave"
  >
    <!-- Elementos dentro de la sección -->
    <div 
      v-for="(element, index) in section.elements" 
      :key="element.id"
      class="element-wrapper"
      :style="getElementWrapperStyles(element)"
      @click.stop="handleElementClick(element)"
    >
      <component
        :is="getComponentType(element.type)"
        :element="element"
        @select="handleElementSelect"
        @click="handleElementClick"
      />
      
      <!-- Controles del elemento -->
      <div v-if="selectedElementId === element.id" class="element-controls">
        <button @click.stop="deleteElement(index)" class="control-btn delete">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M8 6V4m0 2h8m-9 9h6m2 0H9m0 0h6m-6-4h12m-6 4h12"/>
          </svg>
        </button>
        <button @click.stop="duplicateElement(element)" class="control-btn duplicate">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </button>
      </div>
    </div>
    
    <!-- Indicador de drop zone -->
    <div v-if="isDragOver" class="drop-indicator">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/>
      </svg>
      <span>Soltar elemento aquí</span>
    </div>
    
    <!-- Controles de la sección -->
    <div v-if="isSelected" class="section-controls">
      <button @click.stop="deleteSection" class="control-btn delete">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M8 6V4m0 2h8m-9 9h6m2 0H9m0 0h6m-6-4h12m-6 4h12"/>
        </svg>
      </button>
      <button @click.stop="duplicateSection" class="control-btn duplicate">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import TextElement from '../elements/TextElement.vue'
import ImageElement from '../elements/ImageElement.vue'
import ButtonElement from '../elements/ButtonElement.vue'
import ContainerElement from '../elements/ContainerElement.vue'

const props = defineProps({
  section: {
    type: Object,
    required: true
  },
  isSelected: {
    type: Boolean,
    default: false
  },
  selectedElementId: {
    type: String,
    default: null
  }
})

const emit = defineEmits(['select', 'select-element', 'delete', 'duplicate', 'delete-element', 'duplicate-element', 'add-element'])

const isDragOver = ref(false)

const sectionStyles = computed(() => {
  const styles = {
    // Layout
    display: props.section.display || 'block',
    flexDirection: props.section.flexDirection || 'row',
    flexWrap: props.section.flexWrap || 'nowrap',
    justifyContent: props.section.justifyContent || 'flex-start',
    alignItems: props.section.alignItems || 'stretch',
    gap: props.section.gap || '0',
    
    // Posicionamiento
    position: props.section.position || 'relative',
    top: props.section.top || 'auto',
    left: props.section.left || 'auto',
    right: props.section.right || 'auto',
    bottom: props.section.bottom || 'auto',
    zIndex: props.section.zIndex || 1,
    
    // Tamaño
    width: props.section.width || '100%',
    height: props.section.height || 'auto',
    minHeight: props.section.minHeight || 'auto',
    
    // Espaciado
    padding: props.section.padding || '60px 20px',
    margin: props.section.margin || '0',
    
    // Colores y fondo
    backgroundColor: props.section.backgroundColor || '#ffffff',
    backgroundImage: props.section.backgroundImage ? `url(${props.section.backgroundImage})` : 'none',
    backgroundSize: props.section.backgroundSize || 'cover',
    backgroundPosition: props.section.backgroundPosition || 'center',
    backgroundRepeat: props.section.backgroundRepeat || 'no-repeat',
    
    // Bordes
    border: props.section.border || 'none',
    borderRadius: props.section.borderRadius || '0',
    
    // Sombra
    boxShadow: props.section.boxShadow || 'none',
    
    // Otros
    opacity: props.section.opacity || 1,
    transform: props.section.transform || 'none',
    transition: props.section.transition || 'none',
    overflow: props.section.overflow || 'visible'
  }
  
  if (props.section.customStyles) {
    Object.assign(styles, props.section.customStyles)
  }
  
  return styles
})

const getElementWrapperStyles = (element) => {
  return {
    position: 'relative',
    display: element.display || 'block',
    width: element.width || 'auto',
    height: element.height || 'auto',
    margin: element.margin || '0 0 20px 0',
    ...element.wrapperStyles
  }
}

const getComponentType = (type) => {
  const components = {
    text: TextElement,
    image: ImageElement,
    button: ButtonElement,
    container: ContainerElement
  }
  return components[type] || TextElement
}

const handleSectionClick = () => {
  emit('select', props.section)
}

const handleElementClick = (element) => {
  emit('select-element', element)
}

const handleElementSelect = (element) => {
  emit('select-element', element)
}

const handleDragOver = (event) => {
  event.preventDefault()
  isDragOver.value = true
}

const handleDragEnter = (event) => {
  event.preventDefault()
  isDragOver.value = true
}

const handleDragLeave = (event) => {
  if (event.target === event.currentTarget) {
    isDragOver.value = false
  }
}

const handleDrop = (event) => {
  event.preventDefault()
  isDragOver.value = false
  
  const elementType = event.dataTransfer.getData('elementType')
  if (elementType) {
    emit('add-element', {
      type: elementType,
      sectionId: section.id
    })
  }
}

const deleteElement = (index) => {
  emit('delete-element', { sectionId: section.id, elementIndex: index })
}

const duplicateElement = (element) => {
  emit('duplicate-element', { sectionId: section.id, element })
}

const deleteSection = () => {
  emit('delete', section)
}

const duplicateSection = () => {
  emit('duplicate', section)
}
</script>

<style scoped>
.dynamic-section {
  position: relative;
  min-height: 200px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.dynamic-section:hover {
  outline: 2px dashed #005674;
  outline-offset: 2px;
}

.element-wrapper {
  position: relative;
  transition: all 0.2s ease;
}

.element-wrapper:hover {
  outline: 1px dashed #58a6ff;
  outline-offset: 2px;
}

.element-controls {
  position: absolute;
  top: -10px;
  right: -10px;
  display: flex;
  gap: 4px;
  z-index: 1000;
}

.section-controls {
  position: absolute;
  top: -10px;
  right: -10px;
  display: flex;
  gap: 4px;
  z-index: 999;
}

.control-btn {
  width: 24px;
  height: 24px;
  border-radius: 4px;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 10px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.control-btn.delete {
  background-color: #dc3545;
  color: white;
}

.control-btn.delete:hover {
  background-color: #c82333;
}

.control-btn.duplicate {
  background-color: #28a745;
  color: white;
}

.control-btn.duplicate:hover {
  background-color: #218838;
}

.drop-indicator {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 86, 116, 0.1);
  border: 2px dashed #005674;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: #005674;
  font-weight: 500;
  pointer-events: none;
  z-index: 10;
}

.drop-indicator i {
  font-size: 24px;
  margin-bottom: 8px;
}

/* Dark mode styles */
@media (prefers-color-scheme: dark) {
  .dynamic-section:hover {
    outline-color: #58a6ff;
  }
  
  .element-wrapper:hover {
    outline-color: #005674;
  }
  
  .drop-indicator {
    background-color: rgba(88, 166, 255, 0.1);
    border-color: #58a6ff;
    color: #58a6ff;
  }
}
</style>
