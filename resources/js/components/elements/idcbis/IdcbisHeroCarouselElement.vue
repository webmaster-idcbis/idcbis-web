<template>
  <section
    class="idcbis-hero-carousel"
    :aria-roledescription="preview ? 'carrusel' : undefined"
    aria-label="IDCBIS, ciencia que transforma vidas"
    @click.stop="$emit('click', element)"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false"
    @focusin="isFocused = true"
    @focusout="onFocusOut"
  >
    <div class="idcbis-hero-carousel__viewport">
      <div
        v-if="useSharedVisual"
        class="idcbis-hero__shared"
        role="img"
        :aria-label="visualLabel"
      >
        <video
          v-if="videoSrc"
          class="idcbis-hero__bg"
          autoplay
          muted
          loop
          playsinline
          :poster="videoPoster"
        >
          <source :src="videoSrc" type="video/mp4" />
        </video>
        <template v-else>
          <img
            v-for="(frame, index) in visualFrames"
            :key="frame.src || index"
            class="idcbis-hero__bg idcbis-hero__frame"
            :class="{ 'idcbis-hero__frame--active': currentFrame === index }"
            :src="frame.src"
            alt=""
            width="1920"
            height="700"
            decoding="async"
            :loading="index === 0 ? 'eager' : 'lazy'"
            :fetchpriority="index === 0 ? 'high' : 'low'"
          />
        </template>
        <div class="idcbis-hero__veil" aria-hidden="true" />
      </div>
      <div class="idcbis-hero-carousel__track" :style="trackStyles">
        <article
          v-for="(slide, index) in slides"
          :key="slide.id || index"
          class="idcbis-hero idcbis-hero-carousel__slide"
          :class="[
            partClasses(slideAnchor(slide, index)),
            { 'idcbis-hero--with-bg': hasSlideBackground(slide) || useSharedVisual },
            { 'idcbis-hero--shared': useSharedVisual },
            { 'idcbis-hero--story': quickAnswers.length > 0 },
          ]"
          :aria-hidden="currentSlide !== index"
          :inert="currentSlide !== index || undefined"
          @click.stop="onSlideClick(slide, index, $event)"
        >
          <picture v-if="slideBackground(slide) && !useSharedVisual" class="idcbis-hero__picture">
            <source
              type="image/webp"
              :srcset="heroSrcSet(slide)"
              sizes="100vw"
            />
            <img
              class="idcbis-hero__bg"
              :src="slideBackground(slide)"
              :alt="slide.imageAlt || ''"
              width="1920"
              height="700"
              decoding="async"
              :loading="index === 0 ? 'eager' : 'lazy'"
              :fetchpriority="index === 0 ? 'high' : 'low'"
            />
          </picture>
          <div v-if="hasSlideBackground(slide) && !useSharedVisual" class="idcbis-hero__veil" aria-hidden="true" />
          <div class="idcbis-hero__content">
            <div class="idcbis-hero__text">
              <component
                :is="currentSlide === index ? 'h1' : 'p'"
                class="idcbis-hero__title"
              >
                <span class="light">{{ slide.titleLight || 'Ciencia que' }}</span>
                {{ slide.titleBold || 'transforma vidas' }}
              </component>
              <p v-if="slide.subtitle">{{ slide.subtitle }}</p>
              <ul v-if="quickAnswers.length && index === 0" class="idcbis-hero__answers">
                <li v-for="item in quickAnswers" :key="item.id || item.question" class="idcbis-hero__answer">
                  <component :is="answerIcon(item.icon)" class="idcbis-hero__answer-icon" aria-hidden="true" />
                  <div>
                    <p class="idcbis-hero__answer-q">{{ item.question }}</p>
                    <p class="idcbis-hero__answer-a">{{ item.answer }}</p>
                  </div>
                </li>
              </ul>
              <div class="idcbis-hero__cta">
                <component
                  :is="preview ? 'a' : 'button'"
                  v-if="slide.button1Text"
                  :href="preview ? (slide.button1Url || '#') : undefined"
                  type="button"
                  class="btn-big primary"
                  @click.stop="!preview && $event.preventDefault()"
                >
                  {{ slide.button1Text }}
                </component>
                <component
                  :is="preview ? 'a' : 'button'"
                  v-if="slide.button2Text"
                  :href="preview ? (slide.button2Url || '#') : undefined"
                  type="button"
                  class="btn-big secondary"
                  @click.stop="!preview && $event.preventDefault()"
                >
                  {{ slide.button2Text }}
                </component>
                <component
                  :is="preview ? 'a' : 'button'"
                  v-if="slide.button3Text"
                  :href="preview ? (slide.button3Url || '#') : undefined"
                  type="button"
                  class="btn-big outline"
                  @click.stop="!preview && $event.preventDefault()"
                >
                  {{ slide.button3Text }}
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

      <button
        v-if="showPauseControl"
        type="button"
        class="idcbis-hero-carousel__pause"
        :aria-pressed="userPaused"
        @click.stop="toggleAutoplay"
      >
        {{ userPaused ? 'Reanudar' : 'Pausar' }}
      </button>

      <div
        v-if="slides.length > 1 && element.showIndicators !== false"
        class="idcbis-hero-carousel__dots"
        role="group"
        aria-label="Elegir servicio"
      >
        <button
          v-for="(slide, index) in slides"
          :key="'dot-' + (slide.id || index)"
          type="button"
          class="idcbis-hero-carousel__dot"
          :class="{ 'idcbis-hero-carousel__dot--active': currentSlide === index }"
          :aria-label="`Ir a ${slideLabel(slide, index)}`"
          :aria-current="currentSlide === index ? 'true' : undefined"
          @click.stop="goToSlide(index)"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { Building2, FlaskConical, HandHeart } from 'lucide-vue-next'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildHeroSlideFocusAnchor } from '../../../utils/editorPartFocus'
