<template>
  <section class="idcbis-about" @click.stop="$emit('click', element)">
    <div class="idcbis-about__flex">
      <div class="idcbis-about__text">
        <div v-if="element.leaderName" class="idcbis-about__leader">
          <span class="idcbis-about__leader-label">Línea de servicio</span>
          <strong>{{ element.leaderName }}</strong>
          <span v-if="element.leaderContact" class="idcbis-about__leader-contact">{{ element.leaderContact }}</span>
        </div>
        <h2>{{ element.title || 'Somos IDCBIS' }}</h2>
        <p>{{ element.content }}</p>
      </div>
      <div v-if="element.image" class="idcbis-about__image-wrap" :class="{ 'idcbis-about__image-wrap--logo': isLogoImage }">
        <img :src="element.image" :alt="element.imageAlt || 'IDCBIS'" class="idcbis-about__image" :class="{ 'idcbis-about__image--logo': isLogoImage }">
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

const isLogoImage = computed(() => {
  const src = props.element.image || ''
  return src.includes('/images/logo/') || src.includes('logo-IDCBIS')
})
</script>

<style scoped>
.idcbis-about {
  padding: 5rem 2rem;
  background: #f5f8fa;
  cursor: pointer;
  font-family: var(--font-idcbis);
}

.idcbis-about__flex {
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 4rem;
  background: white;
  padding: 3rem;
  border-radius: 80px 20px 80px 20px;
  box-shadow: 0 20px 30px rgba(0, 0, 0, 0.05);
}

.idcbis-about__text {
  flex: 1;
}

.idcbis-about__text h2 {
  font-size: clamp(2rem, 3vw, 2.8rem);
  font-weight: 800;
  margin-bottom: 1rem;
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.idcbis-about__leader {
  margin-bottom: 1.25rem;
  padding: 1rem 1.25rem;
  background: #e1f0f5;
  border-radius: 12px;
  border-left: 4px solid #0b4f6c;
}

.idcbis-about__leader-label {
  display: block;
  font-size: 0.7rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: #2c8c99;
  margin-bottom: 0.25rem;
}

.idcbis-about__leader strong {
  display: block;
  color: #0b4f6c;
  font-size: 1.1rem;
}

.idcbis-about__leader-contact {
  display: block;
  font-size: 0.9rem;
  color: #555;
  margin-top: 0.35rem;
  white-space: pre-line;
}

.idcbis-about__text p {
  font-size: 1.2rem;
  color: #444;
  text-align: justify;
  line-height: 1.6;
}

.idcbis-about__image-wrap {
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  padding: 1rem;
  border-radius: 50% 50% 30% 30%;
  flex-shrink: 0;
}

.idcbis-about__image {
  max-width: 300px;
  width: 100%;
  border-radius: 20px;
  display: block;
}

.idcbis-about__image-wrap--logo {
  background: transparent;
  padding: 0;
  border-radius: 0;
}

.idcbis-about__image--logo {
  max-width: 320px;
  border-radius: 12px;
  object-fit: contain;
  box-shadow: 0 8px 24px rgba(11, 79, 108, 0.12);
}

@media (max-width: 900px) {
  .idcbis-about__flex {
    flex-direction: column;
  }
}
</style>
