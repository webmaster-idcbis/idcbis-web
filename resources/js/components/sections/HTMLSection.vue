<template>
  <section 
    class="relative"
    :class="[
      section.styles?.padding || 'py-12',
      section.styles?.backgroundClass || ''
    ]"
    :style="getSectionStyles()"
  >
    <!-- Vista previa del HTML (solo en modo preview/publico) -->
    <div 
      v-if="!isEditing"
      v-html="sanitizedHtml"
      class="max-w-none html-content"
      :style="contentStyles"
    ></div>
    
    <!-- Editor de código HTML -->
    <div v-else class="space-y-4">
      <div class="bg-gray-900 rounded-lg overflow-hidden">
        <div class="flex items-center justify-between px-4 py-2 bg-gray-800 border-b border-gray-700">
          <span class="text-sm font-medium text-gray-300">Código HTML</span>
          <div class="flex items-center gap-2">
            <button 
              @click="formatHtml"
              class="px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600 transition-colors"
              title="Formatear código"
            >
              Formatear
            </button>
            <button 
              @click="clearHtml"
              class="px-2 py-1 text-xs bg-red-900/50 text-red-300 rounded hover:bg-red-900 transition-colors"
              title="Limpiar"
            >
              Limpiar
            </button>
          </div>
        </div>
        <textarea
          v-model="editableContent.html"
          @input="updateContent"
          rows="12"
          class="w-full px-4 py-3 bg-gray-900 text-green-400 font-mono text-sm resize-y focus:outline-none focus:ring-0"
          placeholder="<!-- Escribe tu codigo HTML aqui -->
<div class='mi-clase'>
  <h2>Titulo</h2>
  <p>Contenido...</p>
</div>"
          spellcheck="false"
        ></textarea>
      </div>
      
      <!-- Vista previa en tiempo real -->
      <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
        <div class="text-xs font-medium text-gray-500 mb-2 uppercase tracking-wide">Vista previa</div>
        <div 
          v-html="sanitizedHtml"
          class="max-w-none html-content-preview"
          :style="contentStyles"
        ></div>
      </div>
      
      <!-- Advertencias -->
      <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex items-start gap-2">
          <AlertTriangle class="w-4 h-4 text-yellow-600 mt-0.5 flex-shrink-0" />
          <div class="text-xs text-yellow-700">
            <strong>Advertencia:</strong> El código HTML se ejecutará directamente. Asegúrate de que el código sea seguro y no contenga scripts maliciosos.
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { AlertTriangle } from 'lucide-vue-next';

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
  html: props.section.content?.html || '<div class="p-4 bg-gray-100 rounded-lg">\n  <h2 class="text-xl font-bold mb-2">Título HTML</h2>\n  <p>Contenido personalizado...</p>\n</div>'
});

const sectionStyles = ref({
  backgroundColor: props.section.styles?.backgroundColor || '',
  backgroundGradient: props.section.styles?.backgroundGradient || '',
  textColor: props.section.styles?.textColor || '',
  padding: props.section.styles?.padding || 'py-12',
  alignment: props.section.styles?.alignment || 'text-left'
});

// Sanitización básica de HTML (remover scripts)
const sanitizedHtml = computed(() => {
  let html = editableContent.value.html || '';
  // Remover etiquetas script y eventos onclick/onload
  html = html.replace(/<script[^>]*>[\s\S]*?<\/script>/gi, '');
  html = html.replace(/on\w+\s*=\s*"[^"]*"/gi, '');
  html = html.replace(/on\w+\s*=\s*'[^']*'/gi, '');
  return html;
});

watch(() => props.section, (newSection) => {
  editableContent.value.html = newSection.content?.html || editableContent.value.html;
  sectionStyles.value = {
    backgroundColor: newSection.styles?.backgroundColor || '',
    backgroundGradient: newSection.styles?.backgroundGradient || '',
    textColor: newSection.styles?.textColor || '',
    padding: newSection.styles?.padding || 'py-12',
    alignment: newSection.styles?.alignment || 'text-left'
  };
}, { deep: true });

const getSectionStyles = () => {
  const styles = {};
  
  if (sectionStyles.value.backgroundGradient) {
    styles.background = sectionStyles.value.backgroundGradient;
  } else if (sectionStyles.value.backgroundColor) {
    styles.backgroundColor = sectionStyles.value.backgroundColor;
  }
  
  return styles;
};

const contentStyles = computed(() => {
  const styles = {};
  if (sectionStyles.value.textColor) {
    styles.color = sectionStyles.value.textColor;
  }
  if (sectionStyles.value.alignment) {
    styles.textAlign = sectionStyles.value.alignment;
  }
  return styles;
});

const updateContent = () => {
  emit('update', {
    content: { ...editableContent.value },
    styles: { ...sectionStyles.value }
  });
};

const formatHtml = () => {
  // Formateo básico de HTML
  let html = editableContent.value.html;
  html = html.replace(/>\s*</g, '>\n<');
  html = html.replace(/(<[^/][^>]*>)/g, '\n$1');
  html = html.replace(/(<\/[^>]+>)/g, '$1\n');
  html = html.split('\n').map(line => line.trim()).filter(line => line).join('\n');
  editableContent.value.html = html;
  updateContent();
};

const clearHtml = () => {
  if (confirm('¿Estás seguro de que deseas limpiar todo el código HTML?')) {
    editableContent.value.html = '';
    updateContent();
  }
};

</script>

<style scoped>
.html-content :deep(iframe),
.html-content-preview :deep(iframe) {
  max-width: 100%;
  border: none;
}

.html-content :deep(img),
.html-content-preview :deep(img) {
  max-width: 100%;
  height: auto;
}

.html-content :deep(table),
.html-content-preview :deep(table) {
  width: 100%;
  border-collapse: collapse;
}

.html-content :deep(td),
.html-content :deep(th),
.html-content-preview :deep(td),
.html-content-preview :deep(th) {
  padding: 0.5rem;
  border: 1px solid #e5e7eb;
}
</style>
