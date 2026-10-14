<template>
  <nav
    class="anchor-nav"
    :aria-label="element.label || 'Secciones de la página'"
    @click.stop="$emit('click', element)"
  >
    <div class="anchor-nav__inner">
      <div class="anchor-nav__links">
        <a
          v-for="(link, index) in links"
          :key="link.id || index"
          :href="link.url || '#'"
          :aria-current="active === hashOf(link) ? 'true' : undefined"
          :class="partClasses(linkAnchor(link, index))"
          @click="onLink(link, index, $event)"
        >{{ link.label }}</a>
      </div>
      <button
        v-show="showTop"
        type="button"
        class="anchor-nav__top"
        @click.stop="toTop"
      >{{ element.backLabel || 'Volver arriba' }}</button>
    </div>
  </nav>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import { useIdcbisEditorParts } from '../../../composables/useIdcbisEditorParts'
import { buildAnchorNavFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { partClasses, focusPart } = useIdcbisEditorParts(props, emit)

const links = computed(() => props.element.links || [])
const active = ref('')
const showTop = ref(false)
let observer
let onScroll

const hashOf = (link) => String(link.url || '').replace(/^#/, '')
const linkAnchor = (link, index) => buildAnchorNavFocusAnchor(link.id || `index-${index}`)

const reducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches

const onLink = (link, index, event) => {
  focusPart(linkAnchor(link, index), link.label || `Sección ${index + 1}`, event)
  if (!props.preview) {
    event.preventDefault()
    emit('click', props.element)
    return
  }

  const id = hashOf(link)
  const target = id ? document.getElementById(id) : null
  if (!target) return
  event.preventDefault()
  target.scrollIntoView({ behavior: reducedMotion() ? 'auto' : 'smooth', block: 'start' })
  history.replaceState(null, '', `#${id}`)
  active.value = id
}

const toTop = () => {
  window.scrollTo({ top: 0, behavior: reducedMotion() ? 'auto' : 'smooth' })
}

onMounted(() => {
  if (!props.preview) return

  onScroll = () => {
    showTop.value = window.scrollY > 480
  }
  onScroll()
  window.addEventListener('scroll', onScroll, { passive: true })

  const nodes = links.value
    .map((link) => document.getElementById(hashOf(link)))
    .filter(Boolean)

  if (!nodes.length || typeof IntersectionObserver === 'undefined') return

  observer = new IntersectionObserver((entries) => {
    const visible = entries
      .filter((entry) => entry.isIntersecting)
      .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0]
    if (visible?.target?.id) active.value = visible.target.id
  }, { rootMargin: '-20% 0px -55% 0px', threshold: [0.15, 0.4, 0.7] })

  nodes.forEach((node) => observer.observe(node))
})

onUnmounted(() => {
  observer?.disconnect()
  if (onScroll) window.removeEventListener('scroll', onScroll)
})
</script>

<style scoped>
.anchor-nav {
  position: sticky;
  top: 0;
  z-index: 30;
  background: #003C5F;
  color: #fff;
  font-family: var(--font-idcbis);
  box-shadow: 0 8px 18px rgba(0, 36, 58, 0.16);
}

.anchor-nav__inner {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 1rem;
}

.anchor-nav__links {
  display: flex;
  flex: 1;
  gap: 0.25rem;
  overflow-x: auto;
  scroll-snap-type: x proximity;
}

.anchor-nav__links a {
  flex: 0 0 auto;
  scroll-snap-align: start;
  display: inline-flex;
  align-items: center;
  min-height: 48px;
  padding: 0.65rem 0.9rem;
  color: #fff;
  font-weight: 700;
  text-decoration: none;
  white-space: nowrap;
}

.anchor-nav__links a[aria-current='true'] {
  color: #F6E7B4;
  box-shadow: inset 0 -3px 0 #C4A140;
}

.anchor-nav__links a:hover {
  color: #F6E7B4;
}

.anchor-nav__links a:focus-visible,
.anchor-nav__top:focus-visible {
  outline: 3px solid #C4A140;
  outline-offset: -3px;
}

.anchor-nav__top {
  flex: 0 0 auto;
  min-height: 44px;
  padding: 0.4rem 0.85rem;
  border: 0;
  border-radius: 999px;
  background: transparent;
  color: #F6E7B4;
  font: inherit;
  font-weight: 700;
  cursor: pointer;
}

.anchor-nav__top:hover {
  color: #fff;
}

@media (max-width: 700px) {
  .anchor-nav__inner {
    align-items: stretch;
    flex-direction: column;
    padding-bottom: 0.35rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  .anchor-nav__links {
    scroll-behavior: auto;
  }
}
</style>
