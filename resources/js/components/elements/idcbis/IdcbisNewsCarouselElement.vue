<template>
  <section
    class="news-carousel"
    :aria-roledescription="preview ? 'carrusel' : undefined"
    :aria-label="sectionTitle"
    @click.stop="!preview && $emit('click', element)"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false"
    @focusin="isFocused = true"
    @focusout="onFocusOut"
  >
    <div class="news-carousel__inner">
      <header class="news-carousel__header">
        <div>
          <p v-if="sectionEyebrow" class="news-carousel__eyebrow">{{ sectionEyebrow }}</p>
          <h2 class="news-carousel__title">{{ sectionTitle }}</h2>
          <p v-if="sectionSubtitle" class="news-carousel__subtitle">{{ sectionSubtitle }}</p>
        </div>
        <div v-if="items.length > 1" class="news-carousel__controls">
          <button
            type="button"
            class="news-carousel__nav"
            aria-label="Noticia anterior"
            @click.stop="slidePrev"
          >
            <ChevronLeft :size="22" aria-hidden="true" />
          </button>
          <button
            type="button"
            class="news-carousel__nav"
            aria-label="Noticia siguiente"
            @click.stop="slideNext"
          >
            <ChevronRight :size="22" aria-hidden="true" />
          </button>
        </div>
      </header>

      <p v-if="loading && !items.length" class="news-carousel__empty">
        Cargando noticias…
      </p>

      <p v-else-if="!items.length" class="news-carousel__empty">
        Aún no hay noticias para mostrar en el carrusel.
      </p>

      <div v-else class="news-carousel__viewport">
        <swiper
          :modules="swiperModules"
          :slides-per-view="1.15"
          :space-between="16"
          :loop="items.length >= 4"
          :autoplay="autoplayConfig"
          :pagination="{ clickable: true }"
          :breakpoints="{
            640: { slidesPerView: 1.4, spaceBetween: 18 },
            768: { slidesPerView: 2.2, spaceBetween: 20 },
            1024: { slidesPerView: 3, spaceBetween: 24 },
          }"
          :a11y="{
            enabled: true,
            prevSlideMessage: 'Noticia anterior',
            nextSlideMessage: 'Noticia siguiente',
            paginationBulletMessage: 'Ir a la noticia {{index}}',
          }"
          class="news-carousel__swiper"
          @swiper="onSwiper"
        >
          <swiper-slide
            v-for="item in items"
            :key="item.id"
            class="news-carousel__slide"
          >
            <component
              :is="cardTag(item)"
              v-bind="cardAttrs(item)"
              class="news-carousel__card"
            >
              <div class="news-carousel__media">
                <img
                  v-if="item.image"
                  :src="item.image"
                  :alt="item.title"
                  class="news-carousel__image"
                  loading="lazy"
                >
                <div v-else class="news-carousel__placeholder" aria-hidden="true">
                  IDCBIS
                </div>
                <span class="news-carousel__category">{{ item.categoryLabel }}</span>
              </div>
              <div class="news-carousel__body">
                <time v-if="item.publishedAt" class="news-carousel__date">
                  <Calendar :size="14" aria-hidden="true" />
                  {{ item.publishedAt }}
                </time>
                <h3 class="news-carousel__card-title">{{ item.title }}</h3>
                <p v-if="item.excerpt" class="news-carousel__excerpt">{{ item.excerpt }}</p>
                <span class="news-carousel__cta">
                  Leer más
                  <ArrowRight :size="16" aria-hidden="true" />
                </span>
              </div>
            </component>
          </swiper-slide>
        </swiper>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from 'vue'
import { RouterLink } from 'vue-router'
import { ArrowRight, Calendar, ChevronLeft, ChevronRight } from 'lucide-vue-next'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { A11y, Autoplay, Pagination } from 'swiper/modules'
import axios from 'axios'
import { normalizeNewsItems } from '../../../utils/newsItems'
import 'swiper/css'
import 'swiper/css/pagination'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

defineEmits(['click', 'focus-part'])

const swiperModules = [Autoplay, Pagination, A11y]
const swiperInstance = ref(null)
const apiItems = ref([])
const loading = ref(false)
const isHovered = ref(false)
const isFocused = ref(false)
const prefersReducedMotion = ref(false)

const sectionTitle = computed(() => props.element.sectionTitle || 'Noticias destacadas')
const sectionSubtitle = computed(() => props.element.sectionSubtitle || '')
const sectionEyebrow = computed(() => props.element.sectionEyebrow || 'Actualidad')
const limit = computed(() => props.element.limit ?? 8)
const autoPlay = computed(() => props.element.autoPlay !== false)
const interval = computed(() => props.element.interval || 4500)

const staticItems = computed(() => normalizeNewsItems(props.element).slice(0, limit.value))

const items = computed(() => {
  if (props.preview) return apiItems.value
  return staticItems.value
})

const autoplayConfig = computed(() => {
  if (!props.preview || !autoPlay.value || prefersReducedMotion.value || items.value.length < 2) {
    return false
  }
  return {
    delay: interval.value,
    disableOnInteraction: false,
    pauseOnMouseEnter: true,
  }
})

const cardTag = (item) => {
  if (props.preview && item.url && item.url !== '#') return RouterLink
  return 'article'
}

const cardAttrs = (item) => {
  if (props.preview && item.url && item.url !== '#') {
    return { to: item.url }
  }
  return {}
}

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

