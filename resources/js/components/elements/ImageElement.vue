<template>
  <div 
    :class="['image-element', element.className]"
    :style="containerStyles"
    @click.stop="$emit('click', element)"
  >
    <img 
      :src="element.src || '/images/placeholder.jpg'"
      :alt="element.alt || 'Imagen'"
      :style="imageStyles"
      class="w-full h-full object-cover"
    />
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

const containerStyles = computed(() => mergeElementStyles(props.element, {
  display: props.element.display || 'block',
  width: props.element.width || 'auto',
  maxWidth: props.element.maxWidth || '100%',
}))

const imageStyles = computed(() => {
  const styles = {
    // Tamaño de la imagen
    width: props.element.imageWidth || '100%',
    height: props.element.imageHeight || 'auto',
    
    // Ajuste de imagen
    objectFit: props.element.objectFit || 'cover',
    objectPosition: props.element.objectPosition || 'center',
    
    // Filtros
    filter: props.element.filter || 'none',
    
    // Bordes de la imagen
    border: props.element.imageBorder || 'none',
    borderRadius: props.element.imageBorderRadius || '0'
  }
  
  if (props.element.imageCustomStyles) {
    Object.assign(styles, props.element.imageCustomStyles)
  }
  
  return styles
})

const handleImageError = (event) => {
  event.target.src = '/images/placeholder-error.jpg'
}
</script>

<style scoped>
.image-element {
  display: inline-block;
  cursor: pointer;
}

.image-element:hover {
  outline: 2px dashed #005674;
  outline-offset: 2px;
}

.image-element img {
  display: block;
}
</style>
