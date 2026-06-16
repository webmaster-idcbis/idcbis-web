<template>
  <section 
    class="relative"
    :class="className"
    :style="sectionStyles"
  >
    <!-- Overlay -->
    <div 
      v-if="overlayOpacity > 0"
      class="absolute inset-0 pointer-events-none"
      :style="{ backgroundColor: `rgba(0,0,0,${overlayOpacity / 100})` }"
    ></div>
    
    <div 
      class="relative max-w-7xl mx-auto"
      :class="containerPadding"
    >
      <!-- Título de sección -->
      <div v-if="section.content?.title || isEditing" class="text-center mb-12">
        <h2 
          v-if="!isEditing"
          class="text-3xl md:text-4xl font-bold mb-4"
          :style="{ color: section.styles?.titleColor || '#005674' }"
        >
          {{ section.content?.title }}
        </h2>
        <input
          v-else
          v-model="editableContent.title"
          @input="updateCards"
          type="text"
          class="w-full max-w-2xl mx-auto px-4 py-2 text-3xl font-bold text-center border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none"
          placeholder="Título de la sección (opcional)"
        >
        
        <p 
          v-if="!isEditing && section.content?.subtitle"
          class="text-lg md:text-xl max-w-3xl mx-auto"
          :style="{ color: section.styles?.subtitleColor || '#4B5563' }"
        >
          {{ section.content?.subtitle }}
        </p>
        <input
          v-else-if="isEditing"
          v-model="editableContent.subtitle"
          @input="updateCards"
          type="text"
          class="w-full max-w-2xl mx-auto px-4 py-2 text-lg text-center border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none mt-4"
          placeholder="Subtítulo opcional"
        >
      </div>

      <div 
        :class="[
          'grid gap-8',
          gridClass
        ]"
      >
        <div 
          v-for="(card, index) in cards" 
          :key="index"
          class="group relative overflow-hidden cursor-pointer"
          :class="getCardClass(card)"
          :style="getCardStyle(card)"
          @click="!isEditing && card.link ? openLink(card.link) : null"
        >
          <!-- Imagen de fondo -->
          <div 
            v-if="card.backgroundImage"
            class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
            :style="{ 
              backgroundImage: `url(${card.backgroundImage})`,
              backgroundColor: card.backgroundColor || 'transparent'
            }"
          ></div>
          
          <!-- Overlay gradiente para imagen de fondo -->
          <div 
            v-if="card.backgroundImage"
            class="absolute inset-0 transition-opacity duration-300"
            :style="{ 
              background: card.overlayGradient || 'linear-gradient(135deg, rgba(0,86,116,0.9) 0%, rgba(0,137,150,0.8) 100%)',
              opacity: card.overlayOpacity !== undefined ? card.overlayOpacity : 0.9
            }"
          ></div>

          <!-- Contenido de la tarjeta -->
          <div class="relative z-10 p-6 md:p-8 h-full flex flex-col">
            <!-- Tag -->
            <div v-if="card.tag || isEditing" class="mb-4">
              <span 
                v-if="!isEditing && card.tag"
                class="inline-block px-3 py-1 text-xs font-bold tracking-wider rounded-full"
                :style="{ 
                  backgroundColor: card.tagBgColor || '#FFFFFF',
                  color: card.tagColor || '#005674'
                }"
              >
                {{ card.tag }}
              </span>
              <input
                v-else-if="isEditing"
                v-model="cards[index].tag"
                @input="updateCards"
                type="text"
                class="w-full px-3 py-1 text-sm border border-gray-200 rounded-full"
                placeholder="#TAG"
              >
            </div>

            <!-- Título -->
            <h3 
              v-if="!isEditing" 
              class="text-xl md:text-2xl font-bold mb-3"
              :style="{ color: card.titleColor || (card.backgroundImage ? '#FFFFFF' : '#111827') }"
            >
              {{ card.title }}
            </h3>
            <input
              v-else
              v-model="cards[index].title"
              @input="updateCards"
              type="text"
              class="w-full text-xl font-bold mb-3 border-0 border-b-2 border-gray-200 focus:border-[#005674] focus:outline-none px-0 bg-transparent"
              placeholder="Título"
            >
            
            <!-- Descripción -->
            <p 
              v-if="!isEditing" 
              class="flex-grow"
              :style="{ 
                color: card.descriptionColor || (card.backgroundImage ? 'rgba(255,255,255,0.9)' : '#4B5563'),
                fontSize: '0.95rem'
              }"
            >
              {{ card.description }}
            </p>
            <textarea
              v-else
              v-model="cards[index].description"
              @input="updateCards"
              rows="2"
              class="w-full border-0 border-b-2 border-gray-200 focus:border-[#005674] focus:outline-none px-0 bg-transparent resize-none"
              placeholder="Descripción"
            ></textarea>

            <!-- Link (solo edición) -->
            <div v-if="isEditing" class="mt-4 space-y-2">
              <input
                v-model="cards[index].link"
                @input="updateCards"
                type="text"
                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg"
                placeholder="URL del enlace (opcional)"
              >
              <input
                v-model="cards[index].backgroundImage"
                @input="updateCards"
                type="text"
                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg"
                placeholder="URL imagen de fondo (opcional)"
              >
              <div class="flex gap-2">
                <input
                  v-model="cards[index].backgroundColor"
                  @input="updateCards"
                  type="color"
                  class="w-10 h-8 rounded cursor-pointer"
                  title="Color de fondo"
                >
                <input
                  v-model="cards[index].borderRadius"
                  @input="updateCards"
                  type="text"
                  class="flex-1 px-3 py-1 text-sm border border-gray-200 rounded-lg"
                  placeholder="Border radius (ej: 40px 20px 40px 20px)"
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Editor Controls -->
      <div v-if="isEditing" class="mt-8 flex flex-wrap gap-4">
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
          <option :value="6">6 columnas</option>
        </select>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { Plus, Minus } from 'lucide-vue-next';
