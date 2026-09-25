/**
 * Variantes WebP junto al original: archivo.jpg → archivo-768w.webp
 */
export function webpVariant(src, width) {
  if (!src) return ''
  const clean = String(src).split('?')[0]
  const base = clean.replace(/\.(jpe?g|png|webp)$/i, '')
  return `${base}-${width}w.webp`
}

export function buildSrcSet(src, widths) {
  return widths.map((width) => `${webpVariant(src, width)} ${width}w`).join(', ')
}

export const HERO_WIDTHS = [768, 1280, 1920]
export const CARD_WIDTHS = [400, 800]
