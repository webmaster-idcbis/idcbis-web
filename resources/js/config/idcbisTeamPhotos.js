/**
 * Rutas de fotos del equipo IDCBIS.
 * Prioridad: image explícita → /img/equipo/{photoSlug}.jpg → avatar con iniciales
 *
 * Ejecuta: php artisan page:download-quienes-somos-photos
 * para descargar las fotos desde idcbis.org.co
 */

const TEAM_PHOTO_BASE = '/img/equipo'

export function slugifyPersonName(name = '') {
  return name
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-|-$/g, '')
}

export function teamPhotoUrl(person = {}) {
  if (person.image) return person.image
  const slug = person.photoSlug || photoSlugForName(person.name)
  return `${TEAM_PHOTO_BASE}/${slug}.jpg`
}

export function avatarFallbackUrl(name = '') {
  const encoded = encodeURIComponent(name || 'IDCBIS')
  return `https://ui-avatars.com/api/?name=${encoded}&background=0b4f6c&color=ffffff&size=400&bold=true`
}

/** Slugs de foto alineados con los archivos descargados del sitio oficial */
export const TEAM_PHOTO_SLUGS = {
  'Bernardo Armando Camacho Rodríguez': 'bernardo-armando-camacho-rodriguez',
  'Gustavo Andrés Salguero': 'gustavo-andres-salguero',
  'Ingrid Zulay Silva Cote': 'ingrid-zulay-silva-cote',
  'Alvaro Ignacio Guerrero Devia': 'alvaro-ignacio-guerrero-devia',
  'Diana Carolina Camelo Sánchez': 'diana-carolina-camelo-sanchez',
  'Ana María Perdomo': 'ana-maria-perdomo',
  'Jenny Johana Pinilla Gómez': 'jenny-johana-pinilla-gomez',
  'César Augusto Ramírez Segura': 'cesar-augusto-ramirez-segura',
  'Carlos Ayala Grosso': 'carlos-ayala-grosso',
  'Sonia Patricia Forero': 'sonia-patricia-forero',
  'Jhon Alexander Bello Sepúlveda': 'jhon-alexander-bello-sepulveda',
  'Paula Andrea Gaviria': 'paula-andrea-gaviria',
  'Paola Andrea Cendales Rodríguez': 'paola-andrea-cendales-rodriguez',
  'Leidi Yohana Méndez Báez': 'leidi-yohana-mendez-baez',
  'Marcela Eugenia Gutiérrez Esquivel': 'marcela-eugenia-gutierrez-esquivel',
  'Sindy Lorena Álvarez Hernández': 'sindy-lorena-alvarez-hernandez',
  'William Idarraga Ariza': 'william-idarraga-ariza',
  'Jeimi Martínez Osorio': 'jeimi-martinez-osorio',
  'Mariana Cañas': 'mariana-canas',
  'Gina Alexandra Mendoza Rodríguez': 'gina-alexandra-mendoza-rodriguez',
  'Sandra Patricia Gómez Rubio': 'sandra-patricia-gomez-rubio',
  'Jaime Jhonatan Rivera Díaz': 'jaime-jhonatan-rivera-diaz',
  'José Luis Preciado Gómez': 'jose-luis-preciado-gomez',
  'German Camilo Ramírez Montenegro': 'german-camilo-ramirez-montenegro',
  'Mary Alejandra Guarnizo Devia': 'mary-alejandra-guarnizo-devia',
  'Gustavo Salguero López': 'gustavo-andres-salguero',
}

export function photoSlugForName(name) {
  return TEAM_PHOTO_SLUGS[name] || slugifyPersonName(name)
}
