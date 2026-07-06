<template>
  <section class="idcbis-bubbles" @click.stop="$emit('click', element)">
    <div class="idcbis-bubbles__container">
      <div
        class="idcbis-bubbles__header"
        :class="partClasses('bubbles:header')"
        @click.stop="focusPart('bubbles:header', 'Título de investigación', $event)"
      >
        <h2>
          {{ element.sectionTitle || 'Programas de' }}
          <span>{{ element.sectionHighlight || 'investigación' }}</span>
        </h2>
      </div>
      <div class="idcbis-bubbles__grid">
        <div
          v-for="(item, index) in items"
          :key="item.id || index"
          class="bubble-item"
          :class="partClasses(bubbleAnchor(item, index))"
          :style="{ background: item.color || bubbleColors[index % bubbleColors.length] }"
          @click.stop="onItemClick(item, index, $event)"
        >
          <h4>{{ item.title }}</h4>
          <p>{{ item.description }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { IDCBIS_THEME } from '../../../config/idcbisTheme'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildBubbleFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const bubbleColors = IDCBIS_THEME.bubbleColors
const items = computed(() => props.element.items || [])

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
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 2rem;
}

.bubble-item {
  color: white;
  padding: 2rem;
  border-radius: 70% 30% 70% 30% / 30% 70% 30% 70%;
  text-align: center;
  transition: all 0.3s;
}

.bubble-item:hover {
  border-radius: 30% 70% 30% 70% / 70% 30% 70% 30%;
}

.bubble-item h4 {
  font-size: 1.4rem;
  margin-bottom: 0.5rem;
}

.bubble-item p {
  font-size: 0.9rem;
  opacity: 0.9;
}

@media (max-width: 900px) {
  .idcbis-bubbles__grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 600px) {
  .idcbis-bubbles__grid {
    grid-template-columns: 1fr;
  }
}
</style>
