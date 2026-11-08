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

const STRUCTURAL_KEYS = new Set([
  'id',
  'type',
  'name',
  'icon',
  'href',
  'url',
  'src',
  'image',
  'html',
  'htmlCode',
  'fullBleed',
  'autoPlay',
  'showArrows',
  'showIndicators',
  'blockLabel',
  'theme',
  'order',
  'status',
  'slug',
  'target',
  'rel',
])

function isStructuralKey(key) {
  if (STRUCTURAL_KEYS.has(key)) {
    return true
  }

  return /(?:color|image|url|href|src|class|icon|padding|margin|width|height|radius|gradient|font|size|interval|play|bleed|anchor|theme|layout|align|poster|video|order|status|slug|target|rel|required|rows|columns|limit|variant)$/i.test(
    key,
  )
}

/**
 * Copies translated strings onto the current content tree.
 * Layout, media and structure stay on the published page.
 */
export function mergeTranslatedNode(base, translated) {
  if (typeof base === 'string') {
    return typeof translated === 'string' && translated.trim() !== '' ? translated : base
  }

  if (base == null || typeof base === 'number' || typeof base === 'boolean') {
    return base
  }

  if (Array.isArray(base)) {
    if (!Array.isArray(translated)) {
      return base
    }

    const sameLength = base.length === translated.length

    return base.map((item, index) => {
      if (typeof item === 'string') {
        const next = translated[index]
        return sameLength && typeof next === 'string' && next.trim() !== '' ? next : item
      }

      let match
      if (item && typeof item === 'object' && !Array.isArray(item) && item.id) {
        match = translated.find((entry) => entry && typeof entry === 'object' && entry.id === item.id)
      }
      if (!match && item && typeof item === 'object' && !Array.isArray(item) && item.name) {
        match = translated.find((entry) => entry && typeof entry === 'object' && entry.name === item.name)
      }
      if (!match && sameLength) {
        match = translated[index]
      }
      if (!match && item && typeof item === 'object' && item.value != null) {
        match = translated.find((entry) => entry && typeof entry === 'object' && entry.value === item.value)
      }
      if (match === undefined) {
        return item
      }

      return mergeTranslatedNode(item, match)
    })
  }

  if (typeof base === 'object') {
    if (!translated || typeof translated !== 'object' || Array.isArray(translated)) {
      return base
    }

    const result = { ...base }
    Object.keys(base).forEach((key) => {
      if (isStructuralKey(key) || !Object.prototype.hasOwnProperty.call(translated, key)) {
        return
      }
      result[key] = mergeTranslatedNode(base[key], translated[key])
    })
    return result
  }

  return base
}

/**
 * Applies optional page.translations[locale] as text on the current design,
 * then deep-localizes bilingual leaves.
 */
export function localizePage(page, locale = DEFAULT_LOCALE, fallback = FALLBACK_LOCALE) {
  if (!page || typeof page !== 'object') {
    return page
  }

  const base = { ...page }
  const overlay = locale === fallback
    ? null
    : (page.translations?.[locale] || getPageTranslationOverlay(page.slug, locale))

  if (overlay && typeof overlay === 'object') {
    ;['title', 'meta_title', 'meta_description', 'meta_keywords'].forEach((field) => {
      if (typeof overlay[field] === 'string' && overlay[field].trim() !== '') {
        base[field] = overlay[field]
      }
    })

    if (overlay.content !== undefined && page.content != null) {
      base.content = mergeTranslatedNode(page.content, overlay.content)
    } else if (page.content == null && overlay.content !== undefined) {
      base.content = overlay.content
    }

    if (overlay.sections !== undefined && page.sections != null) {
      base.sections = mergeTranslatedNode(page.sections, overlay.sections)
    } else if (page.sections == null && overlay.sections !== undefined) {
      base.sections = overlay.sections
    }
  }

  return localizeValue(base, locale, fallback)
}

/**
 * Resolves menu/nav item titles that may be string or { es, en }.
 */
export function localizeLabel(label, locale = DEFAULT_LOCALE, fallback = FALLBACK_LOCALE) {
  return localizeValue(label, locale, fallback)
}
