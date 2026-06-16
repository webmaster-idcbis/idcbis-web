<template>
  <section
    class="hero-block"
    :style="heroStyles"
    @click.stop="$emit('click', element)"
  >
    <div class="hero-overlay">
      <component :is="element.level || 'h1'" class="hero-title">{{ element.title || 'Título principal' }}</component>
      <p v-if="element.subtitle" class="hero-subtitle">{{ element.subtitle }}</p>
      <a
        v-if="element.buttonText"
        :href="preview ? (element.buttonUrl || '#') : '#'"
        class="hero-button"
        @click.stop="!preview && $event.preventDefault()"
      >
        {{ element.buttonText }}
      </a>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles, isTransparentBackground } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const heroStyles = computed(() => {
  let bg
  if (props.element.backgroundImage) {
    bg = `linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url(${props.element.backgroundImage})`
  } else if (isTransparentBackground(props.element.backgroundColor)) {
    bg = 'transparent'
  } else if (props.element.backgroundColor) {
    bg = props.element.backgroundColor
  } else {
    bg = 'linear-gradient(135deg, #005674 0%, #003d52 100%)'
  }

  return mergeElementStyles(props.element, {
    background: bg,
    backgroundSize: 'cover',
    backgroundPosition: 'center',
    minHeight: props.element.minHeight || '280px',
    width: '100%',
    borderRadius: props.element.borderRadius || '8px',
    padding: props.element.padding || '48px 24px',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    textAlign: props.element.textAlign || 'center',
  })
})
</script>

<style scoped>
.hero-block {
  cursor: pointer;
  color: white;
}

.hero-overlay {
  max-width: 720px;
}

.hero-title {
  font-size: 2rem;
  font-weight: 700;
  margin: 0 0 12px;
  line-height: 1.2;
}

.hero-subtitle {
  font-size: 1.125rem;
  opacity: 0.95;
  margin: 0 0 20px;
  line-height: 1.5;
}

.hero-button {
  display: inline-block;
  padding: 12px 28px;
  background: white;
  color: #005674;
  font-weight: 600;
  text-decoration: none;
  border-radius: 6px;
  transition: transform 0.2s;
}

.hero-button:hover {
  transform: translateY(-2px);
}
</style>
