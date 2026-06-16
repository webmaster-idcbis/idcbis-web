<template>
  <section 
    class="relative"
    :class="[
      section.styles?.padding || 'py-16',
      section.styles?.backgroundClass || ''
    ]"
    :style="getSectionStyles()"
  >
    <div :class="section.styles?.containerClass || 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8'">
      <!-- Título -->
      <div class="text-center mb-12">
        <h2 
          v-if="!isEditing"
          class="text-3xl md:text-4xl font-bold mb-4"
          :class="section.styles?.titleClass || 'text-gray-900'"
        >
          {{ section.content?.title || 'Lo que dicen nuestros clientes' }}
        </h2>
        <input
          v-else
          v-model="editableContent.title"
          @input="updateContent"
          type="text"
          class="w-full max-w-2xl mx-auto px-4 py-2 text-3xl font-bold text-center border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none"
          placeholder="Título de testimonios"
        >
      </div>
      
      <!-- Grid de testimonios -->
      <div 
        class="grid gap-8"
        :class="getGridClass()"
      >
        <div
          v-for="(item, index) in editableContent.items"
          :key="index"
          class="relative"
        >
          <!-- Card de testimonio -->
          <div 
            class="h-full p-6 rounded-2xl transition-all duration-300"
            :class="[
              section.styles?.cardClass || 'bg-white shadow-lg border border-gray-100',
              { 'hover:shadow-xl hover:-translate-y-1': !isEditing }
            ]"
          >
            <!-- Quote icon -->
            <Quote class="w-10 h-10 mb-4 opacity-20" :class="section.styles?.quoteIconClass || 'text-[#005674]'" />
            
            <!-- Testimonio texto -->
            <p 
              v-if="!isEditing"
              class="text-gray-600 mb-6 leading-relaxed italic"
              v-html="item.text || 'Testimonio de ejemplo...'"
            ></p>
            <textarea
              v-else
              v-model="item.text"
              @input="updateContent"
              rows="4"
              class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none resize-none text-gray-600 italic mb-4"
              placeholder="Escribe el testimonio..."
            ></textarea>
            
            <!-- Autor info -->
            <div class="flex items-center gap-4">
              <!-- Avatar -->
              <div 
                v-if="!isEditing && item.image"
                class="w-14 h-14 rounded-full overflow-hidden flex-shrink-0"
              >
                <img 
                  :src="item.image" 
                  :alt="item.author"
                  class="w-full h-full object-cover"
                  @error="$event.target.style.display='none'"
                >
              </div>
              <div 
                v-else-if="isEditing"
                class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0 border-2 border-dashed border-gray-300"
              >
                <ImageIcon class="w-6 h-6 text-gray-400" />
              </div>
              <div 
                v-else
                class="w-14 h-14 rounded-full bg-gradient-to-br from-[#005674] to-[#008996] flex items-center justify-center flex-shrink-0 text-white font-bold text-lg"
              >
                {{ getInitials(item.author || 'A') }}
              </div>
              
              <div class="flex-1 min-w-0">
                <h4 
                  v-if="!isEditing"
                  class="font-semibold text-gray-900"
                >
                  {{ item.author || 'Nombre del cliente' }}
                </h4>
                <input
                  v-else
                  v-model="item.author"
                  @input="updateContent"
                  type="text"
                  class="w-full px-2 py-1 border-2 border-gray-200 rounded focus:border-[#005674] focus:outline-none font-semibold"
                  placeholder="Nombre"
                >
                
                <p 
                  v-if="!isEditing && item.role"
                  class="text-sm text-gray-500"
                >
                  {{ item.role }}
                </p>
                <input
                  v-else-if="isEditing"
                  v-model="item.role"
                  @input="updateContent"
                  type="text"
                  class="w-full px-2 py-1 border-2 border-gray-200 rounded focus:border-[#005674] focus:outline-none text-sm mt-1"
                  placeholder="Cargo o empresa"
                >
              </div>
            </div>
            
            <!-- URL de imagen (solo edición) -->
            <div v-if="isEditing" class="mt-4 pt-4 border-t border-gray-100">
              <div class="flex items-center gap-2">
                <input
                  v-model="item.image"
                  @input="updateContent"
                  type="url"
                  class="flex-1 px-3 py-1.5 text-sm border-2 border-gray-200 rounded focus:border-[#005674] focus:outline-none"
                  placeholder="URL de imagen de perfil (opcional)"
                >
                <button
                  @click="item.image = ''; updateContent()"
                  v-if="item.image"
                  class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded"
                  title="Eliminar imagen"
                >
                  <X class="w-4 h-4" />
                </button>
              </div>
            </div>
            
            <!-- Controles de edición -->
            <div v-if="isEditing" class="absolute -top-2 -right-2 flex gap-1">
              <button
                @click="moveItem(index, -1)"
                :disabled="index === 0"
                class="p-1.5 bg-white rounded-full shadow-md text-gray-400 hover:text-gray-600 disabled:opacity-30 transition-all"
                title="Mover izquierda"
              >
                <ChevronLeft class="w-4 h-4" />
              </button>
              <button
                @click="moveItem(index, 1)"
                :disabled="index === editableContent.items.length - 1"
                class="p-1.5 bg-white rounded-full shadow-md text-gray-400 hover:text-gray-600 disabled:opacity-30 transition-all"
                title="Mover derecha"
              >
                <ChevronRight class="w-4 h-4" />
              </button>
              <button
                @click="removeItem(index)"
                class="p-1.5 bg-white rounded-full shadow-md text-red-400 hover:text-red-600 hover:bg-red-50 transition-all"
                title="Eliminar testimonio"
              >
                <Trash2 class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Botón agregar (modo edición) -->
      <div v-if="isEditing" class="mt-8 text-center">
        <button
          @click="addItem"
          class="inline-flex items-center gap-2 px-6 py-3 bg-[#005674] text-white rounded-lg hover:bg-[#003C5F] transition-colors"
        >
          <Plus class="w-5 h-5" />
          Agregar testimonio
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Quote, ImageIcon, X, ChevronLeft, ChevronRight, Trash2, Plus } from 'lucide-vue-next';

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
  title: props.section.content?.title || 'Lo que dicen nuestros clientes',
  columns: props.section.content?.columns || 3,
  items: props.section.content?.items?.length > 0
    ? [...props.section.content.items]
    : [
        { 
          text: 'Excelente servicio, superó todas mis expectativas. El equipo fue muy profesional y atento.',
          author: 'María García',
          role: 'CEO, Empresa ABC',
          image: ''
        },
        { 
          text: 'Producto de alta calidad y un soporte técnico excepcional. Totalmente recomendado.',
          author: 'Carlos López',
          role: 'Director de Marketing',
          image: ''
        },
        { 
          text: 'La mejor decisión que tomamos fue trabajar con este equipo. Resultados garantizados.',
          author: 'Ana Martínez',
          role: 'Gerente de Operaciones',
          image: ''
        }
      ]
});

