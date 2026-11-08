<template>
  <section
    class="idcbis-services"
    :class="{ 'is-plain': element.variant === 'plain', 'is-rail': useRail }"
    :id="element.sectionAnchor || undefined"
    @click.stop="$emit('click', element)"
  >
    <div class="idcbis-services__container">
      <div
        class="idcbis-services__header"
        :class="partClasses('services:header')"
        @click.stop="focusPart('services:header', 'Título de servicios', $event)"
      >
        <h2>
          {{ element.sectionTitle || 'Nuestros' }}
          <span>{{ element.sectionHighlight || 'servicios' }}</span>
        </h2>
        <p v-if="element.sectionSubtitle">{{ element.sectionSubtitle }}</p>
      </div>

      <div
        v-if="useRail"
        class="services-rail"
        @mouseleave="closeCards"
        @focusout="onRailFocusOut"
      >
        <p class="sr-only" aria-live="polite">{{ liveMessage }}</p>
        <div ref="trackRef" class="services-rail__track" role="list">
          <component
            :is="preview ? 'a' : 'div'"
            v-for="(card, index) in cards"
            :key="card.id || index"
            :href="preview ? (card.url || '#') : undefined"
            :target="cardTarget(card)"
            :rel="cardTarget(card) === '_blank' ? 'noopener noreferrer' : undefined"
            class="service-card service-card--rail"
            :class="[partClasses(cardAnchor(card, index)), { 'is-active': isActive(card, index) }]"
            :data-key="cardKey(card, index)"
            role="listitem"
            :aria-labelledby="cardTitleId(card, index)"
            @mouseenter="openCard(card, index)"
            @focusin="openCard(card, index)"
            @click.stop="onCardClick(card, index, $event)"
          >
            <div class="service-card__media">
              <picture v-if="card.image">
                <source
                  type="image/webp"
                  :srcset="cardSrcSet(card.image)"
                  sizes="(max-width: 900px) 86vw, 28vw"
                />
                <img
                  class="service-card__image"
                  :src="card.image"
                  :alt="card.imageAlt || ''"
                  width="1200"
                  height="800"
                  loading="lazy"
                  decoding="async"
                />
              </picture>
            </div>
            <span class="service-card__shade" aria-hidden="true"></span>
            <div class="service-card__content">
              <span v-if="card.tag" class="service-card__tag">{{ card.tag }}</span>
              <h3 :id="cardTitleId(card, index)">{{ card.title }}</h3>
              <span v-if="cardTarget(card) === '_blank'" class="sr-only">{{ t('ui.newWindow') }}</span>
              <div class="service-card__detail">
                <div class="service-card__detail-inner">
                  <p v-if="card.description">{{ card.description }}</p>
                  <span class="service-card__more">
                    {{ t('ui.knowService') }}
                    <ArrowRight :size="16" aria-hidden="true" />
                  </span>
                </div>
              </div>
            </div>
          </component>
        </div>
        <div class="services-rail__nav">
          <button
            type="button"
            class="services-rail__arrow"
            :aria-label="t('ui.previousService')"
            @click.stop="cycle(-1)"
          >
            <span aria-hidden="true">←</span>
          </button>
          <button
            type="button"
            class="services-rail__arrow"
            :aria-label="t('ui.nextService')"
            @click.stop="cycle(1)"
          >
            <span aria-hidden="true">→</span>
          </button>
        </div>
      </div>

      <div v-else class="idcbis-services__grid">
        <component
          :is="preview ? 'a' : 'div'"
          v-for="(card, index) in cards"
          :key="card.id || index"
          :href="preview ? (card.url || '#') : undefined"
          :target="cardTarget(card)"
          :rel="cardTarget(card) === '_blank' ? 'noopener noreferrer' : undefined"
          class="service-card"
          :class="partClasses(cardAnchor(card, index))"
          :style="{ backgroundColor: card.bgColor || cardBgs[index % cardBgs.length] }"
          :aria-labelledby="cardTitleId(card, index)"
          @click.stop="onCardClick(card, index, $event)"
        >
          <div class="service-card__media">
            <picture v-if="card.image">
              <source
                type="image/webp"
                :srcset="cardSrcSet(card.image)"
                sizes="(max-width: 640px) 100vw, (max-width: 900px) 50vw, 33vw"
              />
              <img
                class="service-card__image"
                :src="card.image"
                :alt="card.imageAlt || card.title || ''"
                width="1200"
                height="800"
                loading="lazy"
                decoding="async"
              />
            </picture>
          </div>
          <div class="service-card__content">
            <h3 :id="cardTitleId(card, index)">{{ card.title }}</h3>
            <span v-if="cardTarget(card) === '_blank'" class="sr-only">{{ t('ui.newWindow') }}</span>
            <p v-if="card.description">{{ card.description }}</p>
            <span v-if="card.tag" class="service-card__tag">{{ card.tag }}</span>
          </div>
        </component>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, nextTick, ref } from 'vue'
