import { NEWS_CATEGORY_MAP } from '../config/newsCategories'

export function getCategoryLabel(categoryId) {
  if (!categoryId) return 'Sin categoría'
  return NEWS_CATEGORY_MAP[categoryId] || categoryId
}

export function normalizeNewsItems(element) {
  const items = Array.isArray(element?.items) ? element.items : []

  return items.map((item) => ({
    id: item.id || item.slug || item.title,
    title: item.title || 'Sin título',
    excerpt: item.excerpt || '',
    category: item.category || 'sin-categoria',
    categoryLabel: item.categoryLabel || getCategoryLabel(item.category),
    publishedAt: item.publishedAt || '',
    image: item.image || '',
    slug: item.slug || '',
    url: item.url || (item.slug ? `/noticias/${item.slug}` : '#'),
  }))
}

export function filterNewsItems(items, { category = 'all', query = '' } = {}) {
  const normalizedQuery = normalizeText(query)

  return items.filter((item) => {
    const matchesCategory = category === 'all' || item.category === category
    if (!matchesCategory) return false
    if (!normalizedQuery) return true

    const haystack = normalizeText(
      `${item.title} ${item.excerpt} ${item.categoryLabel} ${item.publishedAt}`,
    )
    return haystack.includes(normalizedQuery)
  })
}

function normalizeText(value) {
  return (value || '')
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
}
