<template>
  <section class="idcbis-contact" :aria-labelledby="titleId" @click.stop="$emit('click', element)">
    <div class="idcbis-contact__inner">
      <h2 :id="titleId" class="idcbis-contact__title">Contáctenos</h2>
      <div class="idcbis-contact__grid">
        <div
          v-for="(item, index) in items"
          :key="item.id || index"
          class="idcbis-contact__item"
          :class="partClasses(contactAnchor(item, index))"
          @click.stop="onItemClick(item, index, $event)"
        >
          <h3>
            <ContentIcon v-if="item.icon" :value="item.icon" decorative />
            <span>{{ item.title }}</span>
          </h3>
          <component
            :is="item.link && preview ? 'a' : 'p'"
            :href="item.link && preview ? item.link : undefined"
          >
            {{ item.text }}
          </component>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildContactFocusAnchor } from '../../../utils/editorPartFocus'
import ContentIcon from '../ContentIcon.vue'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const items = computed(() => props.element.items || [])
const titleId = computed(() => `idcbis-contact-title-${props.element.id || 'section'}`)

const contactAnchor = (item, index) => buildContactFocusAnchor(item.id || `index-${index}`)

const onItemClick = (item, index, event) => {
  focusPart(contactAnchor(item, index), item.title || `Contacto ${index + 1}`, event)
  if (!props.preview) emit('click', props.element)
}
</script>

<style scoped>
.idcbis-contact {
  background: #0b4f6c;
  padding: 4rem 2rem;
  color: white;
  cursor: pointer;
  font-family: var(--font-idcbis);
}

.idcbis-contact__inner {
  max-width: 1400px;
  margin: 0 auto;
}

.idcbis-contact__title {
  margin: 0 0 1.5rem;
  text-align: center;
  font-size: clamp(1.75rem, 3vw, 2.5rem);
  line-height: 1.2;
  font-weight: 800;
  color: #ffffff;
}

.idcbis-contact__grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.25rem;
  text-align: center;
}

.idcbis-contact__item {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  padding: 2rem;
  border-radius: 40px 10px 40px 10px;
}

.idcbis-contact__item h3 {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.6rem;
  font-size: 1.35rem;
  line-height: 1.3;
  margin: 0 0 1rem;
  color: #ffffff;
}

.idcbis-contact__item p,
.idcbis-contact__item a {
  color: #ffffff;
  text-decoration: none;
  font-size: 1.1rem;
  margin: 0;
  white-space: pre-line;
  line-height: 1.65;
}

.idcbis-contact__item a:hover {
  text-decoration: underline;
}

.idcbis-contact__item a:focus-visible {
  outline: 3px solid #ffffff;
  outline-offset: 3px;
  border-radius: 4px;
}

@media (max-width: 900px) {
  .idcbis-contact__grid {
    grid-template-columns: 1fr;
  }
}
</style>
