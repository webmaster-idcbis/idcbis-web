<template>
  <div class="h-screen flex flex-col">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-4 py-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
          <router-link to="/admin/pages" class="text-gray-600 hover:text-gray-900">
            <ArrowLeft class="w-5 h-5" />
          </router-link>
          <h1 class="text-xl font-semibold text-gray-900">
            {{ isEditing ? 'Editar Página' : 'Nueva Página' }}
          </h1>
        </div>
        
        <div class="flex items-center gap-3">
          <input 
            v-model="pageForm.slug"
            type="text" 
            placeholder="slug-url"
            class="px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-[#005674]"
          >
          <select 
            v-model="pageForm.status"
            class="px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-[#005674]"
          >
            <option value="draft">Borrador</option>
            <option value="published">Publicar</option>
          </select>
          <button 
            @click="toggleSidebar"
            class="px-3 py-2 text-gray-600 hover:bg-gray-100 rounded-lg flex items-center gap-2"
            :title="sidebarOpen ? 'Ocultar menú' : 'Mostrar menú'"
          >
            <PanelLeftClose v-if="sidebarOpen" class="w-4 h-4" />
            <PanelLeftOpen v-else class="w-4 h-4" />
          </button>
          <button 
            @click="savePage"
            :disabled="saving"
            class="px-4 py-2 bg-[#005674] text-white rounded-lg hover:bg-[#003C5F] disabled:opacity-50 flex items-center gap-2"
          >
            <Save v-if="!saving" class="w-4 h-4" />
            <span v-if="!saving">Guardar</span>
            <span v-else>Guardando...</span>
          </button>
        </div>
      </div>
      
      <div class="mt-3">
        <input 
          v-model="pageForm.title"
          type="text" 
          placeholder="Título de la página"
          class="w-full text-2xl font-bold border-0 border-b-2 border-transparent focus:border-[#005674] focus:ring-0 px-0"
        >
      </div>
      
      <!-- Error Message -->
      <div v-if="error" class="mt-2 p-2 bg-red-50 border border-red-200 rounded text-red-600 text-sm">
        {{ error }}
      </div>
    </div>

    <!-- Editor Content -->
    <div class="flex-1 flex overflow-hidden">
      <!-- Components Sidebar -->
      <aside v-if="sidebarOpen" class="w-72 bg-gray-50 border-r border-gray-200 flex flex-col">
        <div class="p-4 border-b border-gray-200 bg-white">
          <h2 class="font-semibold text-gray-900 text-lg">Componentes</h2>
          <p class="text-xs text-gray-500 mt-1">Arrastra componentes al canvas</p>
        </div>
        
        <div class="flex-1 overflow-y-auto p-3">
          <div class="grid grid-cols-1 gap-2">
            <div
              v-for="component in availableComponents"
              :key="component.type"
              draggable="true"
              @dragstart="handleDragStart($event, component)"
              class="flex items-center gap-3 p-3 bg-white rounded-lg shadow-sm border-2 border-gray-200 cursor-move hover:border-[#005674] hover:shadow-md transition-all group"
            >
              <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#005674] to-[#008996] flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                <component :is="component.icon" class="w-5 h-5" />
              </div>
              <div>
                <span class="text-sm font-semibold text-gray-800 block">{{ component.name }}</span>
                <span class="text-xs text-gray-500">{{ component.description }}</span>
              </div>
            </div>
          </div>
        </div>
      </aside>

      <!-- Canvas -->
      <main class="flex-1 bg-gray-100 overflow-y-auto">
        <div class="max-w-5xl mx-auto p-6 min-h-full">
          <div 
            ref="dropZone"
            class="bg-white rounded-xl shadow-sm min-h-[700px] p-6 transition-all"
            :class="{ 'ring-2 ring-[#005674] ring-opacity-50': isDragging }"
            @dragover.prevent="handleDragOver"
            @dragleave="handleDragLeave"
            @drop="handleDrop($event)"
          >
            <div v-if="sections.length === 0" class="text-center py-32 text-gray-400 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50">
              <LayoutTemplate class="w-16 h-16 mx-auto mb-4 text-gray-300" />
              <p class="text-lg font-medium text-gray-500">Arrastra componentes aquí</p>
              <p class="text-sm text-gray-400 mt-2">Para construir tu página</p>
            </div>
            
            <div v-else class="space-y-4">
              <div
                v-for="(section, index) in sections"
                :key="section.id"
                class="relative group border-2 border-transparent hover:border-[#005674] rounded-lg transition-all"
                :class="{ 'ring-2 ring-[#005674] bg-blue-50': selectedSection === index }"
              >
                <!-- Section Controls -->
                <div class="absolute -left-12 top-2 flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition-all z-10">
                  <button 
                    @click="moveSection(index, -1)"
                    :disabled="index === 0"
                    class="p-2 bg-white rounded-lg shadow-md hover:bg-gray-50 disabled:opacity-30 border border-gray-200 transition-all"
                    title="Mover arriba"
                  >
                    <ChevronUp class="w-4 h-4 text-gray-600" />
                  </button>
                  <button 
                    @click="moveSection(index, 1)"
                    :disabled="index === sections.length - 1"
                    class="p-2 bg-white rounded-lg shadow-md hover:bg-gray-50 disabled:opacity-30 border border-gray-200 transition-all"
                    title="Mover abajo"
                  >
                    <ChevronDown class="w-4 h-4 text-gray-600" />
                  </button>
                  <button 
                    @click="duplicateSection(index)"
                    class="p-2 bg-white rounded-lg shadow-md hover:bg-blue-50 border border-gray-200 transition-all"
                    title="Duplicar"
                  >
                    <Copy class="w-4 h-4 text-blue-600" />
                  </button>
                  <button 
                    @click="removeSection(index)"
                    class="p-2 bg-white rounded-lg shadow-md hover:bg-red-50 border border-gray-200 transition-all"
                    title="Eliminar"
                  >
                    <Trash2 class="w-4 h-4 text-red-500" />
                  </button>
                </div>
                
                <!-- Section Label -->
                <div class="absolute -top-3 left-4 bg-[#005674] text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">
                  {{ section.name }}
                </div>
                
                <!-- Section Content -->
                <div 
                  @click="selectSection(index)"
                  class="cursor-pointer p-2 rounded-lg"
                >
                  <component 
                    :is="getSectionComponent(section.type)"
                    :section="section"
                    :isEditing="true"
                    @update="updateSection(index, $event)"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

      <!-- Properties Panel -->
      <aside class="w-80 bg-white border-l border-gray-200 flex flex-col shadow-lg" v-if="selectedSection !== null">
        <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-[#005674] to-[#008996]">
          <h2 class="font-semibold text-white">Editar {{ sections[selectedSection]?.name }}</h2>
          <p class="text-xs text-white/80 mt-1">Tipo: {{ sections[selectedSection]?.type }}</p>
        </div>
        
        <div class="flex-1 overflow-y-auto p-4">
          <SectionProperties 
            :section="sections[selectedSection]"
            @update="updateSection(selectedSection, $event)"
          />
        </div>
        
        <div class="p-4 border-t border-gray-200 bg-gray-50">
          <button 
            @click="selectedSection = null"
            class="w-full py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
          >
            Cerrar panel
          </button>
        </div>
      </aside>
      
      <!-- Empty state when no section selected -->
      <aside v-else class="w-80 bg-gray-50 border-l border-gray-200 flex flex-col items-center justify-center p-6">
        <MousePointer class="w-12 h-12 text-gray-300 mb-3" />
        <p class="text-gray-500 text-center text-sm">Haz clic en una sección para editar sus propiedades</p>
      </aside>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, markRaw } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { 
  ArrowLeft, 
  Save, 
  ChevronUp, 
  ChevronDown, 
  X,
  Layout,
  Type,
  Image as ImageIcon,
  Grid3X3,
  LayoutTemplate,
  MousePointer,
  FileText,
  BarChart3,
  Users,
  Contact,
  Quote,
  Video,
  Table2,
  List,
  Star,
  PanelLeftClose,
  PanelLeftOpen
} from 'lucide-vue-next';
import { useCmsStore } from '../../stores/cms';

