<template>
  <section class="stats-grid" :class="element.className" :style="sectionStyles" @click.stop="$emit('click', element)">
    <div class="stats-grid__inner">
      <div
        v-for="(item, index) in items"
        :key="item.id || index"
        class="stat-card"
      >
        <div v-if="item.icon" class="stat-card__icon">{{ item.icon }}</div>
        <span class="stat-card__number">{{ item.value }}</span>
        <span class="stat-card__label">{{ item.label }}</span>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
})

defineEmits(['click'])

const items = computed(() => props.element.items || [])

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
  background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
  padding: 2.5rem 2rem;
  border-radius: 20px;
  min-width: 200px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  transition: transform 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease;
  border: 2px solid transparent;
}

.stat-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  border-color: #ff6659;
}

.stat-card__icon {
  font-size: 2.5rem;
  margin-bottom: 1.2rem;
  line-height: 1;
}

.stat-card__number {
  font-size: 3.2rem;
  font-weight: 700;
  color: #1a237e;
  display: block;
  margin-bottom: 0.5rem;
  line-height: 1;
}

.stat-card__label {
  color: #607d8b;
  font-size: 1rem;
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
</style>
