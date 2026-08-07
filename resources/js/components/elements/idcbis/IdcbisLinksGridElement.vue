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
      <div class="idcbis-links__grid">
        <component
          :is="preview && link.url ? 'a' : 'div'"
          v-for="(link, index) in links"
          :key="link.id || index"
          :href="preview && link.url ? link.url : undefined"
          :target="preview && link.url?.startsWith('http') ? '_blank' : undefined"
          class="link-card"
          :style="cardStyles"
        >
          <ContentIcon :value="link.icon || '🔗'" class="link-card__icon" />
          <h3 :style="element.cardTitleColor ? { color: element.cardTitleColor } : undefined">{{ link.label }}</h3>
          <p v-if="link.description">{{ link.description }}</p>
        </component>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles, resolveBackground } from '../../../composables/useElementStyles'
import ContentIcon from '../ContentIcon.vue'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const links = computed(() => props.element.links || [])

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
  max-width: 1400px;
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
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 1.25rem;
}

.link-card {
  display: block;
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
</style>
