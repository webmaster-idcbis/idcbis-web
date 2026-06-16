<template>
  <section class="idcbis-faq" @click.stop="$emit('click', element)">
    <div class="idcbis-faq__container">
      <div class="idcbis-faq__header">
        <h2>
          {{ element.sectionTitle || 'Preguntas' }}
          <span>{{ element.sectionHighlight || 'frecuentes' }}</span>
        </h2>
      </div>
      <div class="idcbis-faq__list">
        <details
          v-for="(item, index) in items"
          :key="item.id || index"
          class="faq-item"
          :open="preview && index === 0"
        >
          <summary class="faq-question">{{ item.question }}</summary>
          <p class="faq-answer">{{ item.answer }}</p>
        </details>
      </div>
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
.idcbis-faq {
  padding: 5rem 2rem;
  background: linear-gradient(180deg, #f5f8fa 0%, #e1f0f5 100%);
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.idcbis-faq__container {
  max-width: 900px;
  margin: 0 auto;
}

.idcbis-faq__header {
  text-align: center;
  margin-bottom: 2.5rem;
}

.idcbis-faq__header h2 {
  font-size: clamp(1.75rem, 3vw, 2.5rem);
  font-weight: 800;
  text-transform: uppercase;
  color: #0b4f6c;
}

.idcbis-faq__header h2 span {
  color: #2c8c99;
}

.idcbis-faq__list {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.faq-item {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 16px rgba(11, 79, 108, 0.08);
  border: 1px solid rgba(11, 79, 108, 0.08);
}

.faq-question {
  padding: 1.25rem 1.5rem;
  font-weight: 700;
  font-size: 1.05rem;
  color: #0b4f6c;
  cursor: pointer;
  list-style: none;
}

.faq-question::-webkit-details-marker {
  display: none;
}

.faq-question::after {
  content: '+';
  float: right;
  font-size: 1.25rem;
  color: #2c8c99;
}

.faq-item[open] .faq-question::after {
  content: '−';
}

.faq-answer {
  padding: 0 1.5rem 1.25rem;
  color: #444;
  line-height: 1.65;
  margin: 0;
  white-space: pre-line;
}
</style>
