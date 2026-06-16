<template>
  <div class="space-y-3">
    <h4 class="text-sm font-semibold text-gray-900">Carrusel Hero IDCBIS</h4>
    <p class="text-xs text-slate-600 bg-slate-50 border border-slate-200 rounded p-2">
      Mismo diseño de la propuesta azul: texto a la izquierda, imagen orgánica a la derecha y dos botones por slide.
    </p>

    <div class="grid grid-cols-2 gap-2">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Intervalo (ms)</label>
        <input v-model.number="element.interval" type="number" min="2000" step="500" class="field-input">
      </div>
      <label class="flex items-end gap-2 text-sm pb-2">
        <input v-model="element.autoPlay" type="checkbox" class="rounded">
        Autoplay
      </label>
    </div>

    <div class="grid grid-cols-2 gap-2">
      <label class="flex items-center gap-2 text-sm">
        <input v-model="element.showArrows" type="checkbox" class="rounded">
        Flechas
      </label>
      <label class="flex items-center gap-2 text-sm">
        <input v-model="element.showIndicators" type="checkbox" class="rounded">
        Indicadores
      </label>
    </div>

    <div class="flex items-center justify-between pt-2 border-t">
      <span class="text-xs font-medium">Slides ({{ slides.length }})</span>
      <button type="button" class="text-xs px-2 py-1 bg-[#0B4F6C] text-white rounded" @click="addSlide">
        + Slide
      </button>
    </div>

    <div
      v-for="(slide, index) in slides"
      :key="slide.id || index"
      class="border rounded-lg p-3 space-y-2 bg-gray-50"
    >
      <div class="flex justify-between items-center">
        <span class="text-xs font-semibold">Slide {{ index + 1 }}</span>
        <div class="flex gap-1">
          <button type="button" class="text-xs border px-1 rounded" :disabled="index === 0" @click="moveSlide(index, -1)">↑</button>
          <button type="button" class="text-xs border px-1 rounded" :disabled="index === slides.length - 1" @click="moveSlide(index, 1)">↓</button>
          <button type="button" class="text-xs text-red-600" :disabled="slides.length <= 1" @click="removeSlide(index)">✕</button>
        </div>
      </div>

      <input v-model="slide.titleLight" type="text" placeholder="Línea superior (ligera)" class="field-input">
      <input v-model="slide.titleBold" type="text" placeholder="Título principal" class="field-input">
      <textarea v-model="slide.subtitle" rows="2" placeholder="Subtítulo" class="field-input"></textarea>

      <div class="grid grid-cols-2 gap-2">
        <input v-model="slide.button1Text" type="text" placeholder="Botón 1" class="field-input">
        <input v-model="slide.button1Url" type="text" placeholder="URL botón 1" class="field-input">
        <input v-model="slide.button2Text" type="text" placeholder="Botón 2" class="field-input">
        <input v-model="slide.button2Url" type="text" placeholder="URL botón 2" class="field-input">
      </div>

      <input v-model="slide.image" type="text" placeholder="/img/foto.jpg" class="field-input">
      <input v-model="slide.imageBadge" type="text" placeholder="Emoji decorativo (ej. 🔬)" class="field-input">
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { createIdcbisHeroSlide } from '../../../utils/pageElementFactory'

const props = defineProps({ element: { type: Object, required: true } })

const slides = computed(() => props.element.slides || [])

const addSlide = () => {
  if (!props.element.slides) props.element.slides = []
  props.element.slides.push(createIdcbisHeroSlide())
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

<style scoped>
.field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
