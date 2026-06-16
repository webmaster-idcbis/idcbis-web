<template>
  <section 
    class="relative bg-cover bg-center"
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
      class="relative max-w-7xl mx-auto"
      :class="containerPadding"
      :style="{ color: section.styles?.color || 'inherit' }"
    >
      <div 
        class="text-center"
        :style="textAlignStyle"
      >
        <!-- Título con soporte para span light -->
        <h2 
          v-if="!isEditing"
          class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight"
          v-html="renderedTitle"
        ></h2>
        <div v-else class="space-y-4 mb-6">
          <input
            v-model="editableContent.title"
            @input="updateContent"
            type="text"
            class="w-full text-4xl md:text-5xl lg:text-6xl font-bold bg-transparent border-0 border-b-2 focus:border-[#005674] text-center placeholder-gray-400"
            :style="inputStyle"
            placeholder="Título Principal"
          >
          <p class="text-sm text-gray-500">Usa [light]texto[/light] para resaltar en azul claro</p>
        </div>
        
        <!-- Subtítulo -->
        <p 
          v-if="!isEditing"
          class="text-xl md:text-2xl max-w-3xl mx-auto opacity-90 mb-8"
          v-html="renderedSubtitle"
        ></p>
        <div v-else class="space-y-4 mb-8">
          <textarea
            v-model="editableContent.subtitle"
            @input="updateContent"
            rows="3"
            class="w-full text-xl md:text-2xl max-w-3xl mx-auto bg-transparent border-0 border-b-2 focus:border-[#005674] text-center placeholder-gray-400 resize-none"
            :style="inputStyle"
            placeholder="Subtítulo descriptivo (usa + para separar líneas)"
          ></textarea>
          <p class="text-sm text-gray-500">Separa líneas con + (ej: Investigación + Sangre + Tejidos)</p>
        </div>
        
        <!-- Botones CTA tipo pill -->
        <div v-if="hasButtons || isEditing" class="flex flex-wrap justify-center gap-4">
          <!-- Botón primario -->
          <a 
            v-if="!isEditing && section.content?.ctaText"
            :href="section.content?.ctaLink || '#services'"
            class="inline-flex items-center gap-2 px-8 py-4 bg-white text-[#005674] font-bold text-lg rounded-full hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1"
            :style="buttonStyle"
          >
            {{ section.content?.ctaText }}
            <ArrowRight class="w-5 h-5" />
          </a>
          
          <!-- Botón secundario -->
          <a 
            v-if="!isEditing && section.content?.ctaSecondaryText"
            :href="section.content?.ctaSecondaryLink || '#contact'"
            class="inline-flex items-center gap-2 px-8 py-4 border-2 border-white text-white font-bold text-lg rounded-full hover:bg-white hover:text-[#005674] transition-all"
          >
            {{ section.content?.ctaSecondaryText }}
          </a>
          
          <!-- Editor de botones -->
          <div v-if="isEditing" class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full max-w-2xl">
            <div class="space-y-2">
              <label class="text-sm text-gray-500">Botón primario</label>
              <input
                v-model="editableContent.ctaText"
                @input="updateContent"
                type="text"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#005674]"
                placeholder="Texto botón principal"
              >
              <input
                v-model="editableContent.ctaLink"
                @input="updateContent"
                type="text"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#005674] text-sm"
                placeholder="URL"
              >
            </div>
            <div class="space-y-2">
              <label class="text-sm text-gray-500">Botón secundario</label>
              <input
                v-model="editableContent.ctaSecondaryText"
                @input="updateContent"
                type="text"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#005674]"
                placeholder="Texto botón secundario"
              >
              <input
                v-model="editableContent.ctaSecondaryLink"
                @input="updateContent"
                type="text"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#005674] text-sm"
                placeholder="URL"
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { ArrowRight } from 'lucide-vue-next';

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
  title: props.section.content?.title || 'Transformamos la salud de Colombia [light]desde Bogotá[/light]',
  subtitle: props.section.content?.subtitle || 'Investigación + Sangre + Tejidos + Avanzadas + Cordón Umbilical',
  ctaText: props.section.content?.ctaText || 'Ver Servicios',
  ctaLink: props.section.content?.ctaLink || '#services',
  ctaSecondaryText: props.section.content?.ctaSecondaryText || 'Contacto',
  ctaSecondaryLink: props.section.content?.ctaSecondaryLink || '#contact',
  backgroundImage: props.section.content?.backgroundImage || ''
});

