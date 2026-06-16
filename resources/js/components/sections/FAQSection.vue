<template>
  <section 
    class="relative"
    :class="[
      section.styles?.padding || 'py-16',
      section.styles?.backgroundClass || ''
    ]"
    :style="getSectionStyles()"
  >
    <div :class="section.styles?.containerClass || 'max-w-3xl mx-auto px-4 sm:px-6 lg:px-8'">
      <!-- Título de la sección -->
      <div class="text-center mb-12">
        <h2 
          v-if="!isEditing"
          class="text-3xl font-bold mb-4"
          :class="section.styles?.titleClass || 'text-gray-900'"
        >
          {{ section.content?.title || 'Preguntas Frecuentes' }}
        </h2>
        <input
          v-else
          v-model="editableContent.title"
          @input="updateContent"
          type="text"
          class="w-full max-w-lg mx-auto px-4 py-2 text-3xl font-bold text-center border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none"
          placeholder="Preguntas Frecuentes"
        >
        
        <p 
          v-if="!isEditing && section.content?.subtitle"
          class="text-lg text-gray-600 mt-2"
        >
          {{ section.content.subtitle }}
        </p>
        <input
          v-else-if="isEditing"
          v-model="editableContent.subtitle"
          @input="updateContent"
          type="text"
          class="w-full max-w-lg mx-auto px-4 py-2 text-lg text-center border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none mt-4"
          placeholder="Subtítulo opcional"
        >
      </div>
      
      <!-- Lista de preguntas -->
      <div class="space-y-4">
        <div
          v-for="(item, index) in editableContent.items"
          :key="index"
          class="border-2 rounded-xl overflow-hidden transition-all duration-300"
          :class="[
            section.styles?.itemClass || 'border-gray-200 bg-white',
            { 'shadow-md': openIndex === index && !isEditing }
          ]"
        >
          <!-- Pregunta (header) -->
          <button
            v-if="!isEditing"
            @click="toggleItem(index)"
            class="w-full flex items-center justify-between p-5 text-left hover:bg-gray-50 transition-colors"
            :class="{ 'bg-gray-50': openIndex === index }"
          >
            <span 
              class="font-semibold text-lg pr-4"
              :class="section.styles?.questionClass || 'text-gray-900'"
            >
              {{ item.question || `Pregunta ${index + 1}` }}
            </span>
            <ChevronDown 
              class="w-6 h-6 flex-shrink-0 transition-transform duration-300"
              :class="[
                section.styles?.iconClass || 'text-gray-500',
                { 'rotate-180': openIndex === index }
              ]"
            />
          </button>
          
          <!-- Respuesta (collapsible) -->
          <div
            v-if="!isEditing"
            class="overflow-hidden transition-all duration-300"
            :style="{ maxHeight: openIndex === index ? '500px' : '0', opacity: openIndex === index ? 1 : 0 }"
          >
            <div 
              class="p-5 pt-0 text-gray-600 leading-relaxed"
              :class="section.styles?.answerClass || ''"
              v-html="item.answer || 'Respuesta pendiente...'"
            ></div>
          </div>
          
          <!-- Modo edición -->
          <div v-else class="p-4 space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Pregunta {{ index + 1 }}</span>
              <div class="flex items-center gap-2">
                <button
                  @click="moveItem(index, -1)"
                  :disabled="index === 0"
                  class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30"
                  title="Mover arriba"
                >
                  <ChevronUp class="w-4 h-4" />
                </button>
                <button
                  @click="moveItem(index, 1)"
                  :disabled="index === editableContent.items.length - 1"
                  class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30"
                  title="Mover abajo"
                >
                  <ChevronDown class="w-4 h-4" />
                </button>
                <button
                  @click="removeItem(index)"
                  class="p-1 text-red-400 hover:text-red-600"
                  title="Eliminar pregunta"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </div>
            
            <input
              v-model="item.question"
              @input="updateContent"
              type="text"
              class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none font-semibold"
              placeholder="Escribe la pregunta..."
            >
            
            <textarea
              v-model="item.answer"
              @input="updateContent"
              rows="3"
              class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none resize-none"
              placeholder="Escribe la respuesta... (puedes usar HTML básico)"
            ></textarea>
          </div>
        </div>
      </div>
      
      <!-- Botón agregar (modo edición) -->
      <div v-if="isEditing" class="mt-6 text-center">
        <button
          @click="addItem"
          class="inline-flex items-center gap-2 px-6 py-3 bg-[#005674] text-white rounded-lg hover:bg-[#003C5F] transition-colors"
        >
          <Plus class="w-5 h-5" />
          Agregar pregunta
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue';
import { ChevronDown, ChevronUp, Trash2, Plus } from 'lucide-vue-next';

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
  title: props.section.content?.title || 'Preguntas Frecuentes',
  subtitle: props.section.content?.subtitle || '',
  items: props.section.content?.items?.length > 0 
    ? [...props.section.content.items]
    : [
        { question: '¿Cuál es la pregunta más común?', answer: 'Esta es una respuesta de ejemplo. Puedes agregar tantas preguntas como necesites.' },
        { question: '¿Cómo puedo contactarlos?', answer: 'Puedes contactarnos a través de nuestro formulario de contacto o por correo electrónico.' }
      ]
});

const sectionStyles = ref({
  backgroundColor: props.section.styles?.backgroundColor || '',
  padding: props.section.styles?.padding || 'py-16',
  containerClass: props.section.styles?.containerClass || 'max-w-3xl mx-auto px-4 sm:px-6 lg:px-8',
  titleClass: props.section.styles?.titleClass || 'text-gray-900',
  itemClass: props.section.styles?.itemClass || 'border-gray-200 bg-white',
  questionClass: props.section.styles?.questionClass || 'text-gray-900',
  answerClass: props.section.styles?.answerClass || '',
  iconClass: props.section.styles?.iconClass || 'text-gray-500'
});

const openIndex = ref(null);

watch(() => props.section, (newSection) => {
  editableContent.value = {
    title: newSection.content?.title || 'Preguntas Frecuentes',
    subtitle: newSection.content?.subtitle || '',
    items: newSection.content?.items?.length > 0 
      ? [...newSection.content.items]
      : editableContent.value.items
  };
  sectionStyles.value = {
    backgroundColor: newSection.styles?.backgroundColor || '',
    padding: newSection.styles?.padding || 'py-16',
    containerClass: newSection.styles?.containerClass || 'max-w-3xl mx-auto px-4 sm:px-6 lg:px-8',
    titleClass: newSection.styles?.titleClass || 'text-gray-900',
    itemClass: newSection.styles?.itemClass || 'border-gray-200 bg-white',
    questionClass: newSection.styles?.questionClass || 'text-gray-900',
    answerClass: newSection.styles?.answerClass || '',
    iconClass: newSection.styles?.iconClass || 'text-gray-500'
  };
}, { deep: true });

const getSectionStyles = () => {
  const styles = {};
  
  if (sectionStyles.value.backgroundColor) {
    styles.backgroundColor = sectionStyles.value.backgroundColor;
  }
  
  return styles;
};

const toggleItem = (index) => {
  openIndex.value = openIndex.value === index ? null : index;
};

const updateContent = () => {
  emit('update', {
    content: { ...editableContent.value },
    styles: { ...sectionStyles.value }
  });
};

const addItem = () => {
  editableContent.value.items.push({
    question: '',
    answer: ''
  });
  updateContent();
};

const removeItem = (index) => {
  if (confirm('¿Eliminar esta pregunta?')) {
    editableContent.value.items.splice(index, 1);
    updateContent();
  }
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
