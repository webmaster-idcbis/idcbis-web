import { generateId } from './pageElementFactory'

export const QUIENES_SOMOS_LAYOUTS = [
  { value: 'organigrama', label: 'Organigrama (imagen)' },
  { value: 'list', label: 'Lista con viñetas (funciones)' },
  { value: 'founders', label: 'Miembros fundadores (logo + enlace)' },
  { value: 'team', label: 'Equipo con fotos' },
  { value: 'policies', label: 'Políticas y enlaces' },
  { value: 'contact', label: 'Horarios y contacto' },
]

export function createPrinciple(overrides = {}) {
  return {
    id: generateId(),
    icon: '⭐',
    title: 'Nuevo principio',
    image: '',
    imageAlt: '',
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

export function createFounderItem(overrides = {}) {
  return {
    name: '',
    logo: '',
    url: '',
    logoOnDark: false,
    ...overrides,
  }
}

export function normalizeFounderItem(item) {
  if (typeof item === 'string') {
    return createFounderItem({ name: item })
  }
  if (!item || typeof item !== 'object') {
    return createFounderItem()
  }
  return createFounderItem({
    name: item.name || '',
    logo: item.logo || '',
    url: item.url || '',
    logoOnDark: Boolean(item.logoOnDark),
  })
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
    case 'organigrama':
      return {
        ...base,
        description: base.description || '',
        image: base.image || '',
        imageAlt: base.imageAlt || '',
        caption: base.caption || '',
      }
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
    case 'organigrama':
      section.description = section.description || ''
      section.image = section.image || ''
      section.imageAlt = section.imageAlt || ''
      section.caption = section.caption || ''
      delete section.items
      delete section.members
      break
    case 'team':
      if (!Array.isArray(section.members)) section.members = []
      section.members.forEach((member) => {
        if (!member.id) member.id = generateId()
      })
      delete section.items
      break
    case 'founders':
      if (!Array.isArray(section.items)) section.items = []
      section.items = section.items.map(normalizeFounderItem)
      delete section.members
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
