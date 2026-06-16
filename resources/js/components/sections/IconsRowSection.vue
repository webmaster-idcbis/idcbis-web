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
      <!-- Título -->
      <div v-if="section.content?.title || isEditing" class="text-center mb-12">
        <h2 
          v-if="!isEditing"
          class="text-3xl md:text-4xl font-bold mb-4"
          :style="{ color: section.styles?.titleColor || 'inherit' }"
        >
          {{ section.content?.title }}
        </h2>
        <input
          v-else
          v-model="editableContent.title"
          @input="updateContent"
          type="text"
          class="w-full max-w-2xl mx-auto px-4 py-2 text-3xl font-bold text-center border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none"
          placeholder="Título de la sección"
        >
        
        <p 
          v-if="!isEditing && section.content?.subtitle"
          class="text-lg md:text-xl opacity-80 max-w-3xl mx-auto"
          :style="{ color: section.styles?.subtitleColor || 'inherit' }"
        >
          {{ section.content?.subtitle }}
        </p>
        <input
          v-else-if="isEditing"
          v-model="editableContent.subtitle"
          @input="updateContent"
          type="text"
          class="w-full max-w-2xl mx-auto px-4 py-2 text-lg text-center border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none mt-4"
          placeholder="Subtítulo opcional"
        >
      </div>

      <!-- Grid de íconos -->
      <div 
        :class="[
          'grid gap-6 md:gap-8',
          gridClass
        ]"
      >
        <div 
          v-for="(item, index) in items" 
          :key="index"
          class="group"
        >
          <!-- Vista pública -->
          <div v-if="!isEditing" class="text-center">
            <div 
              class="w-20 h-20 md:w-24 md:h-24 mx-auto mb-4 rounded-full flex items-center justify-center transition-transform group-hover:scale-110"
              :class="item.iconBg || 'bg-[#005674]/10'"
            >
              <component 
                :is="getIcon(item.icon)" 
                class="w-10 h-10 md:w-12 md:h-12"
                :class="item.iconColor || 'text-[#005674]'"
              />
            </div>
            <h3 
              class="text-lg md:text-xl font-semibold mb-2"
              :class="item.titleClass || 'text-gray-900'"
            >
              {{ item.title }}
            </h3>
            <p 
              v-if="item.description"
              class="text-sm md:text-base opacity-70"
              :class="item.descriptionClass || 'text-gray-600'"
            >
              {{ item.description }}
            </p>
          </div>

          <!-- Vista edición -->
          <div v-else class="bg-white rounded-xl p-4 border-2 border-gray-200 space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-500">Ítem {{ index + 1 }}</span>
              <div class="flex items-center gap-1">
                <button
                  @click="moveItem(index, -1)"
                  :disabled="index === 0"
                  class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30"
                  title="Mover izquierda"
                >
                  <ChevronLeft class="w-4 h-4" />
                </button>
                <button
                  @click="moveItem(index, 1)"
                  :disabled="index === items.length - 1"
                  class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30"
                  title="Mover derecha"
                >
                  <ChevronRight class="w-4 h-4" />
                </button>
                <button
                  @click="removeItem(index)"
                  class="p-1 text-red-400 hover:text-red-600"
                  title="Eliminar"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </div>

            <div class="flex items-center gap-2">
              <select
                v-model="item.icon"
                @change="updateContent"
                class="flex-1 px-2 py-1 text-sm border border-gray-200 rounded"
              >
                <option value="microscope">Microscopio</option>
                <option value="droplet">Gota/Sangre</option>
                <option value="heart">Corazón</option>
                <option value="dna">ADN</option>
                <option value="flask">Frasco</option>
                <option value="shield">Escudo</option>
                <option value="activity">Actividad</option>
                <option value="users">Usuarios</option>
                <option value="clipboard">Portapapeles</option>
                <option value="book-open">Libro</option>
              </select>
            </div>

            <input
              v-model="item.title"
              @input="updateContent"
              type="text"
              class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none font-semibold"
              placeholder="Título"
            >
            
            <textarea
              v-model="item.description"
              @input="updateContent"
              rows="2"
              class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none resize-none text-sm"
              placeholder="Descripción opcional"
            ></textarea>
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
          Agregar ítem
        </button>
        
        <div class="mt-4 flex items-center justify-center gap-2">
          <label class="text-sm text-gray-600">Columnas:</label>
          <select
            v-model="editableContent.columns"
            @change="updateContent"
            class="px-3 py-1 border border-gray-200 rounded"
          >
            <option :value="2">2</option>
            <option :value="3">3</option>
            <option :value="4">4</option>
            <option :value="5">5</option>
            <option :value="6">6</option>
            <option :value="8">8</option>
          </select>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { 
  Microscope, Droplets, Heart, Dna, FlaskConical, Shield, Activity, Users, ClipboardList, BookOpen,
  ChevronLeft, ChevronRight, Trash2, Plus 
} from 'lucide-vue-next';
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

const iconMap = {
  microscope: Microscope,
  droplet: Droplets,
  heart: Heart,
  dna: Dna,
  flask: FlaskConical,
  shield: Shield,
  activity: Activity,
  users: Users,
  clipboard: ClipboardList,
  'book-open': BookOpen
};

const getIcon = (name) => iconMap[name] || Microscope;

const editableContent = ref({
  title: props.section.content?.title || 'Nuestros Servicios',
  subtitle: props.section.content?.subtitle || '',
  columns: props.section.content?.columns || 4,
  items: props.section.content?.items?.length > 0
    ? [...props.section.content.items]
    : [
        { icon: 'microscope', title: 'Investigación', description: 'Ciencia y biotecnología' },
        { icon: 'droplet', title: 'Sangre', description: 'Banco de sangre distrital' },
        { icon: 'heart', title: 'Tejidos', description: 'Banco de tejidos' },
        { icon: 'dna', title: 'Avanzadas', description: 'Tecnología de punta' }
      ]
});

const items = computed(() => editableContent.value.items);

const gridClass = computed(() => {
  const cols = editableContent.value.columns || 4;
  const gridClasses = {
    2: 'grid-cols-2',
    3: 'grid-cols-2 md:grid-cols-3',
    4: 'grid-cols-2 md:grid-cols-4',
    5: 'grid-cols-2 md:grid-cols-3 lg:grid-cols-5',
    6: 'grid-cols-2 md:grid-cols-3 lg:grid-cols-6',
    8: 'grid-cols-2 md:grid-cols-4 lg:grid-cols-8'
  };
  return gridClasses[cols] || gridClasses[4];
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    title: newSection.content?.title || 'Nuestros Servicios',
    subtitle: newSection.content?.subtitle || '',
    columns: newSection.content?.columns || 4,
    items: newSection.content?.items?.length > 0
      ? [...newSection.content.items]
      : editableContent.value.items
  };
}, { deep: true });

const updateContent = () => {
  emit('update', {
    content: { ...editableContent.value }
  });
};

const addItem = () => {
  editableContent.value.items.push({
    icon: 'microscope',
    title: 'Nuevo servicio',
    description: 'Descripción del servicio'
  });
  updateContent();
};

const removeItem = (index) => {
  if (confirm('¿Eliminar este ítem?')) {
    editableContent.value.items.splice(index, 1);
    updateContent();
  }
};

const moveItem = (index, direction) => {
  const newIndex = index + direction;
  if (newIndex < 0 || newIndex >= items.value.length) return;
  
  const temp = editableContent.value.items[index];
  editableContent.value.items.splice(index, 1);
  editableContent.value.items.splice(newIndex, 0, temp);
  updateContent();
};
</script>
