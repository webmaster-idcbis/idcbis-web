<template>
  <section class="cta-banner" @click.stop="$emit('click', element)">
    <div class="cta-banner__inner" :style="bannerStyles">
      <h2 v-if="element.title">{{ element.title }}</h2>
      <p v-if="element.subtitle">{{ element.subtitle }}</p>
      <div v-if="buttons.length" class="cta-buttons">
        <a
          v-for="(btn, index) in buttons"
          :key="btn.id || index"
          :href="preview ? (btn.url || '#') : '#'"
          class="btn"
          :class="btn.variant === 'outline' ? 'btn-outline' : 'btn-primary'"
          @click.stop="!preview && $event.preventDefault()"
        >
          <span v-if="btn.icon">{{ btn.icon }}</span>
          {{ btn.label }}
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { resolveBackground } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const buttons = computed(() => props.element.buttons || [])

const bannerStyles = computed(() => ({
  background: resolveBackground(props.element, 'linear-gradient(135deg, #1a237e 0%, #283593 100%)'),
}))
</script>

<style scoped>
.cta-banner {
  padding: 3rem 2rem 6rem;
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.cta-banner__inner {
  max-width: 1000px;
  margin: 0 auto;
  color: #fff;
  padding: 5rem 2rem;
  text-align: center;
  border-radius: 30px;
}

.cta-banner__inner h2 {
  font-size: clamp(1.75rem, 4vw, 2.8rem);
  margin-bottom: 1.5rem;
  line-height: 1.25;
}

.cta-banner__inner p {
  font-size: 1.3rem;
  max-width: 700px;
  margin: 0 auto 3rem;
  opacity: 0.9;
  line-height: 1.6;
}

.cta-buttons {
  display: flex;
  justify-content: center;
  gap: 2rem;
  flex-wrap: wrap;
}

.btn {
  padding: 1.1rem 2.5rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  font-size: 1.1rem;
  transition: all 0.4s ease;
  display: inline-flex;
  align-items: center;
  gap: 0.7rem;
}

.btn-primary {
  background: linear-gradient(135deg, #d32f2f 0%, #9a0007 100%);
  color: #fff;
  box-shadow: 0 8px 25px rgba(211, 47, 47, 0.4);
}

.btn-primary:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(211, 47, 47, 0.5);
}

.btn-outline {
  background: transparent;
  color: #fff;
  border: 2px solid rgba(255, 255, 255, 0.7);
}

.btn-outline:hover {
  background: rgba(255, 255, 255, 0.1);
  border-color: #fff;
  transform: translateY(-5px);
}

@media (max-width: 768px) {
  .btn {
    width: 100%;
    max-width: 300px;
    justify-content: center;
  }
  .cta-buttons {
    flex-direction: column;
    align-items: center;
  }
}
</style>
