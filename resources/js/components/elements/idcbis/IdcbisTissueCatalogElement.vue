<template>
  <section :id="element.id || undefined" class="idcbis-tissue-catalog" @click.stop="$emit('click', element)">
    <div class="idcbis-tissue-catalog__container">
      <div
        class="idcbis-tissue-catalog__header"
        :class="partClasses('catalog:header')"
        @click.stop="focusPart('catalog:header', 'Título del portafolio', $event)"
      >
        <h2>
          {{ element.sectionTitle || 'Portafolio de' }}
          <span>{{ element.sectionHighlight || 'tejidos' }}</span>
        </h2>
        <p v-if="element.sectionSubtitle">{{ element.sectionSubtitle }}</p>
      </div>

      <div
        class="idcbis-tissue-catalog__filters"
        role="tablist"
        aria-label="Filtrar portafolio por tipo de tejido"
      >
        <button
          v-for="category in categories"
          :key="category.id"
          type="button"
          role="tab"
          class="filter-chip"
          :class="{ 'is-active': activeCategory === category.id }"
          :aria-selected="activeCategory === category.id"
          :tabindex="activeCategory === category.id ? 0 : -1"
          @click="selectCategory(category.id)"
          @keydown="onFilterKeydown($event, category.id)"
        >
          {{ category.label }}
        </button>
      </div>

      <div class="idcbis-tissue-catalog__grid" role="list">
        <article
          v-for="(item, index) in filteredItems"
          :key="item.id || index"
          class="tissue-card"
          :class="[partClasses(itemAnchor(item, index)), { 'is-open': selectedId === item.id }]"
          role="listitem"
        >
          <button
            type="button"
            class="tissue-card__trigger"
            :aria-expanded="selectedId === item.id"
            :aria-controls="`tissue-detail-${item.id}`"
            @click.stop="toggleItem(item, index, $event)"
          >
            <div
              class="tissue-card__image"
              :style="item.image ? { backgroundImage: `url('${item.image}')` } : {}"
              role="img"
              :aria-label="item.imageAlt || item.title"
            />
            <div class="tissue-card__body">
              <p v-if="item.tag" class="tissue-card__tag">{{ item.tag }}</p>
              <h3>{{ item.title }}</h3>
              <p>{{ item.summary }}</p>
              <span class="tissue-card__more">
                {{ selectedId === item.id ? 'Ocultar detalle' : 'Ver presentaciones y usos' }}
              </span>
            </div>
          </button>
        </article>
      </div>

      <div
        v-if="selectedItem"
        :id="`tissue-detail-${selectedItem.id}`"
        class="tissue-detail"
        tabindex="-1"
      >
        <div class="tissue-detail__intro">
          <p class="tissue-detail__kicker">{{ categoryLabel(selectedItem.category) }}</p>
          <h3>{{ selectedItem.title }}</h3>
          <p v-if="selectedItem.summary">{{ selectedItem.summary }}</p>
        </div>
        <div class="tissue-detail__grid">
          <div v-if="selectedItem.preservation">
            <h4>Preservación</h4>
            <p>{{ selectedItem.preservation }}</p>
          </div>
          <div v-if="selectedItem.conservation">
            <h4>Conservación</h4>
            <p>{{ selectedItem.conservation }}</p>
          </div>
          <div v-if="applicationList.length">
            <h4>Aplicaciones clínicas</h4>
            <ul>
              <li v-for="(app, i) in applicationList" :key="`app-${i}`">{{ app }}</li>
            </ul>
          </div>
          <div v-if="presentationList.length">
            <h4>Presentaciones</h4>
            <ul>
              <li v-for="(pres, i) in presentationList" :key="`pres-${i}`">{{ pres }}</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="idcbis-tissue-catalog__cta">
        <div>
          <h3>Biblioteca digital de tejidos</h3>
          <p>
            Las IPS habilitadas con programas de trasplante e inscritas en la Red Nacional de Donación
            y Trasplantes, y los profesionales independientes inscritos en el REPS, pueden consultar
            el inventario y formalizar la solicitud de tejidos.
          </p>
        </div>
        <div class="idcbis-tissue-catalog__actions">
          <a
            v-if="preview"
            class="btn btn--primary"
            :href="libraryHref"
            :target="isExternal(libraryHref) ? '_blank' : undefined"
            :rel="isExternal(libraryHref) ? 'noopener noreferrer' : undefined"
          >
            {{ element.libraryLabel || 'Abrir biblioteca digital de tejidos' }}
          </a>
          <span v-else class="btn btn--primary">{{ element.libraryLabel || 'Abrir biblioteca digital de tejidos' }}</span>
          <a
            v-if="preview && element.pdfUrl"
            class="btn btn--ghost"
            :href="element.pdfUrl"
            target="_blank"
            rel="noopener noreferrer"
          >
            Descargar portafolio PDF
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildServiceCardFocusAnchor } from '../../../utils/editorPartFocus'

