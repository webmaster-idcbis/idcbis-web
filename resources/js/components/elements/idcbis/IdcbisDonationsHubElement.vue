<template>
  <section
    class="donate-hub"
    :class="{ 'is-editor': !preview }"
    aria-labelledby="donate-hub-title"
    @click.stop="$emit('click', element)"
  >
    <div class="donate-hub__hero">
      <div class="donate-hub__glow" aria-hidden="true"></div>
      <header
        class="donate-hub__intro"
        :class="partClasses('hub:hero')"
        @click.stop="focusPart('hub:hero', 'Encabezado', $event)"
      >
        <p class="donate-hub__eyebrow">
          <Heart class="donate-hub__eyebrow-icon" aria-hidden="true" />
          {{ element.eyebrow || 'Un acto que nace de ti' }}
        </p>
        <h1 id="donate-hub-title">{{ element.title || 'Elige cómo regalar vida' }}</h1>
        <p v-if="element.subtitle" class="donate-hub__lead">{{ element.subtitle }}</p>
      </header>
    </div>

    <div class="donate-hub__stage">
      <h2 class="sr-only">Caminos de donación</h2>
      <ul class="donate-hub__paths">
        <li v-for="(path, index) in paths" :key="path.id || index">
          <component
            :is="pathTag(path)"
            class="path-card"
            :class="[pathToneClass(path), partClasses(pathAnchor(index))]"
            v-bind="pathBind(path)"
            @click="onPathClick(index, $event)"
          >
            <span
              class="path-card__media"
              :style="mediaStyle(path)"
              aria-hidden="true"
            ></span>
            <span class="path-card__shade" aria-hidden="true"></span>
            <span class="path-card__body">
              <span class="path-card__kicker">
                <component :is="pathIcon(path)" class="path-card__icon" aria-hidden="true" />
                {{ path.kicker }}
              </span>
              <h3 class="path-card__title">{{ path.title }}</h3>
              <span v-if="path.description" class="path-card__desc">{{ path.description }}</span>
              <span v-if="pathFacts(path).length" class="path-card__facts">
                <span v-for="fact in pathFacts(path)" :key="fact">{{ fact }}</span>
              </span>
              <span class="path-card__cta">
                {{ path.cta || 'Conocer este camino' }}
                <span aria-hidden="true">→</span>
              </span>
            </span>
          </component>
        </li>
      </ul>
    </div>

    <section
      class="donate-hub__values"
      aria-labelledby="donate-hub-values"
      :class="partClasses('hub:values')"
      @click.stop="focusPart('hub:values', 'Principios', $event)"
    >
      <div class="donate-hub__values-inner">
        <h2 id="donate-hub-values">{{ element.valuesTitle || 'Así entendemos la donación' }}</h2>
        <ul>
          <li v-for="(value, index) in values" :key="value.id || index">
            <span class="value-mark" aria-hidden="true">
              <component :is="valueIcon(index)" />
            </span>
            <span>
              <strong>{{ value.title }}</strong>
              <span>{{ value.text }}</span>
            </span>
          </li>
        </ul>
      </div>
    </section>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { RouterLink } from 'vue-router'
import { Droplet, HandHeart, Heart, ShieldCheck, Users } from 'lucide-vue-next'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const paths = computed(() => (Array.isArray(props.element.paths) ? props.element.paths : []))
const values = computed(() => (Array.isArray(props.element.values) ? props.element.values : []))

const pathAnchor = (index) => `hub:path:${index}`

const pathFacts = (path) => (Array.isArray(path.facts) ? path.facts.filter(Boolean) : [])

const pathToneClass = (path) => (path.tone === 'tejidos' ? 'path-card--tejidos' : 'path-card--sangre')

const pathIcon = (path) => (path.tone === 'tejidos' ? Heart : Droplet)

const valueIcons = [HandHeart, Heart, Users, ShieldCheck]
const valueIcon = (index) => valueIcons[index % valueIcons.length]

const isExternal = (url) => /^https?:\/\//i.test(url || '')

const pathTag = (path) => {
  if (!props.preview || !path.url) return 'div'
  return isExternal(path.url) ? 'a' : RouterLink
}

