/**
 * Servicios del Home (grid idcbis-services) y submenú de navegación.
 * Mantener alineado con database/data/propuesta-azul-content.php
 */
export const HOME_SERVICES = [
  {
    id: 'card_sangre',
    titleKey: 'header.servicesMenu.blood',
    title: 'Donar sangre',
    href: '/banco-de-sangre',
  },
  {
    id: 'card_cordon',
    titleKey: 'header.servicesMenu.cord',
    title: 'Cordón umbilical',
    href: '/banco-publico-sangre-cordon-umbilical',
  },
  {
    id: 'card_tejidos',
    titleKey: 'header.servicesMenu.tissues',
    title: 'Tejidos',
    href: '/banco-distrital-de-tejidos',
  },
  {
    id: 'card_terapias',
    titleKey: 'header.servicesMenu.therapies',
    title: 'Terapias avanzadas',
    href: '/investigacion-terapias-avanzadas',
  },
  {
    id: 'card_donantes',
    titleKey: 'header.servicesMenu.donors',
    title: 'Registro de donantes',
    href: '/darcelulas',
  },
  {
    id: 'card_bienestar',
    titleKey: 'header.servicesMenu.wellness',
    title: 'Bienestar',
    href: '/servicios-institucionales',
  },
]

/** Detecta el ítem "Servicios" del menú principal */
export function isServicesMenuItem(item) {
  if (!item) return false
  const href = String(item.href || '').replace(/\/$/, '') || '/'
  if (href === '/servicios') return true
  const name = String(item.name || '').toLowerCase()
  return name === 'servicios' || name === 'services'
}