// Import section components
import HeroSection from '../../components/sections/HeroSection.vue';
import TextSection from '../../components/sections/TextSection.vue';
import CardsSection from '../../components/sections/CardsSection.vue';
import ImageSection from '../../components/sections/ImageSection.vue';
import GallerySection from '../../components/sections/GallerySection.vue';
import ButtonSection from '../../components/sections/ButtonSection.vue';
import FeaturesSection from '../../components/sections/FeaturesSection.vue';
import StatsSection from '../../components/sections/StatsSection.vue';
import TeamSection from '../../components/sections/TeamSection.vue';
import ContactSection from '../../components/sections/ContactSection.vue';
import SectionProperties from '../../components/editor/SectionProperties.vue';

const route = useRoute();
const router = useRouter();
const cmsStore = useCmsStore();

const isEditing = computed(() => !!route.params.id);
const saving = ref(false);
const selectedSection = ref(null);
const error = ref(null);

const sidebarOpen = ref(true);

const pageForm = ref({
  title: '',
  slug: '',
  status: 'draft',
  meta_description: ''
});

const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value;
};

const sections = ref([]);

const availableComponents = [
  { type: 'hero', name: 'Hero Section', icon: markRaw(LayoutTemplate), description: 'Banner principal con título y CTA' },
  { type: 'text', name: 'Bloque de Texto', icon: markRaw(Type), description: 'Contenido de texto enriquecido' },
  { type: 'cards', name: 'Tarjetas', icon: markRaw(Grid3X3), description: 'Grid de tarjetas con imagen y texto' },
  { type: 'image', name: 'Imagen', icon: markRaw(ImageIcon), description: 'Imagen individual con pie de foto' },
  { type: 'gallery', name: 'Galería', icon: markRaw(Layout), description: 'Galería de múltiples imágenes' },
  { type: 'button', name: 'Botón', icon: markRaw(MousePointer), description: 'Botón con enlace personalizable' },
  { type: 'features', name: 'Características', icon: markRaw(Star), description: 'Grid de características o servicios' },
  { type: 'quote', name: 'Cita', icon: markRaw(FileText), description: 'Bloque de cita o testimonio' },
  { type: 'stats', name: 'Estadísticas', icon: markRaw(BarChart3), description: 'Números y estadísticas destacados' },
  { type: 'team', name: 'Equipo', icon: markRaw(Users), description: 'Perfiles de miembros del equipo' },
  { type: 'contact', name: 'Contacto', icon: markRaw(Contact), description: 'Formulario de contacto' },
];

