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
  backgroundImage: '',
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
        backgroundColor: '#C4A140',
        items: [{ value: '100', label: 'métrica', id: generateId() }],
      }
    case 'idcbis-bubbles':
      return {
        ...baseElement,
        fullBleed: true,
        sectionTitle: 'Programas de',
        sectionHighlight: 'investigación',
        cardColor: '#0B4F6C',
        items: [{ title: 'Programa', description: 'Descripción', id: generateId() }],
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
        items: [{ icon: '/img/Iconos/contacto.svg', title: 'Contacto', text: '', id: generateId() }],
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
        color: '#ffffff',
        backgroundColor: '#0b4f6c',
        highlightColor: '#C4A140',
        cardBackground: '',
        cardTextColor: '',
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
    case 'idcbis-quienes-somos':
      return {
        ...baseElement,
        fullBleed: true,
        heroTitle: 'Quiénes Somos',
        heroSubtitle: 'Ciencia, biotecnología e innovación en salud',
        heroEyebrow: 'Instituto IDCBIS',
        heroImage: '/img/Quienes-Somos-l-IDCBIS-2020.png',
        intro: ['Texto introductorio del instituto.'],
        mission: 'Misión del IDCBIS.',
        vision: 'Visión del IDCBIS.',
        purpose: 'Propósito superior.',
        principles: [{ id: generateId(), icon: '/img/Iconos/excelencia.svg', title: 'Excelencia' }],
        director: null,
        sections: [],
      }
    case 'idcbis-documents-page':
      return {
        ...baseElement,
        fullBleed: true,
        eyebrow: 'Transparencia',
        heroTitle: 'Documentos',
        heroSubtitle: 'Consulta los documentos publicados por sección.',
        intro: '',
        layout: 'sidebar',
        documentColumns: 2,
        showSearch: true,
        groups: [
          {
            id: generateId(),
            label: String(new Date().getFullYear()),
            documents: [
              { id: generateId(), title: 'Documento de ejemplo', publishedAt: '', url: '' },
            ],
          },
        ],
      }
    case 'idcbis-documents-list':
      return {
        ...baseElement,
        fullBleed: true,
        layout: 'sidebar',
        documentColumns: 1,
        showSearch: true,
        groups: [
          {
            id: generateId(),
            label: String(new Date().getFullYear()),
            documents: [
              { id: generateId(), title: 'Documento de ejemplo', publishedAt: '', url: '' },
            ],
          },
        ],
      }
    case 'idcbis-news-list':
      return {
        ...baseElement,
        fullBleed: true,
        columns: 3,
        itemsPerPage: 9,
        showSearch: true,
        showCategoryFilter: true,
        items: [
          {
            id: generateId(),
            title: 'Noticia de ejemplo',
            excerpt: 'Resumen breve de la noticia para la tarjeta del listado.',
            category: 'investigacion',
            publishedAt: '',
            image: '',
            slug: '',
          },
        ],
      }
    case 'idcbis-news-carousel':
      return {
        ...baseElement,
        fullBleed: true,
        sectionEyebrow: 'Actualidad',
        sectionTitle: 'Noticias destacadas',
        sectionSubtitle: 'Las publicaciones más recientes del IDCBIS.',
        limit: 8,
        autoPlay: true,
        interval: 4500,
        items: [
          {
            id: generateId(),
            title: 'Noticia de ejemplo',
            excerpt: 'Resumen breve para el carrusel de noticias.',
            category: 'investigacion',
            publishedAt: '',
            image: '',
            slug: '',
          },
        ],
      }
    case 'idcbis-tissue-catalog':
      return {
        ...baseElement,
        fullBleed: true,
        sectionTitle: 'Portafolio de',
        sectionHighlight: 'tejidos',
        sectionSubtitle: 'Consulte presentaciones, preservación y usos clínicos de cada tejido.',
        libraryUrl: '',
        libraryLabel: 'Abrir biblioteca digital de tejidos',
        requestEmail: 'bandetejidosycelulas@idcbis.org.co',
        pdfUrl: 'https://idcbis.org.co/media_up_idcbis/2025/08/Portafolio-Banco-de-Tejidos.pdf',
        categories: [
          { id: 'osteomuscular', label: 'Osteomuscular' },
          { id: 'ocular', label: 'Ocular' },
          { id: 'piel', label: 'Piel y dermis' },
          { id: 'membrana', label: 'Membrana amniótica' },
        ],
        items: [],
      }
    case 'idcbis-team-grid':
      return {
        ...baseElement,
        fullBleed: true,
        sectionTitle: 'Nuestro equipo',
        sectionIcon: '👥',
        members: [
          {
            id: generateId(),
            name: 'Nombre del miembro',
            role: 'Cargo',
            email: '',
            credentials: '',
            photoSlug: '',
            image: '',
          },
        ],
      }
    case 'idcbis-checklist':
      return {
        ...baseElement,
        fullBleed: true,
        anchorId: 'requisitos',
        title: '¿Puedo donar?',
        subtitle: 'Revisa si cumples los requisitos principales antes de agendar tu donación.',
        backgroundColor: '#E1F0F5',
        ctaText: 'Cumplo los requisitos, agendar',
        ctaUrl: 'tel:+5713649620',
        items: [
          { id: generateId(), text: 'Tener entre 18 y 65 años.' },
          { id: generateId(), text: 'Pesar más de 50 kg.' },
          { id: generateId(), text: 'Sentirte bien de salud el día de la donación.' },
        ],
      }
    case 'idcbis-card-grid':
      return {
        ...baseElement,
        fullBleed: true,
        title: 'Tipos de donación',
        subtitle: 'Conoce las diferentes formas en que puedes contribuir a salvar vidas.',
        backgroundColor: '#E1F0F5',
        items: [
          {
            id: generateId(),
            icon: 'Droplets',
            title: 'Sangre total',
            description: 'La donación más frecuente. Se extraen aproximadamente 450 ml.',
            duration: '7 a 10 minutos',
            frequency: 'Cada 3 a 4 meses',
          },
        ],
      }
    case 'idcbis-info-grid':
      return {
        ...baseElement,
        fullBleed: true,
        anchorId: 'ubicacion',
        title: 'Información práctica',
        subtitle: 'Horarios, dirección y canales de contacto del Banco Distrital de Sangre.',
        backgroundColor: '#E1F0F5',
        items: [
          {
            id: generateId(),
            icon: 'MapPin',
            title: 'Dirección',
            text: 'Carrera 28 #39 A - 10, Bogotá, Colombia',
            link: 'https://www.google.com/maps/search/?api=1&query=Carrera+28+%2339A-10,+Bogot%C3%A1,+Colombia',
            linkLabel: 'Cómo llegar',
          },
          {
            id: generateId(),
            icon: 'Clock',
            title: 'Horarios',
            text: 'Lunes a viernes: 7:00 a. m. - 5:00 p. m.\nSábados: 8:00 a. m. - 2:00 p. m.',
            link: '',
            linkLabel: '',
          },
          {
            id: generateId(),
            icon: 'Phone',
            title: 'Contacto',
            text: 'Teléfono: (+57) 1 364 9620\nCorreo: bancodesangre@idcbis.org.co',
            link: 'tel:+5713649620',
            linkLabel: 'Llamar ahora',
          },
        ],
      }
    case 'stats-grid':
      return {
        ...baseElement,
        fullBleed: true,
        items: [
          { id: generateId(), icon: '/img/Iconos/horario.svg', value: '15', label: 'Minutos de donación' },
          { id: generateId(), icon: '/img/Iconos/banco de sangre.svg', value: '450', label: 'ml por donación' },
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
          { id: generateId(), label: 'Agendar cita', url: '#', variant: 'primary', icon: '/img/Iconos/horario.svg' },
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
    case 'sitemap':
      return {
        ...baseElement,
        fullBleed: true,
        title: 'Mapa del sitio',
        subtitle: 'Navega por todas las secciones del sitio.',
        showHero: true,
        showNote: true,
      }
    default:
      return baseElement
  }
}
