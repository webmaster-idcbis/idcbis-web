<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <div
      id="a11y-content"
      ref="contentRef"
      class="min-h-screen flex flex-col flex-grow"
    >
      <Header />
      <main class="flex-grow">
        <slot />
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
import AccessibilityMenu from './AccessibilityMenu.vue'
import { bindAccessibilityContent, initAccessibility } from '../../composables/useAccessibility'

const contentRef = ref(null)

onMounted(() => {
  bindAccessibilityContent(contentRef.value)
  initAccessibility()
})
</script>