// Renderizar título con soporte para span light
const renderedTitle = computed(() => {
  let title = editableContent.value.title || '';
  // Reemplazar [light]texto[/light] con span estilizado
  title = title.replace(/\[light\](.*?)\[\/light\]/g, '<span class="text-[#60A5FA] font-light">$1</span>');
  return title;
});

// Renderizar subtítulo con soporte para + como separador
const renderedSubtitle = computed(() => {
  let subtitle = editableContent.value.subtitle || '';
  // Reemplazar + con separador visual
  subtitle = subtitle.replace(/\s*\+\s*/g, ' <span class="mx-2 text-white/60">•</span> ');
  return subtitle;
});

const hasButtons = computed(() => {
  return props.section.content?.ctaText || props.section.content?.ctaSecondaryText;
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    title: newSection.content?.title || 'Transformamos la salud de Colombia [light]desde Bogotá[/light]',
    subtitle: newSection.content?.subtitle || 'Investigación + Sangre + Tejidos + Avanzadas + Cordón Umbilical',
    ctaText: newSection.content?.ctaText || 'Ver Servicios',
    ctaLink: newSection.content?.ctaLink || '#services',
    ctaSecondaryText: newSection.content?.ctaSecondaryText || 'Contacto',
    ctaSecondaryLink: newSection.content?.ctaSecondaryLink || '#contact',
    backgroundImage: newSection.content?.backgroundImage || ''
  };
}, { deep: true });

// Computed styles
const sectionStyles = computed(() => {
  const styles = {};
  const s = props.section.styles || {};
  
  // Background
  if (s.background) {
    styles.background = s.background;
  } else if (s.backgroundColor) {
    styles.backgroundColor = s.backgroundColor;
  } else if (s.backgroundImage) {
    styles.backgroundImage = `url(${s.backgroundImage})`;
    styles.backgroundPosition = s.backgroundPosition || 'center';
    styles.backgroundSize = s.backgroundSize || 'cover';
    styles.backgroundRepeat = s.backgroundRepeat || 'no-repeat';
  } else {
    // Default IDCBIS gradient
    styles.background = 'linear-gradient(135deg, #003C5F 0%, #005674 50%, #008996 100%)';
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
  
  if (s.paddingTop || s.paddingTop === 0) classes.push(`pt-[${s.paddingTop}px]`);
  if (s.paddingBottom || s.paddingBottom === 0) classes.push(`pb-[${s.paddingBottom}px]`);
  if (s.paddingLeft || s.paddingLeft === 0) classes.push(`px-[${s.paddingLeft}px]`);
  if (s.paddingRight || s.paddingRight === 0) classes.push(`px-[${s.paddingRight}px]`);
  
  // Default padding más grande para hero
  if (classes.length === 0) classes.push('py-24', 'md:py-32', 'px-4', 'sm:px-6', 'lg:px-8');
  
  return classes.join(' ');
});

const overlayOpacity = computed(() => {
  return props.section.styles?.overlayOpacity || 0;
});

const textAlignStyle = computed(() => {
  const align = props.section.styles?.textAlign;
  return align ? { textAlign: align } : {};
});

const inputStyle = computed(() => {
  const color = props.section.styles?.color;
  return color ? { color: color, borderColor: `${color}50` } : {};
});

const buttonStyle = computed(() => {
  const color = props.section.styles?.color;
  return color ? { color: color } : {};
});

const updateContent = () => {
  emit('update', {
    content: { ...editableContent.value }
  });
};
</script>
