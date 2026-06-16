<template>
  <section
    class="idcbis-hero"
    :style="sectionStyle"
    @click.stop="$emit('click', element)"
  >
    <div class="idcbis-hero__content">
      <div class="idcbis-hero__text">
        <h1>
          <span class="light">{{ element.titleLight || 'Tú puedes' }}</span>
          {{ element.titleBold || 'salvar vidas' }}
        </h1>
        <p>{{ element.subtitle }}</p>
        <div class="idcbis-hero__cta">
          <component
            :is="preview ? 'a' : 'button'"
            v-if="element.button1Text"
            :href="preview ? (element.button1Url || '#') : undefined"
            type="button"
            class="btn-big orange"
            @click.stop="!preview && $event.preventDefault()"
          >
            {{ element.button1Text }}
          </component>
          <component
            :is="preview ? 'a' : 'button'"
            v-if="element.button2Text"
            :href="preview ? (element.button2Url || '#') : undefined"
            type="button"
            class="btn-big purple"
            @click.stop="!preview && $event.preventDefault()"
          >
            {{ element.button2Text }}
          </component>
        </div>
      </div>
      <div
        v-if="element.heroImage"
        class="idcbis-hero__image"
        :style="{ backgroundImage: `url(${element.heroImage})` }"
        role="img"
        :aria-label="element.heroImageAlt || 'Imagen destacada'"
      />
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { IDCBIS_THEME } from '../../../config/idcbisTheme'

defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const sectionStyle = computed(() => ({
  background: IDCBIS_THEME.gradientMain,
}))
</script>

<style scoped>
.idcbis-hero {
  color: white;
  padding: 4rem 2rem 6rem;
  position: relative;
  overflow: hidden;
  cursor: pointer;
  font-family: var(--font-idcbis);
}

.idcbis-hero::before {
  content: '';
  position: absolute;
  top: -50px;
  right: -50px;
  width: 300px;
  height: 300px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
}

.idcbis-hero::after {
  content: '';
  position: absolute;
  bottom: -80px;
  left: -80px;
  width: 400px;
  height: 400px;
  background: rgba(0, 0, 0, 0.05);
  border-radius: 50%;
}

.idcbis-hero__content {
  max-width: 1400px;
  margin: 0 auto;
  position: relative;
  z-index: 2;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 3rem;
}

.idcbis-hero__text {
  flex: 1;
}

.idcbis-hero__text h1 {
  font-size: clamp(2.5rem, 5vw, 4.5rem);
  font-weight: 600;
  line-height: 1.1;
  margin-bottom: 1rem;
  text-transform: uppercase;
}

.idcbis-hero__text h1 .light {
  font-weight: 300;
  display: block;
  font-size: clamp(2rem, 4vw, 3rem);
  opacity: 0.9;
}

.idcbis-hero__text p {
  font-size: 1.3rem;
  margin-bottom: 2rem;
  opacity: 0.95;
  max-width: 600px;
}

.idcbis-hero__cta {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.btn-big {
  padding: 1.2rem 2.8rem;
  border: none;
  border-radius: 60px;
  font-size: 1.2rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s;
  text-transform: uppercase;
  letter-spacing: 1px;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  text-decoration: none;
  display: inline-block;
}

.btn-big.orange {
  background: #2c8c99;
  color: white;
}

.btn-big.purple {
  background: #0b4f6c;
  color: white;
}

.idcbis-hero__image {
  flex: 1;
  min-width: 280px;
  max-width: 480px;
  border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
  border: 4px solid white;
  overflow: hidden;
  box-shadow: 0 25px 40px -10px rgba(0, 0, 0, 0.3);
  height: 380px;
  background-size: cover;
  background-position: center;
  position: relative;
}

.idcbis-hero__image::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(145deg, rgba(11, 79, 108, 0.2) 0%, rgba(44, 140, 153, 0.2) 100%);
}

@media (max-width: 900px) {
  .idcbis-hero__content {
    flex-direction: column;
    text-align: center;
  }
  .idcbis-hero__text p {
    margin-left: auto;
    margin-right: auto;
  }
  .idcbis-hero__cta {
    justify-content: center;
  }
  .idcbis-hero__image {
    width: 100%;
    max-width: none;
    height: 280px;
  }
}
</style>
