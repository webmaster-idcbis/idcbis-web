import { DEFAULT_LOCALE, FALLBACK_LOCALE } from '../i18n'
import { getPageTranslationOverlay } from '../i18n/pageOverlays'

const LOCALE_KEYS = new Set(['es', 'en'])

/**
 * Detects bilingual leaf values shaped as { es: '...', en: '...' }.
 */
export function isLocalizedStringMap(value) {
  if (!value || typeof value !== 'object' || Array.isArray(value)) {
    return false
  }

  const keys = Object.keys(value)
  if (!keys.length || keys.some((key) => !LOCALE_KEYS.has(key))) {
    return false
  }

  return keys.every((key) => {
    const entry = value[key]
    return entry === null || typeof entry === 'string' || typeof entry === 'number'
  })
}

/**
 * Resolves a value for the active locale.
 * - Plain strings/numbers stay as-is
 * - { es, en } maps pick the locale (fallback to es)
 * - Objects/arrays are walked recursively
 * - Page-level translations: if root has `translations[locale]`, merges over base fields
 */
export function localizeValue(value, locale = DEFAULT_LOCALE, fallback = FALLBACK_LOCALE) {
  if (value === null || value === undefined) {
    return value
  }

  if (typeof value === 'string' || typeof value === 'number' || typeof value === 'boolean') {
    return value
  }

  if (isLocalizedStringMap(value)) {
    const primary = value[locale]
    if (primary !== undefined && primary !== null && primary !== '') {
      return primary
    }
    const secondary = value[fallback]
    if (secondary !== undefined && secondary !== null) {
      return secondary
    }
    const first = Object.values(value).find((entry) => entry !== undefined && entry !== null)
    return first ?? ''
  }

  if (Array.isArray(value)) {
    return value.map((item) => localizeValue(item, locale, fallback))
  }

  if (typeof value === 'object') {
    const result = {}
    Object.keys(value).forEach((key) => {
      if (key === 'translations') {
        return
      }
      result[key] = localizeValue(value[key], locale, fallback)
    })
    return result
  }

  return value
}

/**
 * Applies optional page.translations[locale] overlay, then deep-localizes bilingual leaves.
 */
export function localizePage(page, locale = DEFAULT_LOCALE, fallback = FALLBACK_LOCALE) {
  if (!page || typeof page !== 'object') {
    return page
  }

  const overlay = page.translations?.[locale] || getPageTranslationOverlay(page.slug, locale)
  const base = { ...page }

  if (overlay && typeof overlay === 'object') {
    ;['title', 'meta_title', 'meta_description', 'meta_keywords', 'content', 'sections'].forEach(
      (field) => {
        if (overlay[field] !== undefined) {
          base[field] = overlay[field]
        }
      },
    )
  }

  return localizeValue(base, locale, fallback)
}

/**
 * Resolves menu/nav item titles that may be string or { es, en }.
 */
export function localizeLabel(label, locale = DEFAULT_LOCALE, fallback = FALLBACK_LOCALE) {
  return localizeValue(label, locale, fallback)
}
