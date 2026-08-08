<template>
  <div
    class="carousel-element"
    :class="{ 'carousel-element--hero-full': isHeroFull }"
    :style="carouselStyles"
    @click="$emit('click', element)"
  >
    <div
      class="carousel-container"
      :class="{ 'carousel-container--hero-full': isHeroFull }"
      :style="containerStyles"
    >
      <div class="carousel-track" :style="trackStyles">
        <div
          v-for="(slide, index) in slides"
          :key="slide.id || index"
          class="carousel-slide"
          :class="partClasses(slideAnchor(slide, index))"
          :style="slideStyles"
          @click.stop="onSlideClick(slide, index, $event)"
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
import { useIdcbisEditorParts } from '../../composables/useIdcbisEditorParts'
import { buildCarouselSlideFocusAnchor } from '../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const currentSlide = ref(0)
let autoplayInterval = null

const slides = computed(() => props.element.slides || [])

const slideAnchor = (slide, index) => buildCarouselSlideFocusAnchor(slide.id || `index-${index}`)

const onSlideClick = (slide, index, event) => {
  goToSlide(index)
  focusPart(slideAnchor(slide, index), slide.title || `Slide ${index + 1}`, event)
  if (!props.preview) emit('click', props.element)
}

const focusSlideFromAnchor = (anchor) => {
  if (!anchor?.startsWith('slide:')) return
  const id = anchor.slice(6)
  const index = slides.value.findIndex((slide, i) => (slide.id || `index-${i}`) === id)
  if (index >= 0) currentSlide.value = index
}

watch(() => props.focusedPart, focusSlideFromAnchor, { immediate: true })

const isHeroFull = computed(() => props.element.variant === 'hero-full')

const containerStyles = computed(() => {
  const styles = {
    borderRadius: props.element.borderRadius || (isHeroFull.value ? '0 0 30px 30px' : '8px'),
  }
  // Hero full: altura 100% por CSS responsive (ignora height del CMS en móvil).
  if (!isHeroFull.value) {
    styles.height = props.element.height || '400px'
  }
  return styles
})

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
    // El padding responsive del hero se aplica por CSS; aquí solo desktop / no-hero
    padding: props.element.contentPadding || (hero ? undefined : '32px 24px 48px'),
    maxWidth: hero ? '1200px' : undefined,
    margin: hero ? '0 auto' : undefined,
    width: hero ? '100%' : undefined,
    boxSizing: 'border-box',
  }
}

const titleStyles = (slide) => {
  // Hero-full: tipografía por CSS (responsive). Solo inline si el CMS define tamaño.
  const customSize = slide.titleSize || props.element.titleSize
  const styles = {
    fontWeight: slide.titleWeight || props.element.titleWeight || '700',
    color: slide.titleColor || props.element.titleColor || '#ffffff',
    textTransform: slide.titleTransform || props.element.titleTransform || 'none',
    overflowWrap: 'break-word',
  }
  if (customSize) styles.fontSize = customSize
  else if (!isHeroFull.value) styles.fontSize = '2.5rem'
  if (isHeroFull.value) {
    styles.lineHeight = '1.2'
    styles.maxWidth = '800px'
    styles.textShadow = '0 2px 15px rgba(0, 0, 0, 0.3)'
    styles.fontFamily = 'var(--font-idcbis)'
  }
  return styles
}

const descriptionStyles = (slide) => {
  const customSize = slide.descriptionSize || props.element.descriptionSize
  const styles = {
    color: slide.descriptionColor || props.element.descriptionColor || '#ffffff',
    maxWidth: props.element.descriptionMaxWidth || (isHeroFull.value ? '700px' : '720px'),
    overflowWrap: 'break-word',
  }
  if (customSize) styles.fontSize = customSize
  else if (!isHeroFull.value) styles.fontSize = '1.1rem'
  if (isHeroFull.value) styles.opacity = '0.95'
  return styles
}

