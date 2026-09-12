<template>
  <div v-if="isLongPage" class="back-to-top">
    <button
      type="button"
      class="back-to-top__button"
      :aria-label="t('common.backToTopAria')"
      @click="goTop"
    >
      <ChevronUp class="back-to-top__icon" aria-hidden="true" :stroke-width="2.5" />
      <span>{{ t('common.backToTop') }}</span>
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { ChevronUp } from 'lucide-vue-next'
import { useI18n } from '../../i18n'
import { scrollToTop } from '../../utils/scrollToTop'

const LONG_PAGE_MIN_PX = 1400
const LONG_PAGE_MIN_RATIO = 1.7

const route = useRoute()
const { t } = useI18n()
const isLongPage = ref(false)

let resizeObserver = null
let measureTimer = null

const measure = () => {
  const pageHeight = document.documentElement.scrollHeight
  const viewport = window.innerHeight
  isLongPage.value = pageHeight > LONG_PAGE_MIN_PX && pageHeight > viewport * LONG_PAGE_MIN_RATIO
}

const scheduleMeasure = () => {
  clearTimeout(measureTimer)
  measureTimer = setTimeout(measure, 120)
}

const goTop = () => {
  scrollToTop('smooth')
}

onMounted(() => {
  measure()
  window.addEventListener('resize', scheduleMeasure)
  window.addEventListener('load', measure)

  resizeObserver = new ResizeObserver(scheduleMeasure)
  resizeObserver.observe(document.documentElement)
})

onUnmounted(() => {
  clearTimeout(measureTimer)
  window.removeEventListener('resize', scheduleMeasure)
  window.removeEventListener('load', measure)
  resizeObserver?.disconnect()
})

watch(
  () => route.fullPath,
  () => {
    isLongPage.value = false
    scheduleMeasure()
  },
)
</script>

<style scoped>
.back-to-top {
  display: flex;
  justify-content: center;
  padding: 1.75rem 1rem 2rem;
}

.back-to-top__button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.45rem;
  min-height: 48px;
  padding: 0.75rem 1.75rem;
  border: 0;
  border-radius: 9999px;
  background: linear-gradient(135deg, #005674 0%, #008996 100%);
  color: #fff;
  font-family: var(--font-idcbis);
  font-size: 0.9375rem;
  font-weight: 700;
  letter-spacing: 0.02em;
  cursor: pointer;
  box-shadow: 0 8px 20px rgba(0, 86, 116, 0.22);
  transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.back-to-top__button:hover {
  background: linear-gradient(135deg, #003c5f 0%, #005674 100%);
  transform: translateY(-2px);
  box-shadow: 0 12px 24px rgba(0, 60, 95, 0.28);
}

.back-to-top__button:focus-visible {
  outline: 2px solid #c4a140;
  outline-offset: 3px;
}

.back-to-top__icon {
  width: 1.2rem;
  height: 1.2rem;
}
</style>