const DEFAULT_CATEGORIES = [
  { id: 'all', label: 'Todos' },
  { id: 'osteomuscular', label: 'Osteomuscular' },
  { id: 'ocular', label: 'Ocular' },
  { id: 'piel', label: 'Piel y dermis' },
  { id: 'membrana', label: 'Membrana amniótica' },
]

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const activeCategory = ref('all')
const selectedId = ref(null)

const items = computed(() => props.element.items || [])

const categories = computed(() => {
  const extra = (props.element.categories || []).filter((c) => c.id && c.id !== 'all')
  const fromItems = [...new Set(items.value.map((item) => item.category).filter(Boolean))]
    .filter((id) => !extra.some((c) => c.id === id))
    .map((id) => DEFAULT_CATEGORIES.find((c) => c.id === id) || { id, label: id })
  return [{ id: 'all', label: 'Todos' }, ...extra, ...fromItems]
})

const filteredItems = computed(() => {
  if (activeCategory.value === 'all') return items.value
  return items.value.filter((item) => item.category === activeCategory.value)
})

const selectedItem = computed(() => items.value.find((item) => item.id === selectedId.value) || null)

const toList = (value) => {
  if (Array.isArray(value)) return value.filter(Boolean)
  if (typeof value === 'string' && value.trim()) {
    return value.split(/\n|•/).map((part) => part.trim()).filter(Boolean)
  }
  return []
}

const applicationList = computed(() => toList(selectedItem.value?.applications))
const presentationList = computed(() => toList(selectedItem.value?.presentations))

const libraryHref = computed(() => {
  if (props.element.libraryUrl) return props.element.libraryUrl
  const email = props.element.requestEmail || 'bandetejidosycelulas@idcbis.org.co'
  return `mailto:${email}?subject=${encodeURIComponent('Solicitud de acceso a la Biblioteca digital de tejidos')}`
})

const itemAnchor = (item, index) => buildServiceCardFocusAnchor(item.id || `index-${index}`)

const categoryLabel = (id) => categories.value.find((c) => c.id === id)?.label || id

const isExternal = (href) => typeof href === 'string' && /^https?:\/\//.test(href)

const selectCategory = (id) => {
  activeCategory.value = id
  if (selectedItem.value && id !== 'all' && selectedItem.value.category !== id) {
    selectedId.value = null
  }
}

const toggleItem = (item, index, event) => {
  selectedId.value = selectedId.value === item.id ? null : item.id
  focusPart(itemAnchor(item, index), item.title || `Tejido ${index + 1}`, event)
  if (!props.preview) emit('click', props.element)
}

const onFilterKeydown = (event, currentId) => {
  const keys = ['ArrowRight', 'ArrowLeft', 'Home', 'End']
  if (!keys.includes(event.key)) return
  event.preventDefault()
  const list = categories.value
  const current = list.findIndex((c) => c.id === currentId)
  let next = current
  if (event.key === 'ArrowRight') next = (current + 1) % list.length
  if (event.key === 'ArrowLeft') next = (current - 1 + list.length) % list.length
  if (event.key === 'Home') next = 0
  if (event.key === 'End') next = list.length - 1
  selectCategory(list[next].id)
  event.currentTarget.parentElement?.querySelectorAll('[role="tab"]')[next]?.focus()
}
</script>

