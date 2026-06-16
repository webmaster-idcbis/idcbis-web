<template>
  <div
    class="carousel-element"
    :class="{ 'carousel-element--hero-full': isHeroFull }"
    :style="carouselStyles"
    @click="$emit('click', element)"
  >
    <div
      class="carousel-container"
      :style="{
        height: element.height || (isHeroFull ? '550px' : '400px'),
        borderRadius: element.borderRadius || (isHeroFull ? '0 0 30px 30px' : '8px'),
      }"
    >
      <div class="carousel-track" :style="trackStyles">
        <div
          v-for="(slide, index) in slides"
          :key="slide.id || index"
          class="carousel-slide"
          :style="slideStyles"
        >
          <a
            v-if="slide.link && preview"
            :href="slide.link"
            class="slide-link-overlay"
          />
          <img
            v-if="slide.image"
            :src="slide.image"
            :alt="slide.title || 'Slide'"
            class="slide-image"
          >
          <div v-else class="slide-placeholder">
            <span>Sin imagen</span>
          </div>

          <div
            class="slide-overlay"
            :style="{ background: slide.overlay || element.overlay || (isHeroFull ? 'linear-gradient(90deg, rgba(26, 35, 126, 0.85) 0%, rgba(26, 35, 126, 0.7) 100%)' : 'linear-gradient(transparent, rgba(0, 0, 0, 0.7))') }"
          ></div>

          <div class="slide-content" :style="contentStyles(slide)">
            <h3 v-if="slide.title" class="slide-title" :style="titleStyles(slide)">{{ slide.title }}</h3>
            <p v-if="slide.description" class="slide-description" :style="descriptionStyles(slide)">{{ slide.description }}</p>
            <a
              v-if="slide.buttonText"
              :href="preview ? (slide.buttonUrl || '#') : '#'"
              class="slide-button"
              :style="buttonStyles(slide)"
              @click.stop="!preview && $event.preventDefault()"
            >
              {{ slide.buttonText }}
            </a>
          </div>
        </div>
      </div>

      <button
        v-if="slides.length > 1 && element.showArrows !== false"
        type="button"
        @click.stop="prevSlide"
        class="carousel-nav carousel-nav-prev"
        aria-label="Anterior"
      >‹</button>
      <button
        v-if="slides.length > 1 && element.showArrows !== false"
        type="button"
        @click.stop="nextSlide"
        class="carousel-nav carousel-nav-next"
        aria-label="Siguiente"
      >›</button>

      <div v-if="slides.length > 1 && element.showIndicators !== false" class="carousel-indicators">
        <button
          v-for="(slide, index) in slides"
          :key="'dot-' + (slide.id || index)"
          type="button"
          @click.stop="goToSlide(index)"
          class="carousel-indicator"
          :class="{ active: currentSlide === index }"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'

import { resolveBackgroundColor } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const currentSlide = ref(0)
let autoplayInterval = null

const slides = computed(() => props.element.slides || [])

const isHeroFull = computed(() => props.element.variant === 'hero-full')

const carouselStyles = computed(() => ({
  width: props.element.width || '100%',
  backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#f8f9fa'),
  padding: props.element.padding || '0',
  borderRadius: isHeroFull.value ? '0' : (props.element.borderRadius || '8px'),
  margin: isHeroFull.value ? '0 0 5rem' : (props.element.margin || '16px 0'),
  position: 'relative',
  overflow: 'hidden',
  boxShadow: isHeroFull.value ? '0 15px 40px rgba(0, 0, 0, 0.2)' : undefined,
}))

const trackStyles = computed(() => ({
  display: 'flex',
  transition: 'transform 0.5s ease',
  transform: `translateX(-${currentSlide.value * 100}%)`,
  height: '100%',
}))

const slideStyles = computed(() => ({
  minWidth: '100%',
  flexShrink: 0,
  height: '100%',
}))

const contentStyles = (slide) => {
  const hero = isHeroFull.value
  const align = slide.textAlign || props.element.textAlign || (hero ? 'left' : 'center')
  return {
    textAlign: align,
    justifyContent: slide.verticalAlign || props.element.verticalAlign || (hero ? 'center' : 'flex-end'),
    alignItems: align === 'left' ? 'flex-start' : align === 'right' ? 'flex-end' : 'center',
    padding: props.element.contentPadding || (hero ? '0 4rem' : '32px 24px 48px'),
    maxWidth: hero ? '1200px' : undefined,
    margin: hero ? '0 auto' : undefined,
    width: hero ? '100%' : undefined,
  }
}

const titleStyles = (slide) => ({
  fontSize: slide.titleSize || props.element.titleSize || (isHeroFull.value ? '3.5rem' : '2.5rem'),
  fontWeight: slide.titleWeight || props.element.titleWeight || '700',
  color: slide.titleColor || props.element.titleColor || '#ffffff',
  textTransform: slide.titleTransform || props.element.titleTransform || 'none',
  lineHeight: isHeroFull.value ? '1.2' : undefined,
  marginBottom: isHeroFull.value ? '1.5rem' : undefined,
  maxWidth: isHeroFull.value ? '800px' : undefined,
  textShadow: isHeroFull.value ? '0 2px 15px rgba(0, 0, 0, 0.3)' : undefined,
  fontFamily: isHeroFull.value ? 'var(--font-idcbis)' : undefined,
})