import { ArrowRight } from 'lucide-vue-next'
import { useI18n } from '../../../i18n'
import { IDCBIS_THEME } from '../../../config/idcbisTheme'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildServiceCardFocusAnchor } from '../../../utils/editorPartFocus'
import { CARD_WIDTHS, buildSrcSet } from '../../../utils/responsiveImages'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { t } = useI18n()
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const cardBgs = IDCBIS_THEME.cardBgs
const cards = computed(() => props.element.cards || [])
const useRail = computed(() => props.element.variant !== 'plain' && cards.value.length >= 4)

const activeKey = ref(null)
const liveMessage = ref('')
const trackRef = ref(null)

const cardKey = (card, index) => String(card.id || index)
const isActive = (card, index) => activeKey.value === cardKey(card, index)

const openCard = (card, index) => {
  if (!useRail.value) return
  activeKey.value = cardKey(card, index)
  liveMessage.value = card.title || ''
}

const closeCards = () => {
  activeKey.value = null
}

const onRailFocusOut = (event) => {
  const next = event.relatedTarget
  if (next && event.currentTarget?.contains(next)) return
  closeCards()
}

const cycle = (direction) => {
  const count = cards.value.length
  if (!count) return
  const current = cards.value.findIndex((card, index) => cardKey(card, index) === activeKey.value)
  const base = current < 0 ? (direction > 0 ? -1 : 0) : current
  const next = (base + direction + count) % count
  const card = cards.value[next]
  activeKey.value = cardKey(card, next)
  liveMessage.value = card.title || ''
  const motion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  nextTick(() => {
    trackRef.value
      ?.querySelector(`[data-key="${activeKey.value}"]`)
      ?.scrollIntoView({ behavior: motion ? 'auto' : 'smooth', inline: 'center', block: 'nearest' })
  })
}

const cardAnchor = (card, index) => buildServiceCardFocusAnchor(card.id || `index-${index}`)

const cardTitleId = (card, index) => `service-card-title-${card.id || index}`

const cardTarget = (card) => (props.preview && card.target === '_blank' ? '_blank' : undefined)

const cardSrcSet = (src) => buildSrcSet(src, CARD_WIDTHS)

const onCardClick = (card, index, event) => {
  focusPart(cardAnchor(card, index), card.title || `Tarjeta ${index + 1}`, event)
  if (!props.preview) emit('click', props.element)
}
</script>

<style scoped>
.idcbis-services {
  padding: 6rem 2rem;
  background: #f5f8fa;
  cursor: pointer;
  font-family: var(--font-idcbis);
  scroll-margin-top: 88px;
}

.idcbis-services__container {
  max-width: 1400px;
  margin: 0 auto;
}

.idcbis-services__header {
  text-align: center;
  margin-bottom: 4rem;
}

.idcbis-services.is-rail .idcbis-services__header {
  margin-bottom: 1.75rem;
}

.idcbis-services__header h2 {
  font-size: clamp(1.75rem, 3vw, 2.5rem);
  font-weight: 800;
  line-height: 1.2;
  text-transform: uppercase;
  color: #0b4f6c;
}

.idcbis-services__header h2 span {
  color: #005674;
}

.idcbis-services__header p {
  font-size: 1.125rem;
  line-height: 1.65;
  color: #333333;
  max-width: 700px;
  margin: 0.5rem auto 0;
}

.idcbis-services__grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  align-items: stretch;
  gap: 2rem;
}

.service-card {
  border-radius: 40px 20px 40px 20px;
  padding: 0;
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.1);
  border: 2px solid transparent;
  display: flex;
  flex-direction: column;
  text-decoration: none;
  color: inherit;
  overflow: hidden;
  height: 100%;
}

.service-card:hover {
  transform: translateY(-4px);
  border-color: #0b4f6c;
  box-shadow: 0 30px 40px -10px rgba(0, 0, 0, 0.18);
}

.service-card:focus-visible {
  outline: 3px solid #005674;
  outline-offset: 3px;
}

.service-card__media {
  aspect-ratio: 3 / 2;
  background-color: #d1e9f2;
  overflow: hidden;
}

