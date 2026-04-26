<template>
  <section 
    class="relative py-20 bg-cover bg-center"
    :style="{ backgroundImage: section.content?.backgroundImage ? `url(${section.content.backgroundImage})` : 'linear-gradient(to bottom right, #005674, #008996)' }"
  >
    <div class="absolute inset-0 bg-black/40" v-if="section.content?.backgroundImage"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h2 
          v-if="!isEditing"
          class="text-4xl md:text-5xl font-bold text-white mb-6"
        >
          {{ section.content?.title || 'Título Principal' }}
        </h2>
        <input
          v-else
          v-model="editableContent.title"
          @input="updateContent"
          type="text"
          class="w-full text-4xl md:text-5xl font-bold text-white mb-6 bg-transparent border-0 border-b-2 border-white/50 focus:border-white text-center placeholder-white/50"
          placeholder="Título Principal"
        >
        
        <p 
          v-if="!isEditing"
          class="text-xl text-white/90 max-w-3xl mx-auto"
        >
          {{ section.content?.subtitle || 'Subtítulo descriptivo' }}
        </p>
        <textarea
          v-else
          v-model="editableContent.subtitle"
          @input="updateContent"
          rows="2"
          class="w-full text-xl text-white/90 max-w-3xl mx-auto bg-transparent border-0 border-b-2 border-white/50 focus:border-white text-center placeholder-white/50 resize-none"
          placeholder="Subtítulo descriptivo"
        ></textarea>
        
        <div v-if="section.content?.ctaText || isEditing" class="mt-8">
          <a 
            v-if="!isEditing"
            :href="section.content?.ctaLink || '#'"
            class="inline-block px-6 py-3 bg-yellow-400 text-[#003C5F] font-semibold rounded-lg hover:bg-yellow-300 transition-colors"
          >
            {{ section.content?.ctaText }}
          </a>
          <div v-else class="flex gap-4 justify-center">
            <input
              v-model="editableContent.ctaText"
              @input="updateContent"
              type="text"
              class="px-4 py-2 bg-white/20 text-white rounded border-0 focus:ring-2 focus:ring-white/50"
              placeholder="Texto del botón"
            >
            <input
              v-model="editableContent.ctaLink"
              @input="updateContent"
              type="text"
              class="px-4 py-2 bg-white/20 text-white rounded border-0 focus:ring-2 focus:ring-white/50"
              placeholder="URL del enlace"
            >
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue';

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
  title: props.section.content?.title || 'Título Principal',
  subtitle: props.section.content?.subtitle || 'Subtítulo descriptivo',
  ctaText: props.section.content?.ctaText || '',
  ctaLink: props.section.content?.ctaLink || '#',
  backgroundImage: props.section.content?.backgroundImage || ''
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    title: newSection.content?.title || 'Título Principal',
    subtitle: newSection.content?.subtitle || 'Subtítulo descriptivo',
    ctaText: newSection.content?.ctaText || '',
    ctaLink: newSection.content?.ctaLink || '#',
    backgroundImage: newSection.content?.backgroundImage || ''
  };
}, { deep: true });

const updateContent = () => {
  emit('update', {
    content: { ...editableContent.value }
  });
};
</script>
