<template>
  <section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div 
        v-if="!isEditing"
        class="prose max-w-none"
        :class="`text-${section.content?.alignment || 'left'}`"
        v-html="renderedContent"
      ></div>
      <div v-else class="space-y-4">
        <div class="flex gap-2 mb-2">
          <button
            v-for="align in ['left', 'center', 'right']"
            :key="align"
            @click="setAlignment(align)"
            :class="[
              'p-2 rounded hover:bg-gray-100',
              editableContent.alignment === align ? 'bg-gray-200' : ''
            ]"
          >
            <AlignLeft v-if="align === 'left'" class="w-4 h-4" />
            <AlignCenter v-if="align === 'center'" class="w-4 h-4" />
            <AlignRight v-if="align === 'right'" class="w-4 h-4" />
          </button>
        </div>
        <textarea
          v-model="editableContent.content"
          @input="updateContent"
          rows="8"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] focus:border-transparent resize-y"
          placeholder="Escribe tu contenido aquí..."
        ></textarea>
        <p class="text-xs text-gray-500">Puedes usar HTML básico para formato</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { AlignLeft, AlignCenter, AlignRight } from 'lucide-vue-next';

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
  content: props.section.content?.content || 'Escribe tu contenido aquí...',
  alignment: props.section.content?.alignment || 'left'
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    content: newSection.content?.content || 'Escribe tu contenido aquí...',
    alignment: newSection.content?.alignment || 'left'
  };
}, { deep: true });

const renderedContent = computed(() => {
  return editableContent.value.content;
});

const setAlignment = (align) => {
  editableContent.value.alignment = align;
  updateContent();
};

const updateContent = () => {
  emit('update', {
    content: { ...editableContent.value }
  });
};
</script>
