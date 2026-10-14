<template>
  <section
    :id="element.anchorId || undefined"
    class="expand-rail"
    :class="{ 'is-editor': !preview, 'is-compact': isCompact }"
    :aria-labelledby="headingId"
    @click.stop="$emit('click', element)"
  >
    <div class="expand-rail__inner">
      <header
        class="expand-rail__header"
        :class="partClasses('expand:header')"
        @click.stop="focusPart('expand:header', 'Título de líneas', $event)"
      >
        <h2 :id="headingId">{{ element.sectionTitle || 'Líneas de investigación' }}</h2>
        <p v-if="element.sectionSubtitle">{{ element.sectionSubtitle }}</p>
      </header>

      <p v-if="canSlide" class="sr-only" aria-live="polite">{{ liveMessage }}</p>

      <div class="expand-rail__track" role="list">
        <template v-for="(card, index) in visibleCards" :key="card.id || index">
          <a
            v-if="preview && !isCompact"
            role="listitem"
            class="expand-card"
            :class="partClasses(cardAnchor(card, index))"
            :href="card.url || '#'"
            @click="onCardClick(card, index, $event)"
          >
            <span class="expand-card__media" :style="mediaStyle(card)" aria-hidden="true"></span>
            <span class="expand-card__shade" aria-hidden="true"></span>
            <span class="expand-card__body">
              <span v-if="card.kicker" class="expand-card__kicker">{{ card.kicker }}</span>
              <span class="expand-card__title">{{ card.title }}</span>
              <span v-if="card.description" class="expand-card__desc">{{ card.description }}</span>
            </span>
          </a>

          <div
            v-else
            role="listitem"
            class="expand-card"
            :class="[partClasses(cardAnchor(card, index)), { 'is-open': isOpen(card) }]"
          >
            <span class="expand-card__media" :style="mediaStyle(card)" aria-hidden="true"></span>
            <span class="expand-card__shade" aria-hidden="true"></span>
            <div class="expand-card__body">
              <button
                v-if="isCompact"
                type="button"
                class="expand-card__toggle"
                :aria-expanded="isOpen(card)"
                :aria-controls="panelId(card, index)"
                @click.stop="onToggle(card, index, $event)"
              >
                <span v-if="card.kicker" class="expand-card__kicker">{{ card.kicker }}</span>
                <span class="expand-card__title">{{ card.title }}</span>
              </button>
              <div v-else @click.stop="onCardClick(card, index, $event)">
                <span v-if="card.kicker" class="expand-card__kicker">{{ card.kicker }}</span>
                <span class="expand-card__title">{{ card.title }}</span>
              </div>
              <div
                :id="panelId(card, index)"
                class="expand-card__panel"
                v-show="!isCompact || isOpen(card)"
              >
                <p v-if="card.description" class="expand-card__desc">{{ card.description }}</p>
                <a
                  v-if="preview && isCompact && card.url"
                  class="expand-card__enter"
                  :href="card.url"
                >{{ card.linkText || 'Abrir' }}</a>
              </div>
            </div>
          </div>
        </template>
      </div>

      <div v-if="canSlide" class="expand-rail__nav">
        <button
          type="button"
          class="expand-rail__arrow"
          :disabled="start === 0"
          aria-label="Ver las tarjetas anteriores"
          @click.stop="slide(-1)"
        >
          <span aria-hidden="true">←</span>
        </button>
        <button
          type="button"
          class="expand-rail__arrow"
          :disabled="start >= maxStart"
          aria-label="Ver las tarjetas siguientes"
          @click.stop="slide(1)"
        >
          <span aria-hidden="true">→</span>
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildExpandingCardFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const isCompact = ref(typeof window !== 'undefined' && window.matchMedia('(max-width: 900px)').matches)
const start = ref(0)
const openId = ref(null)
const liveMessage = ref('')
let mediaQuery