<style scoped>
.idcbis-tissue-catalog {
  padding: 5.5rem 2rem;
  background: linear-gradient(180deg, #f5f8fa 0%, #eef4f7 100%);
  font-family: var(--font-idcbis);
  cursor: pointer;
  scroll-margin-top: 96px;
}

.idcbis-tissue-catalog__container {
  max-width: 1280px;
  margin: 0 auto;
}

.idcbis-tissue-catalog__header {
  text-align: center;
  margin-bottom: 2rem;
}

.idcbis-tissue-catalog__header h2 {
  font-family: var(--font-idcbis-display);
  font-size: clamp(2rem, 4vw, 3.1rem);
  font-weight: 800;
  text-transform: uppercase;
  color: #0b4f6c;
  line-height: 1.15;
}

.idcbis-tissue-catalog__header h2 span {
  background: linear-gradient(135deg, #0b4f6c, #008996);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.idcbis-tissue-catalog__header p {
  margin: 0.85rem auto 0;
  max-width: 720px;
  font-size: 1.15rem;
  line-height: 1.65;
  color: #4b5563;
}

.idcbis-tissue-catalog__filters {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 0.65rem;
  margin-bottom: 2.25rem;
}

.filter-chip {
  min-height: 44px;
  padding: 0.65rem 1.15rem;
  border-radius: 999px;
  border: 1px solid rgba(11, 79, 108, 0.18);
  background: #fff;
  color: #0b4f6c;
  font-weight: 700;
  font-size: 0.92rem;
  cursor: pointer;
}

.filter-chip:hover,
.filter-chip:focus-visible {
  border-color: #005674;
}

.filter-chip:focus-visible {
  outline: none;
  box-shadow: 0 0 0 3px rgba(0, 86, 116, 0.28);
}

.filter-chip.is-active {
  background: linear-gradient(135deg, #005674, #008996);
  color: #fff;
  border-color: transparent;
}

.idcbis-tissue-catalog__grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 1.5rem;
}

.tissue-card {
  background: #fff;
  border-radius: 28px 14px 28px 14px;
  overflow: hidden;
  box-shadow: 0 16px 32px rgba(11, 79, 108, 0.08);
  border: 2px solid transparent;
  transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}

.tissue-card.is-open,
.tissue-card:hover {
  border-color: #008996;
  box-shadow: 0 22px 40px rgba(11, 79, 108, 0.16);
}

.tissue-card__trigger {
  display: flex;
  flex-direction: column;
  width: 100%;
  min-height: 100%;
  text-align: left;
  background: transparent;
  border: 0;
  padding: 0;
  cursor: pointer;
  color: inherit;
}

.tissue-card__trigger:focus-visible {
  outline: none;
  box-shadow: inset 0 0 0 3px #005674;
}

.tissue-card__image {
  height: 190px;
  background: #d1e9f2 center/cover no-repeat;
}

.tissue-card__body {
  display: flex;
  flex-direction: column;
  gap: 0.55rem;
  padding: 1.25rem 1.35rem 1.5rem;
}

.tissue-card__tag {
  align-self: flex-start;
  margin: 0;
  padding: 0.28rem 0.7rem;
  border-radius: 999px;
  background: #e1f0f5;
  color: #005674;
  font-size: 0.72rem;
  font-weight: 800;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

.tissue-card h3 {
  margin: 0;
  color: #0b4f6c;
  font-size: 1.2rem;
  line-height: 1.3;
}

.tissue-card p {
  margin: 0;
  color: #4b5563;
  line-height: 1.55;
  font-size: 0.95rem;
  flex: 1;
}

.tissue-card__more {
  margin-top: 0.35rem;
  color: #008996;
  font-weight: 700;
  font-size: 0.9rem;
}

.tissue-detail {
  margin-top: 1.75rem;
  padding: 1.75rem 1.85rem;
  border-radius: 24px;
  background: #fff;
  border: 1px solid rgba(11, 79, 108, 0.1);
  box-shadow: 0 16px 32px rgba(11, 79, 108, 0.08);
}

.tissue-detail__kicker {
  margin: 0 0 0.35rem;
  color: #c4a140;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  font-size: 0.78rem;
}

.tissue-detail h3 {
  margin: 0 0 0.6rem;
  color: #0b4f6c;
  font-size: 1.5rem;
}

.tissue-detail__intro p {
  margin: 0;
  color: #4b5563;
  line-height: 1.65;
}

.tissue-detail__grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 1.25rem 1.75rem;
  margin-top: 1.35rem;
}

.tissue-detail h4 {
  margin: 0 0 0.45rem;
  color: #005674;
  font-size: 0.95rem;
  text-transform: uppercase;
  letter-spacing: 0.04em;
}

.tissue-detail p,
.tissue-detail li {
  color: #374151;
  line-height: 1.6;
  font-size: 0.95rem;
}

.tissue-detail ul {
  margin: 0;
  padding-left: 1.1rem;
}

.idcbis-tissue-catalog__cta {
  margin-top: 2.5rem;
  display: flex;
  justify-content: space-between;
  gap: 1.5rem;
  align-items: center;
  padding: 1.75rem 1.85rem;
  border-radius: 24px;
  background: linear-gradient(135deg, #0b4f6c 0%, #005674 60%, #008996 100%);
  color: #fff;
}

.idcbis-tissue-catalog__cta h3 {
  margin: 0 0 0.45rem;
  font-size: 1.35rem;
}

.idcbis-tissue-catalog__cta p {
  margin: 0;
  max-width: 640px;
  line-height: 1.6;
  color: rgba(255, 255, 255, 0.9);
}

.idcbis-tissue-catalog__actions {
  display: flex;
  flex-direction: column;
  gap: 0.7rem;
  min-width: min(100%, 280px);
}

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 44px;
  padding: 0.75rem 1.1rem;
  border-radius: 999px;
  font-weight: 700;
  text-decoration: none;
  text-align: center;
}

.btn--primary {
  background: #c4a140;
  color: #1a1a1a;
}

.btn--primary:hover,
.btn--primary:focus-visible {
  background: #d4b35a;
}

.btn--ghost {
  background: transparent;
  color: #fff;
  border: 1px solid rgba(255, 255, 255, 0.45);
}

.btn--ghost:hover,
.btn--ghost:focus-visible {
  border-color: #fff;
}

.btn:focus-visible {
  outline: none;
  box-shadow: 0 0 0 3px rgba(196, 161, 64, 0.45);
}

@media (max-width: 1024px) {
  .idcbis-tissue-catalog__grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .idcbis-tissue-catalog__cta {
    flex-direction: column;
    align-items: stretch;
  }
}

@media (max-width: 640px) {
  .idcbis-tissue-catalog {
    padding: 4rem 1.15rem;
  }

  .idcbis-tissue-catalog__grid,
  .tissue-detail__grid {
    grid-template-columns: 1fr;
  }
}

@media (prefers-reduced-motion: reduce) {
  .tissue-card,
  .filter-chip,
  .btn {
    transition: none;
  }
}
</style>
