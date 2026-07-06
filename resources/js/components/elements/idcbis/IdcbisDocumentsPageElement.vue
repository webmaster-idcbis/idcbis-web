<template>
  <div class="docs-page" @click.stop="!preview && $emit('click', element)">
    <header class="docs-hero" :style="heroStyle">
      <div class="docs-hero__inner">
        <p class="docs-hero__eyebrow">{{ element.eyebrow || 'Transparencia' }}</p>
        <h1>{{ element.heroTitle || 'Documentos' }}</h1>
        <p v-if="element.heroSubtitle" class="docs-hero__subtitle">{{ element.heroSubtitle }}</p>
      </div>
    </header>

    <section v-if="element.intro" class="docs-intro">
      <div class="docs-container docs-container--narrow">
        <p>{{ element.intro }}</p>
      </div>
    </section>

    <section class="docs-main">
      <div class="docs-container">
        <div v-if="showSearch" class="docs-search">
          <Search class="docs-search__icon" aria-hidden="true" />
          <input
            v-model="searchQuery"
            type="search"
            class="docs-search__input"
            placeholder="Buscar documento…"
            aria-label="Buscar documentos"
          >
        </div>

        <div
          class="docs-layout"
          :class="{
            'docs-layout--sidebar': layout === 'sidebar',
            'docs-layout--tabs': layout === 'tabs',
            'docs-layout--compact': navCompact,
            'docs-layout--wide-nav': !navCompact,
          }"
        >
          <aside class="docs-nav" aria-label="Secciones de documentos">
            <button
              v-for="group in groups"
              :key="group.id"
              type="button"
              class="docs-nav-btn"
              :class="{ 'docs-nav-btn--active': selectedGroupId === group.id }"
              @click.stop="selectedGroupId = group.id"
            >
              <span class="docs-nav-btn__label">{{ group.label }}</span>
              <span class="docs-nav-btn__count">{{ group.documents?.length || 0 }}</span>
            </button>
          </aside>

          <div class="docs-content">
            <template v-if="searchQuery.trim()">
              <p class="docs-results-meta">
                {{ filteredDocuments.length }} resultado(s)
              </p>
              <ul class="docs-grid" :class="gridClass">
                <li v-for="doc in filteredDocuments" :key="doc.id || doc.title">
                  <DocCard :doc="doc" :preview="preview" />
                </li>
              </ul>
              <p v-if="!filteredDocuments.length" class="docs-empty">
                No hay documentos que coincidan con tu búsqueda.
              </p>
            </template>

            <template v-else-if="activeGroup">
              <header class="docs-group-head">
                <h2>{{ activeGroup.label }}</h2>
              </header>
              <ul v-if="activeGroup.documents?.length" class="docs-grid" :class="gridClass">
                <li v-for="doc in activeGroup.documents" :key="doc.id || doc.title">
                  <DocCard :doc="doc" :preview="preview" />
                </li>
              </ul>
              <p v-else class="docs-empty">
                Esta sección aún no tiene documentos.
              </p>
            </template>

            <p v-else class="docs-empty">
              Agrega al menos una sección con documentos.
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { computed, ref, watch, defineComponent, h } from 'vue'
import { Search, FileText, ExternalLink } from 'lucide-vue-next'
import { normalizeDocumentGroups, isCompactNav } from '../../../utils/documentPageGroups'

const DocCard = defineComponent({
  name: 'DocCard',
  props: {
    doc: { type: Object, required: true },
    preview: { type: Boolean, default: false },
  },
  setup(props) {
    return () => {
      const hasUrl = !!(props.doc.url && props.doc.url !== '#')
      const Tag = hasUrl && props.preview ? 'a' : 'div'
      const attrs = hasUrl && props.preview
        ? {
            href: props.doc.url,
            target: '_blank',
            rel: 'noopener noreferrer',
            class: 'docs-card docs-card--linked',
            onClick: (e) => e.stopPropagation(),
          }
        : { class: 'docs-card' }

      return h(Tag, attrs, [
        h('div', { class: 'docs-card__icon', 'aria-hidden': 'true' }, [
          h(FileText, { size: 22 }),
        ]),
        h('div', { class: 'docs-card__body' }, [
          h('h4', { class: 'docs-card__title' }, props.doc.title || 'Sin título'),
          props.doc.publishedAt
            ? h('time', { class: 'docs-card__date' }, `Publicado: ${props.doc.publishedAt}`)
            : null,
        ]),
        hasUrl && props.preview
          ? h(ExternalLink, { class: 'docs-card__arrow', size: 18, 'aria-hidden': 'true' })
          : null,
      ])
    }
  },
})

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const searchQuery = ref('')
const selectedGroupId = ref('')

