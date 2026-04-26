<template>
  <section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div 
        :class="[
          'grid gap-8',
          `grid-cols-1 md:grid-cols-${section.content?.columns || 3}`
        ]"
      >
        <div 
          v-for="(card, index) in cards" 
          :key="index"
          class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow"
        >
          <div v-if="card.image" class="h-48 overflow-hidden">
            <img 
              :src="card.image" 
              :alt="card.title"
              class="w-full h-full object-cover"
            >
          </div>
          <div class="p-6">
            <h3 v-if="!isEditing" class="text-xl font-semibold text-gray-900 mb-2">
              {{ card.title }}
            </h3>
            <input
              v-else
              v-model="cards[index].title"
              @input="updateCards"
              type="text"
              class="w-full text-xl font-semibold mb-2 border-0 border-b border-gray-300 focus:border-[#005674] focus:ring-0 px-0"
              placeholder="Título"
            >
            
            <p v-if="!isEditing" class="text-gray-600">{{ card.description }}</p>
            <textarea
              v-else
              v-model="cards[index].description"
              @input="updateCards"
              rows="3"
              class="w-full text-gray-600 border-0 border-b border-gray-300 focus:border-[#005674] focus:ring-0 px-0 resize-none"
              placeholder="Descripción"
            ></textarea>
            
            <div v-if="isEditing" class="mt-4">
              <input
                v-model="cards[index].image"
                @input="updateCards"
                type="text"
                class="w-full text-sm border border-gray-300 rounded px-2 py-1"
                placeholder="URL de la imagen"
              >
            </div>
          </div>
        </div>
      </div>
      
      <!-- Editor Controls -->
      <div v-if="isEditing" class="mt-8 flex gap-4">
        <button 
          @click="addCard"
          class="px-4 py-2 bg-[#005674] text-white rounded-lg hover:bg-[#003C5F] flex items-center gap-2"
        >
          <Plus class="w-4 h-4" />
          Agregar Card
        </button>
        <button 
          v-if="cards.length > 1"
          @click="removeCard(cards.length - 1)"
          class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center gap-2"
        >
          <Minus class="w-4 h-4" />
          Eliminar último
        </button>
        <select
          v-model="editableContent.columns"
          @change="updateCards"
          class="px-3 py-2 border border-gray-300 rounded-lg"
        >
          <option :value="2">2 columnas</option>
          <option :value="3">3 columnas</option>
          <option :value="4">4 columnas</option>
        </select>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Plus, Minus } from 'lucide-vue-next';

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
  columns: props.section.content?.columns || 3,
  items: props.section.content?.items || [
    { title: 'Card 1', description: 'Descripción', image: '' },
    { title: 'Card 2', description: 'Descripción', image: '' },
    { title: 'Card 3', description: 'Descripción', image: '' }
  ]
});

const cards = ref([...editableContent.value.items]);

watch(() => props.section, (newSection) => {
  editableContent.value = {
    columns: newSection.content?.columns || 3,
    items: newSection.content?.items || []
  };
  cards.value = [...editableContent.value.items];
}, { deep: true });

const updateCards = () => {
  emit('update', {
    content: {
      columns: editableContent.value.columns,
      items: [...cards.value]
    }
  });
};

const addCard = () => {
  cards.value.push({ title: `Card ${cards.value.length + 1}`, description: 'Descripción', image: '' });
  updateCards();
};

const removeCard = (index) => {
  cards.value.splice(index, 1);
  updateCards();
};
</script>
