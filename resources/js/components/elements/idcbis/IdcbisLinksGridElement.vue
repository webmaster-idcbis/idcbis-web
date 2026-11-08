<template>
  <section class="idcbis-links" :class="[element.className, { 'is-media': isMedia }]" :style="sectionStyles" @click.stop="$emit('click', element)">
    <div class="idcbis-links__container">
      <div class="idcbis-links__header">
        <h2>
          {{ element.sectionTitle || 'Recursos' }}
          <span :style="{ color: element.highlightColor || '#C4A140' }">{{ element.sectionHighlight || 'y enlaces' }}</span>
        </h2>
        <p v-if="element.sectionSubtitle">{{ element.sectionSubtitle }}</p>
      </div>
      <div
        class="idcbis-links__grid"
        :class="{ 'is-expand': isExpand, 'is-media': isMedia }"
        @mouseleave="closeCards"
        @focusout="onGridFocusOut"
      >
        <component
          :is="preview && link.url ? 'a' : 'div'"
          v-for="(link, index) in links"
          :key="link.id || index"
          :href="preview && link.url ? link.url : undefined"
          :target="preview && link.url?.startsWith('http') ? '_blank' : undefined"
          :rel="preview && link.url?.startsWith('http') ? 'noopener noreferrer' : undefined"
          class="link-card"
          :class="{ 'is-active': isExpand && openKey === cardKey(link, index) }"
          :style="cardStyles"
          @mouseenter="openCard(link, index)"
          @focusin="openCard(link, index)"
        >
          <div v-if="isMedia && link.image" class="link-card__media">
            <picture v-if="rasterSrcSet(link.image)">
              <source
                type="image/webp"
                :srcset="rasterSrcSet(link.image)"
                sizes="(max-width: 900px) 78vw, 25vw"
              />
              <img
                :src="link.image"
                :alt="link.imageAlt || ''"
                width="1200"
                height="750"
                loading="lazy"
                decoding="async"
              />
            </picture>
            <img
              v-else
              :src="link.image"
              :alt="link.imageAlt || ''"
              width="1200"
              height="750"
              loading="lazy"
              decoding="async"
            />
          </div>
          <span v-if="isMedia && link.image" class="link-card__shade" aria-hidden="true"></span>
          <div class="link-card__body">
            <ContentIcon v-if="!isMedia || !link.image" :value="link.icon || '🔗'" class="link-card__icon" />
            <h3 :style="!isMedia && element.cardTitleColor ? { color: element.cardTitleColor } : undefined">{{ link.label }}</h3>
            <p v-if="link.description && (!isExpand || isMedia)">{{ link.description }}</p>
            <div v-else-if="link.description" class="link-card__detail">
              <div class="link-card__detail-inner">
                <p>{{ link.description }}</p>
              </div>
            </div>
            <span v-if="isMedia && preview && link.url" class="link-card__cta">
              Conocer la línea
              <span aria-hidden="true">→</span>
            </span>
          </div>
        </component>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref } from 'vue'
import { mergeElementStyles, resolveBackground } from '../../../composables/useElementStyles'
import { CARD_WIDTHS, buildSrcSet } from '../../../utils/responsiveImages'
import ContentIcon from '../ContentIcon.vue'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const links = computed(() => props.element.links || [])
const isExpand = computed(() => props.element.layout === 'expand')
const isMedia = computed(() => props.element.layout === 'media')
const openKey = ref(null)

