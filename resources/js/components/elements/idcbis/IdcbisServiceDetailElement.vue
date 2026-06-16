<template>
  <section class="idcbis-service-detail" @click.stop="$emit('click', element)">
    <div class="idcbis-service-detail__container">
      <div class="idcbis-service-detail__header">
        <h2>
          {{ element.sectionTitle || 'Conoce' }}
          <span>{{ element.sectionHighlight || 'nuestros servicios' }}</span>
        </h2>
        <p v-if="element.sectionSubtitle">{{ element.sectionSubtitle }}</p>
      </div>
      <div class="idcbis-service-detail__list">
        <article
          v-for="(item, index) in items"
          :key="item.id || index"
          class="detail-card"
        >
          <div class="detail-card__num">{{ index + 1 }}</div>
          <div class="detail-card__body">
            <h3>{{ item.title }}</h3>
            <p v-if="item.summary" class="detail-card__summary">{{ item.summary }}</p>
            <div v-if="item.audience" class="detail-block">
              <strong>¿Para quién es?</strong>
              <p>{{ item.audience }}</p>
            </div>
            <div v-if="item.access" class="detail-block detail-block--access">
              <strong>¿Cómo se accede?</strong>
              <p class="detail-access">{{ item.access }}</p>
            </div>
          </div>
        </article>
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
.idcbis-service-detail {
  padding: 5rem 2rem;
  background: #fff;
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.idcbis-service-detail__container {
  max-width: 1400px;
  margin: 0 auto;
}

.idcbis-service-detail__header {
  text-align: center;
  margin-bottom: 3rem;
}

.idcbis-service-detail__header h2 {
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 800;
  text-transform: uppercase;
  color: #0b4f6c;
}

.idcbis-service-detail__header h2 span {
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.idcbis-service-detail__header p {
  margin-top: 0.75rem;
  font-size: 1.15rem;
  color: #555;
  max-width: 720px;
  margin-left: auto;
  margin-right: auto;
}

.idcbis-service-detail__list {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.detail-card {
  display: flex;
  gap: 1.25rem;
  background: #f5f8fa;
  border-radius: 24px;
  padding: 1.75rem;
  border: 2px solid transparent;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.detail-card:hover {
  border-color: #2c8c99;
  box-shadow: 0 12px 32px rgba(11, 79, 108, 0.12);
}

.detail-card__num {
  flex-shrink: 0;
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  color: white;
  font-weight: 800;
  font-size: 1.25rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.detail-card__body h3 {
  font-size: 1.5rem;
  font-weight: 700;
  color: #0b4f6c;
  margin-bottom: 0.5rem;
}

.detail-card__summary {
  color: #444;
  line-height: 1.6;
  margin-bottom: 1rem;
}

.detail-block {
  margin-top: 0.75rem;
  padding: 1rem;
  background: white;
  border-radius: 12px;
  border-left: 4px solid #4ecdc4;
}

.detail-block--access {
  border-left-color: #ffd166;
}

.detail-block strong {
  display: block;
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: #0b4f6c;
  margin-bottom: 0.35rem;
}

.detail-block p {
  color: #333;
  line-height: 1.55;
  font-size: 0.95rem;
  margin: 0;
  white-space: pre-line;
}

.detail-access :deep(a) {
  color: #0b4f6c;
  font-weight: 600;
}

@media (max-width: 640px) {
  .detail-card {
    flex-direction: column;
  }
}
</style>
