<template>
  <section 
    class="relative"
    :class="[
      section.styles?.padding || 'py-8',
      section.styles?.backgroundClass || ''
    ]"
    :style="getSectionStyles()"
  >
    <div :class="section.styles?.containerClass || 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8'">
      <!-- Línea simple -->
      <hr
        v-if="dividerType === 'line'"
        class="border-0"
        :class="lineClass"
        :style="{ 
          height: thickness + 'px',
          background: lineColor,
          width: width + '%',
          margin: width < 100 ? '0 auto' : '0'
        }"
      >
      
      <!-- Línea con texto -->
      <div
        v-else-if="dividerType === 'text'"
        class="flex items-center gap-4"
      >
        <div
          class="flex-1 h-px"
          :style="{ 
            background: lineColor,
            height: thickness + 'px'
          }"
        ></div>
        <span
          v-if="!isEditing"
          class="text-sm font-medium whitespace-nowrap"
          :class="section.styles?.textClass || 'text-gray-500'"
        >
          {{ section.content?.text || 'Texto' }}
        </span>
        <input
          v-else
          v-model="editableContent.text"
          @input="updateContent"
          type="text"
          class="px-3 py-1 text-sm text-center border-2 border-gray-200 rounded focus:border-[#005674] focus:outline-none"
          placeholder="Texto del separador"
        >
        <div
          class="flex-1 h-px"
          :style="{ 
            background: lineColor,
            height: thickness + 'px'
          }"
        ></div>
      </div>
      
      <!-- Línea con icono -->
      <div
        v-else-if="dividerType === 'icon'"
        class="flex items-center justify-center gap-4"
      >
        <div
          class="flex-1 h-px"
          :style="{ 
            background: lineColor,
            height: thickness + 'px'
          }"
        ></div>
        <div
          v-if="!isEditing"
          class="flex items-center justify-center w-10 h-10 rounded-full"
          :class="section.styles?.iconContainerClass || 'bg-gray-100'"
        >
          <component :is="getIconComponent()" class="w-5 h-5" :class="section.styles?.iconClass || 'text-gray-500'" />
        </div>
        <div
          v-else
          class="flex items-center gap-2"
        >
          <select
            v-model="editableContent.icon"
            @change="updateContent"
            class="px-3 py-1.5 text-sm border-2 border-gray-200 rounded focus:border-[#005674] focus:outline-none"
          >
            <option value="star">⭐ Estrella</option>
            <option value="heart">❤️ Corazón</option>
            <option value="diamond">💎 Diamante</option>
            <option value="leaf">🍃 Hoja</option>
            <option value="sparkles">✨ Brillos</option>
            <option value="zap">⚡ Rayo</option>
            <option value="arrow-down">⬇️ Flecha</option>
            <option value="circle">⭕ Círculo</option>
          </select>
        </div>
        <div
          class="flex-1 h-px"
          :style="{ 
            background: lineColor,
            height: thickness + 'px'
          }"
        ></div>
      </div>
      
      <!-- Ondas decorativas -->
      <div
        v-else-if="dividerType === 'waves'"
        class="flex items-center justify-center"
      >
        <svg
          viewBox="0 0 1200 120"
          preserveAspectRatio="none"
          class="w-full h-12"
          :style="{ fill: lineColor }"
        >
          <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
      </div>
      
      <!-- Puntos decorativos -->
      <div
        v-else-if="dividerType === 'dots'"
        class="flex items-center justify-center gap-2"
      >
        <div
          v-for="n in dotCount"
          :key="n"
          class="rounded-full"
          :style="{ 
            width: dotSize + 'px',
            height: dotSize + 'px',
            background: lineColor
          }"
        ></div>
      </div>
      
      <!-- Configuración en modo edición -->
      <div v-if="isEditing" class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de separador</label>
            <div class="flex flex-wrap gap-2">
              <button
                v-for="type in dividerTypes"
                :key="type.value"
                @click="setDividerType(type.value)"
                class="px-3 py-1.5 text-sm rounded-lg border-2 transition-all"
                :class="dividerType === type.value 
                  ? 'border-[#005674] bg-[#005674] text-white' 
                  : 'border-gray-200 hover:border-gray-300'"
              >
                {{ type.label }}
              </button>
            </div>
          </div>
          
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Grosor (px)</label>
              <input
                v-model.number="thickness"
                @input="updateContent"
                type="number"
                min="1"
                max="20"
                class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Ancho (%)</label>
              <input
                v-model.number="width"
                @input="updateContent"
                type="number"
                min="10"
                max="100"
                class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none"
              >
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
            <div class="flex items-center gap-3">
              <input
                v-model="lineColor"
                @input="updateContent"
                type="color"
                class="w-12 h-10 rounded cursor-pointer border-2 border-gray-200"
              >
              <input
                v-model="lineColor"
                @input="updateContent"
                type="text"
                class="flex-1 px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none text-sm"
                placeholder="#E5E7EB"
              >
            </div>
          </div>
          
          <!-- Opciones específicas para dots -->
          <div v-if="dividerType === 'dots'" class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad de puntos</label>
              <input
                v-model.number="dotCount"
                @input="updateContent"
                type="number"
                min="3"
                max="10"
                class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Tamaño de puntos (px)</label>
              <input
                v-model.number="dotSize"
                @input="updateContent"
                type="number"
                min="4"
                max="20"
                class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none"
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
import { Star, Heart, Sparkles, Zap, ArrowDown, Circle } from 'lucide-vue-next';

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
  text: props.section.content?.text || 'Texto',
  icon: props.section.content?.icon || 'star'
});