const descriptionStyles = (slide) => ({
  fontSize: slide.descriptionSize || props.element.descriptionSize || (isHeroFull.value ? '1.4rem' : '1.1rem'),
  color: slide.descriptionColor || props.element.descriptionColor || '#ffffff',
  maxWidth: props.element.descriptionMaxWidth || (isHeroFull.value ? '700px' : '720px'),
  marginBottom: isHeroFull.value ? '2.5rem' : undefined,
  opacity: isHeroFull.value ? '0.95' : undefined,
})

const buttonStyles = (slide) => {
  const hero = isHeroFull.value
  return {
    background: slide.buttonBg || props.element.buttonBg || (hero ? 'linear-gradient(135deg, #d32f2f 0%, #9a0007 100%)' : '#005674'),
    color: slide.buttonColor || props.element.buttonColor || '#ffffff',
    borderRadius: slide.buttonRadius || props.element.buttonRadius || '999px',
    fontWeight: slide.buttonWeight || props.element.buttonWeight || '600',
    textTransform: slide.buttonTransform || props.element.buttonTransform || (hero ? 'none' : 'uppercase'),
    letterSpacing: slide.buttonLetterSpacing || props.element.buttonLetterSpacing || (hero ? '0' : '0.04em'),
    padding: hero ? '1.1rem 2.8rem' : undefined,
    fontSize: hero ? '1.2rem' : undefined,
    boxShadow: hero ? '0 8px 25px rgba(211, 47, 47, 0.4)' : undefined,
    display: hero ? 'inline-flex' : undefined,
    alignItems: hero ? 'center' : undefined,
    gap: hero ? '0.8rem' : undefined,
  }
}

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
  if (props.element.autoPlay && slides.value.length > 1) {
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
.carousel-element {
  cursor: pointer;
}

.carousel-container {
  position: relative;
  width: 100%;
  overflow: hidden;
  border-radius: 8px;
}

.carousel-track {
  height: 100%;
}

.carousel-slide {
  position: relative;
  background: #1a1a2e;
}

.slide-overlay {
  position: absolute;
  inset: 0;
  z-index: 2;
}

.slide-image {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.slide-placeholder {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.slide-link-overlay {
  position: absolute;
  inset: 0;
  z-index: 4;
}

.slide-content {
  position: absolute;
  inset: 0;
  z-index: 5;
  color: white;
  display: flex;
  flex-direction: column;
  gap: 10px;
  pointer-events: none;
}

.slide-button {
  display: inline-block;
  margin-top: 12px;
  padding: 10px 24px;
  background: #005674;
  color: white;
  text-decoration: none;
  border-radius: 6px;
  font-weight: 600;
  pointer-events: auto;
}

.slide-button:hover {
  background: #003d52;
}

.slide-title {
  font-size: 1.75rem;
  font-weight: 700;
  margin-bottom: 8px;
  line-height: 1.15;
}

.slide-description {
  font-size: 1rem;
  line-height: 1.5;
  max-width: 600px;
  margin: 0;
}

.carousel-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(255, 255, 255, 0.9);
  border: none;
  color: #333;
  font-size: 28px;
  width: 44px;
  height: 44px;
  cursor: pointer;
  border-radius: 50%;
  z-index: 10;
}

.carousel-nav-prev { left: 12px; }
.carousel-nav-next { right: 12px; }

.carousel-indicators {
  position: absolute;
  bottom: 16px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 8px;
  z-index: 10;
}

.carousel-indicator {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  border: 2px solid rgba(255, 255, 255, 0.6);
  background: rgba(255, 255, 255, 0.3);
  cursor: pointer;
  padding: 0;
}

.carousel-indicator.active {
  background: white;
  border-color: white;
}

.carousel-element--hero-full {
  font-family: var(--font-idcbis);
}

.carousel-element--hero-full .carousel-nav {
  background: rgba(255, 255, 255, 0.15);
  color: #fff;
  width: 60px;
  height: 60px;
  backdrop-filter: blur(10px);
  font-size: 1.5rem;
}

.carousel-element--hero-full .carousel-nav:hover {
  background: rgba(255, 255, 255, 0.25);
}

.carousel-element--hero-full .carousel-indicator {
  width: 14px;
  height: 14px;
  background: rgba(255, 255, 255, 0.5);
  border: none;
}

.carousel-element--hero-full .carousel-indicator.active {
  background: #d32f2f;
}

.carousel-element--hero-full .slide-button:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(211, 47, 47, 0.5);
}

@media (max-width: 768px) {
  .carousel-element--hero-full .slide-content {
    padding: 0 2rem !important;
    text-align: center !important;
    align-items: center !important;
  }
}
</style>
