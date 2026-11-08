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
    id: 'card_tejidos',
    titleKey: 'header.servicesMenu.tissues',
    title: 'Tejidos',
    href: '/banco-distrital-de-tejidos',
  },
  {
    id: 'card_terapias',
    titleKey: 'header.servicesMenu.therapies',
    title: 'Terapias avanzadas',
    href: '/unidad-de-terapias-avanzadas',
  },
  {
    id: 'card_omimed',
    titleKey: 'header.servicesMenu.omimed',
    title: 'OmiMed',
    href: '/omimed',
  },
  {
    id: 'card_donantes',
    titleKey: 'header.servicesMenu.donors',
    title: 'Registro Nacional de Donantes de Células Progenitoras Hematopoyéticas - Darcelulas',
    href: '/darcelulas',
  },
  {
    id: 'card_bienestar',
    titleKey: 'header.servicesMenu.donations',
    title: 'Donaciones',
    href: '/donaciones',
  },
]

export function homeServiceHref(id) {
  return HOME_SERVICES.find((service) => service.id === id)?.href || '/'
}

/** Detecta el ítem "Servicios" del menú principal */
export function isServicesMenuItem(item) {
  if (!item) return false
  const href = String(item.href || '').replace(/\/$/, '') || '/'
  if (href === '/servicios') return true
  const name = String(item.name || '').toLowerCase()
  return name === 'servicios' || name === 'services'
}
