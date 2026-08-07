import { computed, ref } from 'vue'
import es from './locales/es'
import en from './locales/en'

export const SUPPORTED_LOCALES = [
  { code: 'es', labelKey: 'common.spanish', short: 'ES' },
  { code: 'en', labelKey: 'common.english', short: 'EN' },
]

export const DEFAULT_LOCALE = 'es'
export const FALLBACK_LOCALE = 'es'

const messages = { es, en }

const localeRef = ref(DEFAULT_LOCALE)

function resolvePath(object, path) {
  return path.split('.').reduce((acc, key) => {
    if (acc && typeof acc === 'object' && key in acc) {
      return acc[key]
    }
    return undefined
  }, object)
}

function interpolate(template, params = {}) {
  if (typeof template !== 'string') {
    return template
  }

  return template.replace(/\{(\w+)\}/g, (_, key) => {
    return params[key] !== undefined && params[key] !== null ? String(params[key]) : `{${key}}`
  })
}

export function getStoredLocale() {
  try {
    const stored = localStorage.getItem('language')
    if (stored && messages[stored]) {
      return stored
    }
  } catch {
    // ignore storage errors
  }
  return DEFAULT_LOCALE
}

export function setI18nLocale(code) {
  const next = messages[code] ? code : DEFAULT_LOCALE
  localeRef.value = next

  if (typeof document !== 'undefined') {
    document.documentElement.lang = next
  }

  try {
    localStorage.setItem('language', next)
  } catch {
    // ignore storage errors
  }

  return next
}

export function t(key, params = {}, explicitLocale = null) {
  const locale = explicitLocale || localeRef.value
  const primary = resolvePath(messages[locale], key)
  if (typeof primary === 'string') {
    return interpolate(primary, params)
  }

  if (locale !== FALLBACK_LOCALE) {
    const fallback = resolvePath(messages[FALLBACK_LOCALE], key)
    if (typeof fallback === 'string') {
      return interpolate(fallback, params)
    }
  }

  return key
}

export function useI18n() {
  const locale = computed(() => localeRef.value)
  const availableLocales = SUPPORTED_LOCALES

  const translate = (key, params = {}) => t(key, params, localeRef.value)

  const setLocale = (code) => setI18nLocale(code)

  return {
    locale,
    availableLocales,
    t: translate,
    setLocale,
  }
}

export function initI18n(preferredLocale = null) {
  const initial = preferredLocale && messages[preferredLocale]
    ? preferredLocale
    : getStoredLocale()
  return setI18nLocale(initial)
}

export { localeRef, messages }
