<template>
  <section
    ref="root"
    class="idcbis-stats"
    aria-label="Cifras del IDCBIS"
    :style="{ backgroundColor: resolveBackgroundColor(element.backgroundColor, '#C4A140') }"
    @click.stop="$emit('click', element)"
  >
    <div class="idcbis-stats__container">
      <ul class="idcbis-stats__grid">
        <li
          v-for="(item, index) in items"
          :key="item.id || index"
          class="idcbis-stats__item"
          :class="[partClasses(statAnchor(item, index)), { 'is-visible': revealed }]"
          :style="revealed ? { animationDelay: `${index * 80}ms` } : undefined"
          @click.stop="onItemClick(item, index, $event)"
        >
          <component :is="statIcon(item.icon)" class="idcbis-stats__icon" aria-hidden="true" />
          <p class="big-number">{{ shownValue(item) }}</p>
          <p class="label">{{ item.label }}</p>
          <p v-if="item.caption" class="caption">{{ item.caption }}</p>
        </li>
      </ul>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import { Award, Droplet, FlaskConical, Heart, Users } from 'lucide-vue-next'
import { resolveBackgroundColor } from '../../../composables/useElementStyles'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildStatFocusAnchor } from '../../../utils/editorPartFocus'

const ICONS = {
  droplet: Droplet,
  users: Users,
  award: Award,
  flask: FlaskConical,
  heart: Heart,
}

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const root = ref(null)
const revealed = ref(false)
const progress = ref(1)
let observer = null
let frame = null

const items = computed(() => props.element.items || [])

const statAnchor = (item, index) => buildStatFocusAnchor(item.id || `index-${index}`)
const statIcon = (name) => ICONS[name] || Award

const onItemClick = (item, index, event) => {
  focusPart(statAnchor(item, index), item.label || `Cifra ${index + 1}`, event)
  if (!props.preview) emit('click', props.element)
}

const parseStat = (value) => {
  const text = String(value ?? '')
  const match = text.match(/^(\D*)(\d{1,3}(?:\.\d{3})+|\d+)(.*)$/)
  if (!match) return null
  const numeric = Number(match[2].replace(/\./g, ''))
  if (!Number.isFinite(numeric)) return null
  return { prefix: match[1], numeric, suffix: match[3], grouped: match[2].includes('.') }
}

const formatNumber = (numeric, grouped) => {
  if (!grouped) return String(numeric)
  return new Intl.NumberFormat('es-CO').format(numeric)
}

const shownValue = (item) => {
  const parsed = parseStat(item.value)
  if (!parsed || progress.value >= 1) return item.value
  const current = Math.round(parsed.numeric * progress.value)
  return `${parsed.prefix}${formatNumber(current, parsed.grouped)}${parsed.suffix}`
}

const finish = () => {
  progress.value = 1
  revealed.value = true
}

const runCount = () => {
  const start = performance.now()
  const duration = 900
  const step = (now) => {
    const t = Math.min(1, (now - start) / duration)
    progress.value = 1 - (1 - t) ** 3
    if (t < 1) frame = requestAnimationFrame(step)
  }
  progress.value = 0
  frame = requestAnimationFrame(step)
}

onMounted(() => {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  if (!props.preview || reduce) {
    finish()
    return
  }
  observer = new IntersectionObserver(([entry]) => {
    if (!entry?.isIntersecting) return
    revealed.value = true
    runCount()
    observer?.disconnect()
  }, { threshold: 0.35 })
  if (root.value) observer.observe(root.value)
})

onUnmounted(() => {
  observer?.disconnect()
  if (frame) cancelAnimationFrame(frame)
})
</script>

<style scoped>
.idcbis-stats {
  padding: 3.5rem 1.5rem;
  border-radius: 60px 60px 0 0;
  margin-top: 2rem;
  cursor: pointer;
  font-family: var(--font-idcbis);
}

.idcbis-stats__container {
  max-width: 1200px;
  margin: 0 auto;
}

.idcbis-stats__grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 1.25rem;
}

.idcbis-stats__item {
  background: #ffffff;
  margin: 0;
  padding: 1.5rem 1.25rem 1.35rem;
  border-radius: 1.25rem;
  text-align: center;
  box-shadow: 0 12px 0 rgba(0, 60, 95, 0.12);
  opacity: 0;
  transform: translateY(12px);
}

.idcbis-stats__item.is-visible {
  animation: stat-in 0.6s ease forwards;
}

.idcbis-stats__icon {
  width: 1.75rem;
  height: 1.75rem;
  margin: 0 auto 0.75rem;
  color: #003C5F;
}

.big-number {
  margin: 0;
  font-size: clamp(2.25rem, 4vw, 3.25rem);
  font-weight: 800;
  color: #0b4f6c;
  line-height: 1;
  font-variant-numeric: tabular-nums;
}

.label {
  margin: 0.65rem 0 0;
  font-size: 1rem;
  font-weight: 700;
  color: #1a1a1a;
  line-height: 1.35;
}

.caption {
  margin: 0.4rem 0 0;
  font-size: 0.95rem;
  font-weight: 500;
  color: #003C5F;
  line-height: 1.4;
}

@keyframes stat-in {
  to {
    opacity: 1;
    transform: none;
  }
}

@media (max-width: 700px) {
  .idcbis-stats {
    padding: 2.5rem 1rem 2rem;
    border-radius: 32px 32px 0 0;
  }

  .idcbis-stats__grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.75rem;
  }

  .idcbis-stats__item {
    padding: 1.15rem 0.75rem 1rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  .idcbis-stats__item,
  .idcbis-stats__item.is-visible {
    opacity: 1;
    transform: none;
    animation: none;
  }
}
</style>