const pathBind = (path) => {
  if (!props.preview || !path.url) return {}
  if (isExternal(path.url)) return { href: path.url }
  return { to: path.url }
}

const mediaStyle = (path) => {
  if (!path.image) return {}
  return { backgroundImage: `url("${path.image}")` }
}

const onPathClick = (index, event) => {
  if (props.preview) return
  focusPart(pathAnchor(index), `Camino ${index + 1}`, event)
}
</script>

<style scoped>
.donate-hub {
  font-family: var(--font-idcbis);
  background: #f4f7f8;
  color: #1a1a1a;
  overflow: hidden;
}

.donate-hub.is-editor {
  cursor: pointer;
}

.donate-hub__hero {
  position: relative;
  padding: 5.25rem 1.25rem 7.5rem;
  background: linear-gradient(155deg, #003c5f 0%, #005674 48%, #0b4f6c 100%);
  color: #fff;
}

.donate-hub__glow {
  position: absolute;
  inset: 0;
  background:
    radial-gradient(circle at 12% 78%, rgba(196, 161, 64, 0.38), transparent 32%),
    radial-gradient(circle at 88% 12%, rgba(0, 172, 193, 0.32), transparent 28%),
    repeating-linear-gradient(115deg, rgba(255, 255, 255, 0.045) 0 1px, transparent 1px 16px);
  pointer-events: none;
}

.donate-hub__intro {
  position: relative;
  z-index: 1;
  max-width: 46rem;
  margin: 0 auto;
  text-align: center;
}

.donate-hub__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  margin: 0 0 1rem;
  padding: 0.35rem 0.85rem;
  border: 1px solid rgba(232, 212, 138, 0.7);
  border-radius: 999px;
  color: #f3e2ad;
  font-size: 0.95rem;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

.donate-hub__eyebrow-icon {
  width: 1rem;
  height: 1rem;
}

.donate-hub__intro h1 {
  margin: 0;
  font-family: var(--font-idcbis-display);
  font-size: clamp(2.2rem, 6.4vw, 4.6rem);
  font-weight: 900;
  line-height: 0.95;
  letter-spacing: -0.02em;
  text-transform: uppercase;
  text-wrap: balance;
}

.donate-hub__lead {
  max-width: 38rem;
  margin: 1.15rem auto 0;
  color: rgba(255, 255, 255, 0.94);
  font-size: 1.15rem;
  line-height: 1.65;
}

.donate-hub__stage {
  position: relative;
  z-index: 1;
  max-width: 1240px;
  margin: -4.25rem auto 0;
  padding: 0 1.25rem 2.5rem;
}

.donate-hub__paths {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
  margin: 0;
  padding: 0;
  list-style: none;
}

.donate-hub__paths > li {
  display: flex;
  min-width: 0;
}

.path-card {
  position: relative;
  display: flex;
  flex: 1;
  min-height: 28rem;
  overflow: hidden;
  border-radius: 36px 12px 36px 12px;
  color: #fff;
  text-decoration: none;
  box-shadow: 0 22px 48px rgba(0, 60, 95, 0.22);
  isolation: isolate;
}

.path-card:focus-visible {
  outline: 3px solid #c4a140;
  outline-offset: 4px;
}

.path-card__media,
.path-card__shade {
  position: absolute;
  inset: 0;
}

.path-card__media {
  background-color: #0b4f6c;
  background-position: center;
  background-size: cover;
  transform: scale(1.04);
  transition: transform 0.7s ease;
}

.path-card--sangre .path-card__shade {
  background:
    linear-gradient(180deg, rgba(90, 12, 24, 0.05) 0%, rgba(0, 32, 48, 0.08) 42%, rgba(0, 24, 40, 0.94) 100%);
}

.path-card--tejidos .path-card__shade {
  background:
    linear-gradient(180deg, rgba(196, 161, 64, 0.08) 0%, rgba(0, 40, 56, 0.1) 42%, rgba(0, 28, 46, 0.94) 100%);
}

.path-card--sangre::after,
.path-card--tejidos::after {
  content: "";
  position: absolute;
  z-index: 2;
  top: 0;
  right: 0;
  left: 0;
  height: 4px;
  pointer-events: none;
}

.path-card--sangre::after {
  background: #d32f2f;
}

.path-card--tejidos::after {
  background: #c4a140;
}

.path-card__body {
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-end;
  gap: 0.75rem;
  width: 100%;
  margin-top: auto;
  padding: 1.35rem 1.35rem 1.5rem;
  background: linear-gradient(180deg, transparent 0%, transparent 42%, rgba(0, 22, 36, 0.78) 72%, rgba(0, 22, 36, 0.92) 100%);
}

.path-card__kicker {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  color: #f6e7b8;
  font-size: 0.95rem;
  font-weight: 700;
  letter-spacing: 0.06em;
  text-transform: uppercase;
}

.path-card__icon {
  width: 1.05rem;
  height: 1.05rem;
}

.path-card__title {
  margin: 0;
  font-family: var(--font-idcbis-display);
  font-size: clamp(2rem, 4vw, 3.1rem);
  font-weight: 900;
  line-height: 0.95;
  letter-spacing: -0.02em;
  text-transform: uppercase;
}

.path-card__desc {
  max-width: 36rem;
  color: rgba(255, 255, 255, 0.94);
  font-size: 1.05rem;
  line-height: 1.55;
}

.path-card__facts {
  display: flex;
  flex-wrap: wrap;
  gap: 0.45rem;
}

.path-card__facts span {
  padding: 0.35rem 0.7rem;
  border: 1px solid rgba(255, 255, 255, 0.45);
  border-radius: 999px;
  background: rgba(0, 24, 40, 0.35);
  font-size: 0.92rem;
  font-weight: 700;
}

.path-card__cta {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  min-height: 44px;
  margin-top: 0.35rem;
  padding: 0.55rem 1.05rem;
  border-radius: 999px;
  background: #c4a140;
  color: #003c5f;
  font-size: 1.05rem;
  font-weight: 800;
}

.path-card:hover .path-card__media,
.path-card:focus-visible .path-card__media {
  transform: scale(1.1);
}

.path-card:hover .path-card__cta,
.path-card:focus-visible .path-card__cta {
  background: #e6c56a;
}

.donate-hub__values {
  padding: 0.5rem 1.25rem 4.5rem;
}

.donate-hub__values-inner {
  max-width: 1240px;
  margin: 0 auto;
}

.donate-hub__values h2 {
  margin: 0 0 1.25rem;
  color: #0b4f6c;
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  font-weight: 800;
  text-transform: uppercase;
}

.donate-hub__values ul {
  display: grid;
  grid-template-columns: 1fr;
  gap: 0.9rem;
  margin: 0;
  padding: 0;
  list-style: none;
}

.donate-hub__values li {
  display: flex;
  gap: 0.85rem;
  align-items: flex-start;
  min-height: 44px;
  padding: 1.05rem 1.1rem 1.15rem;
  border-radius: 18px 8px 18px 8px;
  background: #fff;
  box-shadow: inset 0 3px 0 #c4a140, 0 10px 24px rgba(0, 60, 95, 0.06);
}

.value-mark {
  display: inline-flex;
  flex: 0 0 auto;
  align-items: center;
  justify-content: center;
  width: 2.5rem;
  height: 2.5rem;
  border-radius: 999px;
  background: #e7f3f6;
  color: #005674;
}

.value-mark svg {
  width: 1.2rem;
  height: 1.2rem;
}

.donate-hub__values strong {
  display: block;
  color: #003c5f;
  font-size: 1.05rem;
}

.donate-hub__values li span span {
  display: block;
  margin-top: 0.2rem;
  color: #1a1a1a;
  line-height: 1.5;
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

@media (min-width: 700px) {
  .donate-hub__values ul {
    grid-template-columns: 1fr 1fr;
  }
}

@media (min-width: 960px) {
  .donate-hub__paths {
    grid-template-columns: 1fr 1fr;
  }

  .path-card {
    min-height: 34rem;
  }

  .donate-hub__values ul {
    grid-template-columns: repeat(4, 1fr);
  }
}

@media (prefers-reduced-motion: reduce) {
  .path-card__media {
    transition: none;
    transform: none;
  }

  .path-card:hover .path-card__media,
  .path-card:focus-visible .path-card__media {
    transform: none;
  }
}
</style>
