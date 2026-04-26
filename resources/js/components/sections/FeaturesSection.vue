<template>
  <section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div v-if="!isEditing" class="grid gap-8" :class="`grid-cols-1 md:grid-cols-${section.content?.columns || 3}`">
        <div 
          v-for="(item, index) in section.content?.items" 
          :key="index"
          class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow"
        >
          <div class="w-12 h-12 bg-[#005674]/10 rounded-lg flex items-center justify-center mb-4">
            <component :is="getIcon(item.icon)" class="w-6 h-6 text-[#005674]" />
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ item.title }}</h3>
          <p class="text-gray-600">{{ item.description }}</p>
        </div>
      </div>
      
      <div v-else class="space-y-4">
        <div class="flex items-center gap-4 mb-6">
          <label class="text-sm font-medium text-gray-700">Columnas:</label>
          <select 
            v-model="editableContent.columns" 
            @change="updateContent"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#005674]"
          >
            <option :value="2">2</option>
            <option :value="3">3</option>
            <option :value="4">4</option>
          </select>
        </div>
        
        <div 
          v-for="(item, index) in editableContent.items" 
          :key="index"
          class="bg-white rounded-lg p-4 border border-gray-200 space-y-3"
        >
          <div class="flex items-center justify-between">
            <span class="font-medium text-gray-700">Item {{ index + 1 }}</span>
            <button 
              @click="removeItem(index)"
              class="text-red-500 hover:text-red-700"
            >
              <Trash2 class="w-4 h-4" />
            </button>
          </div>
          <input
            v-model="item.title"
            @input="updateContent"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
            placeholder="Título"
          >
          <textarea
            v-model="item.description"
            @input="updateContent"
            rows="2"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
            placeholder="Descripción"
          ></textarea>
          <select
            v-model="item.icon"
            @change="updateContent"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
          >
            <option value="star">Estrella</option>
            <option value="heart">Corazón</option>
            <option value="shield">Escudo</option>
            <option value="zap">Rayo</option>
            <option value="check">Check</option>
          </select>
        </div>
        
        <button 
          @click="addItem"
          class="w-full py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-[#005674] hover:text-[#005674] transition-colors"
        >
          <Plus class="w-4 h-4 inline mr-2" />
          Agregar item
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Star, Heart, Shield, Zap, Check, Plus, Trash2 } from 'lucide-vue-next';

const props = defineProps({
  section: { type: Object, required: true },
  isEditing: { type: Boolean, default: false }
});

const emit = defineEmits(['update']);

const iconMap = { Star, Heart, Shield, Zap, Check };

const getIcon = (name) => iconMap[name] || Star;

const editableContent = ref({
  columns: props.section.content?.columns || 3,
  items: props.section.content?.items || []
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    columns: newSection.content?.columns || 3,
    items: newSection.content?.items || []
  };
}, { deep: true });

const updateContent = () => {
  emit('update', { content: { ...editableContent.value } });
};

const addItem = () => {
  editableContent.value.items.push({
    title: 'Nueva característica',
    description: 'Descripción de la característica',
    icon: 'star'
  });
  updateContent();
};

const removeItem = (index) => {
  editableContent.value.items.splice(index, 1);
  updateContent();
};
</script>