const sectionComponents = {
  hero: markRaw(HeroSection),
  text: markRaw(TextSection),
  cards: markRaw(CardsSection),
  image: markRaw(ImageSection),
  gallery: markRaw(GallerySection),
  button: markRaw(ButtonSection),
  features: markRaw(FeaturesSection),
  stats: markRaw(StatsSection),
  team: markRaw(TeamSection),
  contact: markRaw(ContactSection),
};

const getSectionComponent = (type) => {
  return sectionComponents[type] || 'div';
};

const isDragging = ref(false);

const handleDragStart = (event, component) => {
  event.dataTransfer.setData('component', JSON.stringify(component));
};

const handleDragOver = () => {
  isDragging.value = true;
};

const handleDragLeave = () => {
  isDragging.value = false;
};

const handleDrop = (event) => {
  const componentData = event.dataTransfer.getData('component');
  if (!componentData) return;
  
  const component = JSON.parse(componentData);
  const newSection = {
    id: Date.now(),
    type: component.type,
    name: component.name,
    content: getDefaultContent(component.type),
    settings: {},
    styles: {}
  };
  
  sections.value.push(newSection);
  selectedSection.value = sections.value.length - 1;
};

const getDefaultContent = (type) => {
  const defaults = {
    hero: {
      title: 'Título Principal',
      subtitle: 'Subtítulo descriptivo',
      backgroundImage: '',
      ctaText: 'Ver más',
      ctaLink: '#'
    },
    text: {
      content: '<p>Escribe tu contenido aquí...</p>',
      alignment: 'left'
    },
    cards: {
      columns: 3,
      items: [
        { title: 'Card 1', description: 'Descripción de la tarjeta 1', image: '', link: '#' },
        { title: 'Card 2', description: 'Descripción de la tarjeta 2', image: '', link: '#' },
        { title: 'Card 3', description: 'Descripción de la tarjeta 3', image: '', link: '#' }
      ]
    },
    image: {
      src: '',
      alt: 'Descripción de la imagen',
      caption: ''
    },
    gallery: {
      images: [
        { src: '', alt: 'Imagen 1' },
        { src: '', alt: 'Imagen 2' },
        { src: '', alt: 'Imagen 3' }
      ]
    },
    button: {
      text: 'Click aquí',
      link: '#',
      style: 'primary'
    },
    features: {
      columns: 3,
      items: [
        { title: 'Característica 1', description: 'Descripción de la característica', icon: 'star' },
        { title: 'Característica 2', description: 'Descripción de la característica', icon: 'star' },
        { title: 'Característica 3', description: 'Descripción de la característica', icon: 'star' }
      ]
    },
    quote: {
      content: 'Tu cita o testimonio aquí...',
      author: 'Autor',
      role: 'Cargo o empresa'
    },
    stats: {
      columns: 4,
      items: [
        { number: '100+', label: 'Proyectos completados' },
        { number: '50+', label: 'Clientes satisfechos' },
        { number: '10', label: 'Años de experiencia' },
        { number: '99%', label: 'Satisfacción' }
      ]
    },
    team: {
      columns: 3,
      items: [
        { name: 'Nombre 1', role: 'Cargo', image: '', bio: 'Breve descripción' },
        { name: 'Nombre 2', role: 'Cargo', image: '', bio: 'Breve descripción' },
        { name: 'Nombre 3', role: 'Cargo', image: '', bio: 'Breve descripción' }
      ]
    },
    contact: {
      title: 'Contáctanos',
      subtitle: 'Estamos aquí para ayudarte',
      email: 'contacto@ejemplo.com',
      phone: '+57 300 000 0000',
      address: 'Dirección de la oficina'
    }
  };
  return defaults[type] || {};
};