const fetchRecentPosts = async () => {
  if (!props.preview) return
  loading.value = true
  try {
    const response = await axios.get('/api/posts', {
      params: {
        paginate: 1,
        page: 1,
        per_page: limit.value,
      },
    })
    apiItems.value = response.data.data || []
  } catch {
    apiItems.value = []
  } finally {
    loading.value = false
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

watch(() => props.preview, (isPublic) => {
  if (isPublic) fetchRecentPosts()
})

watch(limit, () => {
  if (props.preview) fetchRecentPosts()
})

onMounted(() => {
  prefersReducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  if (props.preview) fetchRecentPosts()
})

onUnmounted(() => {
  swiperInstance.value = null
})
</script>

<style scoped>
.news-carousel {
  font-family: var(--font-idcbis);
  background: linear-gradient(180deg, #ffffff 0%, #f0f5f8 100%);
  padding: 3rem 1.5rem 3.5rem;
  color: #1e293b;
  cursor: pointer;
  overflow: hidden;
}

.news-carousel__inner {
  max-width: 1200px;
  margin: 0 auto;
}

.news-carousel__header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 1.5rem;
  margin-bottom: 1.75rem;
}

.news-carousel__eyebrow {
  margin: 0 0 0.35rem;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: #2c8c99;
}

.news-carousel__title {
  margin: 0;
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.5rem, 2.5vw, 2rem);
  font-weight: 800;
  color: #0b4f6c;
  line-height: 1.2;
}

.news-carousel__subtitle {
  margin: 0.5rem 0 0;
  max-width: 36rem;
  font-size: 0.9375rem;
  line-height: 1.55;
  color: #64748b;
}

.news-carousel__controls {
  display: flex;
  gap: 0.5rem;
  flex-shrink: 0;
}

.news-carousel__nav {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 44px;
  height: 44px;
  border: 1px solid #d7e4ea;
  border-radius: 9999px;
  background: #fff;
  color: #0b4f6c;
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, color 0.2s, box-shadow 0.2s;
}

.news-carousel__nav:hover {
  border-color: #2c8c99;
  background: #f0f9fb;
  color: #005674;
}

.news-carousel__nav:focus-visible {
  outline: none;
  box-shadow: 0 0 0 3px rgba(44, 140, 153, 0.3);
}

.news-carousel__empty {
  margin: 0;
  padding: 2.5rem 1rem;
  text-align: center;
  color: #94a3b8;
  background: #fff;
  border: 1px dashed #e2e8f0;
  border-radius: 16px;
}

.news-carousel__viewport {
  position: relative;
}

.news-carousel__swiper {
  overflow: hidden;
  padding-bottom: 2.5rem;
}

.news-carousel__slide {
  height: auto;
}

.news-carousel__card {
  display: flex;
  flex-direction: column;
  height: 100%;
  background: #fff;
  border: 1px solid #e8eef2;
  border-radius: 16px;
  overflow: hidden;
  text-decoration: none;
  color: inherit;
  transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
}

a.news-carousel__card:hover {
  border-color: #2c8c99;
  box-shadow: 0 12px 32px rgba(11, 79, 108, 0.12);
  transform: translateY(-3px);
}

.news-carousel__media {
  position: relative;
  aspect-ratio: 16 / 10;
  overflow: hidden;
  background: linear-gradient(135deg, #e8f4f8, #d4eef0);
}

.news-carousel__image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.news-carousel__placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.125rem;
  font-weight: 800;
  letter-spacing: 0.08em;
  color: #0b4f6c;
  opacity: 0.35;
}

.news-carousel__category {
  position: absolute;
  left: 0.75rem;
  bottom: 0.75rem;
  padding: 0.3rem 0.65rem;
  border-radius: 9999px;
  background: rgba(11, 79, 108, 0.92);
  color: #fff;
  font-size: 0.6875rem;
  font-weight: 700;
  letter-spacing: 0.02em;
  max-width: calc(100% - 1.5rem);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.news-carousel__body {
  display: flex;
  flex-direction: column;
  flex: 1;
  gap: 0.45rem;
  padding: 1rem 1.15rem 1.15rem;
}

.news-carousel__date {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 0.8125rem;
  color: #64748b;
}

.news-carousel__card-title {
  margin: 0;
  font-size: 1rem;
  font-weight: 800;
  color: #0b4f6c;
  line-height: 1.35;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.news-carousel__excerpt {
  margin: 0;
  font-size: 0.875rem;
  color: #64748b;
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.news-carousel__cta {
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
  margin-top: auto;
  padding-top: 0.4rem;
  font-size: 0.8125rem;
  font-weight: 700;
  color: #2c8c99;
}

a.news-carousel__card:hover .news-carousel__cta {
  color: #0b4f6c;
}

:deep(.news-carousel__swiper .swiper-pagination-bullet) {
  width: 10px;
  height: 10px;
  background: #b7c9d2;
  opacity: 1;
  transition: width 0.2s, background 0.2s;
}

:deep(.news-carousel__swiper .swiper-pagination-bullet-active) {
  width: 24px;
  border-radius: 9999px;
  background: #0b4f6c;
}

@media (max-width: 640px) {
  .news-carousel {
    padding: 2.25rem 1rem 2.75rem;
  }

  .news-carousel__header {
    flex-direction: column;
    align-items: flex-start;
  }

  .news-carousel__controls {
    align-self: flex-end;
  }
}

@media (prefers-reduced-motion: reduce) {
  a.news-carousel__card:hover {
    transform: none;
  }
}
</style>
