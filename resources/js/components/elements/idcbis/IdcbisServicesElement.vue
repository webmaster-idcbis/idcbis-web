<template>
  <section
    class="idcbis-services"
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
      <div class="idcbis-services__grid">
        <component
          :is="preview ? 'a' : 'div'"
          v-for="(card, index) in cards"
          :key="card.id || index"
          :href="preview ? (card.url || '#') : undefined"
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
            <p>{{ card.description }}</p>
            <span v-if="card.tag" class="service-card__tag">{{ card.tag }}</span>
          </div>
        </component>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
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
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const cardBgs = IDCBIS_THEME.cardBgs
const cards = computed(() => props.element.cards || [])

const cardAnchor = (card, index) => buildServiceCardFocusAnchor(card.id || `index-${index}`)

const cardTitleId = (card, index) => `service-card-title-${card.id || index}`

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
  box-shadow: 0 30px 40px -10px rgba(11, 79, 108, 0.3);
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

@media (max-width: 900px) {
  .idcbis-services__grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
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

@media (prefers-reduced-motion: reduce) {
  .service-card,
  .service-card:hover {
    transition: none;
    transform: none;
  }
}
</style>
