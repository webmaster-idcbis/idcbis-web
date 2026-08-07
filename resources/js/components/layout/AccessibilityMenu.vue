<template>
  <div
    ref="rootRef"
    class="a11y-menu"
    :class="{ 'a11y-menu--open': open }"
  >
    <button
      type="button"
      class="a11y-menu__trigger"
      :aria-expanded="open"
      aria-controls="a11y-menu-panel"
      aria-haspopup="true"
      :aria-label="open ? 'Cerrar menú de accesibilidad' : 'Abrir menú de accesibilidad'"
      @click="toggle"
    >
      <Accessibility class="a11y-menu__trigger-icon" aria-hidden="true" :stroke-width="2" />
    </button>

    <div
      id="a11y-menu-panel"
      class="a11y-menu__panel"
      role="menu"
      aria-label="Opciones de accesibilidad"
      :hidden="!open"
    >
      <p class="a11y-menu__title" id="a11y-menu-title">Accesibilidad</p>

      <ul class="a11y-menu__list" aria-labelledby="a11y-menu-title">
        <li role="none">
          <button
            type="button"
            role="menuitem"
            class="a11y-menu__item"
            :disabled="state.fontScale >= FONT_MAX"
            @click="increaseFont"
          >
            <ZoomIn class="a11y-menu__icon" aria-hidden="true" :stroke-width="2" />
            <span>Aumentar letra</span>
          </button>
        </li>
        <li role="none">
          <button
            type="button"
            role="menuitem"
            class="a11y-menu__item"
            :disabled="state.fontScale <= FONT_MIN"
            @click="decreaseFont"
          >
            <ZoomOut class="a11y-menu__icon" aria-hidden="true" :stroke-width="2" />
            <span>Reducir letra</span>
          </button>
        </li>
        <li role="none">
          <button
            type="button"
            role="menuitem"
            class="a11y-menu__item"
            :class="{ 'a11y-menu__item--active': state.grayscale }"
            :aria-pressed="state.grayscale"
            @click="toggleGrayscale"
          >
            <span class="a11y-menu__icon a11y-menu__icon--bars" aria-hidden="true">
              <span /><span /><span /><span />
            </span>
            <span>Escala de gris</span>
          </button>
        </li>
        <li role="none">
          <button
            type="button"
            role="menuitem"
            class="a11y-menu__item"
            :class="{ 'a11y-menu__item--active': state.highContrast }"
            :aria-pressed="state.highContrast"
            @click="toggleHighContrast"
          >
            <Contrast class="a11y-menu__icon" aria-hidden="true" :stroke-width="2" />
            <span>Alto contraste</span>
          </button>
        </li>
        <li role="none">
          <button
            type="button"
            role="menuitem"
            class="a11y-menu__item"
            :class="{ 'a11y-menu__item--active': state.contrast }"
            :aria-pressed="state.contrast"
            @click="toggleContrast"
          >
            <Eye class="a11y-menu__icon" aria-hidden="true" :stroke-width="2" />
            <span>Contraste</span>
          </button>
        </li>
        <li role="none">
          <button
            type="button"
            role="menuitem"
            class="a11y-menu__item"
            :class="{ 'a11y-menu__item--active': state.underlineLinks }"
            :aria-pressed="state.underlineLinks"
            @click="toggleUnderlineLinks"
          >
            <Link class="a11y-menu__icon" aria-hidden="true" :stroke-width="2" />
            <span>Subrayado de enlaces</span>
          </button>
        </li>
        <li role="none">
          <button
            type="button"
            role="menuitem"
            class="a11y-menu__item"
            :disabled="!isActive"
            @click="reset"
          >
            <RotateCcw class="a11y-menu__icon" aria-hidden="true" :stroke-width="2" />
            <span>Restablecer</span>
          </button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import {
  Accessibility,
  ZoomIn,
  ZoomOut,
  Contrast,
  Eye,
  Link,
  RotateCcw,
} from 'lucide-vue-next'
import { useAccessibility } from '../../composables/useAccessibility'

const open = ref(false)
const rootRef = ref(null)

const {
  state,
  isActive,
  increaseFont,
  decreaseFont,
  toggleGrayscale,
  toggleHighContrast,
  toggleContrast,
  toggleUnderlineLinks,
  reset,
  FONT_MIN,
  FONT_MAX,
} = useAccessibility()