import { HERO_WIDTHS, buildSrcSet } from '../../../utils/responsiveImages'

const ANSWER_ICONS = {
  institute: Building2,
  science: FlaskConical,
  action: HandHeart,
}

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])

const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const currentSlide = ref(0)
const currentFrame = ref(0)
const isHovered = ref(false)
const isFocused = ref(false)
const prefersReducedMotion = ref(false)
const userPaused = ref(false)
let autoplayInterval = null
let frameInterval = null

const slides = computed(() => props.element.slides || [])

const quickAnswers = computed(() => props.element.quickAnswers || [])

const visualFrames = computed(() => (props.element.visualFrames || []).filter((frame) => frame?.src))

const videoSrc = computed(() => props.element.videoSrc || '')

const videoPoster = computed(() => props.element.videoPoster || visualFrames.value[0]?.src || props.element.backgroundImage || '')

const useSharedVisual = computed(() => Boolean(videoSrc.value || visualFrames.value.length))

const visualLabel = computed(() => {
  if (videoSrc.value) {
    return props.element.videoLabel || 'Secuencia del IDCBIS: de la donación al laboratorio y a la vida'
  }
  return visualFrames.value.map((frame) => frame.alt).filter(Boolean).join('. ')
    || 'Personas y laboratorios del IDCBIS'
})

const answerIcon = (name) => ANSWER_ICONS[name] || Building2

const slideBackground = (slide) => slide.backgroundImage || props.element.backgroundImage || ''

const hasSlideBackground = (slide) => Boolean(slideBackground(slide))

const heroSrcSet = (slide) => buildSrcSet(slideBackground(slide), HERO_WIDTHS)

const showPauseControl = computed(() => (
  props.preview
  && props.element.autoPlay !== false
  && slides.value.length > 1
  && !prefersReducedMotion.value
))

const toggleAutoplay = () => {
  userPaused.value = !userPaused.value
}

