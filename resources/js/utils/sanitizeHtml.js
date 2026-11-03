const ALLOWED_SCRIPT_HOST = 'bogota.gov.co'

export function isAllowedExternalScript(src) {
  if (!src) return false

  try {
    const url = new URL(src, window.location.origin)
    const host = url.hostname.toLowerCase()
    return url.protocol === 'https:' && (host === ALLOWED_SCRIPT_HOST || host.endsWith(`.${ALLOWED_SCRIPT_HOST}`))
  } catch {
    return false
  }
}

export function sanitizeNewsHtml(html) {
  if (!html) return ''

  const doc = new DOMParser().parseFromString(String(html), 'text/html')
  doc.querySelectorAll('script').forEach((node) => node.remove())

  doc.body.querySelectorAll('*').forEach((element) => {
    ;[...element.attributes].forEach((attribute) => {
      const name = attribute.name.toLowerCase()
      const value = attribute.value.trim().toLowerCase()

      if (name.startsWith('on')) {
        element.removeAttribute(attribute.name)
        return
      }

      if ((name === 'href' || name === 'src' || name === 'xlink:href') && value.startsWith('javascript:')) {
        element.removeAttribute(attribute.name)
      }
    })
  })

  return doc.body.innerHTML
}