const headingId = computed(() => `${props.element.id || 'expand'}-title`)
const cards = computed(() => props.element.cards || [])
const visibleCount = computed(() => Math.max(1, Number(props.element.visibleCount || 4)))
const canSlide = computed(() => !isCompact.value && cards.value.length > visibleCount.value)
const maxStart = computed(() => Math.max(0, cards.value.length - visibleCount.value))
const visibleCards = computed(() => (
  canSlide.value
    ? cards.value.slice(start.value, start.value + visibleCount.value)
    : cards.value
))

const cardAnchor = (card, index) => buildExpandingCardFocusAnchor(card.id || `index-${index}`)
const panelId = (card, index) => `expand-panel-${card.id || index}`
const isOpen = (card) => !isCompact.value || openId.value === (card.id || card.title)

const mediaStyle = (card) => ({
  backgroundColor: card.accent || '#003C5F',
  backgroundImage: card.image ? `linear-gradient(180deg, rgba(0, 60, 95, 0.08), rgba(0, 60, 95, 0.2)), url("${card.image}")` : undefined,
})

const syncCompact = () => {
  isCompact.value = mediaQuery?.matches ?? false
}

onMounted(() => {
  mediaQuery = window.matchMedia('(max-width: 900px)')
  syncCompact()
  mediaQuery.addEventListener('change', syncCompact)
})

onUnmounted(() => {
  mediaQuery?.removeEventListener('change', syncCompact)
})

const onCardClick = (card, index, event) => {
  focusPart(cardAnchor(card, index), card.title || `Tarjeta ${index + 1}`, event)
  if (!props.preview) emit('click', props.element)
}

const onToggle = (card, index, event) => {
  const id = card.id || card.title
  openId.value = openId.value === id ? null : id
  onCardClick(card, index, event)
}

const slide = (direction) => {
  const next = Math.min(maxStart.value, Math.max(0, start.value + direction))
  start.value = next
  const from = next + 1
  const to = Math.min(cards.value.length, next + visibleCount.value)
  liveMessage.value = `Mostrando tarjetas ${from} a ${to} de ${cards.value.length}`
}
</script>

<style scoped>
.expand-rail {
  padding: 4.5rem 1.25rem 3.5rem;
  background: #f5f8fa;
  font-family: var(--font-idcbis);
  color: #1a1a1a;
  scroll-margin-top: 96px;
}

.expand-rail__inner {
  max-width: 1280px;
  margin: 0 auto;
}

.expand-rail__header {
  margin-bottom: 1.75rem;
  text-align: center;
}

.expand-rail__header h2 {
  margin: 0;
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.75rem, 3vw, 2.6rem);
  font-weight: 800;
  color: #0B4F6C;
  text-transform: uppercase;
  letter-spacing: 0.01em;
}

.expand-rail__header p {
  max-width: 42rem;
  margin: 0.85rem auto 0;
  color: #37474f;
  font-size: 1.125rem;
  line-height: 1.6;
}

.expand-rail__track {
  display: flex;
  gap: 0.75rem;
  align-items: stretch;
  min-height: 28rem;
}

.expand-card {
  position: relative;
  display: flex;
  flex: 1 1 0;
  flex-direction: column;
  justify-content: flex-end;
  min-width: 0;
  min-height: 28rem;
  padding: 1.25rem 1.15rem 1.35rem;
  overflow: hidden;
  border-radius: 1.25rem;
  color: #fff;
  text-decoration: none;
  isolation: isolate;
  transition: flex-grow 0.45s ease;
}

.expand-rail__track:hover .expand-card,
.expand-rail__track:focus-within .expand-card {
  flex-grow: 0.7;
}

.expand-rail__track .expand-card:hover,
.expand-rail__track .expand-card:focus-visible,
.expand-rail.is-editor .expand-card {
  flex-grow: 1;
}

.expand-rail__track .expand-card:hover,
.expand-rail__track .expand-card:focus-visible {
  flex-grow: 2.8;
}

