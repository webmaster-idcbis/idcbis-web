<template>
  <section
    :id="element.anchorId || element.id || undefined"
    class="idcbis-checklist"
    :style="sectionStyles"
    @click.stop="$emit('click', element)"
  >
    <div class="idcbis-checklist__inner">
      <div v-if="element.title || element.subtitle" class="idcbis-checklist__header">
        <h2 v-if="element.title">{{ element.title }}</h2>
        <p v-if="element.subtitle">{{ element.subtitle }}</p>
      </div>

      <ul class="idcbis-checklist__list">
        <li v-for="(item, index) in requirements" :key="item.id || index">
          <CheckCircle class="idcbis-checklist__icon" :size="24" aria-hidden="true" />
          <span v-if="item.parts">
            <strong>{{ item.parts.label }}</strong>{{ item.parts.rest }}
          </span>
          <span v-else>{{ item.text }}</span>
        </li>
      </ul>

      <div v-if="element.ctaText" class="idcbis-checklist__cta">
        <component
          :is="cta.is"
          :href="cta.href"
          :type="cta.type"
          :target="cta.target"
          :rel="cta.rel"
          class="idcbis-checklist__btn"
          @click.stop="!preview && $event.preventDefault()"
        >
          {{ element.ctaText }}
        </component>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { CheckCircle } from 'lucide-vue-next'
import { resolveBackgroundColor } from '../../../composables/useElementStyles'
import { previewLinkProps } from '../../../utils/previewLink'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const requirements = computed(() =>
  (props.element.items || []).map((item) => ({
    ...item,
    parts: splitRequirement(item.text),
  })),
)
const cta = computed(() => previewLinkProps(props.preview, props.element.ctaUrl))

const splitRequirement = (text) => {
  if (!text) return null
  const idx = text.indexOf(':')
  if (idx < 1 || idx > 28) return null
  return { label: text.slice(0, idx + 1), rest: text.slice(idx + 1) }
}

const sectionStyles = computed(() => ({
  backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#E1F0F5'),
  padding: props.element.padding || '4.5rem 1.25rem',
}))
</script>

<style scoped>
.idcbis-checklist {
  font-family: var(--font-idcbis);
  color: #1a1a1a;
  cursor: pointer;
  scroll-margin-top: 96px;
}

.idcbis-checklist__inner {
  max-width: 880px;
  margin: 0 auto;
}

.idcbis-checklist__header {
  text-align: center;
  margin-bottom: 3rem;
}

.idcbis-checklist__header h2 {
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.75rem, 3vw, 2.5rem);
  font-weight: 700;
  color: #0B4F6C;
  margin: 0 0 1rem;
  position: relative;
  display: inline-block;
}

.idcbis-checklist__header h2::after {
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

.idcbis-checklist__header p {
  margin: 1.75rem auto 0;
  max-width: 700px;
  color: #37474f;
  font-size: 1.125rem;
  line-height: 1.6;
}

.idcbis-checklist__list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  gap: 1rem;
}

.idcbis-checklist__list li {
  display: flex;
  align-items: flex-start;
  gap: 0.85rem;
  background: #fff;
  border: 1px solid #b7d0d9;
  border-radius: 12px;
  padding: 1.15rem 1.35rem;
  min-height: 44px;
  line-height: 1.5;
  font-size: 1.05rem;
  color: #1a1a1a;
  box-shadow: 0 10px 28px rgba(11, 79, 108, 0.12);
}

.idcbis-checklist__list li strong {
  color: #0B4F6C;
  font-weight: 700;
  margin-right: 0.2rem;
}

.idcbis-checklist__icon {
  flex-shrink: 0;
  color: #005674;
  margin-top: 0.1rem;
}

.idcbis-checklist__cta {
  margin-top: 2.5rem;
  display: flex;
  justify-content: center;
}

.idcbis-checklist__btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 44px;
  padding: 1.1rem 2.5rem;
  border-radius: 50px;
  background: #005674;
  color: #fff;
  font-weight: 700;
  text-decoration: none;
  border: none;
  cursor: pointer;
  font-family: inherit;
  font-size: 1.1rem;
  box-shadow: 0 8px 24px rgba(0, 86, 116, 0.35);
}

.idcbis-checklist__btn:hover {
  background: #003C5F;
  transform: translateY(-3px);
}

.idcbis-checklist__btn:focus {
  outline: none;
}

.idcbis-checklist__btn:focus-visible {
  outline: 3px solid #C4A140;
  outline-offset: 3px;
}

@media (prefers-reduced-motion: reduce) {
  .idcbis-checklist__btn:hover {
    transform: none;
  }
}
</style>
