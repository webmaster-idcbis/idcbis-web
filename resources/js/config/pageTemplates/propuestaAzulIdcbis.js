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
    autoPlay: true,
    interval: 7000,
    showArrows: true,
    showIndicators: true,
    backgroundImage: IDCBIS_SERVICE_BANNERS.home,
    slides: [
      createIdcbisHeroSlide({
        id: 'slide_inicio_home',
        titleLight: 'Tú puedes',
        titleBold: 'salvar vidas',
        subtitle: 'Donar sangre, tejidos o cordón umbilical es fácil, rápido y necesario. La ciencia te necesita.',
        button1Text: 'Quiero donar',
        button1Url: '/servicios',
        button2Text: 'Conocer servicios',
        button2Url: '/servicios',
        image: '',
        imageAlt: '',
        imageBadge: '',
        backgroundImage: IDCBIS_SERVICE_BANNERS.home,
      }),
      createIdcbisHeroSlide({
        id: 'slide_inicio_cordon',
        titleLight: 'Sangre de cordón',
        titleBold: 'umbilical',
        subtitle: 'El IDCBIS opera el primer banco público de sangre de cordón umbilical de Colombia. Recolectamos, procesamos y destinamos células progenitoras hematopoyéticas a pacientes que requieren un trasplante.',
        button1Text: 'Quiero donar',
        button1Url: HOME_SERVICES[1].href,
        button2Text: 'Conocer el banco',
        button2Url: `${HOME_SERVICES[1].href}#donacion`,
        image: '',
        imageAlt: '',
        imageBadge: '',
        backgroundImage: IDCBIS_SERVICE_BANNERS.cordon,
      }),
      createIdcbisHeroSlide({
        id: 'slide_inicio_tejidos',
        titleLight: 'Banco Distrital',
        titleBold: 'de tejidos',
        subtitle: 'Primer banco multitejidos de Colombia y referente para América Latina. Seleccionamos, procesamos y preservamos tejidos humanos con fines terapéuticos, con calidad, seguridad y trazabilidad.',
        button1Text: 'Quiero ser donante',
        button1Url: HOME_SERVICES[2].href,
        button2Text: 'Ver portafolio',
        button2Url: `${HOME_SERVICES[2].href}#portafolio`,
        image: '',
        imageAlt: '',
        imageBadge: '',
        backgroundImage: IDCBIS_SERVICE_BANNERS.tejidos,
      }),
      createIdcbisHeroSlide({
        id: 'slide_inicio_sangre',
        titleLight: 'Banco Distrital',
        titleBold: 'de sangre',
        subtitle: 'Garantizamos componentes sanguíneos seguros para la red hospitalaria de Bogotá. Una donación voluntaria puede beneficiar a hasta tres pacientes.',
        button1Text: 'Quiero donar',
        button1Url: HOME_SERVICES[0].href,
        button2Text: 'Verificar requisitos',
        button2Url: `${HOME_SERVICES[0].href}#requisitos`,
        image: '',
        imageAlt: '',
        imageBadge: '',
        backgroundImage: IDCBIS_SERVICE_BANNERS.sangre,
      }),
      createIdcbisHeroSlide({
        id: 'slide_inicio_terapias',
        titleLight: 'Unidad de',
        titleBold: 'terapias avanzadas',
        subtitle: 'Investigamos y desarrollamos terapia celular, terapia génica e ingeniería tisular para avanzar en la medicina regenerativa en el país.',
        button1Text: 'Conocer la unidad',
        button1Url: HOME_SERVICES[3].href,
        button2Text: 'Contáctenos',
        button2Url: '/contacto',
        image: '',
        imageAlt: '',
        imageBadge: '',
        backgroundImage: IDCBIS_SERVICE_BANNERS.terapias,
      }),
      createIdcbisHeroSlide({
        id: 'slide_inicio_donantes',
        titleLight: 'DarCélulas',
        titleBold: 'registro de donantes',
        subtitle: 'Único registro nacional de donantes de células formadoras de la sangre, articulado con redes internacionales. Su inscripción puede hacer posible un trasplante.',
        button1Text: 'Quiero inscribirme',
        button1Url: HOME_SERVICES[4].href,
        button2Text: 'Conocer DarCélulas',
        button2Url: `${HOME_SERVICES[4].href}#inscripcion`,
        image: '',
        imageAlt: '',
        imageBadge: '',
        backgroundImage: IDCBIS_SERVICE_BANNERS.donantes,
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
      { value: '+3.000', label: 'donaciones/año' },
      { value: '150', label: 'investigadores' },
      { value: '12', label: 'programas' },
      { value: '#1', label: 'en Bogotá' },
    ].map((it, i) => ({ ...it, id: `stat_${i}` })),
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
    content: 'El Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud es un centro de investigación líder en Colombia, comprometido con el avance científico y la mejora de la calidad de vida de los ciudadanos. Contamos con equipamiento de última generación, talento humano de excelencia y una trayectoria reconocida por MinCiencias. Nuestro trabajo se enfoca en tres pilares fundamentales: investigación, innovación y transferencia de conocimiento.',
    image: IMG.about,
    imageAlt: 'IDCBIS',
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

  return [heroCarousel, services, stats, bubbles, about, contact]
}