const sectionStyles = ref({
  backgroundColor: props.section.styles?.backgroundColor || '',
  padding: props.section.styles?.padding || 'py-8',
  containerClass: props.section.styles?.containerClass || 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8',
  textClass: props.section.styles?.textClass || 'text-gray-500',
  iconClass: props.section.styles?.iconClass || 'text-gray-500',
  iconContainerClass: props.section.styles?.iconContainerClass || 'bg-gray-100'
});

const dividerType = ref(props.section.content?.dividerType || 'line');
const thickness = ref(props.section.content?.thickness || 2);
const width = ref(props.section.content?.width || 100);
const lineColor = ref(props.section.content?.lineColor || '#E5E7EB');
const dotCount = ref(props.section.content?.dotCount || 5);
const dotSize = ref(props.section.content?.dotSize || 8);

const dividerTypes = [
  { value: 'line', label: 'Línea' },
  { value: 'text', label: 'Con texto' },
  { value: 'icon', label: 'Con icono' },
  { value: 'waves', label: 'Ondas' },
  { value: 'dots', label: 'Puntos' }
];

const lineClass = computed(() => {
  return dividerType.value === 'line' ? 'w-full' : '';
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    text: newSection.content?.text || 'Texto',
    icon: newSection.content?.icon || 'star'
  };
  sectionStyles.value = {
    backgroundColor: newSection.styles?.backgroundColor || '',
    padding: newSection.styles?.padding || 'py-8',
    containerClass: newSection.styles?.containerClass || 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8',
    textClass: newSection.styles?.textClass || 'text-gray-500',
    iconClass: newSection.styles?.iconClass || 'text-gray-500',
    iconContainerClass: newSection.styles?.iconContainerClass || 'bg-gray-100'
  };
  dividerType.value = newSection.content?.dividerType || 'line';
  thickness.value = newSection.content?.thickness || 2;
  width.value = newSection.content?.width || 100;
  lineColor.value = newSection.content?.lineColor || '#E5E7EB';
  dotCount.value = newSection.content?.dotCount || 5;
  dotSize.value = newSection.content?.dotSize || 8;
}, { deep: true });

const getSectionStyles = () => {
  const styles = {};
  
  if (sectionStyles.value.backgroundColor) {
    styles.backgroundColor = sectionStyles.value.backgroundColor;
  }
  
  return styles;
};

const getIconComponent = () => {
  const icons = {
    star: Star,
    sparkles: Sparkles,
    zap: Zap,
    'arrow-down': ArrowDown,
    circle: Circle,
    heart: Star, // fallback
    diamond: Star,
    leaf: Star
  };
  return icons[editableContent.value.icon] || Star;
};

const setDividerType = (type) => {
  dividerType.value = type;
  updateContent();
};

const updateContent = () => {
  emit('update', {
    content: { 
      ...editableContent.value,
      dividerType: dividerType.value,
      thickness: thickness.value,
      width: width.value,
      lineColor: lineColor.value,
      dotCount: dotCount.value,
      dotSize: dotSize.value
    },
    styles: { ...sectionStyles.value }
  });
};
</script>