.service-card__media picture,
.service-card__image {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.idcbis-services.is-plain {
  background: #fff;
}

.idcbis-services.is-plain .service-card {
  border-radius: 16px;
  background: #fff;
  box-shadow: 0 8px 24px rgba(11, 79, 108, 0.08);
}

.idcbis-services.is-plain .service-card:hover {
  box-shadow: 0 16px 28px rgba(11, 79, 108, 0.14);
}

.idcbis-services.is-plain .service-card__media {
  background-color: transparent;
}

.idcbis-services.is-plain .service-card__image {
  object-fit: contain;
  background: transparent;
}

.service-card__content {
  padding: 1.8rem 1.8rem 2rem;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.service-card h3 {
  font-size: clamp(1.35rem, 1.1rem + 0.9vw, 2rem);
  font-weight: 700;
  margin-bottom: 0.8rem;
  color: #1b1b1b;
  line-height: 1.2;
}

.service-card p {
  font-size: 1rem;
  line-height: 1.65;
  margin-bottom: 2rem;
  color: #333;
  flex-grow: 1;
}

.service-card__tag {
  display: inline-block;
  background: white;
  padding: 0.5rem 1.5rem;
  border-radius: 40px;
  font-weight: 700;
  font-size: 0.9rem;
  align-self: flex-start;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
  border: 1px solid rgba(0, 0, 0, 0.1);
}

.services-rail__track {
  display: flex;
  align-items: stretch;
  gap: 0.75rem;
  min-height: 28rem;
}

.service-card--rail {
  position: relative;
  flex: 1 1 0;
  justify-content: flex-end;
  min-width: 0;
  min-height: 28rem;
  border: 0;
  border-radius: 1.25rem;
  box-shadow: none;
  color: #ffffff;
  isolation: isolate;
  transition: flex-grow 0.45s ease;
}

.services-rail__track:hover .service-card--rail,
.services-rail__track:focus-within .service-card--rail {
  flex-grow: 0.72;
}

.services-rail__track .service-card--rail.is-active,
.services-rail__track .service-card--rail:focus-visible {
  flex-grow: 2.6;
}

.service-card--rail:hover {
  transform: none;
  border-color: transparent;
  box-shadow: none;
}

.service-card--rail:focus-visible {
  outline: 3px solid #C4A140;
  outline-offset: 3px;
}

.service-card--rail .service-card__media,
.service-card--rail .service-card__shade {
  position: absolute;
  inset: 0;
  z-index: -1;
  aspect-ratio: auto;
}

.service-card--rail .service-card__media {
  background: #003C5F;
}

.service-card--rail .service-card__shade {
  background: linear-gradient(180deg, rgba(0, 60, 95, 0.05) 10%, rgba(0, 60, 95, 0.28) 42%, rgba(0, 36, 58, 0.94) 100%);
}

.service-card--rail .service-card__content {
  position: relative;
  z-index: 1;
  flex-grow: 0;
  padding: 1.25rem 1.1rem 1.2rem;
}

.service-card--rail .service-card__tag {
  order: -1;
  margin-bottom: 0.55rem;
  background: #C4A140;
  color: #003C5F;
  border-color: transparent;
  box-shadow: none;
  padding: 0.28rem 0.7rem;
  font-size: 0.72rem;
  letter-spacing: 0.04em;
}

.service-card--rail h3 {
  margin: 0;
  color: #ffffff;
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.05rem, 1.2vw, 1.45rem);
  line-height: 1.2;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.service-card--rail.is-active h3 {
  display: block;
  -webkit-line-clamp: unset;
}

.service-card--rail .service-card__detail {
  display: grid;
  grid-template-rows: 0fr;
  opacity: 0;
  transition: grid-template-rows 0.45s ease, opacity 0.35s ease;
}

.service-card--rail.is-active .service-card__detail {
  grid-template-rows: 1fr;
  opacity: 1;
}

.service-card--rail .service-card__detail-inner {
  overflow: hidden;
  min-height: 0;
}

.service-card--rail .service-card__detail p {
  margin: 0.75rem 0 0;
  color: #f4f7f8;
  font-size: 0.98rem;
  line-height: 1.5;
  flex-grow: 0;
}

.service-card--rail .service-card__more {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  min-height: 44px;
  margin-top: 0.85rem;
  padding: 0.35rem 0.9rem;
  border-radius: 999px;
  background: #C4A140;
  color: #003C5F;
  font-weight: 800;
}

.services-rail__nav {
  display: flex;
  justify-content: center;
  gap: 0.75rem;
  margin-top: 1.15rem;
}

.services-rail__arrow {
  width: 44px;
  height: 44px;
  border: 2px solid #005674;
  border-radius: 999px;
  background: #ffffff;
  color: #005674;
  font-size: 1.15rem;
  cursor: pointer;
}

.services-rail__arrow:hover {
  background: #005674;
  color: #ffffff;
}

.services-rail__arrow:focus-visible {
  outline: 3px solid #005674;
  outline-offset: 3px;
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
  .idcbis-services__grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .services-rail__track {
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    min-height: 0;
    padding-bottom: 0.35rem;
  }

  .service-card--rail,
  .services-rail__track:hover .service-card--rail,
  .services-rail__track:focus-within .service-card--rail,
  .service-card--rail.is-active {
    flex: 0 0 86%;
    scroll-snap-align: center;
    min-height: 24rem;
  }

  .service-card--rail .service-card__detail,
  .service-card--rail.is-active .service-card__detail {
    grid-template-rows: 1fr;
    opacity: 1;
  }
}

@media (max-width: 640px) {
  .idcbis-services {
    padding: 4rem 1.25rem;
  }

  .idcbis-services__grid {
    grid-template-columns: 1fr;
  }

  .idcbis-services__header h2 {
    font-size: 1.75rem;
  }

  .service-card h3 {
    font-size: 1.5rem;
  }
}

@media (hover: none) {
  .service-card--rail .service-card__detail,
  .service-card--rail.is-active .service-card__detail {
    grid-template-rows: 1fr;
    opacity: 1;
  }
}

@media (prefers-reduced-motion: reduce) {
  .service-card,
  .service-card:hover,
  .service-card--rail,
  .service-card--rail .service-card__detail {
    transition: none;
  }

  .service-card:hover {
    transform: none;
  }
}
</style>
