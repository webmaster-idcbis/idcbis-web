import { createElement, createIdcbisHeroSlide } from '../../utils/pageElementFactory'
import { IDCBIS_PROPOSAL_IMAGES as IMG } from '../idcbisProposalImages'

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
    fullBleed: true,
    autoPlay: true,
    interval: 5000,
    showArrows: true,
    showIndicators: true,
    slides: [
      createIdcbisHeroSlide({
        titleLight: 'Tú puedes',
        titleBold: 'salvar vidas',
        subtitle: 'Donar sangre, tejidos o cordón umbilical es fácil, rápido y necesario. La ciencia te necesita.',
        button1Text: 'Quiero donar',
        button1Url: '/servicios',
        button2Text: 'Conocer servicios',
        button2Url: '/servicios',
        image: IMG.hero,
        imageBadge: '🔬',
      }),
      createIdcbisHeroSlide({
        titleLight: 'Conoce',
        titleBold: 'nuestros servicios',
        subtitle: 'Atención especializada, innovación en salud y programas para transformar vidas.',
        button1Text: 'Ver servicios',
        button1Url: '/servicios',
        button2Text: 'Contacto',
        button2Url: '/contacto',
        image: IMG.services[0],
        imageBadge: '❤️',
      }),
      createIdcbisHeroSlide({
        titleLight: 'Somos',
        titleBold: 'IDCBIS',
        subtitle: 'Investigación, biotecnología e innovación para Bogotá y Colombia.',
        button1Text: 'El instituto',
        button1Url: '/el-instituto',
        button2Text: 'Investigación',
        button2Url: '#investigacion',
        image: IMG.about,
        imageBadge: '🔬',
      }),
    ],
  })

  const services = createElement('idcbis-services')
  Object.assign(services, {
    fullBleed: true,
    sectionTitle: 'Nuestros',
    sectionHighlight: 'servicios',
    sectionSubtitle: 'Elige el que más se adapte a ti. Todos son importantes.',
    cards: [
      { title: 'Donar sangre', description: 'Es rápida, segura y salva hasta 3 vidas. Necesitamos todos los grupos sanguíneos.', image: IMG.services[0], tag: '#DONARVIDA', url: '#' },
      { title: 'Cordón umbilical', description: 'Las células del cordón son un tesoro. Ayudan a pacientes pediátricos con enfermedades graves.', image: IMG.services[1], tag: '#FUTURO', url: '#' },
      { title: 'Tejidos', description: 'Piel, huesos, córneas... Tu donación puede devolver la vista o la movilidad a alguien.', image: IMG.services[2], tag: '#REGALAVIDA', url: '#' },
      { title: 'Terapias avanzadas', description: 'Tratamos enfermedades autoinmunes con células. Somos pioneros en Latinoamérica.', image: IMG.services[3], tag: '#INNOVACIÓN', url: '#' },
      { title: 'Registro de donantes', description: '¿Tienes sangre rara? Tu tipo puede ser clave para alguien. Inscribite.', image: IMG.services[4], tag: '#SANGREUNICA', url: '#' },
      { title: 'Bienestar', description: 'Charlas, hábitos, comunidad. Porque la salud también es prevenir.', image: IMG.services[5], tag: '#SENTIRSEBIEN', url: '#' },
    ].map((c, i) => ({ ...c, id: `card_${i}` })),
  })

  const stats = createElement('idcbis-stats')
  Object.assign(stats, {
    fullBleed: true,
    backgroundColor: '#FFD166',
    items: [
      { value: '+3.000', label: 'donaciones/año' },
      { value: '150', label: 'investigadores' },
      { value: '12', label: 'programas' },
      { value: '#1', label: 'en Bogotá' },
    ].map((it, i) => ({ ...it, id: `stat_${i}` })),
  })

  const bubbles = createElement('idcbis-bubbles')
  Object.assign(bubbles, {
    fullBleed: true,
    sectionTitle: 'Programas de',
    sectionHighlight: 'investigación',
    items: [
      { title: 'Registro Nacional', description: 'Donantes de células hematopoyéticas.', color: '#4ECDC4' },
      { title: 'Medicina Transfusional', description: 'Reconocido por MinCiencias.', color: '#2C8C99' },
      { title: 'Ingeniería Tisular', description: 'Medicina regenerativa.', color: '#0B4F6C' },
      { title: 'Medicina de Laboratorio', description: 'Estándares internacionales.', color: '#1E88E5' },
    ].map((it, i) => ({ ...it, id: `bubble_${i}` })),
  })

  const about = createElement('idcbis-about')
  Object.assign(about, {
    fullBleed: true,
    title: 'Somos IDCBIS',
    content: 'El Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud es un centro de investigación líder en Colombia, comprometido con el avance científico y la mejora de la calidad de vida de los ciudadanos. Contamos con equipamiento de última generación, talento humano de excelencia y una trayectoria reconocida por MinCiencias. Nuestro trabajo se enfoca en tres pilares fundamentales: investigación, innovación y transferencia de conocimiento.',
    image: IMG.about,
    imageAlt: 'IDCBIS',
  })

  const contact = createElement('idcbis-contact')
  Object.assign(contact, {
    fullBleed: true,
    items: [
      { icon: '📍', title: 'Sede', text: 'Carrera 32 #12-81, Bogotá' },
      { icon: '📞', title: 'Teléfono', text: '(+57) 1 3649620' },
      { icon: '📧', title: 'Mail', text: 'contacto@idcbis.org.co' },
    ].map((it, i) => ({ ...it, id: `contact_${i}` })),
  })

  return [heroCarousel, services, stats, bubbles, about, contact]
}
