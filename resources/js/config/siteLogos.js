/**
 * Rutas y tamaños de logos IDCBIS (public/images/logo/).
 */
export const SITE_LOGOS = {
  /** Menú principal — fondo azul oscuro */
  header: {
    src: '/images/logo/logo-IDCBIS-blanco.png',
    alt: 'IDCBIS — Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud',
    class: 'h-11 sm:h-12 md:h-14 w-auto max-w-[200px] sm:max-w-[240px] object-contain',
  },
  /** Versión compacta (sidebar colapsado, favicon en UI) */
  icon: {
    src: '/images/logo/logo32x32.png',
    alt: 'IDCBIS',
    class: 'h-8 w-8 object-contain',
  },
  /** Panel admin — fondo claro */
  admin: {
    src: '/images/logo/logo-IDCBIS.jpg',
    alt: 'IDCBIS',
    class: 'h-10 w-auto max-w-[180px] object-contain',
  },
  adminCompact: {
    src: '/images/logo/logo-IDCBIS.jpg',
    alt: 'IDCBIS',
    class: 'h-8 w-auto max-w-[120px] object-contain',
  },
  /** Pie de página — fondo azul oscuro */
  footer: {
    src: '/images/logo/logo-IDCBIS-blanco.png',
    alt: 'IDCBIS',
    class: 'w-[140px] sm:w-[160px] h-auto object-contain',
  },
  /** Sección “Somos IDCBIS” en página de inicio */
  about: {
    src: '/images/logo/logo-IDCBIS.jpg',
    alt: 'Logo IDCBIS',
    class: 'max-w-full h-auto max-h-[280px] object-contain mx-auto',
  },
  favicon: '/images/logo/logo32x32.png',
  appleTouch: '/images/logo/logo180x180.png',
}

/** Logos institucionales (footer) — public/img/ */
export const INSTITUTIONAL_LOGOS = {
  idcbisInstitute: {
    src: '/img/IDCBIS-2020-Banco-Distrital-de-Tejidos-Logo-Instituto.png',
    alt: 'IDCBIS Instituto',
    class: 'w-[110px] h-[90px] object-contain',
  },
  colombia: {
    src: '/img/Marca_pais_Colombia_logo.png',
    alt: 'Marca país Colombia',
    class: 'w-[120px] h-auto object-contain',
  },
  ministerioSalud: {
    src: '/img/Escudo-Ministerio-de-salud.png',
    alt: 'Ministerio de Salud',
    class: 'w-full max-w-[200px] h-auto object-contain',
  },
}
