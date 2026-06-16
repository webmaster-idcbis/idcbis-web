<template>
  <section 
    class="relative"
    :style="getSectionStyles()"
  >
    <!-- Spacer es invisible, solo ocupa espacio -->
    <div
      class="w-full"
      :class="{ 'border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center': isEditing }"
      :style="{ height: isEditing ? '60px' : height + 'px' }"
    >
      <!-- Indicador visual en modo edición -->
      <div v-if="isEditing" class="flex items-center gap-2 text-gray-400">
        <MoveVertical class="w-5 h-5" />
        <span class="text-sm font-medium">Espaciado: {{ height }}px</span>
      </div>
    </div>
    
    <!-- Configuración en modo edición -->
    <div v-if="isEditing" class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Altura del espaciado: {{ height }}px
          </label>
          <input
            v-model.number="height"
            @input="updateContent"
            type="range"
            min="10"
            max="200"
            step="10"
            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#005674]"
          >
          <div class="flex justify-between text-xs text-gray-500 mt-1">
            <span>10px</span>
            <span>100px</span>
            <span>200px</span>
          </div>
        </div>
        
        <!-- Presets rápidos -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Presets</label>
          <div class="flex flex-wrap gap-2">
            <button
              v-for="preset in heightPresets"
              :key="preset.value"
              @click="setHeight(preset.value)"
              class="px-3 py-1.5 text-sm rounded-lg border-2 transition-all"
              :class="height === preset.value 
                ? 'border-[#005674] bg-[#005674] text-white' 
                : 'border-gray-200 hover:border-gray-300'"
            >
              {{ preset.label }}
            </button>
          </div>
        </div>
        
        <!-- Input manual -->
        <div class="flex items-center gap-3">
          <label class="text-sm font-medium text-gray-700">Valor exacto:</label>
          <div class="flex items-center gap-2">
            <input
              v-model.number="height"
              @input="updateContent"
              type="number"
              min="0"
              max="500"
              class="w-20 px-3 py-1.5 border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none text-center"
            >
            <span class="text-sm text-gray-500">px</span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue';
import { MoveVertical } from 'lucide-vue-next';

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

const height = ref(props.section.content?.height || 40);

const heightPresets = [
  { value: 20, label: 'Pequeño (20px)' },
  { value: 40, label: 'Medio (40px)' },
  { value: 60, label: 'Grande (60px)' },
  { value: 100, label: 'Extra (100px)' }
];

watch(() => props.section, (newSection) => {
  height.value = newSection.content?.height || 40;
}, { deep: true });

const getSectionStyles = () => {
  return {
    height: !props.isEditing ? height.value + 'px' : 'auto'
  };
};

const setHeight = (value) => {
  height.value = value;
  updateContent();
};

const updateContent = () => {
  emit('update', {
    content: { height: height.value },
    styles: {}
  });
};
</script>