const selectSection = (index) => {
  selectedSection.value = index;
};

const updateSection = (index, data) => {
  sections.value[index] = { ...sections.value[index], ...data };
};

const moveSection = (index, direction) => {
  const newIndex = index + direction;
  if (newIndex < 0 || newIndex >= sections.value.length) return;
  
  const temp = sections.value[index];
  sections.value[index] = sections.value[newIndex];
  sections.value[newIndex] = temp;
  
  if (selectedSection.value === index) {
    selectedSection.value = newIndex;
  } else if (selectedSection.value === newIndex) {
    selectedSection.value = index;
  }
};

const removeSection = (index) => {
  sections.value.splice(index, 1);
  if (selectedSection.value === index) {
    selectedSection.value = null;
  } else if (selectedSection.value > index) {
    selectedSection.value--;
  }
};

const duplicateSection = (index) => {
  const sectionToClone = sections.value[index];
  const clonedSection = {
    ...sectionToClone,
    id: Date.now() + Math.random()
  };
  sections.value.splice(index + 1, 0, clonedSection);
};

const savePage = async () => {
  saving.value = true;
  error.value = null;
  
  try {
    // Validación básica
    if (!pageForm.value.title.trim()) {
      throw new Error('El título es obligatorio');
    }
    
    // Limpiar las secciones antes de enviar (remover propiedades internas de Vue)
    const cleanSections = sections.value.map(s => ({
      id: s.id,
      type: s.type,
      name: s.name,
      content: s.content
    }));
    
    const pageData = {
      title: pageForm.value.title,
      slug: pageForm.value.slug,
      status: pageForm.value.status,
      meta_description: pageForm.value.meta_description,
      sections: cleanSections
    };
    
    console.log('Enviando datos:', JSON.stringify(pageData, null, 2));
    
    let result;
    if (isEditing.value) {
      result = await cmsStore.updatePage(route.params.id, pageData);
    } else {
      result = await cmsStore.createPage(pageData);
    }
    
    console.log('Respuesta del servidor:', result);
    
    if (result) {
      router.push('/admin/pages');
    }
  } catch (err) {
    console.error('Error completo:', err);
    error.value = err.response?.data?.message || err.message || 'Error al guardar la página';
    alert(error.value);
  } finally {
    saving.value = false;
  }
};

onMounted(async () => {
  if (isEditing.value) {
    try {
      const page = await cmsStore.fetchPage(route.params.id);
      if (page) {
        pageForm.value = {
          title: page.title || '',
          slug: page.slug || '',
          status: page.status || 'draft',
          meta_description: page.meta_description || ''
        };
        // Asegurar que cada sección tenga un ID único
        sections.value = (page.sections || []).map(s => ({
          ...s,
          id: s.id || Date.now() + Math.random()
        }));
      }
    } catch (err) {
      error.value = 'Error al cargar la página';
      console.error(err);
    }
  }
});
</script>