const sectionStyles = ref({
  backgroundColor: props.section.styles?.backgroundColor || '',
  padding: props.section.styles?.padding || 'py-16',
  containerClass: props.section.styles?.containerClass || 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8',
  titleClass: props.section.styles?.titleClass || 'text-gray-900',
  cardClass: props.section.styles?.cardClass || 'bg-white shadow-lg border border-gray-100',
  quoteIconClass: props.section.styles?.quoteIconClass || 'text-[#005674]'
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    title: newSection.content?.title || 'Lo que dicen nuestros clientes',
    columns: newSection.content?.columns || 3,
    items: newSection.content?.items?.length > 0
      ? [...newSection.content.items]
      : editableContent.value.items
  };
  sectionStyles.value = {
    backgroundColor: newSection.styles?.backgroundColor || '',
    padding: newSection.styles?.padding || 'py-16',
    containerClass: newSection.styles?.containerClass || 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8',
    titleClass: newSection.styles?.titleClass || 'text-gray-900',
    cardClass: newSection.styles?.cardClass || 'bg-white shadow-lg border border-gray-100',
    quoteIconClass: newSection.styles?.quoteIconClass || 'text-[#005674]'
  };
}, { deep: true });

const getSectionStyles = () => {
  const styles = {};
  
  if (sectionStyles.value.backgroundColor) {
    styles.backgroundColor = sectionStyles.value.backgroundColor;
  }
  
  return styles;
};

const getGridClass = () => {
  const columns = editableContent.value.columns || 3;
  const gridClasses = {
    1: 'grid-cols-1',
    2: 'grid-cols-1 md:grid-cols-2',
    3: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    4: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4'
  };
  return gridClasses[columns] || gridClasses[3];
};

const getInitials = (name) => {
  return name
    .split(' ')
    .map(n => n[0])
    .join('')
    .substring(0, 2)
    .toUpperCase();
};

const updateContent = () => {
  emit('update', {
    content: { ...editableContent.value },
    styles: { ...sectionStyles.value }
  });
};

const addItem = () => {
  editableContent.value.items.push({
    text: '',
    author: '',
    role: '',
    image: ''
  });
  updateContent();
};

const removeItem = (index) => {
  if (confirm('¿Eliminar este testimonio?')) {
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
