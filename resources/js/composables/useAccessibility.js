import { reactive, readonly, computed } from 'vue'

const STORAGE_KEY = 'idcbis-a11y'
const FONT_MIN = 0.875
const FONT_MAX = 1.5
const FONT_STEP = 0.125

const defaultState = () => ({
  fontScale: 1,
  grayscale: false,
  highContrast: false,
  contrast: false,
  underlineLinks: false,
})

const state = reactive(defaultState())

let contentEl = null

function loadStored() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY)
    if (!raw) {
      return
    }
    const parsed = JSON.parse(raw)
    state.fontScale = clampFont(Number(parsed.fontScale) || 1)
    state.grayscale = Boolean(parsed.grayscale)
    state.highContrast = Boolean(parsed.highContrast)
    state.contrast = Boolean(parsed.contrast)
    state.underlineLinks = Boolean(parsed.underlineLinks)
  } catch {
    // Preferencias corruptas: se ignoran.
  }
}

function persist() {
  localStorage.setItem(
    STORAGE_KEY,
    JSON.stringify({
      fontScale: state.fontScale,
      grayscale: state.grayscale,
      highContrast: state.highContrast,
      contrast: state.contrast,
      underlineLinks: state.underlineLinks,
    }),
  )
}

function clampFont(value) {
  return Math.min(FONT_MAX, Math.max(FONT_MIN, Math.round(value / FONT_STEP) * FONT_STEP))
}

function applyToDom() {
  const html = document.documentElement
  html.style.setProperty('--a11y-font-scale', String(state.fontScale))
  html.classList.toggle('a11y-font-scaled', state.fontScale !== 1)
  html.classList.toggle('a11y-underline-links', state.underlineLinks)

  const target = contentEl || document.getElementById('a11y-content')
  if (!target) {
    return
  }

  target.classList.toggle('a11y-grayscale', state.grayscale)
  target.classList.toggle('a11y-high-contrast', state.highContrast)
  target.classList.toggle('a11y-contrast', state.contrast && !state.highContrast)
}

export function bindAccessibilityContent(el) {
  contentEl = el
  applyToDom()
}

export function initAccessibility() {
  loadStored()
  applyToDom()
}

export function useAccessibility() {
  const increaseFont = () => {
    state.fontScale = clampFont(state.fontScale + FONT_STEP)
    persist()
    applyToDom()
  }

  const decreaseFont = () => {
    state.fontScale = clampFont(state.fontScale - FONT_STEP)
    persist()
    applyToDom()
  }

  const toggleGrayscale = () => {
    state.grayscale = !state.grayscale
    persist()
    applyToDom()
  }

  const toggleHighContrast = () => {
    state.highContrast = !state.highContrast
    if (state.highContrast) {
      state.contrast = false
    }
    persist()
    applyToDom()
  }

  const toggleContrast = () => {
    state.contrast = !state.contrast
    if (state.contrast) {
      state.highContrast = false
    }
    persist()
    applyToDom()
  }

  const toggleUnderlineLinks = () => {
    state.underlineLinks = !state.underlineLinks
    persist()
    applyToDom()
  }

  const reset = () => {
    Object.assign(state, defaultState())
    persist()
    applyToDom()
  }

  const isActive = computed(() => (
    state.fontScale !== 1
    || state.grayscale
    || state.highContrast
    || state.contrast
    || state.underlineLinks
  ))

  return {
    state: readonly(state),
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
  }
}
