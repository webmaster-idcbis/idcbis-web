<template>
  <section
    :id="element.anchorId || element.id || undefined"
    class="idcbis-card-grid"
    :style="sectionStyles"
    @click.stop="$emit('click', element)"
  >
    <div class="idcbis-card-grid__inner">
      <div v-if="element.title || element.subtitle" class="idcbis-card-grid__header">
        <h2 v-if="element.title">{{ element.title }}</h2>
        <p v-if="element.subtitle">{{ element.subtitle }}</p>
      </div>

      <div v-if="items.length" class="idcbis-card-grid__grid">
        <article
          v-for="(item, index) in items"
          :key="item.id || index"
          class="idcbis-card-grid__card"
        >
          <div class="idcbis-card-grid__icon" aria-hidden="true">
            <component :is="iconFor(item, index)" :size="22" />
          </div>
          <h3>{{ item.title }}</h3>
          <p v-if="item.description">{{ item.description }}</p>
          <dl v-if="item.duration || item.frequency">
            <div v-if="item.duration">
              <dt>Duración</dt>
              <dd>{{ item.duration }}</dd>
            </div>
            <div v-if="item.frequency">
              <dt>Frecuencia</dt>
              <dd>{{ item.frequency }}</dd>
            </div>
          </dl>
        </article>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { Droplets, FlaskConical, HeartPulse, Users } from 'lucide-vue-next'
import { resolveBackgroundColor } from '../../../composables/useElementStyles'

const ICON_MAP = { Droplets, HeartPulse, FlaskConical, Users }
const DEFAULT_ICONS = [Droplets, HeartPulse, FlaskConical, Users]

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const items = computed(() => props.element.items || [])

const iconFor = (item, index) => ICON_MAP[item.icon] || DEFAULT_ICONS[index % DEFAULT_ICONS.length]

const sectionStyles = computed(() => ({
  backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#E1F0F5'),
  padding: props.element.padding || '4.5rem 1.25rem',
}))
</script>

<style scoped>
.idcbis-card-grid {
  font-family: var(--font-idcbis);
  color: #1a1a1a;
  cursor: pointer;
  scroll-margin-top: 96px;
}

.idcbis-card-grid__inner {
  max-width: 1200px;
  margin: 0 auto;
}

.idcbis-card-grid__header {
  text-align: center;
  margin-bottom: 2.75rem;
}

.idcbis-card-grid__header h2 {
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.75rem, 3vw, 2.5rem);
  font-weight: 700;
  color: #0B4F6C;
  margin: 0 0 1rem;
  position: relative;
  display: inline-block;
}

.idcbis-card-grid__header h2::after {
  content: '';
  position: absolute;
  width: 96px;
  height: 4px;
  background: #C4A140;
  bottom: -12px;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 4px;
}

.idcbis-card-grid__header p {
  margin: 1.75rem auto 0;
  max-width: 640px;
  color: #37474f;
  font-size: 1.125rem;
  line-height: 1.6;
}

.idcbis-card-grid__grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
  align-items: stretch;
}

.idcbis-card-grid__card {
  background: #fff;
  border: 1px solid #b7d0d9;
  border-radius: 16px;
  padding: 1.5rem 1.5rem 1.25rem;
  box-shadow: 0 10px 28px rgba(11, 79, 108, 0.12);
  display: flex;
  flex-direction: column;
  min-height: 100%;
  height: 100%;
  position: relative;
  overflow: hidden;
}

.idcbis-card-grid__card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 5px;
  background: #C4A140;
}

.idcbis-card-grid__icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: #005674;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0.35rem 0 0.9rem;
  flex-shrink: 0;
}

.idcbis-card-grid__card h3 {
  font-family: var(--font-idcbis-display);
  margin: 0 0 0.6rem;
  font-size: 1.35rem;
  font-weight: 700;
  color: #0B4F6C;
  line-height: 1.3;
  min-height: 1.75em;
}

.idcbis-card-grid__card p {
  margin: 0 0 1.15rem;
  color: #1a1a1a;
  font-size: 0.98rem;
  line-height: 1.6;
  flex: 1 1 auto;
}

.idcbis-card-grid__card dl {
  margin: auto 0 0;
  padding: 0.85rem 0.9rem;
  background: #005674;
  border-radius: 12px;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 0.75rem 1rem;
}

.idcbis-card-grid__card dl div {
  display: flex;
  flex-direction: column;
  gap: 0.2rem;
  min-width: 0;
}

.idcbis-card-grid__card dt {
  font-size: 0.7rem;
  font-weight: 700;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: #F5E6B8;
}

.idcbis-card-grid__card dd {
  margin: 0;
  color: #ffffff;
  font-weight: 700;
  font-size: 0.92rem;
  line-height: 1.35;
}

@media (min-width: 768px) {
  .idcbis-card-grid__grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1.75rem;
  }
}
</style>
