<template>
  <section :id="element.anchorId || element.id || undefined" class="process-timeline-block" :style="blockStyles" @click.stop="$emit('click', element)">
    <div class="process-timeline-block__container">
      <div v-if="element.title || element.subtitle" class="section-header">
        <h2 v-if="element.title" class="section-title">{{ element.title }}</h2>
        <p v-if="element.subtitle" class="section-subtitle">{{ element.subtitle }}</p>
      </div>
      <div class="process-timeline">
        <div
          v-for="(step, index) in steps"
          :key="step.id || index"
          class="timeline-item"
          :class="{ 'timeline-item--even': (index + 1) % 2 === 0 }"
        >
          <div class="timeline-number">{{ index + 1 }}</div>
          <div class="timeline-content">
            <h3>{{ step.title }}</h3>
            <p>{{ step.description }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { resolveBackgroundColor } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
})

defineEmits(['click'])

const steps = computed(() => props.element.steps || [])

const blockStyles = computed(() => ({
  backgroundColor: resolveBackgroundColor(props.element.backgroundColor, 'transparent'),
  padding: props.element.padding || undefined,
}))
</script>

<style scoped>
.process-timeline-block {
  padding: 6rem 2rem;
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.process-timeline-block__container {
  max-width: 1200px;
  margin: 0 auto;
}

.section-header {
  text-align: center;
  margin-bottom: 4rem;
}

.section-title {
  font-size: 2.5rem;
  color: #0B4F6C;
  margin-bottom: 1rem;
  position: relative;
  display: inline-block;
}

.section-title::after {
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

.section-subtitle {
  color: #37474f;
  font-size: 1.125rem;
  max-width: 700px;
  margin: 1.75rem auto 0;
}

.process-timeline {
  position: relative;
  max-width: 1000px;
  margin: 4rem auto 0;
}

.process-timeline::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 4px;
  height: 100%;
  background: linear-gradient(to bottom, #005674, #C4A140);
  border-radius: 2px;
}

.timeline-item {
  display: flex;
  justify-content: center;
  margin-bottom: 4rem;
  position: relative;
  flex-direction: row;
}

.timeline-item--even {
  flex-direction: row-reverse;
}

.timeline-content {
  width: 45%;
  background: #fff;
  border: 1px solid #b7d0d9;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 10px 28px rgba(11, 79, 108, 0.12);
  position: relative;
}

.timeline-content::after {
  content: '';
  position: absolute;
  top: 30px;
  width: 20px;
  height: 20px;
  background: #fff;
  transform: rotate(45deg);
}

.timeline-item:not(.timeline-item--even) .timeline-content::after {
  right: -10px;
}

.timeline-item--even .timeline-content::after {
  left: -10px;
}

.timeline-content h3 {
  font-size: 1.25rem;
  color: #0B4F6C;
  margin: 0 0 0.75rem;
}

.timeline-content p {
  color: #1a1a1a;
  line-height: 1.65;
  margin: 0;
}

.timeline-number {
  position: absolute;
  top: -25px;
  left: 50%;
  transform: translateX(-50%);
  width: 50px;
  height: 50px;
  background: #005674;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-weight: bold;
  font-size: 1.3rem;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  z-index: 10;
}

@media (max-width: 992px) {
  .process-timeline::before {
    left: 30px;
  }
  .timeline-item,
  .timeline-item--even {
    flex-direction: row;
    justify-content: flex-start;
    padding-left: 60px;
  }
  .timeline-content {
    width: 100%;
  }
  .timeline-content::after {
    left: -10px !important;
    right: auto !important;
  }
  .timeline-number {
    left: 30px;
    transform: translateX(0);
  }
}

@media (prefers-reduced-motion: reduce) {
  .timeline-item,
  .timeline-content {
    transition: none;
  }
}
</style>