const rasterSrcSet = (src) => {
  if (!src || /\.svg(?:[?#].*)?$/i.test(src)) return ''
  const clean = String(src).split('?')[0]
  if (!/\.(?:jpe?g|png|webp)$/i.test(clean)) return ''
  if (/programa/i.test(clean)) return ''
  return buildSrcSet(src, CARD_WIDTHS)
}

const cardKey = (link, index) => String(link.id || index)

const openCard = (link, index) => {
  if (!isExpand.value) return
  openKey.value = cardKey(link, index)
}

const closeCards = () => {
  openKey.value = null
}

const onGridFocusOut = (event) => {
  const next = event.relatedTarget
  if (next && event.currentTarget?.contains(next)) return
  closeCards()
}

const sectionStyles = computed(() => {
  const styles = mergeElementStyles(props.element)

  // Soporta color plano o gradiente; sin imagen de fondo aplica el azul institucional por defecto
  if (!props.element.backgroundImage) {
    styles.background = resolveBackground(props.element, '#0b4f6c')
    delete styles.backgroundColor
  }

  if (!styles.padding) styles.padding = '5rem 2rem'
  if (!styles.color) styles.color = '#ffffff'

  return styles
})

const cardStyles = computed(() => {
  if (isMedia.value) {
    return { borderRadius: '18px' }
  }

  const styles = {}
  if (props.element.cardBackground) styles.background = props.element.cardBackground
  if (props.element.cardTextColor) styles.color = props.element.cardTextColor
  if (props.element.cardBorder) styles.border = props.element.cardBorder
  if (props.element.cardBorderRadius) styles.borderRadius = props.element.cardBorderRadius
  if (props.element.cardBoxShadow) styles.boxShadow = props.element.cardBoxShadow
  return styles
})
</script>

<style scoped>
.idcbis-links {
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.idcbis-links__container {
  max-width: 1200px;
  margin: 0 auto;
}

.idcbis-links__header {
  text-align: center;
  margin-bottom: 2.5rem;
}

.idcbis-links__header h2 {
  font-size: clamp(1.75rem, 3vw, 2.5rem);
  font-weight: 800;
  text-transform: uppercase;
}

.idcbis-links__header p {
  margin-top: 0.5rem;
  opacity: 0.9;
  max-width: 640px;
  margin-left: auto;
  margin-right: auto;
}

.idcbis-links__grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(min(100%, 240px), 1fr));
  gap: 1.25rem;
}

.link-card {
  display: flex;
  flex-direction: column;
  height: 100%;
  box-sizing: border-box;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 20px;
  padding: 1.5rem;
  text-decoration: none;
  color: inherit;
  transition: transform 0.2s, background 0.2s;
}

.link-card:hover {
  transform: translateY(-4px);
  filter: brightness(1.08);
}

.link-card:focus-visible {
  outline: 2px solid #ffffff;
  outline-offset: 3px;
}

@media (prefers-reduced-motion: reduce) {
  .link-card {
    transition: none;
  }

  .link-card:hover {
    transform: none;
  }
}

.link-card__icon {
  font-size: 2rem;
  display: inline-block;
  margin-bottom: 0.75rem;
}

.link-card h3 {
  font-size: 1.1rem;
  font-weight: 700;
  margin-bottom: 0.35rem;
}

.link-card p {
  font-size: 0.9rem;
  opacity: 0.85;
  line-height: 1.45;
  margin: 0;
}

.idcbis-links__grid.is-expand {
  display: flex;
  align-items: stretch;
  gap: 0.85rem;
  min-height: 300px;
}

.is-expand .link-card {
  flex: 1 1 0%;
  min-width: 0;
  justify-content: flex-start;
  min-height: 300px;
  padding: 1.75rem 1.35rem;
  background: #ffffff;
  color: #1a1a1a;
  border: 1px solid rgba(11, 79, 108, 0.14);
  box-shadow: none;
  overflow: hidden;
  transition: flex-grow 0.5s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.4s ease, border-color 0.4s ease;
}

.is-expand .link-card:hover {
  transform: none;
  filter: none;
}

.is-expand .link-card.is-active {
  flex-grow: 1.75;
  border-color: #008996;
  box-shadow: inset 4px 0 0 #c4a140, 0 14px 32px rgba(0, 60, 95, 0.1);
}

.is-expand .link-card h3 {
  color: #0b4f6c;
  font-size: 1.2rem;
  line-height: 1.25;
}

.is-expand .link-card__detail {
  display: grid;
  grid-template-rows: 0fr;
  opacity: 0;
  margin-top: 0;
  transition: grid-template-rows 0.5s ease, opacity 0.35s ease, margin-top 0.4s ease;
}

.is-expand .link-card.is-active .link-card__detail {
  grid-template-rows: 1fr;
  opacity: 1;
  margin-top: 0.9rem;
}

.is-expand .link-card__detail-inner {
  overflow: hidden;
  min-height: 0;
}

.is-expand .link-card__detail p {
  color: #1a1a1a;
  opacity: 1;
  font-size: 1rem;
  line-height: 1.55;
}

.is-expand .link-card:focus-visible {
  outline: 2px solid #005674;
  outline-offset: 3px;
}

@media (max-width: 899px), (hover: none) {
  .idcbis-links__grid.is-expand {
    display: grid;
    grid-template-columns: 1fr;
    min-height: 0;
  }

  .is-expand .link-card,
  .is-expand .link-card.is-active {
    flex: none;
    min-height: 0;
  }

  .is-expand .link-card__detail,
  .is-expand .link-card.is-active .link-card__detail {
    grid-template-rows: 1fr;
    opacity: 1;
    margin-top: 0.75rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  .is-expand .link-card,
  .is-expand .link-card__detail {
    transition: none;
  }
}

.idcbis-links.is-media .idcbis-links__container {
  max-width: 1400px;
}

.idcbis-links.is-media .idcbis-links__header {
  margin-bottom: 1.75rem;
}

.idcbis-links__grid.is-media {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 0.9rem;
  align-items: stretch;
}

.is-media .link-card {
  position: relative;
  isolation: isolate;
  justify-content: flex-end;
  min-height: 26rem;
  padding: 0;
  overflow: hidden;
  color: #ffffff;
  background: #003c5f;
  border: 0;
  box-shadow: 0 10px 24px rgba(0, 60, 95, 0.12);
}

.is-media .link-card:hover {
  transform: translateY(-4px);
  filter: none;
  box-shadow: 0 16px 32px rgba(0, 60, 95, 0.18);
}

.is-media .link-card:focus-visible {
  outline: 3px solid #c4a140;
  outline-offset: 3px;
}

.link-card__media,
.link-card__shade {
  position: absolute;
  inset: 0;
}

.link-card__media {
  z-index: 0;
  overflow: hidden;
  background: #003c5f;
}

.link-card__shade {
  z-index: 1;
  background: linear-gradient(180deg, rgba(0, 28, 44, 0) 0%, rgba(0, 28, 44, 0.1) 32%, rgba(0, 18, 32, 0.9) 58%, rgba(0, 14, 26, 0.96) 100%);
  pointer-events: none;
}

.link-card__media picture,
.link-card__media img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

.link-card__media img {
  transition: transform 0.45s ease;
}

.is-media .link-card:hover .link-card__media img {
  transform: scale(1.05);
}

.link-card__body {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  min-width: 0;
}

.is-media .link-card__body {
  position: relative;
  z-index: 2;
  flex-grow: 0;
  gap: 0.4rem;
  padding: 1.15rem 1rem 1rem;
}

.is-media .link-card h3 {
  margin: 0;
  color: #ffffff;
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.05rem, 1.2vw, 1.35rem);
  font-weight: 800;
  line-height: 1.2;
}

.is-media .link-card p {
  margin: 0;
  color: #f4f7f8;
  opacity: 1;
  font-size: 0.92rem;
  line-height: 1.45;
}

.link-card__cta {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  min-height: 44px;
  margin-top: 0.2rem;
  color: #ffffff;
  font-weight: 700;
}

.is-media .link-card__cta span {
  color: #d9b85a;
}

@media (max-width: 900px) {
  .idcbis-links__grid.is-media {
    display: grid;
    grid-template-columns: none;
    grid-auto-flow: column;
    grid-auto-columns: min(78vw, 280px);
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    padding-bottom: 0.4rem;
  }

  .is-media .link-card {
    scroll-snap-align: start;
    min-height: 24rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  .is-media .link-card,
  .link-card__media img,
  .is-media .link-card:hover,
  .is-media .link-card:hover .link-card__media img {
    transition: none;
    transform: none;
  }
}
</style>