import { useSectionStyles } from '../../composables/useSectionStyles';

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

// Usar composable para estilos
const { sectionStyles, containerPadding, overlayOpacity, className } = useSectionStyles(props);

const editableContent = ref({
  title: props.section.content?.title || '',
  subtitle: props.section.content?.subtitle || '',
  columns: props.section.content?.columns || 3,
  items: props.section.content?.items || [
    { 
      title: 'Investigación Científica', 
      description: 'Publicaciones en revistas indexadas', 
      image: '',
      backgroundImage: '',
      backgroundColor: '#F0F9FF',
      borderRadius: '40px 20px 40px 20px',
      tag: '#INVESTIGACIÓN',
      tagBgColor: '#005674',
      tagColor: '#FFFFFF'
    },
    { 
      title: 'Banco de Sangre', 
      description: 'Donación y procesamiento de sangre', 
      image: '',
      backgroundImage: '',
      backgroundColor: '#FEF3C7',
      borderRadius: '20px 40px 20px 40px',
      tag: '#DONACIÓN',
      tagBgColor: '#F59E0B',
      tagColor: '#FFFFFF'
    },
    { 
      title: 'Tejidos', 
      description: 'Banco de tejidos para trasplantes', 
      image: '',
      backgroundImage: '',
      backgroundColor: '#FDF2F8',
      borderRadius: '40px 20px 40px 20px',
      tag: '#TRASPLANTES',
      tagBgColor: '#EC4899',
      tagColor: '#FFFFFF'
    }
  ]
});

const cards = ref([...editableContent.value.items]);

const gridClass = computed(() => {
  const cols = editableContent.value.columns || 3;
  const classes = {
    2: 'grid-cols-1 md:grid-cols-2',
    3: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    4: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
    6: 'grid-cols-2 md:grid-cols-3 lg:grid-cols-6'
  };
  return classes[cols] || classes[3];
});

const getCardClass = (card) => {
  const classes = ['transition-all', 'duration-300'];
  if (!card.backgroundImage) {
    classes.push('shadow-md', 'hover:shadow-xl');
  }
  return classes.join(' ');
};

const getCardStyle = (card) => {
  const style = {};
  
  // Border radius orgánico
  if (card.borderRadius) {
    style.borderRadius = card.borderRadius;
  } else {
    style.borderRadius = '40px 20px 40px 20px';
  }
  
  // Color de fondo (solo si no hay imagen de fondo)
  if (!card.backgroundImage && card.backgroundColor) {
    style.backgroundColor = card.backgroundColor;
  }
  
  // Transform hover para efecto IDCBIS
  style.transform = 'rotate(-1deg)';
  
  return style;
};

const openLink = (link) => {
  if (link) {
    window.open(link, '_blank');
  }
};

watch(() => props.section, (newSection) => {
  editableContent.value = {
    title: newSection.content?.title || '',
    subtitle: newSection.content?.subtitle || '',
    columns: newSection.content?.columns || 3,
    items: newSection.content?.items?.length > 0
      ? [...newSection.content.items]
      : editableContent.value.items
  };
  cards.value = [...editableContent.value.items];
}, { deep: true });

const updateCards = () => {
  emit('update', {
    content: {
      title: editableContent.value.title,
      subtitle: editableContent.value.subtitle,
      columns: editableContent.value.columns,
      items: [...cards.value]
    }
  });
};

const addCard = () => {
  cards.value.push({ 
    title: `Card ${cards.value.length + 1}`, 
    description: 'Descripción de la tarjeta',
    image: '',
    backgroundImage: '',
    backgroundColor: '#F0F9FF',
    borderRadius: '40px 20px 40px 20px',
    tag: ''
  });
  updateCards();
};

const removeCard = (index) => {
  cards.value.splice(index, 1);
  updateCards();
};
</script>

<style scoped>
.group:hover {
  transform: rotate(0deg) scale(1.02) !important;
}
</style>
