<template>
  <section
    class="idcbis-hero-carousel"
    @click.stop="$emit('click', element)"
  >
    <div class="idcbis-hero-carousel__viewport">
      <div class="idcbis-hero-carousel__track" :style="trackStyles">
        <article
          v-for="(slide, index) in slides"
          :key="slide.id || index"
          class="idcbis-hero idcbis-hero-carousel__slide"
        >
          <div class="idcbis-hero__content">
            <div class="idcbis-hero__text">
              <h1>
                <span class="light">{{ slide.titleLight || 'Tú puedes' }}</span>
                {{ slide.titleBold || 'salvar vidas' }}
              </h1>
              <p v-if="slide.subtitle">{{ slide.subtitle }}</p>
              <div class="idcbis-hero__cta">
                <component
                  :is="preview ? 'a' : 'button'"
                  v-if="slide.button1Text"
                  :href="preview ? (slide.button1Url || '#') : undefined"
                  type="button"
                  class="btn-big orange"
                  @click.stop="!preview && $event.preventDefault()"
                >
                  {{ slide.button1Text }}
                </component>
                <component
                  :is="preview ? 'a' : 'button'"
                  v-if="slide.button2Text"
                  :href="preview ? (slide.button2Url || '#') : undefined"
                  type="button"
                  class="btn-big purple"
                  @click.stop="!preview && $event.preventDefault()"
                >
                  {{ slide.button2Text }}
                </component>
              </div>
            </div>
            <div
              v-if="slide.image"
              class="idcbis-hero__image"
              :style="{ backgroundImage: `url(${slide.image})` }"
              role="img"
              :aria-label="slide.imageAlt || 'Imagen destacada'"
            >
              <span v-if="slide.imageBadge" class="idcbis-hero__badge">{{ slide.imageBadge }}</span>
            </div>
          </div>
        </article>
      </div>

      <button
        v-if="slides.length > 1 && element.showArrows !== false"
        type="button"
        class="idcbis-hero-carousel__nav idcbis-hero-carousel__nav--prev"
        aria-label="Anterior"
        @click.stop="prevSlide"
      >
        <svg class="idcbis-hero-carousel__nav-icon" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M15 18l-6-6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
      <button
        v-if="slides.length > 1 && element.showArrows !== false"
        type="button"
        class="idcbis-hero-carousel__nav idcbis-hero-carousel__nav--next"
        aria-label="Siguiente"
        @click.stop="nextSlide"
      >
        <svg class="idcbis-hero-carousel__nav-icon" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M9 18l6-6-6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>

      <div
        v-if="slides.length > 1 && element.showIndicators !== false"
        class="idcbis-hero-carousel__dots"
      >
        <button
          v-for="(slide, index) in slides"
          :key="'dot-' + (slide.id || index)"
          type="button"
          class="idcbis-hero-carousel__dot"
          :class="{ 'idcbis-hero-carousel__dot--active': currentSlide === index }"
          :aria-label="`Ir al slide ${index + 1}`"
          @click.stop="goToSlide(index)"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const currentSlide = ref(0)
let autoplayInterval = null

const slides = computed(() => props.element.slides || [])

const trackStyles = computed(() => ({
  transform: `translateX(-${currentSlide.value * 100}%)`,
}))

const nextSlide = () => {
  if (!slides.value.length) return
  currentSlide.value = (currentSlide.value + 1) % slides.value.length
}

const prevSlide = () => {
  if (!slides.value.length) return
  currentSlide.value = currentSlide.value === 0 ? slides.value.length - 1 : currentSlide.value - 1
}

const goToSlide = (index) => {
  currentSlide.value = index
}

const startAutoplay = () => {
  stopAutoplay()
  if (props.element.autoPlay !== false && slides.value.length > 1) {
    autoplayInterval = setInterval(nextSlide, props.element.interval || 5000)
  }
}

const stopAutoplay = () => {
  if (autoplayInterval) {
    clearInterval(autoplayInterval)
    autoplayInterval = null
  }
}

watch(() => [props.element.autoPlay, props.element.interval, slides.value.length], startAutoplay)

onMounted(startAutoplay)
onUnmounted(stopAutoplay)
</script>

<style scoped>
.idcbis-hero-carousel {
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.idcbis-hero-carousel__viewport {
  position: relative;
  overflow: hidden;
}

.idcbis-hero-carousel__track {
  display: flex;
  transition: transform 0.55s cubic-bezier(0.4, 0, 0.2, 1);
}

.idcbis-hero-carousel__slide {
  min-width: 100%;
  flex-shrink: 0;
}

/* —— Mismo diseño que Propuesta 2 - Azul (.hero-fun) —— */
.idcbis-hero {
  color: white;
  padding: 4rem 2rem 6rem;
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
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
  pointer-events: none;
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
  pointer-events: none;
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

.btn-big.orange:hover {
  background: #3ba0ab;
  transform: scale(1.05);
  box-shadow: 0 15px 30px rgba(44, 140, 153, 0.4);
}

.btn-big.purple {
  background: #0b4f6c;
  color: white;
}

.btn-big.purple:hover {
  background: #145c7a;
  transform: scale(1.05);
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
  z-index: 1;
}

.idcbis-hero__badge {
  position: absolute;
  bottom: 20px;
  right: 30px;
  font-size: 3.5rem;
  opacity: 0.7;
  z-index: 2;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
  pointer-events: none;
}

.idcbis-hero-carousel__nav {
  position: absolute;
  z-index: 20;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  padding: 0;
  border: 1px solid rgba(255, 255, 255, 0.35);
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  color: rgba(255, 255, 255, 0.9);
  cursor: pointer;
  opacity: 0.55;
  transition: opacity 0.25s ease, background 0.25s ease, border-color 0.25s ease, transform 0.25s ease;
}

.idcbis-hero-carousel__nav-icon {
  width: 14px;
  height: 14px;
  display: block;
}

.idcbis-hero-carousel__nav:hover {
  opacity: 1;
  background: rgba(255, 255, 255, 0.2);
  border-color: rgba(255, 255, 255, 0.55);
}

.idcbis-hero-carousel__nav--prev {
  bottom: 2.75rem;
  left: 1.25rem;
  top: auto;
  transform: none;
}

.idcbis-hero-carousel__nav--next {
  bottom: 2.75rem;
  right: 1.25rem;
  top: auto;
  transform: none;
}

.idcbis-hero-carousel__nav--prev:hover,
.idcbis-hero-carousel__nav--next:hover {
  transform: scale(1.06);
}

.idcbis-hero-carousel__viewport:hover .idcbis-hero-carousel__nav {
  opacity: 0.85;
}

.idcbis-hero-carousel__dots {
  position: absolute;
  bottom: 1.25rem;
  left: 50%;
  transform: translateX(-50%);
  z-index: 20;
  display: flex;
  gap: 0.5rem;
}

.idcbis-hero-carousel__dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  border: 2px solid rgba(255, 255, 255, 0.7);
  background: rgba(255, 255, 255, 0.25);
  padding: 0;
  cursor: pointer;
  transition: all 0.2s;
}

.idcbis-hero-carousel__dot--active {
  background: white;
  border-color: white;
  transform: scale(1.15);
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

  .idcbis-hero-carousel__nav {
    width: 28px;
    height: 28px;
    bottom: 2.5rem;
    opacity: 0.45;
  }

  .idcbis-hero-carousel__nav-icon {
    width: 12px;
    height: 12px;
  }

  .idcbis-hero-carousel__nav--prev {
    left: 0.75rem;
  }

  .idcbis-hero-carousel__nav--next {
    right: 0.75rem;
  }
}
</style>