const groups = computed(() => normalizeDocumentGroups(props.element))

const layout = computed(() => props.element.layout || 'sidebar')
const showSearch = computed(() => props.element.showSearch !== false)
const navCompact = computed(() => isCompactNav(groups.value))

const gridClass = computed(() => {
  const cols = props.element.documentColumns ?? 1
  return cols === 2 ? 'docs-grid--2' : 'docs-grid--1'
})

const activeGroup = computed(() =>
  groups.value.find((g) => g.id === selectedGroupId.value) || groups.value[0] || null,
)

watch(groups, (list) => {
  if (!list.length) {
    selectedGroupId.value = ''
    return
  }
  if (!list.some((g) => g.id === selectedGroupId.value)) {
    selectedGroupId.value = list[0].id
  }
}, { immediate: true, deep: true })

const heroStyle = computed(() => {
  const img = props.element.heroImage
  if (!img) {
    return { background: 'linear-gradient(135deg, #0b4f6c 0%, #1a5f7a 50%, #2c8c99 100%)' }
  }
  return {
    backgroundImage: `linear-gradient(rgba(11, 79, 108, 0.88), rgba(44, 140, 153, 0.82)), url(${img})`,
    backgroundSize: 'cover',
    backgroundPosition: 'center',
  }
})

const normalize = (v) => (v || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '')

const filteredDocuments = computed(() => {
  const q = normalize(searchQuery.value.trim())
  if (!q) return []
  return groups.value.flatMap((g) =>
    (g.documents || []).map((d) => ({ ...d, groupLabel: g.label })),
  ).filter((d) => normalize(`${d.title} ${d.publishedAt} ${d.groupLabel}`).includes(q))
})
</script>

<style scoped>
.docs-page {
  font-family: var(--font-idcbis);
  color: #1e293b;
  cursor: pointer;
}

.docs-hero {
  padding: 3.5rem 1.5rem 3rem;
  color: #fff;
}

.docs-hero__inner {
  max-width: 900px;
  margin: 0 auto;
}

.docs-hero__eyebrow {
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  opacity: 0.85;
  margin: 0 0 0.5rem;
}

.docs-hero h1 {
  font-size: clamp(1.75rem, 4vw, 2.75rem);
  font-weight: 800;
  line-height: 1.15;
  margin: 0 0 0.75rem;
}

.docs-hero__subtitle {
  font-size: 1.0625rem;
  opacity: 0.92;
  line-height: 1.55;
  margin: 0;
  max-width: 40rem;
}

.docs-intro {
  background: #fff;
  padding: 2rem 1.5rem;
  border-bottom: 1px solid #e8eef2;
}

.docs-intro p {
  margin: 0;
  text-align: center;
  color: #64748b;
  line-height: 1.7;
  font-size: 1.0625rem;
}

.docs-main {
  background: #f0f5f8;
  padding: 2.5rem 1.5rem 4rem;
}

.docs-container {
  max-width: 1200px;
  margin: 0 auto;
}

.docs-container--narrow {
  max-width: 760px;
}

.docs-search {
  position: relative;
  max-width: 420px;
  margin: 0 auto 2rem;
}

.docs-search__icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  width: 1.125rem;
  height: 1.125rem;
  color: #94a3b8;
  pointer-events: none;
}

