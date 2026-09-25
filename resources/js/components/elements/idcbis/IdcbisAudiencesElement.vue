<template>
  <!--
    Acceso complementario por perfil. No sustituye el menú principal:
    ayuda a que cada persona llegue a una página ya publicada.
  -->
  <section
    class="idcbis-audiences"
    :aria-labelledby="titleId"
    @click.stop="$emit('click', element)"
  >
    <div class="idcbis-audiences__container">
      <header
        class="idcbis-audiences__header"
        :class="partClasses('audiences:header')"
        @click.stop="focusPart('audiences:header', 'Título de perfiles', $event)"
      >
        <h2 :id="titleId">
          {{ element.sectionTitle || 'Encuentra lo que necesitas según tu perfil' }}
        </h2>
        <p v-if="element.sectionSubtitle">{{ element.sectionSubtitle }}</p>
      </header>

      <ul class="idcbis-audiences__grid">
        <li v-for="(card, index) in cards" :key="card.id || index">
          <component
            :is="preview ? 'a' : 'div'"
            class="idcbis-audiences__card"
            :class="partClasses(cardAnchor(card, index))"
            :href="preview ? (card.url || '#') : undefined"
            @click.stop="onCardClick(card, index, $event)"
          >
            <component :is="cardIcon(card.icon)" class="idcbis-audiences__icon" aria-hidden="true" />
            <h3>{{ card.title }}</h3>
            <p>{{ card.description }}</p>
            <span class="idcbis-audiences__link">
              {{ card.linkText || 'Ir a mi sección' }}
              <ArrowRight class="idcbis-audiences__arrow" aria-hidden="true" />
            </span>
          </component>
        </li>
      </ul>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import {
  ArrowRight,
  Briefcase,
  Droplet,
  FlaskConical,
  GraduationCap,
  Handshake,
  HeartHandshake,
  Newspaper,
  Stethoscope,
  Users,
} from 'lucide-vue-next'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildAudienceFocusAnchor } from '../../../utils/editorPartFocus'

const ICONS = {
  users: Users,
  droplet: Droplet,
  patient: HeartHandshake,
  stethoscope: Stethoscope,
  flask: FlaskConical,
  student: GraduationCap,
  handshake: Handshake,
  news: Newspaper,
  briefcase: Briefcase,
}

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const cards = computed(() => props.element.cards || [])
const titleId = computed(() => `audiences-title-${props.element.id || 'home'}`)
const cardAnchor = (card, index) => buildAudienceFocusAnchor(card.id || `index-${index}`)
const cardIcon = (name) => ICONS[name] || Users

const onCardClick = (card, index, event) => {
  focusPart(cardAnchor(card, index), card.title || `Perfil ${index + 1}`, event)
  if (!props.preview) emit('click', props.element)
}
</script>

<style scoped>
.idcbis-audiences {
  font-family: var(--font-idcbis);
  background: #f8f9fa;
  padding: 3.5rem 1.25rem;
  cursor: pointer;
}

.idcbis-audiences__container {
  max-width: 1200px;
  margin: 0 auto;
}

.idcbis-audiences__header {
  max-width: 40rem;
  margin-bottom: 1.75rem;
}

.idcbis-audiences__header h2 {
  margin: 0 0 0.5rem;
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.5rem, 3vw, 2rem);
  font-weight: 800;
  line-height: 1.2;
  color: #0B4F6C;
}

.idcbis-audiences__header p {
  margin: 0;
  color: #607d8b;
  font-size: 1.05rem;
  line-height: 1.5;
}

.idcbis-audiences__grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: 1fr;
  gap: 0.875rem;
}

.idcbis-audiences__card {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  height: 100%;
  padding: 1.15rem 1.15rem 1rem;
  background: #ffffff;
  border: 1px solid #eceff1;
  border-radius: 0.9rem;
  text-decoration: none;
  color: inherit;
  box-shadow: 0 1px 2px rgba(0, 60, 95, 0.04);
  transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
}

.idcbis-audiences__card:hover {
  border-color: #008996;
  box-shadow: 0 10px 24px rgba(0, 60, 95, 0.08);
  transform: translateY(-2px);
}

.idcbis-audiences__card:focus-visible {
  outline: 3px solid #005674;
  outline-offset: 3px;
}

.idcbis-audiences__icon {
  width: 1.5rem;
  height: 1.5rem;
  margin-bottom: 0.75rem;
  color: #005674;
}

.idcbis-audiences__card h3 {
  margin: 0 0 0.35rem;
  font-size: 1.05rem;
  font-weight: 700;
  color: #0B4F6C;
  line-height: 1.3;
}

.idcbis-audiences__card p {
  margin: 0 0 0.9rem;
  color: #607d8b;
  font-size: 0.95rem;
  line-height: 1.45;
}

.idcbis-audiences__link {
  margin-top: auto;
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  min-height: 44px;
  font-weight: 700;
  color: #005674;
}

.idcbis-audiences__arrow {
  width: 1rem;
  height: 1rem;
}

@media (min-width: 700px) {
  .idcbis-audiences__grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (min-width: 1024px) {
  .idcbis-audiences__grid {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}

@media (prefers-reduced-motion: reduce) {
  .idcbis-audiences__card,
  .idcbis-audiences__card:hover {
    transition: none;
    transform: none;
  }
}
</style>
