<template>
  <section class="news-list" @click.stop="!preview && $emit('click', element)">
    <div class="news-list__inner">
      <div v-if="showSearch" class="news-search">
        <Search class="news-search__icon" aria-hidden="true" />
        <input
          v-model="searchQuery"
          type="search"
          class="news-search__input"
          placeholder="Buscar noticia…"
          aria-label="Buscar noticias"
          @click.stop
        >
      </div>

      <div
        v-if="showCategoryFilter"
        class="news-filters"
        role="group"
        aria-label="Filtrar por categoría"
      >
        <button
          v-for="filter in categoryFilters"
          :key="filter.id"
          type="button"
          class="news-filter-btn"
          :class="{ 'news-filter-btn--active': selectedCategory === filter.id }"
          :aria-pressed="selectedCategory === filter.id"
          @click.stop="selectedCategory = filter.id"
        >
          {{ filter.label }}
        </button>
      </div>

      <p v-if="searchQuery.trim() || selectedCategory !== 'all'" class="news-results-meta">
        {{ visibleItems.length }} noticia(s)
        <template v-if="selectedCategory !== 'all'">
          en {{ getCategoryLabel(selectedCategory) }}
        </template>
      </p>

      <div v-if="apiLoading && !apiItems.length" class="news-empty">
        Cargando noticias…
      </div>

      <ul v-else-if="paginatedItems.length" class="news-grid" :class="gridClass">
        <li
          v-for="item in paginatedItems"
          :key="item.id"
          :class="partClasses(newsAnchor(item))"
          @click.stop="focusPart(newsAnchor(item), item.title, $event)"
        >
          <NewsCard :item="item" :preview="preview" />
        </li>
      </ul>

      <p v-else-if="!apiLoading" class="news-empty">
        <template v-if="hasAnyItems">
          No hay noticias que coincidan con tu búsqueda o filtro.
        </template>
        <template v-else>
          Próximamente publicaremos noticias del IDCBIS en esta sección.
        </template>
      </p>

      <div v-if="hasMore" class="news-load-more">
        <button
          type="button"
          class="news-load-more__btn"
          @click.stop="loadMore"
        >
          Cargar más noticias
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref, watch, defineComponent, h, onMounted } from 'vue'
import { Search, Calendar, ArrowRight } from 'lucide-vue-next'
import { RouterLink } from 'vue-router'
import axios from 'axios'
import { NEWS_CATEGORIES } from '../../../config/newsCategories'
import { filterNewsItems, getCategoryLabel, normalizeNewsItems } from '../../../utils/newsItems'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildNewsItemFocusAnchor } from '../../../utils/editorPartFocus'

const NewsCard = defineComponent({
  name: 'NewsCard',
  props: {
    item: { type: Object, required: true },
    preview: { type: Boolean, default: false },
  },
  setup(props) {
    return () => {
      const hasLink = props.preview && props.item.url && props.item.url !== '#'
      const Tag = hasLink ? RouterLink : 'article'
      const attrs = hasLink
        ? { to: props.item.url, class: 'news-card news-card--linked' }
        : { class: 'news-card' }

      return h(Tag, attrs, [
        h('div', { class: 'news-card__media' }, [
          props.item.image
            ? h('img', {
                src: props.item.image,
                alt: props.item.title,
                class: 'news-card__image',
                loading: 'lazy',
              })
            : h('div', { class: 'news-card__placeholder', 'aria-hidden': 'true' }, [
                h('span', null, 'IDCBIS'),
              ]),
          h('span', { class: 'news-card__category' }, props.item.categoryLabel),
        ]),
        h('div', { class: 'news-card__body' }, [
          props.item.publishedAt
            ? h('time', { class: 'news-card__date' }, [
                h(Calendar, { size: 14, 'aria-hidden': 'true' }),
                ` ${props.item.publishedAt}`,
              ])
            : null,
          h('h3', { class: 'news-card__title' }, props.item.title),
          props.item.excerpt
            ? h('p', { class: 'news-card__excerpt' }, props.item.excerpt)
            : null,
          h('span', { class: 'news-card__cta' }, [
            'Leer más ',
            h(ArrowRight, { size: 16, 'aria-hidden': 'true' }),
          ]),
        ]),
      ])
    }
  },
})

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const searchQuery = ref('')
const selectedCategory = ref('all')
const visibleCount = ref(props.element.itemsPerPage ?? 9)
const apiItems = ref([])
const apiLoading = ref(false)
const apiPage = ref(1)
const apiLastPage = ref(1)

