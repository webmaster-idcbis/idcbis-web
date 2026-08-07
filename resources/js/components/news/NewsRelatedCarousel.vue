<template>
  <section
    v-if="items.length"
    class="related-carousel"
    aria-roledescription="carrusel"
    :aria-label="title"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false"
    @focusin="isFocused = true"
    @focusout="onFocusOut"
  >
    <div class="related-carousel__header">
      <h2 class="related-carousel__title">{{ title }}</h2>
      <div v-if="items.length > 1" class="related-carousel__controls">
        <button
          type="button"
          class="related-carousel__nav"
          aria-label="Noticia anterior"
          @click="slidePrev"
        >
          <ChevronLeft :size="18" aria-hidden="true" />
        </button>
        <button
          type="button"
          class="related-carousel__nav"
          aria-label="Noticia siguiente"
          @click="slideNext"
        >
          <ChevronRight :size="18" aria-hidden="true" />
        </button>
      </div>
    </div>

    <swiper
      :modules="swiperModules"
      :slides-per-view="1.2"
      :space-between="12"
      :loop="items.length >= 4"
      :autoplay="autoplayConfig"
      :pagination="{ clickable: true }"
      :breakpoints="{
        640: { slidesPerView: 2.1, spaceBetween: 14 },
        900: { slidesPerView: 3, spaceBetween: 16 },
      }"
      :a11y="{
        enabled: true,
        prevSlideMessage: 'Noticia anterior',
        nextSlideMessage: 'Noticia siguiente',
        paginationBulletMessage: 'Ir a la noticia {{index}}',
      }"
      class="related-carousel__swiper"
      @swiper="onSwiper"
    >
      <swiper-slide v-for="item in items" :key="item.id" class="related-carousel__slide">
        <router-link :to="item.url" class="related-carousel__card">
          <div class="related-carousel__media">
            <img
              v-if="item.image"
              :src="item.image"
              :alt="item.title"
              loading="lazy"
            >
            <div v-else class="related-carousel__placeholder" aria-hidden="true">IDCBIS</div>
          </div>
          <div class="related-carousel__body">
            <span class="related-carousel__category">{{ item.categoryLabel }}</span>
            <h3 class="related-carousel__card-title">{{ item.title }}</h3>
            <time v-if="item.publishedAt" class="related-carousel__date">{{ item.publishedAt }}</time>
          </div>
        </router-link>
      </swiper-slide>
    </swiper>
  </section>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from 'vue'
import { ChevronLeft, ChevronRight } from 'lucide-vue-next'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { A11y, Autoplay, Pagination } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/pagination'

const props = defineProps({
  items: { type: Array, default: () => [] },
  title: { type: String, default: 'Noticias relacionadas' },
  autoPlay: { type: Boolean, default: true },
  interval: { type: Number, default: 4000 },
})

const swiperModules = [Autoplay, Pagination, A11y]
const swiperInstance = ref(null)
const isHovered = ref(false)
const isFocused = ref(false)
const prefersReducedMotion = ref(false)

const autoplayConfig = computed(() => {
  if (!props.autoPlay || prefersReducedMotion.value || props.items.length < 2) {
    return false
  }
  return {
    delay: props.interval,
    disableOnInteraction: false,
    pauseOnMouseEnter: true,
  }
})

const onSwiper = (instance) => {
  swiperInstance.value = instance
}

const slidePrev = () => swiperInstance.value?.slidePrev()
const slideNext = () => swiperInstance.value?.slideNext()

const onFocusOut = (event) => {
  if (!event.currentTarget.contains(event.relatedTarget)) {
    isFocused.value = false
  }
}

watch([isHovered, isFocused], ([hovered, focused]) => {
  const swiper = swiperInstance.value
  if (!swiper?.autoplay) return
  if (hovered || focused) {
    swiper.autoplay.stop()
  } else if (autoplayConfig.value) {
    swiper.autoplay.start()
  }
})

onMounted(() => {
  prefersReducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches
})

onUnmounted(() => {
  swiperInstance.value = null
})
</script>

<style scoped>
.related-carousel {
  font-family: var(--font-idcbis);
  background: #f0f5f8;
  padding: 2.25rem 1.5rem 2.75rem;
  overflow: hidden;
}

.related-carousel__header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  max-width: 960px;
  margin: 0 auto 1.25rem;
}

.related-carousel__title {
  margin: 0;
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.2rem, 2vw, 1.4rem);
  font-weight: 800;
  color: #0b4f6c;
  line-height: 1.25;
}

.related-carousel__controls {
  display: flex;
  gap: 0.4rem;
  flex-shrink: 0;
}

.related-carousel__nav {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border: 1px solid #d7e4ea;
  border-radius: 9999px;
  background: #fff;
  color: #0b4f6c;
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, box-shadow 0.2s;
}

.related-carousel__nav:hover {
  border-color: #2c8c99;
  background: #f0f9fb;
}

.related-carousel__nav:focus-visible {
  outline: none;
  box-shadow: 0 0 0 3px rgba(44, 140, 153, 0.3);
}

.related-carousel__swiper {
  max-width: 960px;
  margin: 0 auto;
  padding-bottom: 2rem;
  overflow: hidden;
}

.related-carousel__slide {
  height: auto;
}

.related-carousel__card {
  display: flex;
  flex-direction: column;
  height: 100%;
  background: #fff;
  border: 1px solid #e8eef2;
  border-radius: 12px;
  overflow: hidden;
  text-decoration: none;
  color: inherit;
  transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
}

.related-carousel__card:hover {
  border-color: #2c8c99;
  box-shadow: 0 8px 22px rgba(11, 79, 108, 0.1);
  transform: translateY(-2px);
}

.related-carousel__media {
  aspect-ratio: 16 / 9;
  overflow: hidden;
  background: linear-gradient(135deg, #e8f4f8, #d4eef0);
}

.related-carousel__media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.related-carousel__placeholder {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9375rem;
  font-weight: 800;
  letter-spacing: 0.06em;
  color: #0b4f6c;
  opacity: 0.3;
}

.related-carousel__body {
  display: flex;
  flex-direction: column;
  gap: 0.3rem;
  padding: 0.85rem 0.95rem 1rem;
  flex: 1;
}

.related-carousel__category {
  font-size: 0.625rem;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  color: #2c8c99;
}

.related-carousel__card-title {
  margin: 0;
  font-size: 0.875rem;
  font-weight: 700;
  color: #0b4f6c;
  line-height: 1.35;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.related-carousel__date {
  margin-top: auto;
  padding-top: 0.25rem;
  font-size: 0.75rem;
  color: #64748b;
}

:deep(.related-carousel__swiper .swiper-pagination-bullet) {
  width: 8px;
  height: 8px;
  background: #b7c9d2;
  opacity: 1;
  transition: width 0.2s, background 0.2s;
}

:deep(.related-carousel__swiper .swiper-pagination-bullet-active) {
  width: 18px;
  border-radius: 9999px;
  background: #0b4f6c;
}

@media (max-width: 640px) {
  .related-carousel {
    padding: 1.75rem 1rem 2.25rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  .related-carousel__card:hover {
    transform: none;
  }
}
</style>
