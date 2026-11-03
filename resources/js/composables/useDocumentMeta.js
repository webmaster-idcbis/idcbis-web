const DEFAULT_TITLE = 'IDCBIS - Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud'

export function pageTitle(title) {
  const clean = String(title || '').trim()
  if (!clean) return DEFAULT_TITLE
  if (clean.includes('IDCBIS')) return clean
  return `${clean} | IDCBIS`
}

function upsertMeta(name, content) {
  let element = document.head.querySelector(`meta[name="${name}"]`)

  if (!content) {
    if (name !== 'description') {
      element?.remove()
    }
    return
  }

  if (!element) {
    element = document.createElement('meta')
    element.setAttribute('name', name)
    document.head.appendChild(element)
  }

  element.setAttribute('content', content)
}

function upsertCanonical(href) {
  let element = document.head.querySelector('link[rel="canonical"]')

  if (!href) {
    element?.remove()
    return
  }

  if (!element) {
    element = document.createElement('link')
    element.setAttribute('rel', 'canonical')
    document.head.appendChild(element)
  }

  element.setAttribute('href', href)
}

function absoluteUrl(value, fallbackPath) {
  if (value && /^https?:\/\//i.test(value)) return value

  const path = value && value.startsWith('/') ? value : fallbackPath
  const normalized = path.startsWith('/') ? path : `/${path}`
  return `${window.location.origin}${normalized}`
}

export function applyDocumentMeta({ title, description = '', canonical, noIndex = false, fallbackPath = '/' }) {
  document.title = pageTitle(title)
  upsertMeta('description', description || 'Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud - IDCBIS')
  upsertMeta('robots', noIndex ? 'noindex, nofollow' : '')
  upsertCanonical(absoluteUrl(canonical, fallbackPath))
}
