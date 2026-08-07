<template>
  <div class="news-list-props space-y-4">
    <p class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2">
      Las noticias se gestionan en <strong>Admin → Noticias</strong>. En el sitio público este bloque muestra las publicaciones automáticamente.
      Los ítems de ejemplo abajo solo sirven para previsualizar el diseño en el editor.
    </p>

    <PropertySection title="Presentación" :collapsible="true" :default-open="true">
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Columnas</label>
          <select v-model.number="element.columns" class="editor-field-input">
            <option :value="1">1 columna</option>
            <option :value="2">2 columnas</option>
            <option :value="3">3 columnas</option>
          </select>
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Noticias por página</label>
          <input
            v-model.number="element.itemsPerPage"
            type="number"
            min="3"
            max="24"
            class="editor-field-input"
          >
        </div>
      </div>
      <label class="flex items-center gap-2 text-xs text-gray-700">
        <input v-model="element.showSearch" type="checkbox" class="rounded">
        Mostrar buscador
      </label>
      <label class="flex items-center gap-2 text-xs text-gray-700">
        <input v-model="element.showCategoryFilter" type="checkbox" class="rounded">
        Mostrar filtro por categoría
      </label>
    </PropertySection>

    <PropertySection title="Noticias de ejemplo" :collapsible="true">
      <PropertyRepeater
        :items="element.items"
        item-label="Noticia"
        add-label="Agregar noticia de ejemplo"
        :active-focus="activeFocus"
        :get-focus-id="(item) => buildNewsItemFocusAnchor(item.id)"
        @add="addItem"
        @remove="removeItem"
        @move="moveItem"
      >
        <template #default="{ item }">
          <div :data-editor-focus="buildNewsItemFocusAnchor(item.id)" class="space-y-2">
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
                placeholder="Fecha (ej. 15 marzo 2025)"
                class="editor-field-input"
              >
            </div>
            <input v-model="item.image" type="text" placeholder="URL de imagen" class="editor-field-input">
            <input v-model="item.slug" type="text" placeholder="Slug (ej. mi-noticia)" class="editor-field-input">
          </div>
        </template>
      </PropertyRepeater>
    </PropertySection>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue'
import PropertySection from '../fields/PropertySection.vue'
import PropertyRepeater from '../fields/PropertyRepeater.vue'
import { NEWS_CATEGORIES } from '../../../config/newsCategories'
import { generateId } from '../../../utils/pageElementFactory'
import { scrollToEditorFocus, buildNewsItemFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const categories = NEWS_CATEGORIES
const activeFocus = computed(() => props.partFocus?.anchor || '')

watch(() => props.partFocus?.anchor, (anchor) => {
  if (anchor) scrollToEditorFocus(anchor)
}, { immediate: true })

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
