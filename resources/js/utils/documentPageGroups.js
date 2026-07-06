import { generateId } from './pageElementFactory'

/** Normaliza groups / yearGroups legacy a { id, label, documents } */
export function normalizeDocumentGroups(source) {
  const raw = source?.groups || source?.yearGroups || []
  return raw.map((group) => ({
    ...group,
    id: group.id || generateId(),
    label: group.label || group.year || 'Sin título',
    documents: (group.documents || []).map((doc) => ({
      ...doc,
      id: doc.id || generateId(),
    })),
  }))
}

export function createDocumentGroup(label = 'Nueva sección') {
  return {
    id: generateId(),
    label,
    documents: [],
  }
}

export function createDocumentItem() {
  return {
    id: generateId(),
    title: '',
    publishedAt: '',
    url: '',
  }
}

/** Sidebar estrecha para años; ancha para títulos largos (estados financieros) */
export function isCompactNav(groups) {
  if (!groups?.length) return true
  return groups.every((g) => /^\d{4}$/.test(String(g.label || '').trim()))
}
