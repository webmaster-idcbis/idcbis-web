/**
 * Estilos de caja y layout aplicables a cualquier elemento del page builder.
 */
export function getLayoutStyles(element = {}) {
  const styles = {}

  const keys = [
    'width', 'height', 'minWidth', 'maxWidth', 'minHeight', 'maxHeight',
    'margin', 'padding', 'display', 'boxSizing', 'overflow',
    'flex', 'flexGrow', 'flexShrink', 'flexBasis', 'alignSelf', 'order',
    'position', 'top', 'left', 'right', 'bottom', 'zIndex',
  ]

  keys.forEach((key) => {
    const val = element[key]
    if (val !== undefined && val !== null && val !== '') {
      styles[key] = val
    }
  })

  if (element.alignCenter) {
    styles.marginLeft = element.marginLeft || 'auto'
    styles.marginRight = element.marginRight || 'auto'
    if (!element.width) {
      styles.width = 'fit-content'
      styles.maxWidth = element.maxWidth || '100%'
    }
  }

  if (element.customStyles && typeof element.customStyles === 'object') {
    Object.assign(styles, element.customStyles)
  }

  return styles
}

export function getTypographyStyles(element = {}) {
  const styles = {}
  const keys = [
    'fontSize', 'fontFamily', 'fontWeight', 'fontStyle', 'textAlign',
    'lineHeight', 'letterSpacing', 'textTransform', 'textDecoration',
    'color',
  ]
  keys.forEach((key) => {
    const val = element[key]
    if (val !== undefined && val !== null && val !== '') {
      styles[key] = val
    }
  })
  return styles
}

export function resolveBackgroundColor(value, fallback) {
  if (value === 'transparent' || value === 'none') return 'transparent'
  if (value !== undefined && value !== null && value !== '') return value
  return fallback
}

export function isTransparentBackground(value) {
  return value === 'transparent' || value === 'none'
}

/** Color o gradiente de fondo: respeta transparente, backgroundColor y background legacy */
export function resolveBackground(element = {}, fallback) {
  if (isTransparentBackground(element.backgroundColor)) return 'transparent'
  if (element.backgroundColor) return element.backgroundColor
  if (element.background) return element.background
  return fallback
}

export function getVisualStyles(element = {}) {
  const styles = {}
  if (isTransparentBackground(element.backgroundColor)) {
    styles.backgroundColor = 'transparent'
  } else if (element.backgroundColor) {
    styles.backgroundColor = element.backgroundColor
  }
  if (element.backgroundImage) {
    styles.backgroundImage = `url(${element.backgroundImage})`
    styles.backgroundSize = element.backgroundSize || 'cover'
    styles.backgroundPosition = element.backgroundPosition || 'center'
    styles.backgroundRepeat = element.backgroundRepeat || 'no-repeat'
  }
  if (element.border) styles.border = element.border
  if (element.borderRadius) styles.borderRadius = element.borderRadius
  if (element.boxShadow) styles.boxShadow = element.boxShadow
  if (element.opacity != null) styles.opacity = element.opacity
  if (element.transform) styles.transform = element.transform
  if (element.transition) styles.transition = element.transition
  return styles
}

export function mergeElementStyles(element, extra = {}) {
  return {
    ...getLayoutStyles(element),
    ...getTypographyStyles(element),
    ...getVisualStyles(element),
    ...extra,
  }
}

/** Estilos del wrapper hijo dentro de un contenedor flex/grid */
export function getContainerChildWrapperStyles(child, container) {
  const styles = {}
  const display = container?.display || 'flex'
  const direction = container?.flexDirection || 'column'

  if (display === 'flex') {
    if (child.flex) {
      styles.flex = child.flex
    } else if (direction === 'row' || direction === 'row-reverse') {
      styles.flex = child.flexGrow ? `${child.flexGrow} ${child.flexShrink ?? 0} ${child.flexBasis || 'auto'}` : '0 0 auto'
    } else {
      styles.flex = '0 1 auto'
      styles.width = child.width || '100%'
    }

    if (child.flexGrow != null && child.flexGrow !== '') styles.flexGrow = child.flexGrow
    if (child.flexShrink != null && child.flexShrink !== '') styles.flexShrink = child.flexShrink
    if (child.flexBasis) styles.flexBasis = child.flexBasis
    if (child.alignSelf) styles.alignSelf = child.alignSelf
    if (child.order != null && child.order !== '') styles.order = child.order

    if (direction === 'row' || direction === 'row-reverse') {
      if (child.width) styles.width = child.width
      else if (!child.flex) styles.width = 'auto'
    }
  }

  if (display === 'grid' && child.gridColumn) {
    styles.gridColumn = child.gridColumn
  }

  if (child.alignCenter) {
    styles.marginLeft = 'auto'
    styles.marginRight = 'auto'
  }
  if (child.margin) styles.margin = child.margin

  return styles
}
