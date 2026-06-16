/**
 * Paleta del editor: nombres en español y agrupados por uso.
 */
export const paletteCategories = [
  {
    id: 'basic',
    label: 'Contenido básico',
    items: [
      { type: 'heading', icon: 'H', iconClass: 'text-blue-600', label: 'Título', description: 'Encabezado grande' },
      { type: 'text', icon: '¶', iconClass: 'text-slate-600', label: 'Párrafo', description: 'Texto normal' },
      { type: 'image', icon: '🖼', iconClass: 'text-green-600', label: 'Imagen', description: 'Foto o gráfico (URL)' },
      { type: 'button', icon: '▶', iconClass: 'text-indigo-600', label: 'Botón', description: 'Enlace o acción' },
      { type: 'html', icon: '</>', iconClass: 'text-amber-700', label: 'Código HTML', description: 'Incrustar HTML personalizado' },
    ],
  },
  {
    id: 'layout',
    label: 'Diseño y secciones',
    items: [
      { type: 'hero', icon: '★', iconClass: 'text-[#005674]', label: 'Banner destacado', description: 'Título, texto y botón' },
      { type: 'container', icon: '📦', iconClass: 'text-gray-700', label: 'Sección', description: 'Agrupa varios elementos' },
      { type: 'card', icon: '📋', iconClass: 'text-indigo-500', label: 'Tarjeta', description: 'Bloque con borde' },
      { type: 'carousel', icon: '🎠', iconClass: 'text-purple-600', label: 'Carrusel', description: 'Hero o galería en slides' },
      { type: 'stats-grid', icon: '#', iconClass: 'text-red-600', label: 'Cifras en tarjetas', description: 'Números con icono' },
      { type: 'process-timeline', icon: '↻', iconClass: 'text-indigo-600', label: 'Proceso paso a paso', description: 'Línea de tiempo' },
      { type: 'accordion', icon: '?', iconClass: 'text-amber-600', label: 'Acordeón FAQ', description: 'Preguntas expandibles' },
      { type: 'dual-panel', icon: '▥', iconClass: 'text-blue-700', label: 'Dos paneles', description: 'Listas lado a lado' },
      { type: 'cta-banner', icon: '▶', iconClass: 'text-red-700', label: 'Llamado a la acción', description: 'Banner con botones' },
      { type: 'video', icon: '▶', iconClass: 'text-red-500', label: 'Video', description: 'YouTube o enlace' },
      { type: 'spacer', icon: '↕', iconClass: 'text-gray-400', label: 'Espacio', description: 'Separación vertical' },
      { type: 'divider', icon: '—', iconClass: 'text-gray-500', label: 'Línea', description: 'Separador horizontal' },
    ],
  },
  {
    id: 'extra',
    label: 'Más contenido',
    items: [
      { type: 'list', icon: '•', iconClass: 'text-teal-600', label: 'Lista', description: 'Viñetas o numerada' },
      { type: 'quote', icon: '❝', iconClass: 'text-slate-500', label: 'Cita', description: 'Texto destacado' },
      { type: 'alert', icon: 'ℹ', iconClass: 'text-yellow-600', label: 'Aviso', description: 'Mensaje informativo' },
      { type: 'badge', icon: '🏷', iconClass: 'text-pink-500', label: 'Etiqueta', description: 'Texto pequeño' },
      { type: 'form', icon: '📝', iconClass: 'text-teal-500', label: 'Formulario', description: 'Contacto' },
    ],
  },
  {
    id: 'idcbis',
    label: 'Bloques IDCBIS',
    items: [
      { type: 'idcbis-hero', icon: '★', iconClass: 'text-[#0B4F6C]', label: 'Hero donación', description: 'Título, botones e imagen' },
      { type: 'idcbis-hero-carousel', icon: '⇄', iconClass: 'text-[#2C8C99]', label: 'Hero carrusel', description: 'Hero en slides' },
      { type: 'idcbis-services', icon: '▦', iconClass: 'text-[#2C8C99]', label: 'Grid servicios', description: 'Tarjetas con imagen' },
      { type: 'idcbis-service-detail', icon: '📄', iconClass: 'text-indigo-600', label: 'Detalle servicio', description: 'Página de servicio' },
      { type: 'idcbis-stats', icon: '#', iconClass: 'text-amber-500', label: 'Cifras IDCBIS', description: 'Números destacados' },
      { type: 'idcbis-bubbles', icon: '○', iconClass: 'text-teal-500', label: 'Investigación', description: 'Burbujas de programas' },
      { type: 'idcbis-about', icon: 'ℹ', iconClass: 'text-indigo-600', label: 'Sobre nosotros', description: 'Texto + imagen' },
      { type: 'idcbis-contact', icon: '✉', iconClass: 'text-[#0B4F6C]', label: 'Contacto', description: 'Sede, teléfono, mail' },
      { type: 'idcbis-faq', icon: '?', iconClass: 'text-amber-600', label: 'FAQ IDCBIS', description: 'Preguntas frecuentes' },
      { type: 'idcbis-links', icon: '🔗', iconClass: 'text-blue-600', label: 'Grid enlaces', description: 'Enlaces destacados' },
      { type: 'idcbis-highlights', icon: '✦', iconClass: 'text-purple-600', label: 'Diferenciales', description: 'Puntos destacados' },
    ],
  },
  {
    id: 'advanced',
    label: 'Avanzado',
    items: [
      { type: 'table', icon: '📊', iconClass: 'text-orange-500', label: 'Tabla', description: 'Datos en filas' },
      { type: 'navbar', icon: '🧭', iconClass: 'text-cyan-600', label: 'Menú', description: 'Barra de navegación' },
      { type: 'modal', icon: '📱', iconClass: 'text-gray-600', label: 'Ventana emergente', description: 'Modal' },
    ],
  },
]

export const paletteTypeLabels = Object.fromEntries(
  paletteCategories.flatMap((c) => c.items.map((i) => [i.type, i.label]))
)
