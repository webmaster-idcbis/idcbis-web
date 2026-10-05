<template>
  <section class="idcbis-links" :class="element.className" :style="sectionStyles" @click.stop="$emit('click', element)">
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
        :class="{ 'is-expand': isExpand }"
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
          <ContentIcon :value="link.icon || '🔗'" class="link-card__icon" />
          <h3 :style="element.cardTitleColor ? { color: element.cardTitleColor } : undefined">{{ link.label }}</h3>
          <p v-if="link.description && !isExpand">{{ link.description }}</p>
          <div v-else-if="link.description" class="link-card__detail">
            <div class="link-card__detail-inner">
              <p>{{ link.description }}</p>
            </div>
          </div>
        </component>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref } from 'vue'
import { mergeElementStyles, resolveBackground } from '../../../composables/useElementStyles'
import ContentIcon from '../ContentIcon.vue'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const links = computed(() => props.element.links || [])
const isExpand = computed(() => props.element.layout === 'expand')
const openKey = ref(null)

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
</style>
