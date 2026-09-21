<template>
  <section
    :id="element.anchorId || element.id || undefined"
    class="cta-banner"
    @click.stop="$emit('click', element)"
  >
    <div class="cta-banner__inner" :style="bannerStyles">
      <h2 v-if="element.title">{{ element.title }}</h2>
      <p v-if="element.subtitle">{{ element.subtitle }}</p>
      <div v-if="buttons.length" class="cta-buttons">
        <component
          v-for="(btn, index) in buttons"
          :key="btn.id || index"
          :is="linkProps(btn.url).is"
          :href="linkProps(btn.url).href"
          :type="linkProps(btn.url).type"
          :target="linkProps(btn.url).target"
          :rel="linkProps(btn.url).rel"
          class="btn"
          :class="btn.variant === 'outline' ? 'btn-outline' : 'btn-primary'"
          @click.stop="!preview && $event.preventDefault()"
        >
          <ContentIcon v-if="btn.icon" :value="btn.icon" decorative />
          {{ btn.label }}
        </component>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { resolveBackground } from '../../composables/useElementStyles'
import { previewLinkProps } from '../../utils/previewLink'
import ContentIcon from './ContentIcon.vue'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const buttons = computed(() => props.element.buttons || [])

const linkProps = (url) => previewLinkProps(props.preview, url)

const bannerStyles = computed(() => ({
  background: resolveBackground(props.element, 'linear-gradient(135deg, #005674 0%, #003C5F 100%)'),
}))
</script>

<style scoped>
.cta-banner {
  padding: 3rem 2rem 6rem;
  font-family: var(--font-idcbis);
  cursor: pointer;
  background: #ffffff;
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
  color: #ffffff;
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
  min-height: 44px;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  font-size: 1.1rem;
  transition: all 0.4s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.7rem;
  cursor: pointer;
  font-family: inherit;
  border: 2px solid transparent;
}

.btn:focus {
  outline: none;
}

.btn:focus-visible {
  box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.7);
}

.btn-primary {
  background: #C4A140;
  color: #003C5F;
  font-weight: 700;
  box-shadow: 0 8px 24px rgba(196, 161, 64, 0.4);
}

.btn-primary:hover {
  background: #D9B85A;
  transform: translateY(-3px);
}

.btn-outline {
  background: transparent;
  color: #fff;
  border: 2px solid #C4A140;
}

.btn-outline:hover {
  background: #C4A140;
  color: #003C5F;
  border-color: #C4A140;
  transform: translateY(-3px);
}

@media (max-width: 768px) {
  .cta-banner {
    padding: 2rem 1rem 4rem;
  }

  .cta-banner__inner {
    padding: 3rem 1.25rem;
    border-radius: 20px;
  }

  .cta-banner__inner p {
    font-size: 1.05rem;
    margin-bottom: 2rem;
  }

  .btn {
    width: 100%;
    max-width: 300px;
    justify-content: center;
    padding: 1rem 1.5rem;
    font-size: 1rem;
  }

  .cta-buttons {
    flex-direction: column;
    align-items: center;
    gap: 1rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  .btn,
  .btn-primary:hover,
  .btn-outline:hover {
    transition: none;
    transform: none;
  }
}
</style>