const slideAnchor = (slide, index) => buildHeroSlideFocusAnchor(slide.id || `index-${index}`)

const slideLabel = (slide, index) => {
  const title = [slide.titleLight, slide.titleBold].filter(Boolean).join(' ').trim()
  return title || `Slide ${index + 1}`
}

const onSlideClick = (slide, index, event) => {
  goToSlide(index)
  focusPart(slideAnchor(slide, index), slideLabel(slide, index), event)
  if (!props.preview) {
    emit('click', props.element)
  }
}

const focusSlideFromAnchor = (anchor) => {
  if (!anchor?.startsWith('slide:')) return
  const id = anchor.slice(6)
  const index = slides.value.findIndex((slide, i) => (slide.id || `index-${i}`) === id)
  if (index >= 0) currentSlide.value = index
}

watch(() => props.focusedPart, focusSlideFromAnchor, { immediate: true })

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

const canAutoplay = computed(() => (
  props.preview
  && props.element.autoPlay !== false
  && slides.value.length > 1
  && !prefersReducedMotion.value
  && !userPaused.value
))

const startAutoplay = () => {
  stopAutoplay()
  if (!canAutoplay.value || isHovered.value || isFocused.value) return
  autoplayInterval = setInterval(nextSlide, props.element.interval || 5000)
}

const stopAutoplay = () => {
  if (autoplayInterval) {
    clearInterval(autoplayInterval)
    autoplayInterval = null
  }
}

const startFrames = () => {
  stopFrames()
  if (videoSrc.value || visualFrames.value.length < 2 || prefersReducedMotion.value) return
  frameInterval = setInterval(() => {
    currentFrame.value = (currentFrame.value + 1) % visualFrames.value.length
  }, props.element.frameInterval || 4500)
}

const stopFrames = () => {
  if (frameInterval) {
    clearInterval(frameInterval)
    frameInterval = null
  }
}

const onFocusOut = (event) => {
  if (!event.currentTarget.contains(event.relatedTarget)) {
    isFocused.value = false
  }
}

watch(
  () => [props.element.autoPlay, props.element.interval, slides.value.length, isHovered.value, isFocused.value, canAutoplay.value],
  startAutoplay,
)

onMounted(() => {
  prefersReducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  startAutoplay()
  startFrames()
})
onUnmounted(() => {
  stopAutoplay()
  stopFrames()
})
</script>

<style scoped>
.idcbis-hero-carousel {
  font-family: var(--font-idcbis);
  cursor: pointer;
  max-width: 100%;
  overflow: hidden;
}

.idcbis-hero-carousel__viewport {
  position: relative;
  overflow: hidden;
  max-width: 100%;
}

.idcbis-hero-carousel__track {
  display: flex;
  position: relative;
  z-index: 2;
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
  max-width: 100%;
  box-sizing: border-box;
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
}

.idcbis-hero--with-bg {
  background-color: #0b4f6c;
  min-height: clamp(320px, 36.46vw, 700px);
  display: flex;
  align-items: center;
  padding: 0;
}

.idcbis-hero--story.idcbis-hero--with-bg {
  min-height: calc(100dvh - 8.75rem);
}

.idcbis-hero--shared,
.idcbis-hero--shared.idcbis-hero--with-bg {
  background: transparent;
  background-color: transparent;
}

.idcbis-hero--with-bg::before,
.idcbis-hero--with-bg::after {
  display: none;
}

.idcbis-hero__picture,
.idcbis-hero__bg {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 0;
  pointer-events: none;
}

.idcbis-hero__shared {
  position: absolute;
  inset: 0;
  z-index: 0;
  pointer-events: none;
}

.idcbis-hero__frame {
  opacity: 0;
  transition: opacity 1.1s ease;
}

.idcbis-hero__frame--active {
  opacity: 1;
}

