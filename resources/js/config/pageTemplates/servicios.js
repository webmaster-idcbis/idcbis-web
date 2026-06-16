import { createElement, createSlide, generateId } from '../../utils/pageElementFactory'
import { BDS_THEME } from '../pageThemes/bdsTheme'

/** Plantilla genérica de página de servicios (editable para cualquier área) */
export const SERVICIOS_PAGE_META = {
  title: 'Nuestros Servicios',
  slug: 'servicios',
  description: 'Conoce nuestros servicios, proceso y cómo contactarnos',
  metaTitle: 'Servicios | IDCBIS',
  metaDescription: 'Información sobre servicios, requisitos, proceso y contacto.',
}

const section = (children, opts = {}) => {
  const el = createElement('container')
  Object.assign(el, {
    fullBleed: true,
    sectionBoxed: true,
    maxWidth: '1200px',
    border: 'none',
    display: 'flex',
    flexDirection: 'column',
    gap: '24px',
    padding: '6rem 2rem',
    backgroundColor: '#ffffff',
    ...opts,
    children,
  })
  return el
}

const heading = (text) => {
  const el = createElement('heading')
  Object.assign(el, { content: text, level: 'h2', variant: 'section' })
  return el
}

const subtitle = (text) => {
  const el = createElement('text')
  Object.assign(el, {
    content: text,
    textAlign: 'center',
    color: '#607d8b',
    fontSize: '1.2rem',
    margin: '2rem auto 0',
    maxWidth: '700px',
  })
  return el
}

const card = (data) => {
  const el = createElement('card')
  Object.assign(el, data)
  return el
}

const grid = (children, cols = 'repeat(auto-fit, minmax(300px, 1fr))') => {
  const el = createElement('container')
  Object.assign(el, {
    display: 'grid',
    gridTemplateColumns: cols,
    gap: '2.5rem',
    padding: '0',
    backgroundColor: 'transparent',
    border: 'none',
    minHeight: '0',
    children,
  })
  return el
}