const staticItems = computed(() => normalizeNewsItems(props.element))

const allItems = computed(() => (props.preview ? apiItems.value : staticItems.value))

const hasAnyItems = computed(() =>
  props.preview ? apiItems.value.length > 0 : staticItems.value.length > 0,
)

const showSearch = computed(() => props.element.showSearch !== false)
const showCategoryFilter = computed(() => props.element.showCategoryFilter !== false)
const itemsPerPage = computed(() => props.element.itemsPerPage ?? 9)

const gridClass = computed(() => {
  const cols = props.element.columns ?? 3
  if (cols === 2) return 'news-grid--2'
  if (cols === 1) return 'news-grid--1'
  return 'news-grid--3'
})

const categoryFilters = computed(() => [
  { id: 'all', label: 'Todas' },
  ...NEWS_CATEGORIES,
])

const visibleItems = computed(() => {
  if (props.preview) {
    return apiItems.value
  }
  return filterNewsItems(staticItems.value, {
    category: selectedCategory.value,
    query: searchQuery.value,
  }).slice(0, visibleCount.value)
})

const paginatedItems = computed(() => visibleItems.value)

const hasMore = computed(() => {
  if (props.preview) {
    return apiPage.value < apiLastPage.value
  }
  return visibleCount.value < filterNewsItems(staticItems.value, {
    category: selectedCategory.value,
    query: searchQuery.value,
  }).length
})

const fetchPublicPosts = async (page = 1, append = false) => {
  if (!props.preview) return
  apiLoading.value = true
  try {
    const response = await axios.get('/api/posts', {
      params: {
        paginate: 1,
        page,
        per_page: itemsPerPage.value,
        category: selectedCategory.value,
        q: searchQuery.value.trim() || undefined,
      },
    })
    const items = response.data.data || []
    apiItems.value = append ? [...apiItems.value, ...items] : items
    apiPage.value = response.data.meta?.current_page || page
    apiLastPage.value = response.data.meta?.last_page || 1
  } catch {
    if (!append) apiItems.value = []
  } finally {
    apiLoading.value = false
  }
}

let searchTimer = null
watch([searchQuery, selectedCategory], () => {
  if (!props.preview) {
    visibleCount.value = itemsPerPage.value
    return
  }
  clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    apiPage.value = 1
    fetchPublicPosts(1, false)
  }, 300)
})

watch(itemsPerPage, (value) => {
  visibleCount.value = value
  if (props.preview) {
    fetchPublicPosts(1, false)
  }
})

onMounted(() => {
  if (props.preview) {
    fetchPublicPosts(1, false)
  }
})

watch(() => props.preview, (isPublic) => {
  if (isPublic) fetchPublicPosts(1, false)
})

const newsAnchor = (item) => buildNewsItemFocusAnchor(item.id)

const loadMore = () => {
  if (props.preview) {
    fetchPublicPosts(apiPage.value + 1, true)
    return
  }
  visibleCount.value += itemsPerPage.value
}
</script>

<style scoped>
.news-list {
  font-family: var(--font-idcbis);
  background: #f0f5f8;
  padding: 2.5rem 1.5rem 4rem;
  color: #1e293b;
  cursor: pointer;
}

.news-list__inner {
  max-width: 1200px;
  margin: 0 auto;
}

.news-search {
  position: relative;
  max-width: 420px;
  margin: 0 auto 1.75rem;
}

.news-search__icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  width: 1.125rem;
  height: 1.125rem;
  color: #94a3b8;
  pointer-events: none;
}

.news-search__input {
  width: 100%;
  height: 46px;
  padding: 0 1rem 0 2.75rem;
  border: 1px solid #e2e8f0;
  border-radius: 9999px;
  font-size: 0.9375rem;
  background: #fff;
  outline: none;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.news-search__input:focus-visible {
  border-color: #2c8c99;
  box-shadow: 0 0 0 3px rgba(44, 140, 153, 0.2);
}

.news-filters {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  justify-content: center;
  margin-bottom: 2rem;
}

.news-filter-btn {
  min-height: 44px;
  padding: 0.5rem 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 9999px;
  background: #fff;
  font-family: inherit;
  font-size: 0.8125rem;
  font-weight: 600;
  color: #0b4f6c;
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, color 0.2s, box-shadow 0.2s;
}

.news-filter-btn:hover {
  border-color: #2c8c99;
  background: #f0f9fb;
}

.news-filter-btn:focus-visible {
  outline: none;
  box-shadow: 0 0 0 3px rgba(44, 140, 153, 0.25);
}

.news-filter-btn--active {
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  color: #fff;
  border-color: transparent;
  box-shadow: 0 4px 14px rgba(11, 79, 108, 0.2);
}

.news-results-meta {
  font-size: 0.875rem;
  color: #64748b;
  margin: 0 0 1.25rem;
  text-align: center;
}

.news-grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  gap: 1.5rem;
}

