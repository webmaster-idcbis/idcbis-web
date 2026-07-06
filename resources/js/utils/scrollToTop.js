/**
 * Lleva el scroll al inicio de la página (útil en navegación SPA).
 */
export function scrollToTop(behavior = 'auto') {
  window.scrollTo({ top: 0, left: 0, behavior });
  document.documentElement.scrollTop = 0;
  document.body.scrollTop = 0;
}
