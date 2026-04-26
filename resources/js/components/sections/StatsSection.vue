<template>
  <section class="py-16 bg-[#005674]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div v-if="!isEditing" class="grid gap-8 text-center" :class="`grid-cols-2 md:grid-cols-${section.content?.columns || 4}`">
        <div 
          v-for="(item, index) in section.content?.items" 
          :key="index"
          class="text-white"
        >
          <div class="text-4xl md:text-5xl font-bold mb-2">{{ item.number }}</div>
          <div class="text-white/80">{{ item.label }}</div>
        </div>
      </div>
      
      <div v-else class="space-y-4">
        <div class="flex items-center gap-4 mb-6">
          <label class="text-sm font-medium text-white">Columnas:</label>
          <select 
            v-model="editableContent.columns" 
            @change="updateContent"
            class="border border-gray-300 rounded-lg px-3 py-2 text-gray-900"
          >
            <option :value="2">2</option>
            <option :value="3">3</option>
            <option :value="4">4</option>
          </select>
        </div>
        
        <div 
          v-for="(item, index) in editableContent.items" 
          :key="index"
          class="bg-white/10 rounded-lg p-4 border border-white/20 space-y-3"
        >
          <div class="flex items-center justify-between">
            <span class="font-medium text-white">Estadística {{ index + 1 }}</span>
            <button 
              @click="removeItem(index)"
              class="text-red-300 hover:text-red-200"
            >
              <Trash2 class="w-4 h-4" />
            </button>
          </div>
          <input
            v-model="item.number"
            @input="updateContent"
            type="text"
            class="w-full px-3 py-2 rounded-lg bg-white/20 text-white border-0 placeholder-white/50"
            placeholder="Número (ej: 100+)"
          >
          <input
            v-model="item.label"
            @input="updateContent"
            type="text"
            class="w-full px-3 py-2 rounded-lg bg-white/20 text-white border-0 placeholder-white/50"
            placeholder="Etiqueta"
          >
        </div>
        
        <button 
          @click="addItem"
          class="w-full py-2 border-2 border-dashed border-white/40 rounded-lg text-white/80 hover:border-white hover:text-white transition-colors"
        >
          <Plus class="w-4 h-4 inline mr-2" />
          Agregar estadística
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Plus, Trash2 } from 'lucide-vue-next';

const props = defineProps({
  section: { type: Object, required: true },
  isEditing: { type: Boolean, default: false }
});

const emit = defineEmits(['update']);

const editableContent = ref({
  columns: props.section.content?.columns || 4,
  items: props.section.content?.items || []
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    columns: newSection.content?.columns || 4,
    items: newSection.content?.items || []
  };
}, { deep: true });

const updateContent = () => {
  emit('update', { content: { ...editableContent.value } });
};

const addItem = () => {
  editableContent.value.items.push({
    number: '0',
    label: 'Nueva estadística'
  });
  updateContent();
};

const removeItem = (index) => {
  editableContent.value.items.splice(index, 1);
  updateContent();
};
</script>
