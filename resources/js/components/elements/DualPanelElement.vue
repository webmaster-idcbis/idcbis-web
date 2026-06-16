<template>
  <section class="dual-panel" :style="sectionStyles" @click.stop="$emit('click', element)">
    <div class="dual-panel__container">
      <div v-if="element.title || element.subtitle" class="section-header">
        <h2 v-if="element.title" class="section-title section-title--light">{{ element.title }}</h2>
        <p v-if="element.subtitle" class="section-subtitle section-subtitle--light">{{ element.subtitle }}</p>
      </div>
      <div class="dual-panel__grid">
        <div
          v-for="(panel, index) in panels"
          :key="panel.id || index"
          class="panel-card"
        >
          <h3>
            <span v-if="panel.icon" class="panel-icon">{{ panel.icon }}</span>
            {{ panel.title }}
          </h3>
          <ul class="panel-list" :class="panel.listStyle || 'check'">
            <li v-for="(line, i) in panel.items" :key="i">{{ line }}</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { resolveBackground } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
})

defineEmits(['click'])

const panels = computed(() => props.element.panels || [])

const sectionStyles = computed(() => ({
  background: resolveBackground(props.element, 'linear-gradient(135deg, #1a237e 0%, #9a0007 100%)'),
  borderRadius: props.element.borderRadius || '40px',
  padding: props.element.padding || '6rem 2rem',
  margin: props.element.margin || '4rem auto',
  maxWidth: props.element.maxWidth || '1200px',
}))
</script>

<style scoped>
.dual-panel {
  color: #fff;
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.dual-panel__container {
  max-width: 1100px;
  margin: 0 auto;
}

.section-header {
  text-align: center;
  margin-bottom: 3rem;
}

.section-title {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.section-title--light {
  color: #fff;
}

.section-subtitle--light {
  color: rgba(255, 255, 255, 0.9);
  font-size: 1.2rem;
  max-width: 700px;
  margin: 1rem auto 0;
}

.dual-panel__grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 3rem;
  margin-top: 3rem;
}

.panel-card {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border-radius: 25px;
  padding: 2.5rem;
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: transform 0.4s ease, background 0.4s ease;
}

.panel-card:hover {
  transform: translateY(-10px);
  background: rgba(255, 255, 255, 0.15);
}

.panel-card h3 {
  font-size: 1.8rem;
  margin-bottom: 2rem;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.panel-icon {
  font-size: 1.5rem;
}

.panel-list {
  list-style: none;
  margin: 0;
  padding: 0;
}

.panel-list li {
  margin-bottom: 1.2rem;
  padding-left: 2rem;
  position: relative;
  color: rgba(255, 255, 255, 0.9);
  line-height: 1.55;
}

.panel-list.check li::before {
  content: '✓';
  position: absolute;
  left: 0;
  color: #00acc1;
  font-weight: bold;
  font-size: 1.2rem;
}

.panel-list.bullet li::before {
  content: '•';
  position: absolute;
  left: 0;
  color: #ff6659;
  font-weight: bold;
  font-size: 1.5rem;
  line-height: 1;
}
</style>
