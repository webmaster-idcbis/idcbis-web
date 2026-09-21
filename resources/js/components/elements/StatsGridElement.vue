<template>
  <section
    :id="element.anchorId || element.id || undefined"
    class="stats-grid"
    :class="element.className"
    :style="sectionStyles"
    @click.stop="$emit('click', element)"
  >
    <div class="stats-grid__inner">
      <div
        v-for="(item, index) in items"
        :key="item.id || index"
        class="stat-card"
        role="group"
        :aria-label="statAriaLabel(item)"
      >
        <ContentIcon v-if="item.icon" :value="item.icon" class="stat-card__icon" />
        <span class="stat-card__number" aria-hidden="true">{{ item.value }}</span>
        <span class="stat-card__label" aria-hidden="true">{{ item.label }}</span>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles } from '../../composables/useElementStyles'
import ContentIcon from './ContentIcon.vue'

const props = defineProps({
  element: { type: Object, required: true },
})

defineEmits(['click'])

const items = computed(() => props.element.items || [])

const statAriaLabel = (item) => item.ariaLabel || [item.value, item.label].filter(Boolean).join(' ')

const sectionStyles = computed(() => mergeElementStyles(props.element))
</script>

<style scoped>
.stats-grid {
  padding: 2rem;
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.stats-grid__inner {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 2.5rem;
}

.stat-card {
  text-align: center;
  background: #fff;
  padding: 2.5rem 2rem;
  border-radius: 16px;
  min-width: 200px;
  box-shadow: 0 10px 28px rgba(11, 79, 108, 0.12);
  transition: transform 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease;
  border: 1px solid #b7d0d9;
  border-top: 5px solid #C4A140;
}

.stat-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 18px 36px rgba(11, 79, 108, 0.18);
  border-color: #005674;
}

.stat-card__icon {
  display: inline-block;
  font-size: 2.5rem;
  margin-bottom: 1.2rem;
  line-height: 1;
}

.stat-card__number {
  font-family: var(--font-idcbis-display);
  font-size: 3.2rem;
  font-weight: 800;
  color: #0B4F6C;
  display: block;
  margin-bottom: 0.5rem;
  line-height: 1;
}

.stat-card__label {
  color: #37474f;
  font-size: 1rem;
  font-weight: 600;
}

@media (max-width: 576px) {
  .stat-card {
    min-width: 160px;
    padding: 2rem 1.5rem;
  }
  .stat-card__number {
    font-size: 2.5rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  .stat-card {
    transition: none;
  }
  .stat-card:hover {
    transform: none;
  }
}
</style>
