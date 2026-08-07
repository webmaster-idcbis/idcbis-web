/**
 * Categorías de noticias IDCBIS (alineadas con idcbis.org.co/noticias).
 */
export const NEWS_CATEGORIES = [
  { id: 'apropiacion-social', label: 'Apropiación Social del Conocimiento' },
  { id: 'celulas', label: 'Células' },
  { id: 'congreso', label: 'Congreso' },
  { id: 'convenios', label: 'Convenios' },
  { id: 'donacion', label: 'Donación' },
  { id: 'investigacion', label: 'Investigación' },
  { id: 'reconocimientos', label: 'Reconocimientos' },
  { id: 'sangre', label: 'Sangre' },
  { id: 'tejidos', label: 'Tejidos' },
  { id: 'sin-categoria', label: 'Sin categoría' },
]

export const NEWS_CATEGORY_MAP = Object.fromEntries(
  NEWS_CATEGORIES.map((c) => [c.id, c.label]),
)
