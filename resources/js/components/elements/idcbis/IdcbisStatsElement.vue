<template>
  <section
    class="idcbis-stats"
    :style="{ backgroundColor: resolveBackgroundColor(element.backgroundColor, '#FFD166') }"
    @click.stop="$emit('click', element)"
  >
    <div class="idcbis-stats__container">
      <div class="idcbis-stats__grid">
        <div
          v-for="(item, index) in items"
          :key="item.id || index"
          class="idcbis-stats__item"
        >
          <div class="big-number">{{ item.value }}</div>
          <div class="label">{{ item.label }}</div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { resolveBackgroundColor } from '../../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const items = computed(() => props.element.items || [])
</script>

<style scoped>
.idcbis-stats {
  padding: 4rem 2rem;
  border-radius: 60px 60px 0 0;
  margin-top: 2rem;
  cursor: pointer;
  font-family: var(--font-idcbis);
}

.idcbis-stats__container {
  max-width: 1400px;
  margin: 0 auto;
}

.idcbis-stats__grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 3rem;
  text-align: center;
}

.idcbis-stats__item {
  background: white;
  padding: 2.5rem 1rem;
  border-radius: 50% 50% 30% 30% / 40% 40% 60% 60%;
  box-shadow: 0 20px 0 rgba(0, 0, 0, 0.1);
}

.big-number {
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 800;
  color: #0b4f6c;
  line-height: 1;
}

.label {
  font-size: 1.2rem;
  font-weight: 500;
  color: #333;
  text-transform: uppercase;
  margin-top: 0.5rem;
}
</style>
