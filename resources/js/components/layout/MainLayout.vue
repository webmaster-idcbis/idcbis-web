<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <div
      id="a11y-content"
      ref="contentRef"
      class="min-h-screen flex flex-col flex-grow"
    >
      <Header />
      <main class="flex-grow layout-main">
        <Breadcrumbs />
        <slot />
        <BackToTop />
      </main>
      <Footer />
    </div>
    <AccessibilityMenu />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Header from './Header.vue'
import Footer from './Footer.vue'
import Breadcrumbs from './Breadcrumbs.vue'
import BackToTop from './BackToTop.vue'
import AccessibilityMenu from './AccessibilityMenu.vue'
import { bindAccessibilityContent, initAccessibility } from '../../composables/useAccessibility'

const contentRef = ref(null)

onMounted(() => {
  bindAccessibilityContent(contentRef.value)
  initAccessibility()
})
</script>

<style scoped>
.layout-main {
  position: relative;
}

.layout-main :deep(.breadcrumbs) {
  color: rgba(255, 255, 255, 0.92);
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.35);
}

.layout-main:not(:has(.qs-hero)):not(:has(.docs-hero)):not(:has(.news-article__hero)):not(:has(.search-page__hero)):not(:has(.sitemap__hero)):not(:has(.hero-block)):not(:has(.idcbis-hero)):not(:has(.hero-slider-section)):not(:has(.carousel-element--hero-full)) :deep(.breadcrumbs) {
  color: #005674;
  text-shadow: none;
}
</style>
