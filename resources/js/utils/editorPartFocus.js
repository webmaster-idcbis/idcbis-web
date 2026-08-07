import { nextTick } from 'vue'

/**
 * Desplaza el panel de propiedades hasta el campo con data-editor-focus="{anchor}".
 */
export function scrollToEditorFocus(anchor, root = document) {
  if (!anchor) return

  nextTick(() => {
    requestAnimationFrame(() => {
      const escaped = typeof CSS !== 'undefined' && CSS.escape
        ? CSS.escape(anchor)
        : anchor.replace(/"/g, '\\"')
      const el = root.querySelector?.(`[data-editor-focus="${escaped}"]`)
        ?? document.querySelector(`[data-editor-focus="${escaped}"]`)

      if (!el) return

      el.scrollIntoView({ behavior: 'smooth', block: 'nearest' })
      el.classList.add('editor-focus-flash')
      window.setTimeout(() => el.classList.remove('editor-focus-flash'), 2200)
    })
  })
}

export function buildTeamFocusAnchor(memberId) {
  return `team:${memberId}`
}

export function buildSectionFocusAnchor(sectionId) {
  return `section:${sectionId}`
}

export function buildPrincipleFocusAnchor(principleId) {
  return `principle:${principleId}`
}

export function buildIntroFocusAnchor(index) {
  return `intro:${index}`
}

export function buildHeroSlideFocusAnchor(slideId) {
  return `slide:${slideId}`
}

export function buildServiceCardFocusAnchor(cardId) {
  return `card:${cardId}`
}

export function buildStatFocusAnchor(itemId) {
  return `stat:${itemId}`
}

export function buildBubbleFocusAnchor(itemId) {
  return `bubble:${itemId}`
}

export function buildContactFocusAnchor(itemId) {
  return `contact:${itemId}`
}

export function buildDocumentGroupFocusAnchor(groupId) {
  return `docgroup:${groupId}`
}

export function buildDocumentItemFocusAnchor(docId) {
  return `document:${docId}`
}

export function buildNewsItemFocusAnchor(itemId) {
  return `news:${itemId}`
}

export function buildCarouselSlideFocusAnchor(slideId) {
  return `slide:${slideId}`
}

export function buildAccordionItemFocusAnchor(itemId) {
  return `accordion:${itemId}`
}

export function buildCardFocusAnchor(cardId) {
  return `card:${cardId}`
}