.idcbis-hero__veil {
  position: absolute;
  inset: 0;
  z-index: 1;
  pointer-events: none;
  background: linear-gradient(90deg, rgba(0, 40, 62, 0.86) 0%, rgba(0, 40, 62, 0.62) 46%, rgba(0, 40, 62, 0.22) 100%);
}

.idcbis-hero--with-bg .idcbis-hero__content {
  justify-content: flex-start;
  width: 100%;
  padding: 4rem 2rem 6rem;
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
  max-width: min(1400px, 100%);
  width: 100%;
  margin: 0 auto;
  position: relative;
  z-index: 2;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 3rem;
  box-sizing: border-box;
}

.idcbis-hero__text {
  flex: 1 1 auto;
  min-width: 0;
  max-width: 100%;
}

.idcbis-hero__title {
  font-size: clamp(1.75rem, 5vw, 3.6rem);
  font-weight: 600;
  line-height: 1.15;
  margin-bottom: 1rem;
  text-transform: uppercase;
  overflow-wrap: break-word;
  word-break: normal;
  hyphens: none;
}

.idcbis-hero__title .light {
  font-weight: 300;
  display: block;
  font-size: clamp(1.5rem, 4vw, 3rem);
  opacity: 0.9;
}

.idcbis-hero__text > p {
  font-size: clamp(1rem, 2.2vw, 1.2rem);
  margin-bottom: 1.25rem;
  opacity: 0.95;
  max-width: 46rem;
  overflow-wrap: break-word;
  line-height: 1.5;
}

.idcbis-hero__cta {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
  max-width: 100%;
}

.btn-big {
  padding: 0.85rem 1.75rem;
  min-height: 44px;
  border: 2px solid transparent;
  border-radius: 60px;
  font-size: 1.05rem;
  font-weight: 700;
  cursor: pointer;
  transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
  box-shadow: none;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  box-sizing: border-box;
  text-align: center;
  max-width: 100%;
  line-height: 1.3;
}

.btn-big:focus-visible {
  outline: 3px solid #ffffff;
  outline-offset: 3px;
}

.btn-big.primary,
.btn-big.orange {
  background: #C4A140;
  color: #003C5F;
  border-color: #C4A140;
}

.btn-big.primary:hover,
.btn-big.orange:hover {
  background: #D9B85A;
  border-color: #D9B85A;
}

.btn-big.secondary {
  background: #ffffff;
  color: #003C5F;
  border-color: #ffffff;
}

.btn-big.secondary:hover {
  background: #eceff1;
  border-color: #eceff1;
}

.btn-big.outline,
.btn-big.purple {
  background: transparent;
  color: #ffffff;
  border-color: #ffffff;
}

.btn-big.outline:hover,
.btn-big.purple:hover {
  background: rgba(255, 255, 255, 0.14);
}

.idcbis-hero__answers {
  list-style: none;
  margin: 0 0 1.5rem;
  padding: 0;
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 0.75rem;
  max-width: 920px;
}

.idcbis-hero__answer {
  display: flex;
  gap: 0.65rem;
  align-items: flex-start;
  margin: 0;
  padding: 0.75rem 0.8rem;
  border-radius: 0.75rem;
  background: rgba(0, 60, 95, 0.88);
  border: 1px solid rgba(255, 255, 255, 0.22);
}

.idcbis-hero__answer-icon {
  width: 1.35rem;
  height: 1.35rem;
  flex-shrink: 0;
  margin-top: 0.1rem;
  color: #C4A140;
}

.idcbis-hero__answer-q {
  margin: 0 0 0.2rem;
  font-size: 0.95rem;
  font-weight: 700;
  line-height: 1.3;
  color: #ffffff;
}

.idcbis-hero__answer-a {
  margin: 0;
  font-size: 0.875rem;
  line-height: 1.4;
  color: rgba(255, 255, 255, 0.92);
  max-width: none;
}

