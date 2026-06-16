<template>
  <div class="space-y-4">
    <h4 class="text-sm font-semibold text-gray-900">Carrusel / Slider</h4>

    <div>
      <label class="block text-xs text-gray-600 mb-1">Estilo</label>
      <select v-model="element.variant" class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
        <option value="">Estándar</option>
        <option value="hero-full">Hero pantalla completa (BDS)</option>
      </select>
    </div>

    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Alto del slider</label>
        <input
          v-model="element.height"
          type="text"
          placeholder="400px"
          class="w-full px-3 py-2 border border-gray-300 rounded text-sm"
        >
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Intervalo (ms)</label>
        <input
          v-model.number="element.interval"
          type="number"
          min="1000"
          step="500"
          class="w-full px-3 py-2 border border-gray-300 rounded text-sm"
        >
      </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Alineación horizontal</label>
        <select v-model="element.textAlign" class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
          <option value="left">Izquierda</option>
          <option value="center">Centro</option>
          <option value="right">Derecha</option>
        </select>
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Alineación vertical</label>
        <select v-model="element.verticalAlign" class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
          <option value="flex-start">Arriba</option>
          <option value="center">Centro</option>
          <option value="flex-end">Abajo</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Overlay global</label>
        <input
          v-model="element.overlay"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded text-sm"
          placeholder="linear-gradient(...)"
        >
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Padding del contenido</label>
        <input
          v-model="element.contentPadding"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded text-sm"
          placeholder="32px 24px 48px"
        >
      </div>
    </div>

    <div class="grid grid-cols-3 gap-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Tamaño título</label>
        <input v-model="element.titleSize" type="text" class="w-full px-3 py-2 border border-gray-300 rounded text-sm" placeholder="2.5rem">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Tamaño descripción</label>
        <input v-model="element.descriptionSize" type="text" class="w-full px-3 py-2 border border-gray-300 rounded text-sm" placeholder="1.1rem">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Ancho descripción</label>
        <input v-model="element.descriptionMaxWidth" type="text" class="w-full px-3 py-2 border border-gray-300 rounded text-sm" placeholder="720px">
      </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
      <label class="flex items-center gap-2 text-sm text-gray-700">
        <input v-model="element.showArrows" type="checkbox" class="rounded">
        Mostrar flechas
      </label>
      <label class="flex items-center gap-2 text-sm text-gray-700">
        <input v-model="element.showIndicators" type="checkbox" class="rounded">
        Mostrar indicadores
      </label>
    </div>

    <label class="flex items-center gap-2 text-sm text-gray-700">
      <input v-model="element.autoPlay" type="checkbox" class="rounded">
      Reproducción automática
    </label>

    <div class="flex items-center justify-between pt-2 border-t border-gray-200">
      <span class="text-xs font-medium text-gray-700">Diapositivas ({{ slides.length }})</span>
      <button
        type="button"
        @click="addSlide"
        class="px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600"
      >
        + Agregar slide
      </button>
    </div>

    <div
      v-for="(slide, index) in slides"
      :key="slide.id || index"
      class="border border-gray-200 rounded-lg p-3 space-y-3 bg-gray-50"
    >
      <div class="flex items-center justify-between">
        <span class="text-xs font-semibold text-gray-700">Slide {{ index + 1 }}</span>
        <div class="flex gap-1">
          <button
            type="button"
            :disabled="index === 0"
            @click="moveSlide(index, -1)"
            class="px-2 py-0.5 text-xs border rounded disabled:opacity-40"
            title="Subir"
          >↑</button>
          <button
            type="button"
            :disabled="index === slides.length - 1"
            @click="moveSlide(index, 1)"
            class="px-2 py-0.5 text-xs border rounded disabled:opacity-40"
            title="Bajar"
          >↓</button>
          <button
            type="button"
            :disabled="slides.length <= 1"
            @click="removeSlide(index)"
            class="px-2 py-0.5 text-xs text-red-600 border border-red-200 rounded disabled:opacity-40"
          >
            Eliminar
          </button>
        </div>
      </div>

      <div>
        <label class="block text-xs text-gray-600 mb-1">URL de imagen</label>
        <input
          v-model="slide.image"
          type="text"
          placeholder="https://... o /images/foto.jpg"
          class="w-full px-3 py-2 border border-gray-300 rounded text-sm bg-white"
        >
      </div>

      <div v-if="slide.image" class="rounded overflow-hidden border border-gray-200 h-24 bg-gray-200">
        <img :src="slide.image" :alt="slide.title || 'Vista previa'" class="w-full h-full object-cover">
      </div>

      <div>
        <label class="block text-xs text-gray-600 mb-1">Título sobre la imagen</label>
        <input
          v-model="slide.title"
          type="text"
          placeholder="Título principal"
          class="w-full px-3 py-2 border border-gray-300 rounded text-sm bg-white"
        >
      </div>

      <div>
        <label class="block text-xs text-gray-600 mb-1">Texto / descripción</label>
        <textarea
          v-model="slide.description"
          rows="2"
          placeholder="Texto descriptivo sobre la imagen"
          class="w-full px-3 py-2 border border-gray-300 rounded text-sm bg-white"
        ></textarea>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Overlay (slide)</label>
          <input
            v-model="slide.overlay"
            type="text"
            placeholder="linear-gradient(...)"
            class="w-full px-3 py-2 border border-gray-300 rounded text-sm bg-white"
          >
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Alineación texto</label>
          <select v-model="slide.textAlign" class="w-full px-3 py-2 border border-gray-300 rounded text-sm bg-white">
            <option value="">Global</option>
            <option value="left">Izquierda</option>
            <option value="center">Centro</option>
            <option value="right">Derecha</option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Texto del botón</label>
          <input
            v-model="slide.buttonText"
            type="text"
            placeholder="Ver más"
            class="w-full px-3 py-2 border border-gray-300 rounded text-sm bg-white"
          >
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">URL del botón</label>
          <input
            v-model="slide.buttonUrl"
            type="text"
            placeholder="/pagina o https://..."
            class="w-full px-3 py-2 border border-gray-300 rounded text-sm bg-white"
          >
        </div>
      </div>

      <div>
        <label class="block text-xs text-gray-600 mb-1">Enlace al hacer clic en la imagen (opcional)</label>
        <input
          v-model="slide.link"
          type="text"
          placeholder="/destino"
          class="w-full px-3 py-2 border border-gray-300 rounded text-sm bg-white"
        >
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue'
import { createSlide } from '../../../utils/pageElementFactory'

const props = defineProps({
  element: { type: Object, required: true },
})

const slides = computed(() => props.element.slides || [])

const ensureSlideIds = () => {
  if (!props.element.slides) return
  props.element.slides.forEach((slide, i) => {
    if (!slide.id) slide.id = `slide_${Date.now()}_${i}`
  })
}

watch(() => props.element, ensureSlideIds, { immediate: true, deep: true })

const addSlide = () => {
  if (!props.element.slides) props.element.slides = []
  props.element.slides.push(createSlide({
    title: 'Título del slide',
    description: 'Descripción breve para este slide',
    buttonText: 'Conocer más',
    buttonUrl: '#',
  }))
}

const removeSlide = (index) => {
  if (props.element.slides.length <= 1) return
  props.element.slides.splice(index, 1)
}

const moveSlide = (index, direction) => {
  const list = props.element.slides
  const newIndex = index + direction
  if (newIndex < 0 || newIndex >= list.length) return
  const [item] = list.splice(index, 1)
  list.splice(newIndex, 0, item)
}
</script>