.expand-card:focus-visible {
  outline: 3px solid #C4A140;
  outline-offset: 3px;
}

.expand-card__media,
.expand-card__shade {
  position: absolute;
  inset: 0;
  z-index: -1;
}

.expand-card__media {
  background-color: #003C5F;
  background-position: center;
  background-size: cover;
}

.expand-card__shade {
  background: linear-gradient(180deg, rgba(0, 60, 95, 0.18) 0%, rgba(0, 60, 95, 0.45) 38%, rgba(0, 36, 58, 0.94) 100%);
}

.expand-card__body {
  position: relative;
  z-index: 1;
}

.expand-card__kicker {
  display: block;
  margin-bottom: 0.35rem;
  color: #F3E2A5;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.expand-card__title {
  display: block;
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.25rem, 1.6vw, 1.85rem);
  font-weight: 800;
  line-height: 1.15;
  text-transform: uppercase;
}

.expand-card__desc,
.expand-card__panel .expand-card__desc {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  color: #f4f7f8;
  font-size: 0.98rem;
  font-weight: 500;
  line-height: 1.5;
  opacity: 0;
  transition: max-height 0.35s ease, opacity 0.35s ease, margin-top 0.35s ease;
}

.expand-card:hover .expand-card__desc,
.expand-card:focus-visible .expand-card__desc,
.expand-rail.is-editor .expand-card__desc,
.expand-card.is-open .expand-card__desc {
  max-height: 16rem;
  margin-top: 0.75rem;
  opacity: 1;
}

.expand-card__toggle {
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  width: 100%;
  min-height: 44px;
  padding: 0;
  border: 0;
  background: transparent;
  color: inherit;
  font: inherit;
  text-align: left;
  cursor: pointer;
}

.expand-card__toggle:focus-visible {
  outline: 3px solid #C4A140;
  outline-offset: 4px;
}

.expand-card__enter {
  display: inline-flex;
  align-items: center;
  min-height: 44px;
  margin-top: 0.85rem;
  padding: 0.45rem 1rem;
  border-radius: 999px;
  background: #C4A140;
  color: #003C5F;
  font-weight: 800;
  text-decoration: none;
}

.expand-card__enter:hover {
  background: #D9B85A;
}

.expand-card__enter:focus-visible {
  outline: 3px solid #ffffff;
  outline-offset: 3px;
}

.expand-rail__nav {
  display: flex;
  justify-content: center;
  gap: 0.75rem;
  margin-top: 1.25rem;
}

.expand-rail__arrow {
  width: 44px;
  height: 44px;
  border: 2px solid #005674;
  border-radius: 999px;
  background: #fff;
  color: #005674;
  font-size: 1.15rem;
  cursor: pointer;
}

.expand-rail__arrow:hover:not(:disabled) {
  background: #005674;
  color: #fff;
}

.expand-rail__arrow:focus-visible {
  outline: 3px solid #005674;
  outline-offset: 3px;
}

.expand-rail__arrow:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

@media (max-width: 900px) {
  .expand-rail {
    padding: 3rem 1rem 2.5rem;
  }

  .expand-rail__track {
    flex-direction: column;
    min-height: 0;
  }

  .expand-card,
  .expand-rail__track:hover .expand-card,
  .expand-rail__track:focus-within .expand-card,
  .expand-rail__track .expand-card:hover,
  .expand-rail__track .expand-card:focus-visible,
  .expand-rail.is-editor .expand-card {
    flex: none;
    min-height: 11.5rem;
  }

  .expand-card__desc,
  .expand-card.is-open .expand-card__desc,
  .expand-rail.is-editor .expand-card__desc {
    max-height: none;
    opacity: 1;
  }
}

@media (prefers-reduced-motion: reduce) {
  .expand-card,
  .expand-card__desc,
  .expand-card__panel .expand-card__desc {
    transition: none;
  }
}
</style>
