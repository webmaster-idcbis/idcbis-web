export const generateId = () =>
  `element_${Date.now()}_${Math.random().toString(36).slice(2, 11)}`

export const createSlide = (overrides = {}) => ({
  id: generateId(),
  image: '',
  title: '',
  description: '',
  buttonText: '',
  buttonUrl: '',
  link: '',
  ...overrides,
})

/** Slide del carrusel hero estilo Propuesta Azul */
export const createIdcbisHeroSlide = (overrides = {}) => ({
  id: generateId(),
  titleLight: 'Tú puedes',
  titleBold: 'salvar vidas',
  subtitle: 'Donar sangre, tejidos o cordón umbilical es fácil, rápido y necesario. La ciencia te necesita.',
  button1Text: 'Quiero donar',
  button1Url: '/servicios',
  button2Text: 'Conocer servicios',
  button2Url: '/servicios',
  image: '/img/banco-distrital-de-tejidos-01.jpg',
  imageAlt: 'IDCBIS',
  imageBadge: '🔬',
  ...overrides,
})

export const createElement = (type) => {
  const baseElement = {
    id: generateId(),
    type,
    content: '',
    color: '#000000',
    fontSize: '16px',
  }

  switch (type) {
    case 'heading':
      return {
        ...baseElement,
        content: 'Título de la sección',
        level: 'h2',
        color: '#111827',
        fontWeight: '700',
        textAlign: 'left',
      }
    case 'html':
      return {
        ...baseElement,
        htmlCode: '<p style="text-align:center;color:#64748b;">Escribe tu HTML aquí</p>',
        padding: '16px',
        width: '100%',
      }
    case 'hero':
      return {
        ...baseElement,
        title: 'Bienvenido a nuestro sitio',
        subtitle: 'Un mensaje claro para tus visitantes',
        buttonText: 'Conocer más',
        buttonUrl: '#',
        level: 'h1',
        textAlign: 'center',
        minHeight: '280px',
        backgroundColor: 'linear-gradient(135deg, #005674 0%, #003d52 100%)',
      }
    case 'video':
      return {
        ...baseElement,
        videoUrl: '',
        width: '100%',
      }
    case 'list':
      return {
        ...baseElement,
        listStyle: 'bullet',
        items: ['Primer punto importante', 'Segundo punto', 'Tercer punto'],
        color: '#374151',
        fontSize: '16px',
      }
    case 'quote':
      return {
        ...baseElement,
        content: 'La mejor manera de predecir el futuro es crearlo.',
        author: '',
        backgroundColor: '#f8fafc',
      }
    case 'spacer':
      return {
        ...baseElement,
        height: '48px',
      }
    case 'divider':
      return {
        ...baseElement,
        borderStyle: '2px solid #e5e7eb',
        margin: '24px 0',
        width: '100%',
      }
    case 'text':
      return {
        ...baseElement,
        content: 'Escribe aquí el texto de tu párrafo. Puedes explicar ideas, servicios o cualquier mensaje para tus visitantes.',
        fontSize: '16px',
        color: '#374151',
        lineHeight: '1.6',
      }
    case 'image':
      return { ...baseElement, src: '/images/placeholder.jpg', alt: 'Imagen' }
    case 'button':
      return {
        ...baseElement,
        content: 'Botón',
        href: '#',
        openInNewTab: false,
        backgroundColor: '#3b82f6',
        color: '#ffffff',
        padding: '10px 20px',
        borderRadius: '6px',
        display: 'inline-block',
        width: 'auto',
        flex: '0 0 auto',
      }
    case 'card':
      return {
        ...baseElement,
        title: 'Título de la tarjeta',
        subtitle: '',
        content: 'Descripción breve del contenido.',
        image: '',
        icon: '',
        tag: '',
        href: '',
        linkLabel: 'Ver más',
        variant: '',
        titleColor: '#0b4f6c',
        titleSize: '1.25rem',
        backgroundColor: '#ffffff',
        padding: '24px',
        borderRadius: '16px',
        border: '1px solid #e5e7eb',
        boxShadow: '0 8px 24px rgba(11, 79, 108, 0.08)',
      }
    case 'alert':
      return {
        ...baseElement,
        title: '',
        content: 'Mensaje de alerta.',
        variant: 'info',
        backgroundColor: '#d1ecf1',
        color: '#0c5460',
        padding: '12px 16px',
        borderRadius: '8px',
      }
    case 'badge':
      return {
        ...baseElement,
        content: 'Nuevo',
        backgroundColor: '#007bff',
        color: '#ffffff',
        padding: '4px 8px',
        borderRadius: '12px',
        fontSize: '12px',
      }
    case 'modal':
      return {
        ...baseElement,
        title: 'Título del Modal',
        content: 'Contenido del modal.',
        size: 'medium',
        backgroundColor: '#ffffff',
        padding: '24px',
        borderRadius: '8px',
      }
    case 'form':
      return {
        ...baseElement,
        title: 'Formulario de Contacto',
        fields: [
          { name: 'nombre', label: 'Nombre', type: 'text', required: true },
          { name: 'email', label: 'Email', type: 'email', required: true },
          { name: 'mensaje', label: 'Mensaje', type: 'textarea', required: true },
        ],
        backgroundColor: '#f8f9fa',
        padding: '20px',
        borderRadius: '8px',
      }
    case 'table':
      return {
        ...baseElement,
        headers: ['Nombre', 'Email', 'Rol', 'Estado'],
        rows: [
          ['Juan Pérez', 'juan@example.com', 'Admin', 'Activo'],
          ['María García', 'maria@example.com', 'Usuario', 'Activo'],
        ],
        backgroundColor: '#ffffff',
        borderRadius: '4px',
      }
    case 'navbar':
      return {
        ...baseElement,
        brand: 'Mi Sitio',
        links: [
          { text: 'Inicio', href: '#home' },
          { text: 'Contacto', href: '#contact' },
        ],
        backgroundColor: '#343a40',
        color: '#ffffff',
        padding: '8px 16px',
      }
    case 'carousel':
      return {
        ...baseElement,
        slides: [
          createSlide({
            title: 'Título principal',
            description: 'Mensaje de impacto para la portada.',
            buttonText: 'Conocer más',
            buttonUrl: '#',
          }),
          createSlide({
            title: 'Slide 2',
            description: 'Descripción',
            buttonText: 'Ver detalles',
            buttonUrl: '#',
          }),
        ],
        autoPlay: true,
        interval: 5000,
        height: '400px',
        backgroundColor: '#f8f9fa',
        padding: '0',
        borderRadius: '8px',
        showArrows: true,
        showIndicators: true,
        textAlign: 'center',
        verticalAlign: 'flex-end',
        overlay: 'linear-gradient(transparent, rgba(0, 0, 0, 0.7))',
        contentPadding: '32px 24px 48px',
        titleSize: '2.5rem',
        descriptionSize: '1.1rem',
        descriptionMaxWidth: '720px',
      }
    case 'container':
      return {
        ...baseElement,
        children: [],
        display: 'flex',
        flexDirection: 'column',
        flexWrap: 'nowrap',
        justifyContent: 'flex-start',
        alignItems: 'stretch',
        gap: '16px',
        padding: '20px',
        backgroundColor: '#f8f9fa',
        borderRadius: '8px',
        border: '2px dashed #cbd5e1',
        minHeight: '120px',
        width: '100%',
        fullBleed: false,
        sectionBoxed: true,
        maxWidth: '1400px',
      }
    case 'idcbis-hero':
      return {
        ...baseElement,
        fullBleed: true,
        titleLight: 'Tú puedes',
        titleBold: 'salvar vidas',
        subtitle: 'Donar sangre, tejidos o cordón umbilical es fácil, rápido y necesario.',
        button1Text: 'Quiero donar',
        button1Url: '#',
        button2Text: 'Conocer servicios',
        button2Url: '#',
        heroImage: '',
        heroImageAlt: '',
      }
    case 'idcbis-services':
      return {
        ...baseElement,
        fullBleed: true,
        sectionTitle: 'Nuestros',
        sectionHighlight: 'servicios',
        sectionSubtitle: '',
        cards: [],
      }
    case 'idcbis-stats':
      return {
        ...baseElement,
        fullBleed: true,
        backgroundColor: '#FFD166',
        items: [{ value: '100', label: 'métrica', id: generateId() }],
      }
    case 'idcbis-bubbles':
      return {
        ...baseElement,
        fullBleed: true,
        sectionTitle: 'Programas de',
        sectionHighlight: 'investigación',
        items: [{ title: 'Programa', description: 'Descripción', color: '#4ECDC4', id: generateId() }],
      }
    case 'idcbis-about':
      return {
        ...baseElement,
        fullBleed: true,
        title: 'Somos IDCBIS',
        content: '',
        image: '',
        imageAlt: 'IDCBIS',
      }
    case 'idcbis-contact':
      return {
        ...baseElement,
        fullBleed: true,
        items: [{ icon: '📍', title: 'Contacto', text: '', id: generateId() }],
      }
    case 'idcbis-hero-carousel':
      return {
        ...baseElement,
        fullBleed: true,
        autoPlay: true,
        interval: 5000,
        showArrows: true,
        showIndicators: true,
        slides: [createIdcbisHeroSlide(), createIdcbisHeroSlide({ titleLight: 'Innovación', titleBold: 'en salud' })],
      }
    case 'idcbis-service-detail':
      return {
        ...baseElement,
        fullBleed: true,
        sectionTitle: 'Nuestros',
        sectionHighlight: 'servicios',
        sectionSubtitle: '',
        items: [{ id: generateId(), title: 'Servicio', summary: '', audience: '', access: '' }],
      }
    case 'idcbis-faq':
      return {
        ...baseElement,
        fullBleed: true,
        sectionTitle: 'Preguntas',
        sectionHighlight: 'frecuentes',
        items: [{ id: generateId(), question: '¿Pregunta?', answer: 'Respuesta.' }],
      }
    case 'idcbis-links':
      return {
        ...baseElement,
        fullBleed: true,
        sectionTitle: 'Recursos',
        sectionHighlight: 'y enlaces',
        sectionSubtitle: '',
        links: [{ id: generateId(), icon: '🔗', label: 'Enlace', url: '#', description: '' }],
      }
    case 'idcbis-highlights':
      return {
        ...baseElement,
        fullBleed: true,
        sectionTitle: 'Lo que nos',
        sectionHighlight: 'diferencia',
        items: [{ id: generateId(), text: 'Diferencial del área' }],
      }
    case 'stats-grid':
      return {
        ...baseElement,
        fullBleed: true,
        items: [
          { id: generateId(), icon: '⏱', value: '15', label: 'Minutos de donación' },
          { id: generateId(), icon: '🩸', value: '450', label: 'ml por donación' },
        ],
      }
    case 'process-timeline':
      return {
        ...baseElement,
        fullBleed: true,
        title: 'Cómo donar sangre',
        subtitle: 'Un proceso seguro y sencillo',
        steps: [
          { id: generateId(), title: 'Paso 1', description: 'Descripción del paso.' },
        ],
      }
    case 'accordion':
      return {
        ...baseElement,
        fullBleed: true,
        title: 'Preguntas frecuentes',
        subtitle: 'Resolvemos tus dudas',
        items: [{ id: generateId(), question: '¿Pregunta?', answer: 'Respuesta.' }],
      }
    case 'cta-banner':
      return {
        ...baseElement,
        fullBleed: true,
        title: '¿Listo para donar?',
        subtitle: 'Tu donación puede salvar vidas.',
        buttons: [
          { id: generateId(), label: 'Agendar cita', url: '#', variant: 'primary', icon: '📅' },
        ],
      }
    case 'dual-panel':
      return {
        ...baseElement,
        fullBleed: true,
        title: 'Dos columnas',
        subtitle: '',
        panels: [
          { id: generateId(), title: 'Panel A', icon: '✓', listStyle: 'check', items: ['Item 1'] },
          { id: generateId(), title: 'Panel B', icon: '•', listStyle: 'bullet', items: ['Item 1'] },
        ],
      }
    default:
      return baseElement
  }
}
