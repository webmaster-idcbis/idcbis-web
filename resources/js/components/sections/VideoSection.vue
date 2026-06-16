<template>
  <section 
    class="relative"
    :class="[
      section.styles?.padding || 'py-12',
      section.styles?.backgroundClass || ''
    ]"
    :style="getSectionStyles()"
  >
    <div :class="section.styles?.containerClass || 'max-w-4xl mx-auto px-4'">
      <!-- Título opcional -->
      <div v-if="section.content?.title || isEditing" class="mb-6 text-center">
        <h2 
          v-if="!isEditing && section.content?.title"
          class="text-2xl font-bold mb-2"
          :class="section.styles?.titleClass || 'text-gray-900'"
        >
          {{ section.content.title }}
        </h2>
        <input
          v-else-if="isEditing"
          v-model="editableContent.title"
          @input="updateContent"
          type="text"
          class="w-full max-w-lg mx-auto px-4 py-2 text-xl font-bold text-center border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none"
          placeholder="Título del video (opcional)"
        >
      </div>
      
      <!-- Contenedor del video -->
      <div 
        class="relative rounded-xl overflow-hidden shadow-lg"
        :class="[
          section.styles?.videoContainerClass || '',
          { 'bg-gray-100 flex items-center justify-center min-h-[300px]': !videoUrl && isEditing }
        ]"
        :style="getVideoContainerStyles()"
      >
        <!-- Video embebido -->
        <div v-if="videoUrl" class="aspect-video">
          <iframe
            v-if="videoType === 'youtube' || videoType === 'vimeo'"
            :src="embedUrl"
            class="w-full h-full"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
          ></iframe>
          
          <video
            v-else-if="videoType === 'direct'"
            :src="videoUrl"
            class="w-full h-full object-contain bg-black"
            controls
            playsinline
          ></video>
        </div>
        
        <!-- Placeholder cuando no hay video -->
        <div v-else-if="!isEditing" class="aspect-video bg-gray-100 flex items-center justify-center">
          <div class="text-center text-gray-400">
            <Video class="w-16 h-16 mx-auto mb-2" />
            <p>Video no disponible</p>
          </div>
        </div>
        
        <!-- Configuración en modo edición -->
        <div v-if="isEditing" class="p-6 bg-white">
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">URL del Video</label>
              <div class="flex gap-2">
                <input
                  v-model="editableContent.url"
                  @input="updateContent"
                  type="url"
                  class="flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none"
                  placeholder="https://youtube.com/watch?v=... o https://vimeo.com/... o URL directa"
                >
                <button
                  @click="pasteFromClipboard"
                  class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors"
                  title="Pegar desde portapapeles"
                >
                  <ClipboardPaste class="w-5 h-5" />
                </button>
              </div>
              <p class="text-xs text-gray-500 mt-1">
                Soporta: YouTube, Vimeo, o URL directa de video (.mp4, .webm, etc.)
              </p>
            </div>
            
            <!-- Preview del video detectado -->
            <div v-if="videoType && videoType !== 'unknown'" class="p-3 bg-green-50 border border-green-200 rounded-lg">
              <div class="flex items-center gap-2 text-green-700">
                <Check class="w-5 h-5" />
                <span class="text-sm font-medium">Video {{ videoType === 'youtube' ? 'de YouTube' : videoType === 'vimeo' ? 'de Vimeo' : 'directo' }} detectado</span>
              </div>
            </div>
            
            <div v-else-if="editableContent.url" class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
              <div class="flex items-center gap-2 text-yellow-700">
                <AlertCircle class="w-5 h-5" />
                <span class="text-sm">No se pudo detectar el tipo de video. Verifica la URL.</span>
              </div>
            </div>
            
            <!-- Opciones de reproducción -->
            <div class="border-t border-gray-200 pt-4">
              <label class="block text-sm font-medium text-gray-700 mb-3">Opciones de reproducción</label>
              <div class="flex flex-wrap gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                  <input
                    v-model="editableContent.autoplay"
                    @change="updateContent"
                    type="checkbox"
                    class="w-4 h-4 text-[#005674] rounded focus:ring-[#005674]"
                  >
                  <span class="text-sm text-gray-600">Autoplay</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                  <input
                    v-model="editableContent.muted"
                    @change="updateContent"
                    type="checkbox"
                    class="w-4 h-4 text-[#005674] rounded focus:ring-[#005674]"
                  >
                  <span class="text-sm text-gray-600">Muted</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                  <input
                    v-model="editableContent.loop"
                    @change="updateContent"
                    type="checkbox"
                    class="w-4 h-4 text-[#005674] rounded focus:ring-[#005674]"
                  >
                  <span class="text-sm text-gray-600">Loop</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                  <input
                    v-model="editableContent.controls"
                    @change="updateContent"
                    type="checkbox"
                    class="w-4 h-4 text-[#005674] rounded focus:ring-[#005674]"
                    checked
                  >
                  <span class="text-sm text-gray-600">Controles</span>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Descripción opcional -->
      <div v-if="section.content?.description || isEditing" class="mt-4 text-center">
        <p 
          v-if="!isEditing && section.content?.description"
          class="text-gray-600"
        >
          {{ section.content.description }}
        </p>
        <textarea
          v-else-if="isEditing"
          v-model="editableContent.description"
          @input="updateContent"
          rows="2"
          class="w-full max-w-lg mx-auto px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#005674] focus:outline-none resize-none"
          placeholder="Descripción del video (opcional)"
        ></textarea>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { Video, Check, AlertCircle, ClipboardPaste } from 'lucide-vue-next';

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
  title: props.section.content?.title || '',
  url: props.section.content?.url || '',
  description: props.section.content?.description || '',
  autoplay: props.section.content?.autoplay || false,
  muted: props.section.content?.muted || false,
  loop: props.section.content?.loop || false,
  controls: props.section.content?.controls !== false
});