const toggle = () => {
  open.value = !open.value
}

const close = () => {
  open.value = false
}

const onDocumentClick = (event) => {
  if (!open.value || !rootRef.value) {
    return
  }
  if (!rootRef.value.contains(event.target)) {
    close()
  }
}

const onKeydown = (event) => {
  if (event.key === 'Escape' && open.value) {
    close()
  }
}

onMounted(() => {
  document.addEventListener('click', onDocumentClick)
  document.addEventListener('keydown', onKeydown)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', onDocumentClick)
  document.removeEventListener('keydown', onKeydown)
})
</script>

<style scoped>
.a11y-menu {
  position: fixed;
  left: 0;
  top: 38%;
  z-index: 80;
  display: flex;
  align-items: flex-start;
  font-family: var(--font-idcbis);
}

.a11y-menu__trigger {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 48px;
  height: 48px;
  min-width: 48px;
  min-height: 48px;
  flex-shrink: 0;
  border: 2px solid #003c5f;
  border-radius: 4px;
  background: #005674;
  color: #fff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  transition: background-color 0.15s ease, border-radius 0.15s ease;
}

.a11y-menu--open .a11y-menu__trigger {
  border-radius: 4px 0 0 4px;
  border-right-color: #005674;
}

.a11y-menu__trigger:hover {
  background: #003c5f;
}

.a11y-menu__trigger:focus-visible {
  outline: 2px solid #c4a140;
  outline-offset: 2px;
}

.a11y-menu__trigger-icon {
  width: 28px;
  height: 28px;
}

.a11y-menu__panel {
  width: min(240px, calc(100vw - 56px));
  margin: 0;
  padding: 0.75rem 0 0.5rem;
  border: 1px solid #4a4a6a;
  border-left: none;
  border-radius: 0 4px 4px 0;
  background: #fff;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.15);
  color: #333;
}

.a11y-menu__panel[hidden] {
  display: none;
}

.a11y-menu__title {
  margin: 0 0 0.35rem;
  padding: 0 1rem;
  font-size: 1.05rem;
  font-weight: 700;
  line-height: 1.3;
  color: #333;
}

.a11y-menu__list {
  margin: 0;
  padding: 0;
  list-style: none;
}

.a11y-menu__item {
  display: flex;
  align-items: center;
  gap: 0.65rem;
  width: 100%;
  min-height: 44px;
  padding: 0.45rem 1rem;
  border: 0;
  background: transparent;
  color: #333;
  font-size: 0.95rem;
  font-weight: 500;
  line-height: 1.3;
  text-align: left;
  cursor: pointer;
  transition: background-color 0.15s ease;
}

.a11y-menu__item:hover:not(:disabled) {
  background: rgba(0, 86, 116, 0.08);
}

.a11y-menu__item:focus-visible {
  outline: 2px solid #005674;
  outline-offset: -2px;
}

.a11y-menu__item--active {
  background: rgba(0, 86, 116, 0.12);
  font-weight: 700;
  color: #003c5f;
}

.a11y-menu__item:disabled {
  opacity: 0.45;
  cursor: not-allowed;
}

.a11y-menu__icon {
  width: 1.15rem;
  height: 1.15rem;
  flex-shrink: 0;
  color: #333;
}

.a11y-menu__icon--bars {
  display: inline-flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 2px;
  width: 1.15rem;
  height: 1.15rem;
  padding-bottom: 1px;
}

.a11y-menu__icon--bars span {
  display: block;
  width: 2px;
  background: currentColor;
  border-radius: 1px;
}

.a11y-menu__icon--bars span:nth-child(1) {
  height: 45%;
}

.a11y-menu__icon--bars span:nth-child(2) {
  height: 70%;
}

.a11y-menu__icon--bars span:nth-child(3) {
  height: 100%;
}

.a11y-menu__icon--bars span:nth-child(4) {
  height: 55%;
}

@media (prefers-reduced-motion: reduce) {
  .a11y-menu__trigger,
  .a11y-menu__item {
    transition: none;
  }
}

@media (max-width: 640px) {
  .a11y-menu {
    top: auto;
    bottom: 5.5rem;
  }
}
</style>
