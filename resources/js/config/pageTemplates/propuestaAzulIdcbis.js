import { createElement, createIdcbisHeroSlide } from '../../utils/pageElementFactory'
import { IDCBIS_PROPOSAL_IMAGES as IMG, IDCBIS_SERVICE_BANNERS } from '../idcbisProposalImages'
import { HOME_SERVICES } from '../homeServices'

export const PROPUESTA_AZUL_PAGE_META = {
  title: 'IDCBIS | Ciencia que te conecta con la vida',
  slug: 'inicio',
  description: 'Página de inicio — Propuesta 2 Azul',
  metaTitle: 'IDCBIS | Ciencia que te conecta con la vida',
  metaDescription: 'Donar sangre, tejidos o cordón umbilical. Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud.',
}

/** Plantilla completa según Propuesta 2 - Azul.html */
export function buildPropuestaAzulPage() {
  const heroCarousel = createElement('idcbis-hero-carousel')
  Object.assign(heroCarousel, {
    blockLabel: 'Hero principal (carrusel)',
    fullBleed: true,
    autoPlay: false,
    interval: 7000,
    showArrows: false,
    showIndicators: false,
    backgroundImage: '',
    videoSrc: '',
    videoPoster: IDCBIS_SERVICE_BANNERS.sangre,
    videoLabel: 'Secuencia del IDCBIS: de la donación al laboratorio y a la vida',
    frameInterval: 4500,
    visualFrames: [
      { src: IDCBIS_SERVICE_BANNERS.sangre, alt: 'Profesional del Banco Distrital de Sangre procesando un componente sanguíneo' },
      { src: IDCBIS_SERVICE_BANNERS.terapias, alt: 'Científica del IDCBIS en el laboratorio de terapias avanzadas' },
      { src: IDCBIS_SERVICE_BANNERS.donantes, alt: 'Manos sosteniendo una célula, la ciencia al servicio de la vida' },
    ],
    quickAnswers: [
      { id: 'qa_que_es', icon: 'institute', question: '¿Qué es IDCBIS?', answer: 'Un Instituto de ciencia, biotecnología e innovación en salud.' },
      { id: 'qa_que_hacemos', icon: 'science', question: '¿Qué hacemos?', answer: 'Convertimos ciencia e innovación en soluciones para la salud y la vida.' },
      { id: 'qa_que_puedes', icon: 'action', question: '¿Qué puedes hacer aquí?', answer: 'Donar, registrarme, conocer servicios, investigar, estudiar o generar alianzas.' },
    ],
    slides: [
      createIdcbisHeroSlide({
        id: 'slide_inicio_home',
        titleLight: 'Ciencia que',
        titleBold: 'transforma vidas',
        subtitle: 'En el IDCBIS convertimos ciencia, innovación y capacidades especializadas en soluciones para la salud y la vida de los colombianos.',
        button1Text: 'Quiero donar sangre',
        button1Url: HOME_SERVICES[0].href,
        button2Text: 'Registrarme en DarCélulas',
        button2Url: HOME_SERVICES[4].href,
        button3Text: 'Conocer nuestros servicios',
        button3Url: '#servicios',
        image: '',
        imageAlt: '',
        imageBadge: '',
        backgroundImage: '',
      }),
    ],
  })

  const services = createElement('idcbis-services')
  Object.assign(services, {
    blockLabel: 'Grid de servicios',
    fullBleed: true,
    sectionAnchor: 'servicios',
    sectionTitle: 'Nuestros',
    sectionHighlight: 'servicios',
    sectionSubtitle: 'Elige el que más se adapte a ti. Todos son importantes.',
    cards: [
      { title: 'Banco Distrital de Sangre', description: 'Es rápida, segura y salva hasta 3 vidas. Necesitamos todos los grupos sanguíneos.', image: IMG.services[0], tag: '#DONARVIDA', url: HOME_SERVICES[0].href },
      { title: 'Sangre de Cordón umbilical', description: 'Las células del cordón son un tesoro. Ayudan a pacientes pediátricos con enfermedades graves.', image: IMG.services[1], tag: '#FUTURO', url: HOME_SERVICES[1].href },
      { title: 'Banco Distrital de Tejidos', description: 'Piel, huesos, córneas... Tu donación puede devolver la vista o la movilidad a alguien.', image: IMG.services[2], tag: '#REGALAVIDA', url: HOME_SERVICES[2].href },
      { title: 'Terapias avanzadas', description: 'Tratamos enfermedades autoinmunes con células. Somos pioneros en Latinoamérica.', image: IMG.services[3], tag: '#INNOVACIÓN', url: HOME_SERVICES[3].href },
      { title: 'Registro Nacional de donantes', description: '¿Tienes sangre rara? Tu tipo puede ser clave para alguien. Inscribite.', image: IMG.services[4], tag: '#SANGREUNICA', url: HOME_SERVICES[4].href },
      { title: 'Bienestar', description: 'Charlas, hábitos, comunidad. Porque la salud también es prevenir.', image: IMG.services[5], tag: '#SENTIRSEBIEN', url: HOME_SERVICES[5].href },
    ].map((c, i) => ({ ...c, id: HOME_SERVICES[i]?.id || `card_${i}` })),
  })

  const stats = createElement('idcbis-stats')
  Object.assign(stats, {
    blockLabel: 'Cifras destacadas',
    fullBleed: true,
    backgroundColor: '#C4A140',
    items: [
      { id: 'stat_sangre', icon: 'droplet', value: '+3.000', label: 'donaciones al año', caption: 'Cada gota cuenta.' },
      { id: 'stat_investigadores', icon: 'users', value: '150', label: 'investigadores trabajando por la salud de Colombia', caption: 'Ciencia con propósito.' },
      { id: 'stat_bogota', icon: 'award', value: '#1', label: 'en Bogotá', caption: 'Reconocimiento que nos compromete.' },
    ],
  })

  const bubbles = createElement('idcbis-bubbles')
  Object.assign(bubbles, {
    blockLabel: 'Programas de investigación',
    fullBleed: true,
    sectionTitle: 'Programas de',
    sectionHighlight: 'investigación',
    cardColor: '#0B4F6C',
    items: [
      { title: 'Registro Nacional', description: 'Donantes de células hematopoyéticas.' },
      { title: 'Medicina Transfusional', description: 'Reconocido por MinCiencias.' },
      { title: 'Ingeniería Tisular', description: 'Medicina regenerativa.' },
      { title: 'Medicina de Laboratorio', description: 'Estándares internacionales.' },
    ].map((it, i) => ({ ...it, id: `bubble_${i}` })),
  })

  const about = createElement('idcbis-about')
  Object.assign(about, {
    blockLabel: 'Somos IDCBIS',
    fullBleed: true,
    title: 'Somos IDCBIS',
    content: 'En el IDCBIS, la ciencia no se queda en el laboratorio. Cada día, un equipo de 150 investigadores trabaja para convertir descubrimientos científicos en soluciones reales para los colombianos.\n\nDesde un banco de sangre hasta una terapia CAR-T, nuestro trabajo tiene un solo propósito: mejorar la vida de las personas.\n\nSomos un Instituto Distrital reconocido por MinCiencias, pero sobre todo, somos las personas detrás de cada avance.',
    quote: 'Trabajo aquí porque cada muestra que procesamos puede salvar una vida.',
    quoteAuthor: '',
    quoteRole: '',
    buttonText: 'Conoce a nuestro equipo',
    buttonUrl: '/quienes-somos#equipo',
    variant: 'clean',
    image: '/img/Servicios%20Home/BS-B-1200x800.png',
    imageAlt: 'Equipo de aféresis y componentes sanguíneos del Banco Distrital de Sangre',
  })

  const portalBogota = createElement('html')
  Object.assign(portalBogota, {
    blockLabel: 'Qué está pasando en Bogotá',
    fullBleed: true,
    padding: '2.5rem 0',
    width: '100%',
    htmlCode: '<section id="portal-bogota-block" data-cat="Salud"></section><script src="https://bogota.gov.co/2025/queestapasando/main-block.js"></script>',
  })

  const contact = createElement('idcbis-contact')
  Object.assign(contact, {
    blockLabel: 'Contacto',
    fullBleed: true,
    items: [
      { icon: '📍', title: 'Sede', text: 'Carrera 32 #12-81, Bogotá' },
      { icon: '📞', title: 'Teléfono', text: '(+57) 1 3649620' },
      { icon: '📧', title: 'Mail', text: 'contacto@idcbis.org.co' },
    ].map((it, i) => ({ ...it, id: `contact_${i}` })),
  })

  const audiences = createElement('idcbis-audiences')
  Object.assign(audiences, {
    blockLabel: 'Accesos según tu perfil',
    fullBleed: true,
    sectionTitle: 'Encuentra lo que necesitas según tu perfil',
    sectionSubtitle: 'Cada persona tiene una razón para visitarnos. Te ayudamos a llegar más rápido.',
    cards: [
      { id: 'audience_ciudadano', icon: 'users', title: 'Soy Ciudadano', description: 'Información, campañas, participación y contacto.', url: '/participa', linkText: 'Ir a mi sección' },
      { id: 'audience_donante', icon: 'droplet', title: 'Soy Donante', description: 'Donación de sangre, tejidos y registro en DarCélulas.', url: '/banco-de-sangre', linkText: 'Ir a mi sección' },
      { id: 'audience_paciente', icon: 'patient', title: 'Soy Paciente o Familiar', description: 'Servicios, orientación y contactos.', url: '/atencion-a-usuarios', linkText: 'Ir a mi sección' },
      { id: 'audience_profesional', icon: 'stethoscope', title: 'Soy Profesional de la Salud', description: 'Servicios especializados, investigación y contacto.', url: '/unidad-de-terapias-avanzadas', linkText: 'Ir a mi sección' },
      { id: 'audience_investigador', icon: 'flask', title: 'Soy Investigador', description: 'Proyectos, grupos, publicaciones y alianzas.', url: '/investigacion', linkText: 'Ir a mi sección' },
      { id: 'audience_estudiante', icon: 'student', title: 'Soy Estudiante', description: 'Prácticas, investigación, convocatorias y contacto.', url: '/contacto', linkText: 'Ir a mi sección' },
      { id: 'audience_aliado', icon: 'handshake', title: 'Soy Aliado', description: 'Cooperación, alianzas y posibilidades de apoyo.', url: '/contacto', linkText: 'Ir a mi sección' },
      { id: 'audience_periodista', icon: 'news', title: 'Soy Periodista', description: 'Noticias, voceros y contacto de Comunicaciones.', url: '/noticias', linkText: 'Ir a mi sección' },
      { id: 'audience_proveedor', icon: 'briefcase', title: 'Soy Proveedor', description: 'Contratación y procesos correspondientes.', url: '/contratacion', linkText: 'Ir a mi sección' },
    ],
  })

  return [heroCarousel, services, audiences, stats, bubbles, about, portalBogota, contact]
}
