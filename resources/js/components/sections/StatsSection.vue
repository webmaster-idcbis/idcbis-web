<template>
  <section 
    class="relative py-16 overflow-hidden"
    :style="{ backgroundColor: section.styles?.backgroundColor || '#FCD34D' }"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Título -->
      <div v-if="section.content?.title || isEditing" class="text-center mb-12">
        <h2 
          v-if="!isEditing"
          class="text-3xl md:text-4xl font-bold mb-4"
          :style="{ color: section.styles?.titleColor || '#1F2937' }"
        >
          {{ section.content?.title }}
        </h2>
        <input
          v-else
          v-model="editableContent.title"
          @input="updateContent"
          type="text"
          class="w-full max-w-2xl mx-auto px-4 py-2 text-3xl font-bold text-center border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none"
          placeholder="Título de la sección"
        >
      </div>

      <!-- Stats Grid -->
      <div v-if="!isEditing" class="grid gap-6 md:gap-8" :class="gridClass">
        <div 
          v-for="(item, index) in editableContent.items" 
          :key="index"
          class="stat-bubble group"
          :style="getStatStyle(item)"
        >
          <div class="text-center p-6">
            <div 
              class="text-4xl md:text-5xl lg:text-6xl font-bold mb-2"
              :style="{ color: item.numberColor || '#1F2937' }"
            >
              {{ item.number }}
            </div>
            <div 
              class="text-sm md:text-base font-medium"
              :style="{ color: item.labelColor || '#4B5563' }"
            >
              {{ item.label }}
            </div>
          </div>
        </div>
      </div>
      
      <!-- Modo edición -->
      <div v-else class="space-y-4">
        <div class="flex items-center gap-4 mb-6">
          <label class="text-sm font-medium text-gray-700">Columnas:</label>
          <select 
            v-model="editableContent.columns" 
            @change="updateContent"
            class="border border-gray-300 rounded-lg px-3 py-2 text-gray-900"
          >
            <option :value="2">2</option>
            <option :value="3">3</option>
            <option :value="4">4</option>
            <option :value="6">6</option>
          </select>
        </div>

        <div class="grid gap-4" :class="gridClass">
          <div 
            v-for="(item, index) in editableContent.items" 
            :key="index"
            class="bg-white rounded-xl p-4 border-2 border-gray-200 space-y-3"
          >
            <div class="flex items-center justify-between">
              <span class="font-medium text-gray-700">Estadística {{ index + 1 }}</span>
              <div class="flex items-center gap-1">
                <button
                  @click="moveItem(index, -1)"
                  :disabled="index === 0"
                  class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30"
                >
                  <ChevronLeft class="w-4 h-4" />
                </button>
                <button
                  @click="moveItem(index, 1)"
                  :disabled="index === editableContent.items.length - 1"
                  class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30"
                >
                  <ChevronRight class="w-4 h-4" />
                </button>
                <button 
                  @click="removeItem(index)"
                  class="p-1 text-red-400 hover:text-red-600"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </div>
            <input
              v-model="item.number"
              @input="updateContent"
              type="text"
              class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-[#005674] focus:outline-none font-bold text-xl"
              placeholder="Número (ej: 100+)"
            >
            <input
              v-model="item.label"
              @input="updateContent"
              type="text"
              class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-[#005674] focus:outline-none"
              placeholder="Etiqueta"
            >
            <div class="flex gap-2">
              <input
                v-model="item.bgColor"
                @input="updateContent"
                type="color"
                class="w-10 h-8 rounded cursor-pointer"
                title="Color de fondo"
              >
              <input
                v-model="item.borderRadius"
                @input="updateContent"
                type="text"
                class="flex-1 px-3 py-1 text-sm border border-gray-300 rounded"
                placeholder="Border radius (ej: 50% 50% 30% 30%)"
              >
            </div>
          </div>
        </div>
        
        <button 
          @click="addItem"
          class="w-full py-3 border-2 border-dashed border-gray-400 rounded-lg text-gray-600 hover:border-[#005674] hover:text-[#005674] transition-colors flex items-center justify-center gap-2"
        >
          <Plus class="w-5 h-5" />
          Agregar estadística
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { Plus, Trash2, ChevronLeft, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
  section: { type: Object, required: true },
  isEditing: { type: Boolean, default: false }
});

const emit = defineEmits(['update']);

const editableContent = ref({
  title: props.section.content?.title || '',
  columns: props.section.content?.columns || 4,
  items: props.section.content?.items?.length > 0
    ? [...props.section.content.items]
    : [
        { 
          number: '60+', 
          label: 'Publicaciones científicas',
          bgColor: '#FFFFFF',
          numberColor: '#005674',
          labelColor: '#4B5563',
          borderRadius: '50% 50% 30% 30%'
        },
        { 
          number: '100K+', 
          label: 'Donantes de sangre',
          bgColor: '#FFFFFF',
          numberColor: '#F59E0B',
          labelColor: '#4B5563',
          borderRadius: '30% 50% 50% 30%'
        },
        { 
          number: '50K+', 
          label: 'Unidades procesadas',
          bgColor: '#FFFFFF',
          numberColor: '#EC4899',
          labelColor: '#4B5563',
          borderRadius: '50% 30% 30% 50%'
        },
        { 
          number: '25+', 
          label: 'Años de experiencia',
          bgColor: '#FFFFFF',
          numberColor: '#10B981',
          labelColor: '#4B5563',
          borderRadius: '30% 30% 50% 50%'
        }
      ]
});

const gridClass = computed(() => {
  const cols = editableContent.value.columns || 4;
  const classes = {
    2: 'grid-cols-2',
    3: 'grid-cols-2 md:grid-cols-3',
    4: 'grid-cols-2 md:grid-cols-4',
    6: 'grid-cols-2 md:grid-cols-3 lg:grid-cols-6'
  };
  return classes[cols] || classes[4];
});

const getStatStyle = (item) => {
  return {
    backgroundColor: item.bgColor || '#FFFFFF',
    borderRadius: item.borderRadius || '50% 50% 30% 30%',
    aspectRatio: '1',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    boxShadow: '0 4px 15px rgba(0,0,0,0.1)',
    transition: 'all 0.3s ease'
  };
};

watch(() => props.section, (newSection) => {
  editableContent.value = {
    title: newSection.content?.title || '',
    columns: newSection.content?.columns || 4,
    items: newSection.content?.items?.length > 0
      ? [...newSection.content.items]
      : editableContent.value.items
  };
}, { deep: true });

const updateContent = () => {
  emit('update', { content: { ...editableContent.value } });
};

const addItem = () => {
  editableContent.value.items.push({
    number: '0',
    label: 'Nueva estadística',
    bgColor: '#FFFFFF',
    numberColor: '#005674',
    labelColor: '#4B5563',
    borderRadius: '50% 50% 30% 30%'
  });
  updateContent();
};

const removeItem = (index) => {
  editableContent.value.items.splice(index, 1);
  updateContent();
};

const moveItem = (index, direction) => {
  const newIndex = index + direction;
  if (newIndex < 0 || newIndex >= editableContent.value.items.length) return;
  
  const temp = editableContent.value.items[index];
  editableContent.value.items.splice(index, 1);
  editableContent.value.items.splice(newIndex, 0, temp);
  updateContent();
};
</script>

<style scoped>
.stat-bubble {
  transition: all 0.3s ease;
}

.stat-bubble:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
</style>
