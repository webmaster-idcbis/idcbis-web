<template>
  <section class="idcbis-highlights" @click.stop="$emit('click', element)">
    <div class="idcbis-highlights__container">
      <div class="idcbis-highlights__header">
        <h2>
          {{ element.sectionTitle || 'Lo que nos' }}
          <span>{{ element.sectionHighlight || 'diferencia' }}</span>
        </h2>
      </div>
      <ul class="idcbis-highlights__grid">
        <li v-for="(item, index) in items" :key="item.id || index" class="highlight-item">
          <span class="highlight-check">✓</span>
          <span>{{ item.text }}</span>
        </li>
      </ul>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const items = computed(() => props.element.items || [])
</script>

<style scoped>
.idcbis-highlights {
  padding: 5rem 2rem;
  background: white;
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.idcbis-highlights__container {
  max-width: 1100px;
  margin: 0 auto;
}

.idcbis-highlights__header {
  text-align: center;
  margin-bottom: 2.5rem;
}

.idcbis-highlights__header h2 {
  font-size: clamp(1.75rem, 3vw, 2.5rem);
  font-weight: 800;
  text-transform: uppercase;
  color: #0b4f6c;
}

.idcbis-highlights__header h2 span {
  color: #2c8c99;
}

.idcbis-highlights__grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1rem;
}

.highlight-item {
  display: flex;
  gap: 0.75rem;
  align-items: flex-start;
  padding: 1rem 1.25rem;
  background: #f5f8fa;
  border-radius: 12px;
  line-height: 1.5;
  color: #333;
  font-size: 0.95rem;
}

.highlight-check {
  flex-shrink: 0;
  width: 28px;
  height: 28px;
  background: #4ecdc4;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 0.85rem;
}
</style>
