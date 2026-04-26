<template>
  <section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <figure class="text-center">
        <img 
          v-if="section.content?.src"
          :src="section.content.src" 
          :alt="section.content?.alt || ''"
          class="w-full h-auto rounded-lg shadow-md"
        >
        <div 
          v-else-if="!isEditing"
          class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400"
        >
          <ImageIcon class="w-12 h-12" />
          <span class="ml-2">Sin imagen</span>
        </div>
        
        <div v-if="isEditing" class="mt-4 space-y-3">
          <input
            v-model="editableContent.src"
            @input="updateContent"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
            placeholder="URL de la imagen"
          >
          <input
            v-model="editableContent.alt"
            @input="updateContent"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
            placeholder="Texto alternativo (alt)"
          >
          <input
            v-model="editableContent.caption"
            @input="updateContent"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
            placeholder="Pie de foto (opcional)"
          >
        </div>
        
        <figcaption 
          v-if="section.content?.caption && !isEditing"
          class="mt-3 text-sm text-gray-600 italic"
        >
          {{ section.content.caption }}
        </figcaption>
      </figure>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Image as ImageIcon } from 'lucide-vue-next';

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
  src: props.section.content?.src || '',
  alt: props.section.content?.alt || '',
  caption: props.section.content?.caption || ''
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    src: newSection.content?.src || '',
    alt: newSection.content?.alt || '',
    caption: newSection.content?.caption || ''
  };
}, { deep: true });

const updateContent = () => {
  emit('update', {
    content: { ...editableContent.value }
  });
};
</script>
