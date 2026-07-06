<template>
  <section class="docs-list" @click.stop="!preview && $emit('click', element)">
    <div class="docs-list__inner">
      <div v-if="showSearch" class="docs-search">
        <Search class="docs-search__icon" aria-hidden="true" />
        <input
          v-model="searchQuery"
          type="search"
          class="docs-search__input"
          placeholder="Buscar documento…"
          aria-label="Buscar documentos"
          @click.stop
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
            :class="{ 'docs-nav-btn--active': selectedGroupId === group.id, ...partClasses(groupAnchor(group)) }"
            @click.stop="onGroupClick(group, $event)"
          >
            <span class="docs-nav-btn__label">{{ group.label }}</span>
            <span class="docs-nav-btn__count">{{ group.documents?.length || 0 }}</span>
          </button>
        </aside>

        <div class="docs-content">
          <template v-if="searchQuery.trim()">
            <p class="docs-results-meta">{{ filteredDocuments.length }} resultado(s)</p>
            <ul class="docs-grid" :class="gridClass">
              <li
                v-for="doc in filteredDocuments"
                :key="doc.id || doc.title"
                :class="partClasses(docAnchor(doc))"
                @click.stop="focusPart(docAnchor(doc), doc.title, $event)"
              >
                <DocCard :doc="doc" :preview="preview" />
              </li>
            </ul>
            <p v-if="!filteredDocuments.length" class="docs-empty">No hay documentos que coincidan con tu búsqueda.</p>
          </template>

          <template v-else-if="activeGroup">
            <header
              class="docs-group-head"
              :class="partClasses(groupAnchor(activeGroup))"
              @click.stop="focusPart(groupAnchor(activeGroup), activeGroup.label, $event)"
            >
              <h2>{{ activeGroup.label }}</h2>
            </header>
            <ul v-if="activeGroup.documents?.length" class="docs-grid" :class="gridClass">
              <li
                v-for="doc in activeGroup.documents"
                :key="doc.id || doc.title"
                :class="partClasses(docAnchor(doc))"
                @click.stop="focusPart(docAnchor(doc), doc.title, $event)"
              >
                <DocCard :doc="doc" :preview="preview" />
              </li>
            </ul>
            <p v-else class="docs-empty">Esta sección aún no tiene documentos.</p>
          </template>

          <p v-else class="docs-empty">Agrega al menos una sección con documentos.</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref, watch, defineComponent, h } from 'vue'
import { Search, FileText, ExternalLink } from 'lucide-vue-next'
import { normalizeDocumentGroups, isCompactNav } from '../../../utils/documentPageGroups'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildDocumentGroupFocusAnchor, buildDocumentItemFocusAnchor } from '../../../utils/editorPartFocus'

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
        ? { href: props.doc.url, target: '_blank', rel: 'noopener noreferrer', class: 'docs-card docs-card--linked', onClick: (e) => e.stopPropagation() }
        : { class: 'docs-card' }

      return h(Tag, attrs, [
        h('div', { class: 'docs-card__icon', 'aria-hidden': 'true' }, [h(FileText, { size: 22 })]),
        h('div', { class: 'docs-card__body' }, [
          h('h4', { class: 'docs-card__title' }, props.doc.title || 'Sin título'),
          props.doc.publishedAt ? h('time', { class: 'docs-card__date' }, `Publicado: ${props.doc.publishedAt}`) : null,
        ]),
        hasUrl && props.preview ? h(ExternalLink, { class: 'docs-card__arrow', size: 18, 'aria-hidden': 'true' }) : null,
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

const groupAnchor = (group) => buildDocumentGroupFocusAnchor(group.id)
const docAnchor = (doc) => buildDocumentItemFocusAnchor(doc.id)

const onGroupClick = (group, event) => {
  selectedGroupId.value = group.id
  focusPart(groupAnchor(group), group.label, event)
  if (!props.preview) emit('click', props.element)
}

watch(groups, (list) => {
  if (!list.length) {
    selectedGroupId.value = ''
    return
  }
  if (!list.some((g) => g.id === selectedGroupId.value)) {
    selectedGroupId.value = list[0].id
  }
}, { immediate: true, deep: true })

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
.docs-list {
  font-family: var(--font-idcbis);
  color: #1e293b;
  background: #f0f5f8;
  padding: 2.5rem 1.5rem 4rem;
  cursor: pointer;
}

.docs-list__inner { max-width: 1200px; margin: 0 auto; }

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
}

.docs-layout { display: grid; gap: 1.5rem; align-items: start; }
.docs-layout--sidebar.docs-layout--compact { grid-template-columns: 200px 1fr; }
.docs-layout--sidebar.docs-layout--wide-nav { grid-template-columns: minmax(260px, 340px) 1fr; }

@media (max-width: 900px) {
  .docs-layout--sidebar { grid-template-columns: 1fr !important; }
  .docs-nav { flex-direction: row; flex-wrap: wrap; position: static; max-height: none; }
}

.docs-nav {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  position: sticky;
  top: 1rem;
  max-height: calc(100vh - 2rem);
  overflow-y: auto;
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
  font-size: 0.875rem;
  font-weight: 600;
  color: #0b4f6c;
  cursor: pointer;
  text-align: left;
}

.docs-nav-btn--active {
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  color: #fff;
  border-color: transparent;
}

.docs-nav-btn__count {
  font-size: 0.6875rem;
  background: rgba(0, 0, 0, 0.08);
  padding: 0.15rem 0.45rem;
  border-radius: 9999px;
}

.docs-group-head h2 {
  margin: 0 0 1rem;
  font-size: 1.25rem;
  font-weight: 800;
  color: #0b4f6c;
}

.docs-grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  gap: 0.875rem;
}

.docs-grid--1 { grid-template-columns: 1fr; }
.docs-grid--2 { grid-template-columns: repeat(2, 1fr); }

@media (max-width: 900px) {
  .docs-grid--2 { grid-template-columns: 1fr; }
}

.docs-empty { text-align: center; color: #94a3b8; padding: 2rem 1rem; }

:deep(.docs-card) {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  padding: 1.15rem 1.25rem;
  background: #fff;
  border: 1px solid #e8eef2;
  border-radius: 14px;
  color: inherit;
  height: 100%;
}

:deep(.docs-card__icon) {
  width: 44px;
  height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #e8f4f8, #d4eef0);
  color: #0b4f6c;
  border-radius: 10px;
}

:deep(.docs-card__title) {
  margin: 0 0 0.35rem;
  font-size: 0.9375rem;
  font-weight: 700;
  color: #0b4f6c;
}
</style>