.idcbis-hero__image {
  flex: 1 1 280px;
  min-width: 0;
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
  width: 44px;
  height: 44px;
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

.idcbis-hero-carousel__nav:focus-visible {
  outline: 2px solid #ffffff;
  outline-offset: 3px;
  opacity: 1;
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

.idcbis-hero-carousel__pause {
  position: absolute;
  z-index: 20;
  top: 1rem;
  right: 1rem;
  min-height: 44px;
  min-width: 44px;
  padding: 0 1rem;
  border: 2px solid #ffffff;
  border-radius: 999px;
  background: rgba(11, 79, 108, 0.72);
  color: #ffffff;
  font-family: inherit;
  font-size: 0.95rem;
  font-weight: 700;
  cursor: pointer;
}

.idcbis-hero-carousel__pause:focus-visible {
  outline: 3px solid #ffffff;
  outline-offset: 3px;
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
  min-width: 44px;
  min-height: 44px;
  border-radius: 50%;
  border: 2px solid transparent;
  background: transparent;
  padding: 0;
  cursor: pointer;
  transition: all 0.2s;
  position: relative;
}

.idcbis-hero-carousel__dot::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  border: 2px solid rgba(255, 255, 255, 0.7);
  background: rgba(255, 255, 255, 0.25);
  transform: translate(-50%, -50%);
}

.idcbis-hero-carousel__dot--active::after {
  background: white;
  border-color: white;
  transform: translate(-50%, -50%) scale(1.15);
}

.idcbis-hero-carousel__dot:focus-visible {
  outline: 2px solid #ffffff;
  outline-offset: 2px;
}

@media (max-width: 900px) {
  .idcbis-hero {
    padding: 3rem 1.25rem 4.5rem;
  }

  .idcbis-hero--with-bg,
  .idcbis-hero--story.idcbis-hero--with-bg {
    min-height: 0;
  }

  .idcbis-hero__answers {
    grid-template-columns: 1fr;
    text-align: left;
  }

  .idcbis-hero__text .idcbis-hero__answer-q,
  .idcbis-hero__text .idcbis-hero__answer-a {
    margin-left: 0;
    margin-right: 0;
    max-width: none;
  }

  .idcbis-hero--with-bg .idcbis-hero__content {
    padding: 3rem 1.25rem 4.5rem;
  }

  .idcbis-hero__content {
    flex-direction: column;
    text-align: center;
    gap: 1.75rem;
  }

  .idcbis-hero__text > p {
    margin-left: auto;
    margin-right: auto;
  }

  .idcbis-hero__veil {
    background: linear-gradient(180deg, rgba(11, 79, 108, 0.9) 0%, rgba(11, 79, 108, 0.62) 100%);
  }

  .idcbis-hero__cta {
    justify-content: center;
    flex-direction: column;
    align-items: stretch;
    gap: 0.75rem;
  }

  .btn-big {
    width: 100%;
    padding: 0.75rem 1.25rem;
    font-size: 1rem;
  }

  .idcbis-hero__image {
    width: 100%;
    max-width: 320px;
    height: 220px;
  }

  .idcbis-hero-carousel__nav {
    width: 44px;
    height: 44px;
    bottom: 2.5rem;
    opacity: 0.75;
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

@media (max-width: 480px) {
  .idcbis-hero,
  .idcbis-hero--with-bg .idcbis-hero__content {
    padding: 2.5rem 1rem 4rem;
  }

  .idcbis-hero__title {
    font-size: clamp(1.6rem, 9vw, 2.25rem);
  }

  .idcbis-hero__title .light {
    font-size: clamp(1.35rem, 7vw, 1.85rem);
  }

  .idcbis-hero__text > p {
    font-size: 1rem;
    margin-bottom: 1.25rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  .idcbis-hero-carousel__track,
  .idcbis-hero__frame {
    transition: none;
  }

  .btn-big,
  .idcbis-hero-carousel__nav,
  .idcbis-hero-carousel__dot,
  .idcbis-hero-carousel__pause {
    transition: none;
  }
}
</style>
