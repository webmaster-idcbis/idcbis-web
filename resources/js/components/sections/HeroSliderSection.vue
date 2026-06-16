<template>
  <section class="hero-slider-section" :style="sectionStyles">
    <swiper
      :modules="[SwiperAutoplay, SwiperPagination, SwiperNavigation]"
      :slides-per-view="1"
      :space-between="0"
      :loop="true"
      :autoplay="{ delay: 5000, disableOnInteraction: false }"
      :pagination="{ clickable: true }"
      :navigation="true"
      class="hero-swiper"
    >
      <swiper-slide
        v-for="(slide, index) in slides"
        :key="index"
        :style="{ backgroundImage: `url(${slide.backgroundImage})` }"
      >
        <div class="slide-overlay"></div>
        <div class="slide-content" :style="contentStyles">
          <h2 
            class="slide-title" 
            :style="{
              fontSize: section.titleSize || '3.5rem',
              marginBottom: '1.5rem',
              lineHeight: 1.2,
              textShadow: '0 2px 15px rgba(0, 0, 0, 0.3)',
              maxWidth: '800px',
              color: slide.titleColor || '#ffffff'
            }"
          >{{ slide.title }}</h2>
          <p 
            class="slide-text" 
            :style="{
              fontSize: section.textSize || '1.4rem',
              marginBottom: '2.5rem',
              opacity: 0.95,
              maxWidth: '700px',
              color: slide.textColor || '#ffffff'
            }"
          >{{ slide.text }}</p>
          <a
            v-if="slide.buttonText"
            :href="slide.buttonLink"
            class="slide-btn"
            :style="{
              display: 'inline-flex',
              alignItems: 'center',
              gap: '0.8rem',
              background: `linear-gradient(135deg, ${slide.buttonColor || section.buttonColor || '#d32f2f'} 0%, #9a0007 100%)`,
              color: slide.buttonTextColor || '#ffffff',
              padding: '1.1rem 2.8rem',
              borderRadius: '50px',
              textDecoration: 'none',
              fontWeight: 600,
              fontSize: '1.2rem',
              boxShadow: '0 8px 25px rgba(211, 47, 47, 0.4)',
              transition: 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1)'
            }"
          >
            {{ slide.buttonText }}
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </swiper-slide>
    </swiper>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Pagination, Navigation } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/pagination'
import 'swiper/css/navigation'

const SwiperAutoplay = Autoplay
const SwiperPagination = Pagination
const SwiperNavigation = Navigation

const props = defineProps({
  section: {
    type: Object,
    required: true
  }
})

const slides = computed(() => {
  return props.section.slides || [
    {
      title: 'Tu donación puede salvar hasta 3 vidas',
      text: 'Cada vez que donas sangre, ayudas a personas en situaciones de emergencia, cirugías complejas y tratamientos de cáncer.',
      buttonText: 'Quiero Donar',
      buttonLink: '#',
      backgroundImage: '/images/hero/slide1.jpg'
    },
    {
      title: 'El Banco de Sangre Distrital te necesita',
      text: 'Somos la principal reserva de sangre de Bogotá. Tu apoyo garantiza que ningún paciente se quede sin su transfusión.',
      buttonText: 'Conoce más',
      buttonLink: '#',
      backgroundImage: '/images/hero/slide2.jpg'
    },
    {
      title: 'Donar sangre es seguro y rápido',
      text: 'El proceso toma solo 15-20 minutos. Nuestro equipo de profesionales te acompaña en todo momento.',
      buttonText: 'Agendar cita',
      buttonLink: '#',
      backgroundImage: '/images/hero/slide3.jpg'
    }
  ]
})

const sectionStyles = computed(() => ({
  height: props.section.height || '550px',
  borderRadius: props.section.borderRadius || '0 0 30px 30px',
  overflow: 'hidden'
}))

const contentStyles = computed(() => ({
  position: 'relative',
  maxWidth: '1200px',
  width: '100%',
  padding: '0 4rem',
  zIndex: 10,
  color: 'white',
  textAlign: props.section.textAlign || 'left'
}))

const titleStyles = computed(() => ({
  fontSize: props.section.titleSize || '3.5rem',
  marginBottom: '1.5rem',
  lineHeight: 1.2,
  textShadow: '0 2px 15px rgba(0, 0, 0, 0.3)',
  maxWidth: '800px'
}))

const textStyles = computed(() => ({
  fontSize: props.section.textSize || '1.4rem',
  marginBottom: '2.5rem',
  opacity: 0.95,
  maxWidth: '700px'
}))

const buttonStyles = computed(() => ({
  display: 'inline-flex',
  alignItems: 'center',
  gap: '0.8rem',
  background: `linear-gradient(135deg, ${props.section.buttonColor || '#d32f2f'} 0%, #9a0007 100%)`,
  color: 'white',
  padding: '1.1rem 2.8rem',
  borderRadius: '50px',
  textDecoration: 'none',
  fontWeight: 600,
  fontSize: '1.2rem',
  boxShadow: '0 8px 25px rgba(211, 47, 47, 0.4)',
  transition: 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1)'
}))
</script>

<style scoped>
.hero-slider-section {
  position: relative;
  margin-bottom: 5rem;
}

.hero-swiper {
  width: 100%;
  height: 100%;
}

:deep(.swiper-slide) {
  position: relative;
  background-size: cover;
  background-position: center;
  display: flex !important;
  align-items: center;
  justify-content: center;
}

.slide-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, rgba(26, 35, 126, 0.85) 0%, rgba(26, 35, 126, 0.7) 100%);
}

.slide-btn:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(211, 47, 47, 0.5) !important;
}

:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
  color: white;
  background: rgba(255, 255, 255, 0.15);
  width: 60px;
  height: 60px;
  border-radius: 50%;
  backdrop-filter: blur(10px);
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
}

:deep(.swiper-button-next:hover),
:deep(.swiper-button-prev:hover) {
  background: rgba(255, 255, 255, 0.25);
  transform: scale(1.1);
}

:deep(.swiper-button-next::after),
:deep(.swiper-button-prev::after) {
  font-size: 1.5rem;
  font-weight: bold;
}

:deep(.swiper-pagination-bullet) {
  width: 12px;
  height: 12px;
  background: rgba(255, 255, 255, 0.5);
  opacity: 1;
  transition: all 0.3s ease;
}

:deep(.swiper-pagination-bullet-active) {
  background: white;
  width: 30px;
  border-radius: 6px;
}

@media (max-width: 768px) {
  .slide-title {
    font-size: 2rem !important;
  }
  
  .slide-text {
    font-size: 1rem !important;
  }
  
  .slide-content {
    padding: 0 2rem !important;
  }
}
</style>
