<template>
  <section class="py-8 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <a 
        v-if="!isEditing"
        :href="section.content?.link || '#'"
        :class="[
          'inline-block px-8 py-3 rounded-lg font-semibold transition-colors',
          buttonStyles[section.content?.style || 'primary']
        ]"
      >
        {{ section.content?.text || 'Click aquí' }}
      </a>
      
      <div v-else class="space-y-4">
        <input
          v-model="editableContent.text"
          @input="updateContent"
          type="text"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] text-center"
          placeholder="Texto del botón"
        >
        <input
          v-model="editableContent.link"
          @input="updateContent"
          type="text"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] text-center block mx-auto"
          placeholder="URL del enlace"
        >
        <div class="flex justify-center gap-2 flex-wrap">
          <button
            v-for="style in ['primary', 'secondary', 'outline']"
            :key="style"
            @click="setStyle(style)"
            :class="[
              'px-4 py-2 rounded-lg font-medium text-sm capitalize',
              editableContent.style === style ? 'ring-2 ring-offset-2 ring-[#005674]' : ''
            ]"
            :style="{ backgroundColor: style === 'primary' ? '#005674' : style === 'secondary' ? '#008996' : 'transparent' }"
          >
            {{ style }}
          </button>
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

const buttonStyles = {
  primary: 'bg-[#005674] text-white hover:bg-[#003C5F]',
  secondary: 'bg-[#008996] text-white hover:bg-[#007a86]',
  outline: 'border-2 border-[#005674] text-[#005674] hover:bg-[#005674] hover:text-white'
};

const editableContent = ref({
  text: props.section.content?.text || 'Click aquí',
  link: props.section.content?.link || '#',
  style: props.section.content?.style || 'primary'
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    text: newSection.content?.text || 'Click aquí',
    link: newSection.content?.link || '#',
    style: newSection.content?.style || 'primary'
  };
}, { deep: true });

const setStyle = (style) => {
  editableContent.value.style = style;
  updateContent();
};

const updateContent = () => {
  emit('update', {
    content: { ...editableContent.value }
  });
};
</script>
