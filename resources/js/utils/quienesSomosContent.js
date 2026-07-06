import { generateId } from './pageElementFactory'

export const QUIENES_SOMOS_LAYOUTS = [
  { value: 'list', label: 'Lista con viñetas (funciones)' },
  { value: 'founders', label: 'Lista de nombres (fundadores)' },
  { value: 'team', label: 'Equipo con fotos' },
  { value: 'policies', label: 'Políticas y enlaces' },
  { value: 'contact', label: 'Horarios y contacto' },
]

export function createPrinciple(overrides = {}) {
  return {
    id: generateId(),
    icon: '⭐',
    title: 'Nuevo principio',
    ...overrides,
  }
}

export function createTeamMember(overrides = {}) {
  return {
    id: generateId(),
    name: '',
    role: '',
    email: '',
    credentials: '',
    photoSlug: '',
    image: '',
    ...overrides,
  }
}

export function createPolicyItem(overrides = {}) {
  return {
    id: generateId(),
    title: '',
    description: '',
    icon: '📋',
    url: '',
    ...overrides,
  }
}

export function createContactBlock(overrides = {}) {
  return {
    id: generateId(),
    icon: '📍',
    title: '',
    text: '',
    ...overrides,
  }
}

export function createQuienesSomosSection(layout = 'list', overrides = {}) {
  const base = {
    id: generateId(),
    title: 'Nueva sección',
    icon: '📄',
    layout,
    ...overrides,
  }

  switch (layout) {
    case 'team':
      return { ...base, members: base.members || [] }
    case 'policies':
      return { ...base, items: base.items || [] }
    case 'contact':
      return { ...base, items: base.items || [] }
    default:
      return { ...base, items: base.items || [] }
  }
}

export function ensureSectionShape(section) {
  if (!section.id) section.id = generateId()

  switch (section.layout) {
    case 'team':
      if (!Array.isArray(section.members)) section.members = []
      section.members.forEach((member) => {
        if (!member.id) member.id = generateId()
      })
      delete section.items
      break
    case 'policies':
    case 'contact':
      if (!Array.isArray(section.items)) section.items = []
      section.items.forEach((item) => {
        if (!item.id) item.id = generateId()
      })
      delete section.members
      break
    default:
      if (!Array.isArray(section.items)) section.items = []
      delete section.members
      break
  }
}

export function onSectionLayoutChange(section, newLayout) {
  const title = section.title
  const icon = section.icon
  const id = section.id

  Object.keys(section).forEach((key) => delete section[key])

  Object.assign(section, createQuienesSomosSection(newLayout, { id, title, icon }))
}

export function ensureQuienesSomosElement(element) {
  if (!element) return

  if (typeof element.intro === 'string') {
    element.intro = element.intro ? [element.intro] : []
  }
  if (!Array.isArray(element.intro)) {
    element.intro = []
  }

  if (!Array.isArray(element.principles)) {
    element.principles = []
  }
  element.principles.forEach((item) => {
    if (!item.id) item.id = generateId()
  })

  if (element.director && typeof element.director === 'object' && !element.director.id) {
    element.director.id = generateId()
  }

  if (!Array.isArray(element.sections)) {
    element.sections = []
  }
  element.sections.forEach(ensureSectionShape)
}
