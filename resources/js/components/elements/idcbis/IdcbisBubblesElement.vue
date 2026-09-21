<template>
  <section
    class="idcbis-bubbles"
    :aria-labelledby="titleId"
    @click.stop="$emit('click', element)"
  >
    <div class="idcbis-bubbles__container">
      <div
        class="idcbis-bubbles__header"
        :class="partClasses('bubbles:header')"
        @click.stop="focusPart('bubbles:header', 'Título de investigación', $event)"
      >
        <h2 :id="titleId">
          {{ element.sectionTitle || 'Programas de' }}
          <span>{{ element.sectionHighlight || 'investigación' }}</span>
        </h2>
      </div>
      <ul class="idcbis-bubbles__grid">
        <li
          v-for="(item, index) in items"
          :key="item.id || index"
          class="bubble-item"
          :class="partClasses(bubbleAnchor(item, index))"
          :style="{ backgroundColor: cardColor }"
          @click.stop="onItemClick(item, index, $event)"
        >
          <h3>{{ item.title }}</h3>
          <p>{{ item.description }}</p>
        </li>
      </ul>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { IDCBIS_THEME } from '../../../config/idcbisTheme'
import { resolveBackgroundColor } from '../../../composables/useElementStyles'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildBubbleFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const items = computed(() => props.element.items || [])
const cardColor = computed(() => resolveBackgroundColor(props.element.cardColor, IDCBIS_THEME.bubbleColor))
const titleId = computed(() => `idcbis-bubbles-title-${props.element.id || 'section'}`)

const bubbleAnchor = (item, index) => buildBubbleFocusAnchor(item.id || `index-${index}`)

const onItemClick = (item, index, event) => {
  focusPart(bubbleAnchor(item, index), item.title || `Programa ${index + 1}`, event)
  if (!props.preview) emit('click', props.element)
}
</script>

<style scoped>
.idcbis-bubbles {
  padding: 6rem 2rem;
  background: white;
  cursor: pointer;
  font-family: var(--font-idcbis);
}

.idcbis-bubbles__container {
  max-width: 1400px;
  margin: 0 auto;
}

.idcbis-bubbles__header {
  text-align: center;
  margin-bottom: 3rem;
}

.idcbis-bubbles__header h2 {
  font-family: var(--font-idcbis-display);
  font-size: clamp(2rem, 4vw, 3.5rem);
  font-weight: 800;
  text-transform: uppercase;
  color: #0b4f6c;
}

.idcbis-bubbles__header h2 span {
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.idcbis-bubbles__grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  align-items: stretch;
  gap: 1.5rem;
}

.bubble-item {
  color: #ffffff;
  background-color: #0b4f6c;
  padding: 2.25rem 1.5rem;
  border-radius: 20px;
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  min-height: 180px;
  box-shadow: 0 10px 28px rgba(11, 79, 108, 0.16);
  border-top: 4px solid #c4a140;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.bubble-item:hover {
  transform: translateY(-6px);
  box-shadow: 0 18px 36px rgba(11, 79, 108, 0.24);
}

.bubble-item:focus-visible {
  outline: 3px solid #c4a140;
  outline-offset: 3px;
}

.bubble-item h3 {
  font-family: var(--font-idcbis-display);
  font-size: 1.25rem;
  font-weight: 800;
  line-height: 1.3;
  margin: 0 0 0.6rem;
}

.bubble-item p {
  font-size: 0.95rem;
  line-height: 1.5;
  margin: 0;
  color: rgba(255, 255, 255, 0.92);
}

@media (max-width: 900px) {
  .idcbis-bubbles__grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 600px) {
  .idcbis-bubbles {
    padding: 4rem 1.25rem;
  }

  .idcbis-bubbles__grid {
    grid-template-columns: 1fr;
  }

  .bubble-item {
    min-height: 148px;
    padding: 1.75rem 1.25rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  .bubble-item,
  .bubble-item:hover {
    transition: none;
    transform: none;
  }
}
</style>