.news-grid--1 {
  grid-template-columns: 1fr;
}

.news-grid--2 {
  grid-template-columns: repeat(2, 1fr);
}

.news-grid--3 {
  grid-template-columns: repeat(3, 1fr);
}

@media (max-width: 1024px) {
  .news-grid--3 {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 640px) {
  .news-grid--2,
  .news-grid--3 {
    grid-template-columns: 1fr;
  }

  .news-filters {
    flex-wrap: nowrap;
    overflow-x: auto;
    justify-content: flex-start;
    padding-bottom: 0.25rem;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
  }

  .news-filter-btn {
    flex-shrink: 0;
  }
}

.news-empty {
  text-align: center;
  color: #94a3b8;
  padding: 3rem 1rem;
  font-size: 1rem;
  line-height: 1.6;
  background: #fff;
  border: 1px dashed #e2e8f0;
  border-radius: 16px;
}

.news-load-more {
  display: flex;
  justify-content: center;
  margin-top: 2.5rem;
}

.news-load-more__btn {
  min-height: 44px;
  padding: 0.75rem 1.75rem;
  border: none;
  border-radius: 9999px;
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  color: #fff;
  font-family: inherit;
  font-size: 0.9375rem;
  font-weight: 700;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

.news-load-more__btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 8px 20px rgba(11, 79, 108, 0.25);
}

.news-load-more__btn:focus-visible {
  outline: none;
  box-shadow: 0 0 0 3px rgba(44, 140, 153, 0.35);
}

:deep(.news-card) {
  display: flex;
  flex-direction: column;
  height: 100%;
  background: #fff;
  border: 1px solid #e8eef2;
  border-radius: 16px;
  overflow: hidden;
  text-decoration: none;
  color: inherit;
  transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
}

:deep(.news-card--linked:hover) {
  border-color: #2c8c99;
  box-shadow: 0 12px 32px rgba(11, 79, 108, 0.12);
  transform: translateY(-3px);
}

:deep(.news-card__media) {
  position: relative;
  aspect-ratio: 16 / 10;
  overflow: hidden;
  background: linear-gradient(135deg, #e8f4f8, #d4eef0);
}

:deep(.news-card__image) {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

:deep(.news-card__placeholder) {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  font-weight: 800;
  letter-spacing: 0.08em;
  color: #0b4f6c;
  opacity: 0.35;
}

:deep(.news-card__category) {
  position: absolute;
  left: 0.75rem;
  bottom: 0.75rem;
  padding: 0.3rem 0.65rem;
  border-radius: 9999px;
  background: rgba(11, 79, 108, 0.92);
  color: #fff;
  font-size: 0.6875rem;
  font-weight: 700;
  letter-spacing: 0.02em;
  max-width: calc(100% - 1.5rem);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

:deep(.news-card__body) {
  display: flex;
  flex-direction: column;
  flex: 1;
  padding: 1.15rem 1.25rem 1.25rem;
  gap: 0.5rem;
}

:deep(.news-card__date) {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 0.8125rem;
  color: #64748b;
  font-style: normal;
}

:deep(.news-card__title) {
  margin: 0;
  font-size: 1.0625rem;
  font-weight: 800;
  color: #0b4f6c;
  line-height: 1.35;
}

:deep(.news-card__excerpt) {
  margin: 0;
  font-size: 0.875rem;
  color: #64748b;
  line-height: 1.55;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

:deep(.news-card__cta) {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  margin-top: auto;
  padding-top: 0.5rem;
  font-size: 0.8125rem;
  font-weight: 700;
  color: #2c8c99;
}

:deep(.news-card--linked:hover .news-card__cta) {
  color: #0b4f6c;
}

@media (prefers-reduced-motion: reduce) {
  :deep(.news-card--linked:hover),
  .news-load-more__btn:hover {
    transform: none;
  }
}
</style>
