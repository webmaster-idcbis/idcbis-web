/**
 * Estructura del mapa del sitio IDCBIS.
 * Cada `slug` genera la ruta `/{slug}` (excepto inicio y contacto).
 */
export const SITE_SITEMAP = [
  {
    title: 'Quiénes Somos',
    slug: 'quienes-somos',
    icon: '🏛️',
    description: 'Historia, misión y equipo del instituto',
  },
  {
    title: 'Servicios',
    slug: 'servicios',
    icon: '❤️',
    description: 'Bancos de sangre, tejidos y servicios institucionales',
    children: [
      { title: 'Banco Distrital de Sangre', slug: 'banco-de-sangre', icon: '🩸' },
      { title: 'Banco Distrital de Tejidos', slug: 'banco-distrital-de-tejidos', icon: '🧬' },
      { title: 'Banco Público de Sangre de Cordón Umbilical', slug: 'banco-publico-sangre-cordon-umbilical', icon: '👶' },
      { title: 'Servicios Institucionales', slug: 'servicios-institucionales', icon: '🏥' },
    ],
  },
  {
    title: 'Investigación IDCBIS',
    slug: 'investigacion',
    icon: '🔬',
    description: 'Ciencia, innovación y publicaciones',
    children: [
      { title: 'Investigación Científica', slug: 'investigacion-cientifica' },
      { title: 'Investigación y desarrollo en Terapias Avanzadas', slug: 'investigacion-terapias-avanzadas' },
      { title: 'Investigación en Células Progenitoras Hematopoyéticas', slug: 'investigacion-celulas-progenitoras-hematopoyeticas' },
      { title: 'Investigación en medicina transfusional e inmunohematología avanzada', slug: 'investigacion-medicina-transfusional' },
      { title: 'Publicaciones Científicas', slug: 'publicaciones-cientificas' },
    ],
  },
  {
    title: 'Transparencia',
    slug: 'transparencia',
    icon: '📋',
    description: 'Información pública, normativa y datos abiertos',
    children: [
      { title: 'Información de la entidad', slug: 'informacion-de-la-entidad' },
      { title: 'Normativa', slug: 'normativa' },
      { title: 'Contratación', slug: 'contratacion' },
      { title: 'Planeación, presupuesto e informes', slug: 'planeacion-presupuesto-e-informes' },
      { title: 'Trámites', slug: 'tramites' },
      { title: 'Participa', slug: 'transparencia-participa' },
      { title: 'Datos Abiertos', slug: 'datos-abiertos' },
      { title: 'Información específica para grupos de interés', slug: 'informacion-grupos-de-interes' },
      { title: 'Obligación de reporte de información', slug: 'obligacion-reporte-informacion' },
      { title: 'Información tributaria en entidades territoriales locales', slug: 'informacion-tributaria-entidades-territoriales' },
    ],
  },
];

/** Enlaces independientes agrupados para lectura rápida */
export const SITEMAP_QUICK_LINKS = [
  {
    group: 'Participación y atención',
    icon: '🤝',
    items: [
      { title: 'Participa', slug: 'participa' },
      { title: 'Atención a Usuarios', slug: 'atencion-a-usuarios' },
      { title: 'Contáctenos', slug: 'contacto', icon: '✉️' },
    ],
  },
  {
    group: 'Transparencia y gestión',
    icon: '📊',
    items: [
      { title: 'Programa de Transparencia y Ética Pública', slug: 'programa-transparencia-etica-publica' },
      { title: 'Plan anticorrupción y atención al ciudadano', slug: 'plan-anticorrupcion' },
      { title: 'Estados financieros', slug: 'estados-financieros' },
      { title: 'Ejecución presupuestal', slug: 'ejecucion-presupuestal' },
      { title: 'Contratación bienes y servicios', slug: 'contratacion-bienes-servicios' },
      { title: 'Rendición de Cuentas', slug: 'rendicion-de-cuentas' },
    ],
  },
  {
    group: 'Comunidad y proveedores',
    icon: '📰',
    items: [
      { title: 'Trabaje con nosotros', slug: 'trabaje-con-nosotros' },
      { title: 'Apoyo financiero', slug: 'apoyo-financiero' },
      { title: 'Noticias', slug: 'noticias' },
      { title: 'Información a proveedores', slug: 'informacion-a-proveedores' },
    ],
  },
];

/** Slugs con contenido publicado y listo */
export const PUBLISHED_SITEMAP_SLUGS = new Set([
  'inicio',
  'mapa-del-sitio',
  'quienes-somos',
  'programa-transparencia-etica-publica',
  'estados-financieros',
  'plan-anticorrupcion',
  'banco-de-sangre',
  'servicios',
  'contacto',
]);

export function sitemapItemUrl(slug) {
  if (!slug || slug === 'inicio') return '/';
  return `/${slug}`;
}

export function isSitemapPublished(slug) {
  return PUBLISHED_SITEMAP_SLUGS.has(slug);
}

export function flattenSitemap(items = SITE_SITEMAP) {
  const flat = [];

  const walk = (list) => {
    list.forEach((item) => {
      flat.push(item);
      if (item.children?.length) walk(item.children);
    });
  };

  walk(items);
  SITEMAP_QUICK_LINKS.forEach((g) => g.items.forEach((item) => flat.push(item)));

  return flat;
}

export function countSitemapPages() {
  return flattenSitemap().length;
}

export function countPublishedPages() {
  return flattenSitemap().filter((item) => isSitemapPublished(item.slug)).length;
}

export function findSitemapItemBySlug(slug, items = SITE_SITEMAP) {
  for (const item of items) {
    if (item.slug === slug) return item;
    if (item.children?.length) {
      const found = findSitemapItemBySlug(slug, item.children);
      if (found) return found;
    }
  }

  for (const group of SITEMAP_QUICK_LINKS) {
    const found = group.items.find((item) => item.slug === slug);
    if (found) return found;
  }

  return null;
}

export function normalizeSearchText(value) {
  return (value || '')
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '');
}

export function itemMatchesQuery(item, query) {
  if (!query) return true;
  const haystack = normalizeSearchText(
    [item.title, item.description, item.slug].filter(Boolean).join(' '),
  );
  return haystack.includes(normalizeSearchText(query));
}

export function filterSitemapTree(query) {
  const q = normalizeSearchText(query.trim());
  if (!q) return { sections: SITE_SITEMAP, quickLinks: SITEMAP_QUICK_LINKS };

  const sections = SITE_SITEMAP.map((section) => {
    const children = (section.children || []).filter((child) => itemMatchesQuery(child, q));
    const sectionMatch = itemMatchesQuery(section, q);
    if (sectionMatch || children.length) {
      return { ...section, children: sectionMatch ? (section.children || []) : children };
    }
    return null;
  }).filter(Boolean);

  const quickLinks = SITEMAP_QUICK_LINKS.map((group) => ({
    ...group,
    items: group.items.filter((item) => itemMatchesQuery(item, q)),
  })).filter((group) => group.items.length);

  return { sections, quickLinks };
}
