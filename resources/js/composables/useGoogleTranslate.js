import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'

const SOURCE_LANG = 'es'
const SCRIPT_ID = 'google-translate-script'
const ELEMENT_ID = 'google_translate_element'

const currentLang = ref('es')
const ready = ref(false)
let scriptLoading = null

function readCookie(name) {
  const match = document.cookie.match(new RegExp(`(?:^|; )${name}=([^;]*)`))
  return match ? decodeURIComponent(match[1]) : ''
}

function writeCookie(name, value, days = 365) {
  const expires = new Date(Date.now() + days * 864e5).toUTCString()
  const hostname = window.location.hostname
  const parts = [`${name}=${encodeURIComponent(value)}`, 'path=/', `expires=${expires}`]

  document.cookie = parts.join(';')
  document.cookie = [...parts, `domain=${hostname}`].join(';')

  // Also clear/set on parent domain when applicable (Google often uses this).
  const segments = hostname.split('.')
  if (segments.length > 2) {
    const parent = `.${segments.slice(-2).join('.')}`
    document.cookie = [...parts, `domain=${parent}`].join(';')
  }
}

function clearTranslateCookies() {
  const hostname = window.location.hostname
  const expire = 'expires=Thu, 01 Jan 1970 00:00:00 GMT'
  const variants = [
    'googtrans=',
    `googtrans=;domain=${hostname}`,
  ]

  const segments = hostname.split('.')
  if (segments.length > 2) {
    variants.push(`googtrans=;domain=.${segments.slice(-2).join('.')}`)
  }

  variants.forEach((part) => {
    document.cookie = `${part};path=/;${expire}`
  })
}

function detectLangFromCookie() {
  const value = readCookie('googtrans')
  // Formats: "/es/en" or "/auto/en"
  const match = value.match(/^\/(?:[a-z-]+)\/([a-z-]+)$/i)
  if (match?.[1] && match[1] !== SOURCE_LANG) {
    return match[1]
  }
  return SOURCE_LANG
}

function ensureHiddenHost() {
  if (document.getElementById(ELEMENT_ID)) {
    return
  }
  const host = document.createElement('div')
  host.id = ELEMENT_ID
  host.setAttribute('aria-hidden', 'true')
  host.style.display = 'none'
  document.body.appendChild(host)
}

function loadGoogleTranslateScript() {
  if (window.google?.translate?.TranslateElement) {
    return Promise.resolve()
  }

  if (scriptLoading) {
    return scriptLoading
  }

  scriptLoading = new Promise((resolve, reject) => {
    window.googleTranslateElementInit = () => {
      ensureHiddenHost()
      // eslint-disable-next-line no-new
      new window.google.translate.TranslateElement(
        {
          pageLanguage: SOURCE_LANG,
          includedLanguages: 'es,en',
          autoDisplay: false,
        },
        ELEMENT_ID,
      )
      ready.value = true
      resolve()
    }

    if (document.getElementById(SCRIPT_ID)) {
      return
    }

    const script = document.createElement('script')
    script.id = SCRIPT_ID
    script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit'
    script.async = true
    script.onerror = () => reject(new Error('No se pudo cargar Google Translate'))
    document.head.appendChild(script)
  })

  return scriptLoading
}

function getCombo() {
  return document.querySelector('.goog-te-combo')
}

function applyComboValue(lang) {
  const combo = getCombo()
  if (!combo) {
    return false
  }

  // Google usa '' para el idioma original de la página.
  const value = lang === SOURCE_LANG ? '' : lang
  if (combo.value !== value) {
    combo.value = value
  }
  combo.dispatchEvent(new Event('change'))
  return true
}

/**
 * Re-aplica la traducción tras navegación SPA (contenido nuevo en el DOM).
 */
export function refreshTranslation() {
  if (currentLang.value === SOURCE_LANG) {
    return
  }

  // Truco habitual: forzar un re-change del combo de Google.
  const combo = getCombo()
  if (!combo) {
    return
  }

  const target = currentLang.value
  combo.value = SOURCE_LANG
  combo.dispatchEvent(new Event('change'))

  window.setTimeout(() => {
    combo.value = target
    combo.dispatchEvent(new Event('change'))
  }, 50)
}

export async function initGoogleTranslate() {
  const stored = (() => {
    try {
      return localStorage.getItem('language')
    } catch {
      return null
    }
  })()

  currentLang.value = detectLangFromCookie()
  if (currentLang.value === SOURCE_LANG && stored === 'en') {
    currentLang.value = 'en'
    writeCookie('googtrans', `/${SOURCE_LANG}/en`)
  }

  ensureHiddenHost()

  try {
    await loadGoogleTranslateScript()
  } catch {
    ready.value = false
    return currentLang.value
  }

  // Espera breve a que el combo exista en el DOM.
  await new Promise((resolve) => {
    let attempts = 0
    const tick = () => {
      if (getCombo() || attempts > 40) {
        resolve()
        return
      }
      attempts += 1
      window.setTimeout(tick, 50)
    }
    tick()
  })

  if (currentLang.value !== SOURCE_LANG) {
    applyComboValue(currentLang.value)
  }

  return currentLang.value
}

export async function setGoogleTranslateLanguage(lang) {
  const next = lang === 'en' ? 'en' : SOURCE_LANG
  currentLang.value = next

  if (next === SOURCE_LANG) {
    clearTranslateCookies()
  } else {
    writeCookie('googtrans', `/${SOURCE_LANG}/${next}`)
  }

  try {
    await loadGoogleTranslateScript()
  } catch {
    // Fallback: recarga para que la cookie aplique.
    window.location.reload()
    return next
  }

  const applied = applyComboValue(next)
  if (!applied && next !== SOURCE_LANG) {
    window.location.reload()
  }

  // Volver a español a veces deja restos: recarga limpia el DOM.
  if (next === SOURCE_LANG) {
    window.location.reload()
  }

  return next
}

export function useGoogleTranslate() {
  const route = useRoute()

  onMounted(() => {
    initGoogleTranslate()
  })

  watch(
    () => route.fullPath,
    () => {
      window.setTimeout(refreshTranslation, 300)
    },
  )

  return {
    currentLang: computed(() => currentLang.value),
    ready: computed(() => ready.value),
    setLanguage: setGoogleTranslateLanguage,
    refreshTranslation,
  }
}

export { currentLang, SOURCE_LANG }