const buttonStyles = (slide) => {
  const hero = isHeroFull.value
  const styles = {
    background: slide.buttonBg || props.element.buttonBg || (hero ? 'linear-gradient(135deg, #d32f2f 0%, #9a0007 100%)' : '#005674'),
    color: slide.buttonColor || props.element.buttonColor || '#ffffff',
    borderRadius: slide.buttonRadius || props.element.buttonRadius || '999px',
    fontWeight: slide.buttonWeight || props.element.buttonWeight || '600',
    textTransform: slide.buttonTransform || props.element.buttonTransform || (hero ? 'none' : 'uppercase'),
    letterSpacing: slide.buttonLetterSpacing || props.element.buttonLetterSpacing || (hero ? '0' : '0.04em'),
    maxWidth: '100%',
    boxSizing: 'border-box',
  }
  if (hero) {
    styles.boxShadow = '0 8px 25px rgba(211, 47, 47, 0.4)'
    styles.display = 'inline-flex'
    styles.alignItems = 'center'
    styles.justifyContent = 'center'
    styles.gap = '0.8rem'
  }
  return styles
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
  if (props.preview && props.element.autoPlay && slides.value.length > 1) {
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
  max-width: 100%;
}

.carousel-container {
  position: relative;
  width: 100%;
  max-width: 100%;
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

/* Altura responsive: conserva estructura absolute del carrusel */
.carousel-container--hero-full {
  height: 550px;
}

.carousel-element--hero-full .slide-content {
  padding: 3rem 4rem 4rem;
  box-sizing: border-box;
}

.carousel-element--hero-full .slide-title {
  font-size: clamp(2rem, 4.5vw, 3.5rem);
  margin-bottom: 1.25rem;
  line-height: 1.2;
}

.carousel-element--hero-full .slide-description {
  font-size: clamp(1.05rem, 2vw, 1.4rem);
  margin-bottom: 2rem;
  line-height: 1.5;
}

.carousel-element--hero-full .slide-button {
  padding: 1.1rem 2.8rem;
  font-size: 1.2rem;
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

@media (max-width: 900px) {
  .carousel-container--hero-full {
    height: 500px;
  }

  .carousel-element--hero-full .slide-content {
    padding: 2.5rem 2rem 3.25rem !important;
    text-align: center !important;
    align-items: center !important;
    justify-content: center !important;
  }

  .carousel-element--hero-full .slide-title {
    font-size: clamp(1.65rem, 5.5vw, 2.4rem) !important;
    margin-bottom: 0.85rem;
    max-width: 100%;
  }

  .carousel-element--hero-full .slide-description {
    font-size: 1.05rem !important;
    margin-bottom: 1.35rem;
    max-width: 100%;
  }

  .carousel-element--hero-full .slide-button {
    padding: 0.95rem 1.75rem;
    font-size: 1.05rem;
  }

  .carousel-element--hero-full .carousel-nav {
    width: 44px;
    height: 44px;
    font-size: 1.25rem;
  }

  .carousel-nav-prev { left: 8px; }
  .carousel-nav-next { right: 8px; }
}

@media (max-width: 600px) {
  .carousel-container--hero-full {
    /* Más alto en móvil para que título + texto + botón quepan sin recorte */
    height: 580px;
  }

  .carousel-element--hero-full .slide-content {
    padding: 2.25rem 1.15rem 3.5rem !important;
  }

  .carousel-element--hero-full .slide-title {
    font-size: clamp(1.5rem, 7vw, 2rem) !important;
    margin-bottom: 0.75rem;
  }

  .carousel-element--hero-full .slide-description {
    font-size: 0.98rem !important;
    margin-bottom: 1.15rem;
  }

  .carousel-element--hero-full .slide-button {
    width: 100%;
    max-width: 280px;
    padding: 0.9rem 1.4rem;
    font-size: 1rem;
  }

  .carousel-element--hero-full .carousel-indicators {
    bottom: 12px;
  }
}

@media (max-width: 380px) {
  .carousel-container--hero-full {
    height: 620px;
  }

  .carousel-element--hero-full .slide-content {
    padding: 2rem 0.9rem 3.25rem !important;
  }

  .carousel-element--hero-full .slide-button {
    max-width: 100%;
  }
}

@media (prefers-reduced-motion: reduce) {
  .carousel-track {
    transition: none;
  }

  .carousel-element--hero-full .slide-button:hover {
    transform: none;
  }
}
</style>
