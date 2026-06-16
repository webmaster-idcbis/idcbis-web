<template>
  <section 
    class="relative"
    :class="section.styles?.className || ''"
    :style="sectionStyles"
  >
    <!-- Overlay -->
    <div 
      v-if="overlayOpacity > 0"
      class="absolute inset-0 pointer-events-none"
      :style="{ backgroundColor: `rgba(0,0,0,${overlayOpacity / 100})` }"
    ></div>
    
    <div 
      class="relative max-w-4xl mx-auto"
      :class="containerPadding"
    >
      <div 
        v-if="!isEditing"
        class="prose max-w-none"
        :style="contentStyles"
        v-html="renderedContent"
      ></div>
      <div v-else class="space-y-4">
        <div class="flex gap-2 mb-2">
          <button
            v-for="align in ['left', 'center', 'right']"
            :key="align"
            @click="setAlignment(align)"
            :class="[
              'p-2 rounded hover:bg-gray-100',
              editableContent.alignment === align ? 'bg-gray-200' : ''
            ]"
          >
            <AlignLeft v-if="align === 'left'" class="w-4 h-4" />
            <AlignCenter v-if="align === 'center'" class="w-4 h-4" />
            <AlignRight v-if="align === 'right'" class="w-4 h-4" />
          </button>
        </div>
        <textarea
          v-model="editableContent.content"
          @input="updateContent"
          rows="8"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] focus:border-transparent resize-y"
          placeholder="Escribe tu contenido aquí..."
        ></textarea>
        <p class="text-xs text-gray-500">Puedes usar HTML básico para formato</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { AlignLeft, AlignCenter, AlignRight } from 'lucide-vue-next';

const props = defineProps({
  section: {
    type: Object,
    required: true
  },
  isEditing: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['update']);

const editableContent = ref({
  content: props.section.content?.content || 'Escribe tu contenido aquí...',
  alignment: props.section.content?.alignment || 'left'
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    content: newSection.content?.content || 'Escribe tu contenido aquí...',
    alignment: newSection.content?.alignment || 'left'
  };
}, { deep: true });

// Estilos de la sección
const sectionStyles = computed(() => {
  const styles = {};
  const s = props.section.styles || {};
  
  // Background
  if (s.backgroundColor) {
    styles.backgroundColor = s.backgroundColor;
  }
  if (s.backgroundImage) {
    styles.backgroundImage = `url(${s.backgroundImage})`;
    styles.backgroundPosition = s.backgroundPosition || 'center';
    styles.backgroundSize = s.backgroundSize || 'cover';
    styles.backgroundRepeat = s.backgroundRepeat || 'no-repeat';
  }
  
  // Box Shadow
  if (s.boxShadow && s.boxShadow !== 'none') {
    styles.boxShadow = s.boxShadow;
  }
  
  // Border
  if (s.borderWidth) {
    styles.borderWidth = `${s.borderWidth}px`;
    styles.borderStyle = s.borderStyle || 'solid';
    styles.borderColor = s.borderColor || '#e5e7eb';
  }
  if (s.borderRadius) {
    styles.borderRadius = `${s.borderRadius}px`;
  }
  
  return styles;
});

const containerPadding = computed(() => {
  const s = props.section.styles || {};
  const classes = [];
  
  // Convertir padding a clases de tailwind dinámicas
  if (s.paddingTop || s.paddingTop === 0) {
    classes.push(`pt-[${s.paddingTop}px]`);
  } else {
    classes.push('pt-12');
  }
  if (s.paddingBottom || s.paddingBottom === 0) {
    classes.push(`pb-[${s.paddingBottom}px]`);
  } else {
    classes.push('pb-12');
  }
  
  classes.push('px-4', 'sm:px-6', 'lg:px-8');
  
  return classes.join(' ');
});

const overlayOpacity = computed(() => {
  return props.section.styles?.overlayOpacity || 0;
});

const contentStyles = computed(() => {
  const s = props.section.styles || {};
  const styles = {};
  
  if (s.color) {
    styles.color = s.color;
  }
  if (s.textAlign) {
    styles.textAlign = s.textAlign;
  }
  
  return styles;
});

const renderedContent = computed(() => {
  return editableContent.value.content;
});

const setAlignment = (align) => {
  editableContent.value.alignment = align;
  updateContent();
};

const updateContent = () => {
  emit('update', {
    content: { ...editableContent.value }
  });
};
</script>
