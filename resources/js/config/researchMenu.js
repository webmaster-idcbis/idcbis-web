/**
 * Submenú de Investigación en la navegación principal.
 * Las rutas apuntan a las páginas de investigación ya publicadas.
 */
export const RESEARCH_MENU = [
  {
    id: 'cord',
    titleKey: 'header.researchMenu.cord',
    href: '/banco-publico-sangre-cordon-umbilical',
  },
  {
    id: 'therapies',
    titleKey: 'header.researchMenu.therapies',
    href: '/investigacion-terapias-avanzadas',
  },
]

/** Detecta el ítem "Investigación" del menú principal */
export function isResearchMenuItem(item) {
  if (!item) return false
  const href = String(item.href || '').replace(/\/$/, '') || '/'
  if (href === '/investigacion') return true
  const name = String(item.name || '')
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
  return name === 'investigacion' || name === 'research'
}