const sectionStyles = ref({
  backgroundColor: props.section.styles?.backgroundColor || '',
  padding: props.section.styles?.padding || 'py-12',
  containerClass: props.section.styles?.containerClass || 'max-w-4xl mx-auto px-4',
  titleClass: props.section.styles?.titleClass || 'text-gray-900',
  videoContainerClass: props.section.styles?.videoContainerClass || '',
  borderRadius: props.section.styles?.borderRadius || '1rem',
  shadow: props.section.styles?.shadow || 'shadow-lg'
});

watch(() => props.section, (newSection) => {
  editableContent.value = {
    title: newSection.content?.title || '',
    url: newSection.content?.url || '',
    description: newSection.content?.description || '',
    autoplay: newSection.content?.autoplay || false,
    muted: newSection.content?.muted || false,
    loop: newSection.content?.loop || false,
    controls: newSection.content?.controls !== false
  };
  sectionStyles.value = {
    backgroundColor: newSection.styles?.backgroundColor || '',
    padding: newSection.styles?.padding || 'py-12',
    containerClass: newSection.styles?.containerClass || 'max-w-4xl mx-auto px-4',
    titleClass: newSection.styles?.titleClass || 'text-gray-900',
    videoContainerClass: newSection.styles?.videoContainerClass || '',
    borderRadius: newSection.styles?.borderRadius || '1rem',
    shadow: newSection.styles?.shadow || 'shadow-lg'
  };
}, { deep: true });

const videoUrl = computed(() => editableContent.value.url?.trim());

const videoType = computed(() => {
  const url = videoUrl.value;
  if (!url) return null;
  
  // YouTube
  if (url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/)) {
    return 'youtube';
  }
  
  // Vimeo
  if (url.match(/vimeo\.com\/(\d+)/)) {
    return 'vimeo';
  }
  
  // URL directa de video
  if (url.match(/\.(mp4|webm|ogg|mov)(\?.*)?$/i)) {
    return 'direct';
  }
  
  return 'unknown';
});

const embedUrl = computed(() => {
  const url = videoUrl.value;
  if (!url) return '';
  
  const type = videoType.value;
  
  if (type === 'youtube') {
    const videoId = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/)?.[1];
    if (videoId) {
      const params = new URLSearchParams();
      if (editableContent.value.autoplay) params.append('autoplay', '1');
      if (editableContent.value.muted) params.append('mute', '1');
      if (editableContent.value.loop) params.append('loop', '1');
      if (!editableContent.value.controls) params.append('controls', '0');
      return `https://www.youtube.com/embed/${videoId}?${params.toString()}`;
    }
  }
  
  if (type === 'vimeo') {
    const videoId = url.match(/vimeo\.com\/(\d+)/)?.[1];
    if (videoId) {
      const params = new URLSearchParams();
      if (editableContent.value.autoplay) params.append('autoplay', '1');
      if (editableContent.value.muted) params.append('muted', '1');
      if (editableContent.value.loop) params.append('loop', '1');
      return `https://player.vimeo.com/video/${videoId}?${params.toString()}`;
    }
  }
  
  return '';
});

const getSectionStyles = () => {
  const styles = {};
  
  if (sectionStyles.value.backgroundColor) {
    styles.backgroundColor = sectionStyles.value.backgroundColor;
  }
  
  return styles;
};

const getVideoContainerStyles = () => {
  const styles = {};
  
  if (sectionStyles.value.borderRadius) {
    styles.borderRadius = sectionStyles.value.borderRadius;
  }
  
  return styles;
};

const updateContent = () => {
  emit('update', {
    content: { ...editableContent.value },
    styles: { ...sectionStyles.value }
  });
};

const pasteFromClipboard = async () => {
  try {
    const text = await navigator.clipboard.readText();
    editableContent.value.url = text;
    updateContent();
  } catch (err) {
    console.error('Error al pegar:', err);
    alert('No se pudo acceder al portapapeles. Pega manualmente.');
  }
};
</script>