/** Plantilla base de servicios: hero, cifras, beneficios, proceso, FAQ, contacto y CTA */
export function buildServiciosPage() {
  const hero = createElement('carousel')
  Object.assign(hero, {
    fullBleed: true,
    variant: 'hero-full',
    height: '550px',
    autoPlay: true,
    interval: 6000,
    showArrows: true,
    showIndicators: true,
    textAlign: 'left',
    verticalAlign: 'center',
    overlay: BDS_THEME.heroOverlay,
    buttonBg: BDS_THEME.buttonGradient,
    slides: [
      createSlide({
        title: 'Servicios que transforman vidas',
        description: 'Descubre cómo nuestros servicios pueden ayudarte. Información clara, accesible y pensada para ti.',
        buttonText: 'Ver requisitos',
        buttonUrl: '#requisitos',
        image: '/img/banner-sangre.jpg',
      }),
      createSlide({
        title: 'Un proceso claro y seguro',
        description: 'Te acompañamos en cada paso con un equipo profesional y protocolos de calidad.',
        buttonText: 'Conocer el proceso',
        buttonUrl: '#proceso',
        image: '/img/donantes1.png',
      }),
      createSlide({
        title: 'Tu participación hace la diferencia',
        description: 'Agenda una cita o contáctanos para más información sobre nuestros servicios.',
        buttonText: 'Contactar',
        buttonUrl: '#cta',
        image: '/img/photo-1559757148-5c350d0d3c56.png',
      }),
    ],
  })

  const stats = createElement('stats-grid')
  Object.assign(stats, {
    fullBleed: true,
    items: [
      { id: generateId(), icon: '⏱', value: '15', label: 'Minutos promedio' },
      { id: generateId(), icon: '✓', value: '100%', label: 'Atención profesional' },
      { id: generateId(), icon: '👥', value: '3', label: 'Beneficios clave' },
      { id: generateId(), icon: '📅', value: '24/7', label: 'Información disponible' },
    ],
  })

  const benefits = section([
    heading('Beneficios de nuestros servicios'),
    subtitle('Conoce las ventajas y el valor que ofrecemos a la comunidad'),
    grid([
      card({ variant: 'feature', icon: '💓', title: 'Atención de calidad', content: 'Protocolos y evaluación profesional en cada etapa del servicio.' }),
      card({ variant: 'feature', icon: '♻️', title: 'Proceso optimizado', content: 'Flujos claros y tiempos de atención pensados para tu comodidad.' }),
      card({ variant: 'feature', icon: '😊', title: 'Compromiso social', content: 'Trabajamos por el bienestar de la comunidad con transparencia y calidez.' }),
    ], 'repeat(auto-fit, minmax(320px, 1fr))'),
  ])

  const process = createElement('process-timeline')
  Object.assign(process, {
    fullBleed: true,
    backgroundColor: '#f0f4f8',
    padding: '6rem 2rem',
    title: 'Cómo funciona',
    subtitle: 'Un proceso sencillo en pocos pasos',
    steps: [
      { id: generateId(), title: 'Registro', description: 'Completa tus datos y recibe orientación inicial sobre el servicio.' },
      { id: generateId(), title: 'Evaluación', description: 'Verificamos que cumples los requisitos necesarios para continuar.' },
      { id: generateId(), title: 'Atención', description: 'Realizamos el procedimiento con equipos calificados y material adecuado.' },
      { id: generateId(), title: 'Seguimiento', description: 'Te indicamos recomendaciones y canales de contacto para dudas.' },
    ],
  })

  const serviceTypes = section([
    heading('Tipos de servicio'),
    subtitle('Opciones disponibles según tus necesidades'),
    grid([
      card({ variant: 'type', icon: '🩸', title: 'Servicio principal', content: 'Descripción del servicio principal que ofrece tu área o programa.' }),
      card({ variant: 'type', icon: '🧪', title: 'Servicio especializado', content: 'Detalle de un servicio complementario o de mayor especialización.' }),
      card({ variant: 'type', icon: '🤝', title: 'Servicio personalizado', content: 'Atención orientada a casos específicos o grupos particulares.' }),
    ]),
  ], {
    backgroundColor: 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)',
    borderRadius: '30px',
    margin: '3rem auto',
    maxWidth: '1200px',
  })

  const rightsDuties = createElement('dual-panel')
  Object.assign(rightsDuties, {
    fullBleed: true,
    title: 'Derechos y responsabilidades',
    subtitle: 'Información importante para usuarios del servicio',
    panels: [
      {
        id: generateId(),
        title: 'Tus derechos',
        icon: '🛡️',
        listStyle: 'check',
        items: [
          'Recibir información clara sobre el servicio',
          'Ser atendido con respeto y confidencialidad',
          'Conocer requisitos y tiempos del proceso',
        ],
      },
      {
        id: generateId(),
        title: 'Tus responsabilidades',
        icon: '🤝',
        listStyle: 'bullet',
        items: [
          'Proporcionar información veraz',
          'Cumplir con los requisitos del servicio',
          'Seguir las indicaciones del personal',
        ],
      },
    ],
  })

  const faq = createElement('accordion')
  Object.assign(faq, {
    fullBleed: true,
    title: 'Preguntas frecuentes',
    subtitle: 'Resolvemos las dudas más comunes',
    items: [
      {
        id: generateId(),
        question: '¿Cuáles son los requisitos?',
        answer: 'Los requisitos varían según el servicio. Consulta la sección correspondiente o contáctanos para orientación personalizada.',
      },
      {
        id: generateId(),
        question: '¿Cuánto dura el proceso?',
        answer: 'El tiempo depende del tipo de servicio. En general, el proceso está diseñado para ser ágil y seguro.',
      },
      {
        id: generateId(),
        question: '¿Cómo puedo agendar?',
        answer: 'Puedes usar el botón de contacto en esta página o comunicarte por teléfono y correo electrónico.',
      },
    ],
  })

  const location = section([
    heading('Ubicación y contacto'),
    subtitle('Visítanos o escríbenos para más información'),
    grid([
      card({
        variant: 'info',
        icon: '📍',
        title: 'Ubicación',
        content: 'IDCBIS\nCarrera 28 #39 A - 10\nBogotá, Colombia\n\nHorario: Lun-Vie 7:00 AM - 5:00 PM',
      }),
      card({
        variant: 'info',
        icon: '📞',
        title: 'Contacto',
        content: 'Teléfono: (+57) 1 3649620\nCorreo: contacto@idcbis.org.co',
      }),
    ], 'repeat(auto-fit, minmax(300px, 1fr))'),
  ])

  const cta = createElement('cta-banner')
  Object.assign(cta, {
    fullBleed: true,
    title: '¿Listo para comenzar?',
    subtitle: 'Contáctanos hoy y recibe la orientación que necesitas sobre nuestros servicios.',
    buttons: [
      { id: generateId(), label: 'Agendar cita', url: '#', variant: 'primary', icon: '📅' },
      { id: generateId(), label: 'Ver requisitos', url: '#requisitos', variant: 'outline', icon: '📥' },
      { id: generateId(), label: 'Más información', url: 'tel:3649620', variant: 'outline', icon: '❓' },
    ],
  })

  return [hero, stats, benefits, process, serviceTypes, rightsDuties, faq, location, cta]
}

/** @deprecated Usar buildServiciosPage */
export const buildBancoDeSangrePage = buildServiciosPage
/** @deprecated Usar SERVICIOS_PAGE_META */
export const BANCO_DE_SANGRE_PAGE_META = SERVICIOS_PAGE_META
