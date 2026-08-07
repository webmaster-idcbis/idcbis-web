<template>
  <div class="news-carousel-props space-y-4">
    <p class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2">
      En el sitio público este carrusel muestra automáticamente las noticias más recientes
      (Admin → Noticias). Los ítems de ejemplo solo sirven para previsualizar el diseño en el editor.
    </p>

    <PropertySection title="Textos" :collapsible="true" :default-open="true">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Antetítulo</label>
        <input v-model="element.sectionEyebrow" type="text" class="editor-field-input" placeholder="Actualidad">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Título</label>
        <input v-model="element.sectionTitle" type="text" class="editor-field-input" placeholder="Noticias destacadas">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Subtítulo</label>
        <textarea
          v-model="element.sectionSubtitle"
          rows="2"
          class="editor-field-input"
          placeholder="Texto breve opcional"
        />
      </div>
    </PropertySection>

    <PropertySection title="Comportamiento" :collapsible="true" :default-open="true">
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Cantidad de noticias</label>
          <input
            v-model.number="element.limit"
            type="number"
            min="3"
            max="12"
            class="editor-field-input"
          >
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Intervalo (ms)</label>
          <input
            v-model.number="element.interval"
            type="number"
            min="2000"
            max="12000"
            step="500"
            class="editor-field-input"
          >
        </div>
      </div>
      <label class="flex items-center gap-2 text-xs text-gray-700">
        <input v-model="element.autoPlay" type="checkbox" class="rounded">
        Desplazamiento automático
      </label>
    </PropertySection>

    <PropertySection title="Noticias de ejemplo" :collapsible="true">
      <PropertyRepeater
        :items="element.items"
        item-label="Noticia"
        add-label="Agregar noticia de ejemplo"
        @add="addItem"
        @remove="removeItem"
        @move="moveItem"
      >
        <template #default="{ item }">
          <div class="space-y-2">
            <input v-model="item.title" type="text" placeholder="Título" class="editor-field-input">
            <textarea
              v-model="item.excerpt"
              rows="2"
              placeholder="Resumen breve"
              class="editor-field-input"
            />
            <div class="grid grid-cols-2 gap-2">
              <select v-model="item.category" class="editor-field-input">
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                  {{ cat.label }}
                </option>
              </select>
              <input
                v-model="item.publishedAt"
                type="text"
                placeholder="Fecha"
                class="editor-field-input"
              >
            </div>
            <input v-model="item.image" type="text" placeholder="URL de imagen" class="editor-field-input">
            <input v-model="item.slug" type="text" placeholder="Slug" class="editor-field-input">
          </div>
        </template>
      </PropertyRepeater>
    </PropertySection>
  </div>
</template>

<script setup>
import PropertySection from '../fields/PropertySection.vue'
import PropertyRepeater from '../fields/PropertyRepeater.vue'
import { NEWS_CATEGORIES } from '../../../config/newsCategories'
import { generateId } from '../../../utils/pageElementFactory'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const categories = NEWS_CATEGORIES

const createNewsItem = () => ({
  id: generateId(),
  title: 'Título de la noticia',
  excerpt: 'Resumen breve de la noticia.',
  category: 'investigacion',
  publishedAt: '',
  image: '',
  slug: '',
})

const addItem = () => {
  if (!props.element.items) props.element.items = []
  props.element.items.push(createNewsItem())
}

const removeItem = (i) => props.element.items.splice(i, 1)

const moveItem = (i, d) => {
  const list = props.element.items
  const next = i + d
  if (next < 0 || next >= list.length) return
  const [item] = list.splice(i, 1)
  list.splice(next, 0, item)
}
</script>
