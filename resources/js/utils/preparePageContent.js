import { toRaw } from 'vue'
import { normalizeDocumentGroups } from './documentPageGroups'
import { ensureQuienesSomosElement } from './quienesSomosContent'

/**
 * Serializa el árbol de elementos del editor para la API (sin proxies de Vue).
 */
export function preparePageContentForSave(elements) {
  const raw = JSON.parse(JSON.stringify(toRaw(elements ?? [])))

  return raw.map((el) => {
    if (el.type === 'idcbis-documents-page') {
      const groups = normalizeDocumentGroups(el).map((group) => ({
        id: group.id,
        label: group.label,
        documents: (group.documents || []).map((doc) => ({
          id: doc.id,
          title: doc.title ?? '',
          publishedAt: doc.publishedAt ?? '',
          url: doc.url ?? '',
        })),
      }))

      const { yearGroups, ...rest } = el
      return { ...rest, groups }
    }

    if (el.type === 'idcbis-quienes-somos') {
      ensureQuienesSomosElement(el)
      return el
    }

    return el
  })
}
