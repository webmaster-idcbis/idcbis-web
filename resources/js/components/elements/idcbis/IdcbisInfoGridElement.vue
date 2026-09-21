<template>
  <section
    :id="element.anchorId || element.id || undefined"
    class="idcbis-info-grid"
    :style="sectionStyles"
    @click.stop="$emit('click', element)"
  >
    <div class="idcbis-info-grid__inner">
      <div v-if="element.title || element.subtitle" class="idcbis-info-grid__header">
        <h2 v-if="element.title">{{ element.title }}</h2>
        <p v-if="element.subtitle">{{ element.subtitle }}</p>
      </div>

      <div class="idcbis-info-grid__grid">
        <article
          v-for="(item, index) in items"
          :key="item.id || index"
          class="idcbis-info-grid__card"
        >
          <component
            :is="iconFor(item.icon)"
            class="idcbis-info-grid__icon"
            :size="28"
            aria-hidden="true"
          />
          <h3>{{ item.title }}</h3>
          <p>{{ item.text }}</p>
          <component
            v-if="item.link && item.linkLabel"
            :is="linkProps(item.link).is"
            :href="linkProps(item.link).href"
            :type="linkProps(item.link).type"
            :target="linkProps(item.link).target"
            :rel="linkProps(item.link).rel"
            class="idcbis-info-grid__link"
            @click.stop="!preview && $event.preventDefault()"
          >
            {{ item.linkLabel }}
            <span v-if="linkProps(item.link).target === '_blank'" class="sr-only">
              (se abre en una pestaña nueva)
            </span>
          </component>
        </article>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { MapPin, Clock, Phone, Mail } from 'lucide-vue-next'
import { resolveBackgroundColor } from '../../../composables/useElementStyles'
import { previewLinkProps } from '../../../utils/previewLink'

const ICON_MAP = { MapPin, Clock, Phone, Mail }

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const items = computed(() => props.element.items || [])

const iconFor = (name) => ICON_MAP[name] || MapPin

const linkProps = (url) => previewLinkProps(props.preview, url)

const sectionStyles = computed(() => ({
  backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#E1F0F5'),
  padding: props.element.padding || '4.5rem 1.25rem 2rem',
}))
</script>

<style scoped>
.idcbis-info-grid {
  font-family: var(--font-idcbis);
  color: #1a1a1a;
  cursor: pointer;
  scroll-margin-top: 96px;
}

.idcbis-info-grid__inner {
  max-width: 1200px;
  margin: 0 auto;
}

.idcbis-info-grid__header {
  text-align: center;
  margin-bottom: 3rem;
}

.idcbis-info-grid__header h2 {
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.75rem, 3vw, 2.5rem);
  font-weight: 700;
  color: #0B4F6C;
  margin: 0 0 1rem;
  position: relative;
  display: inline-block;
}

.idcbis-info-grid__header h2::after {
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

.idcbis-info-grid__header p {
  margin: 1.75rem auto 0;
  max-width: 700px;
  color: #37474f;
  font-size: 1.125rem;
  line-height: 1.6;
}

.idcbis-info-grid__grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
  align-items: stretch;
}

.idcbis-info-grid__card {
  background: #fff;
  border: 1px solid #b7d0d9;
  border-top: 5px solid #C4A140;
  border-radius: 16px;
  padding: 1.75rem;
  box-shadow: 0 10px 28px rgba(11, 79, 108, 0.12);
  display: flex;
  flex-direction: column;
  min-height: 100%;
  height: 100%;
}

.idcbis-info-grid__icon {
  color: #005674;
  margin-bottom: 1rem;
}

.idcbis-info-grid__card h3 {
  margin: 0 0 0.75rem;
  font-family: var(--font-idcbis-display);
  font-size: 1.35rem;
  font-weight: 700;
  color: #0B4F6C;
}

.idcbis-info-grid__card p {
  margin: 0 0 1rem;
  color: #1a1a1a;
  line-height: 1.7;
  white-space: pre-line;
  flex: 1 1 auto;
}

.idcbis-info-grid__link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-top: auto;
  align-self: flex-start;
  min-height: 44px;
  padding: 0.85rem 1.6rem;
  border-radius: 50px;
  background: #005674;
  color: #fff;
  font-weight: 700;
  text-decoration: none;
  border: none;
  cursor: pointer;
  font-family: inherit;
  box-shadow: 0 8px 24px rgba(0, 86, 116, 0.28);
}

.idcbis-info-grid__link:hover {
  transform: translateY(-3px);
}

.idcbis-info-grid__link:focus {
  outline: none;
}

.idcbis-info-grid__link:focus-visible {
  outline: 3px solid #C4A140;
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

@media (min-width: 768px) {
  .idcbis-info-grid__grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (prefers-reduced-motion: reduce) {
  .idcbis-info-grid__link:hover {
    transform: none;
  }
}
</style>
