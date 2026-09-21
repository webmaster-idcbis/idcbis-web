/**
 * Enlaces reales en vista pública; botón inerte en el editor.
 */
export function previewLinkProps(preview, url) {
  if (!preview || !url) {
    return {
      is: 'button',
      type: 'button',
      href: undefined,
      target: undefined,
      rel: undefined,
    }
  }

  const isHttp = /^https?:/i.test(url)

  return {
    is: 'a',
    type: undefined,
    href: url,
    target: isHttp ? '_blank' : undefined,
    rel: isHttp ? 'noopener noreferrer' : undefined,
  }
}

export function isExternalHttp(url) {
  return /^https?:/i.test(url || '')
}