.docs-search__input {
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

.docs-search__input:focus {
  border-color: #2c8c99;
  box-shadow: 0 0 0 3px rgba(44, 140, 153, 0.2);
}

.docs-layout {
  display: grid;
  gap: 1.5rem;
  align-items: start;
}

.docs-layout--sidebar.docs-layout--compact {
  grid-template-columns: 200px 1fr;
}

.docs-layout--sidebar.docs-layout--wide-nav {
  grid-template-columns: minmax(260px, 340px) 1fr;
}

@media (max-width: 900px) {
  .docs-layout--sidebar {
    grid-template-columns: 1fr !important;
  }
}

.docs-nav {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  position: sticky;
  top: 1rem;
  max-height: calc(100vh - 2rem);
  overflow-y: auto;
  padding-right: 0.25rem;
}

@media (max-width: 900px) {
  .docs-nav {
    flex-direction: row;
    flex-wrap: wrap;
    position: static;
    max-height: none;
    overflow: visible;
  }
}

.docs-layout--tabs .docs-nav {
  flex-direction: row;
  flex-wrap: wrap;
  position: static;
  max-height: none;
}

.docs-nav-btn {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 0.5rem;
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  background: #fff;
  font-family: inherit;
  font-size: 0.875rem;
  font-weight: 600;
  color: #0b4f6c;
  cursor: pointer;
  text-align: left;
  transition: background 0.2s, border-color 0.2s, box-shadow 0.2s;
}

.docs-layout--compact .docs-nav-btn {
  align-items: center;
  font-size: 0.9375rem;
  font-weight: 700;
}

.docs-layout--tabs .docs-nav-btn {
  width: auto;
}

.docs-nav-btn:hover {
  border-color: #2c8c99;
  background: #f0f9fb;
}

.docs-nav-btn--active {
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  color: #fff;
  border-color: transparent;
  box-shadow: 0 4px 14px rgba(11, 79, 108, 0.25);
}

.docs-nav-btn__label {
  flex: 1;
  line-height: 1.4;
  min-width: 0;
}

.docs-nav-btn__count {
  flex-shrink: 0;
  font-size: 0.6875rem;
  font-weight: 600;
  opacity: 0.85;
  background: rgba(0, 0, 0, 0.08);
  padding: 0.15rem 0.45rem;
  border-radius: 9999px;
  margin-top: 0.1rem;
}

.docs-nav-btn--active .docs-nav-btn__count {
  background: rgba(255, 255, 255, 0.2);
}

.docs-group-head {
  margin-bottom: 1.25rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid #dde5ea;
}

.docs-group-head h2 {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 800;
  color: #0b4f6c;
  line-height: 1.35;
}

.docs-results-meta {
  font-size: 0.875rem;
  color: #64748b;
  margin: 0 0 1rem;
}

.docs-grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  gap: 0.875rem;
}

.docs-grid--1 {
  grid-template-columns: 1fr;
}

.docs-grid--2 {
  grid-template-columns: repeat(2, 1fr);
}

@media (max-width: 900px) {
  .docs-grid--2 {
    grid-template-columns: 1fr;
  }
}

.docs-empty {
  text-align: center;
  color: #94a3b8;
  padding: 2rem 1rem;
  font-size: 0.9375rem;
}

:deep(.docs-card) {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  padding: 1.15rem 1.25rem;
  background: #fff;
  border: 1px solid #e8eef2;
  border-radius: 14px;
  text-decoration: none;
  color: inherit;
  height: 100%;
  box-sizing: border-box;
  transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
}

:deep(.docs-card--linked:hover) {
  border-color: #2c8c99;
  box-shadow: 0 8px 24px rgba(11, 79, 108, 0.1);
  transform: translateY(-2px);
}

:deep(.docs-card__icon) {
  flex-shrink: 0;
  width: 44px;
  height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #e8f4f8, #d4eef0);
  color: #0b4f6c;
  border-radius: 10px;
}

:deep(.docs-card__body) {
  flex: 1;
  min-width: 0;
}

:deep(.docs-card__title) {
  margin: 0 0 0.35rem;
  font-size: 0.9375rem;
  font-weight: 700;
  color: #0b4f6c;
  line-height: 1.4;
}

:deep(.docs-card__date) {
  font-size: 0.8125rem;
  color: #64748b;
  font-style: normal;
}

:deep(.docs-card__arrow) {
  flex-shrink: 0;
  color: #94a3b8;
  margin-top: 0.25rem;
}

:deep(.docs-card--linked:hover .docs-card__arrow) {
  color: #2c8c99;
}
</style>
