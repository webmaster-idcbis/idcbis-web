<template>
  <section class="idcbis-services" @click.stop="$emit('click', element)">
    <div class="idcbis-services__container">
      <div class="idcbis-services__header">
        <h2>
          {{ element.sectionTitle || 'Nuestros' }}
          <span>{{ element.sectionHighlight || 'servicios' }}</span>
        </h2>
        <p v-if="element.sectionSubtitle">{{ element.sectionSubtitle }}</p>
      </div>
      <div class="idcbis-services__grid">
        <component
          :is="preview ? 'a' : 'div'"
          v-for="(card, index) in cards"
          :key="card.id || index"
          :href="preview ? (card.url || '#') : undefined"
          class="service-card"
          :style="{ backgroundColor: card.bgColor || cardBgs[index % cardBgs.length] }"
        >
          <div
            class="service-card__image"
            :style="card.image ? { backgroundImage: `url(${card.image})` } : {}"
          />
          <div class="service-card__content">
            <h3>{{ card.title }}</h3>
            <p>{{ card.description }}</p>
            <span v-if="card.tag" class="service-card__tag">{{ card.tag }}</span>
          </div>
        </component>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { IDCBIS_THEME } from '../../../config/idcbisTheme'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const cardBgs = IDCBIS_THEME.cardBgs

const cards = computed(() => props.element.cards || [])
</script>

<style scoped>
.idcbis-services {
  padding: 6rem 2rem;
  background: #f5f8fa;
  cursor: pointer;
  font-family: var(--font-idcbis);
}

.idcbis-services__container {
  max-width: 1400px;
  margin: 0 auto;
}

.idcbis-services__header {
  text-align: center;
  margin-bottom: 4rem;
}

.idcbis-services__header h2 {
  font-size: clamp(2rem, 4vw, 3.5rem);
  font-weight: 800;
  text-transform: uppercase;
  color: #0b4f6c;
}

.idcbis-services__header h2 span {
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.idcbis-services__header p {
  font-size: 1.3rem;
  color: #555;
  max-width: 700px;
  margin: 0.5rem auto 0;
}

.idcbis-services__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
}

.service-card {
  border-radius: 40px 20px 40px 20px;
  padding: 0;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.1);
  border: 2px solid transparent;
  display: flex;
  flex-direction: column;
  text-decoration: none;
  color: inherit;
  overflow: hidden;
  height: 100%;
}

.service-card:hover {
  transform: rotate(1deg) scale(1.02);
  border-color: #0b4f6c;
  box-shadow: 0 30px 40px -10px rgba(11, 79, 108, 0.3);
}

.service-card__image {
  height: 180px;
  background-size: cover;
  background-position: center;
  border-radius: 38px 18px 0 0;
  position: relative;
  background-color: #d1e9f2;
}

.service-card__image::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.3) 100%);
}

.service-card__content {
  padding: 1.8rem 1.8rem 2rem;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.service-card h3 {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 0.8rem;
  color: #1b1b1b;
}

.service-card p {
  font-size: 1rem;
  line-height: 1.5;
  margin-bottom: 2rem;
  color: #333;
  flex-grow: 1;
}

.service-card__tag {
  display: inline-block;
  background: white;
  padding: 0.5rem 1.5rem;
  border-radius: 40px;
  font-weight: 700;
  font-size: 0.9rem;
  align-self: flex-start;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
  border: 1px solid rgba(0, 0, 0, 0.1);
}

@media (max-width: 900px) {
  .idcbis-services__grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 600px) {
  .idcbis-services__grid {
    grid-template-columns: 1fr;
  }
}
</style>
