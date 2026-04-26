<template>
  <section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div 
          v-for="(image, index) in images" 
          :key="index"
          class="relative aspect-square group overflow-hidden rounded-lg"
        >
          <img 
            :src="image.src" 
            :alt="image.alt"
            class="w-full h-full object-cover transition-transform group-hover:scale-110"
          >
          
          <button 
            v-if="isEditing"
            @click="removeImage(index)"
            class="absolute top-2 right-2 p-1 bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
          >
            <X class="w-4 h-4" />
          </button>
        </div>
      </div>
      
      <!-- Editor Controls -->
      <div v-if="isEditing" class="mt-8">
        <div class="flex gap-2 mb-4">
          <input
            v-model="newImageUrl"
            type="text"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
            placeholder="URL de la imagen"
            @keyup.enter="addImage"
          >
          <button 
            @click="addImage"
            class="px-4 py-2 bg-[#005674] text-white rounded-lg hover:bg-[#003C5F] flex items-center gap-2"
          >
            <Plus class="w-4 h-4" />
            Agregar
          </button>
        </div>
        
        <div v-if="images.length > 0" class="space-y-2">
          <div 
            v-for="(image, index) in images" 
            :key="`input-${index}`"
            class="flex gap-2 items-center"
          >
            <input
              v-model="images[index].src"
              @input="updateImages"
              type="text"
              class="flex-1 px-3 py-1.5 text-sm border border-gray-300 rounded"
              placeholder="URL"
            >
            <input
              v-model="images[index].alt"
              @input="updateImages"
              type="text"
              class="w-48 px-3 py-1.5 text-sm border border-gray-300 rounded"
              placeholder="Alt text"
            >
            <button 
              @click="removeImage(index)"
              class="p-1.5 text-red-600 hover:bg-red-50 rounded"
            >
              <Trash2 class="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>
      
      <div v-if="images.length === 0 && !isEditing" class="text-center py-12 text-gray-400">
        <Images class="w-12 h-12 mx-auto mb-4" />
        <p>Galería vacía</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Plus, X, Trash2, Images } from 'lucide-vue-next';

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

const images = ref(props.section.content?.images || []);
const newImageUrl = ref('');

watch(() => props.section, (newSection) => {
  images.value = newSection.content?.images || [];
}, { deep: true });

const updateImages = () => {
  emit('update', {
    content: { images: [...images.value] }
  });
};

const addImage = () => {
  if (!newImageUrl.value.trim()) return;
  images.value.push({
    src: newImageUrl.value,
    alt: ''
  });
  newImageUrl.value = '';
  updateImages();
};

const removeImage = (index) => {
  images.value.splice(index, 1);
  updateImages();
};
</script>
