<template>
  <section class="idcbis-links" @click.stop="$emit('click', element)">
    <div class="idcbis-links__container">
      <div class="idcbis-links__header">
        <h2>
          {{ element.sectionTitle || 'Recursos' }}
          <span>{{ element.sectionHighlight || 'y enlaces' }}</span>
        </h2>
        <p v-if="element.sectionSubtitle">{{ element.sectionSubtitle }}</p>
      </div>
      <div class="idcbis-links__grid">
        <component
          :is="preview && link.url ? 'a' : 'div'"
          v-for="(link, index) in links"
          :key="link.id || index"
          :href="preview && link.url ? link.url : undefined"
          :target="preview && link.url?.startsWith('http') ? '_blank' : undefined"
          class="link-card"
        >
          <span class="link-card__icon">{{ link.icon || '🔗' }}</span>
          <h3>{{ link.label }}</h3>
          <p v-if="link.description">{{ link.description }}</p>
        </component>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const links = computed(() => props.element.links || [])
</script>

<style scoped>
.idcbis-links {
  padding: 5rem 2rem;
  background: #0b4f6c;
  color: white;
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.idcbis-links__container {
  max-width: 1400px;
  margin: 0 auto;
}

.idcbis-links__header {
  text-align: center;
  margin-bottom: 2.5rem;
}

.idcbis-links__header h2 {
  font-size: clamp(1.75rem, 3vw, 2.5rem);
  font-weight: 800;
  text-transform: uppercase;
}

.idcbis-links__header h2 span {
  color: #ffd166;
}

.idcbis-links__header p {
  margin-top: 0.5rem;
  opacity: 0.9;
  max-width: 640px;
  margin-left: auto;
  margin-right: auto;
}

.idcbis-links__grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 1.25rem;
}

.link-card {
  display: block;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 20px;
  padding: 1.5rem;
  text-decoration: none;
  color: inherit;
  transition: transform 0.2s, background 0.2s;
}

.link-card:hover {
  transform: translateY(-4px);
  background: rgba(255, 255, 255, 0.18);
}

.link-card__icon {
  font-size: 2rem;
  display: block;
  margin-bottom: 0.75rem;
}

.link-card h3 {
  font-size: 1.1rem;
  font-weight: 700;
  margin-bottom: 0.35rem;
}

.link-card p {
  font-size: 0.9rem;
  opacity: 0.85;
  line-height: 1.45;
  margin: 0;
}
</style>
