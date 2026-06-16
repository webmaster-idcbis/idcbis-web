import { markRaw } from 'vue'
import TextElement from '../components/elements/TextElement.vue'
import ImageElement from '../components/elements/ImageElement.vue'
import ButtonElement from '../components/elements/ButtonElement.vue'
import CardElement from '../components/elements/CardElement.vue'
import AlertElement from '../components/elements/AlertElement.vue'
import BadgeElement from '../components/elements/BadgeElement.vue'
import ModalElement from '../components/elements/ModalElement.vue'
import FormElement from '../components/elements/FormElement.vue'
import TableElement from '../components/elements/TableElement.vue'
import NavbarElement from '../components/elements/NavbarElement.vue'
import CarouselElement from '../components/elements/CarouselElement.vue'
import ContainerElement from '../components/elements/ContainerElement.vue'
import HtmlElement from '../components/elements/HtmlElement.vue'
import HeadingElement from '../components/elements/HeadingElement.vue'
import SpacerElement from '../components/elements/SpacerElement.vue'
import DividerElement from '../components/elements/DividerElement.vue'
import HeroBlockElement from '../components/elements/HeroBlockElement.vue'
import VideoElement from '../components/elements/VideoElement.vue'
import ListElement from '../components/elements/ListElement.vue'
import QuoteElement from '../components/elements/QuoteElement.vue'
import IdcbisHeroElement from '../components/elements/idcbis/IdcbisHeroElement.vue'
import IdcbisServicesElement from '../components/elements/idcbis/IdcbisServicesElement.vue'
import IdcbisStatsElement from '../components/elements/idcbis/IdcbisStatsElement.vue'
import IdcbisBubblesElement from '../components/elements/idcbis/IdcbisBubblesElement.vue'
import IdcbisAboutElement from '../components/elements/idcbis/IdcbisAboutElement.vue'
import IdcbisContactElement from '../components/elements/idcbis/IdcbisContactElement.vue'
import IdcbisHeroCarouselElement from '../components/elements/idcbis/IdcbisHeroCarouselElement.vue'
import IdcbisServiceDetailElement from '../components/elements/idcbis/IdcbisServiceDetailElement.vue'
import IdcbisFaqElement from '../components/elements/idcbis/IdcbisFaqElement.vue'
import IdcbisLinksGridElement from '../components/elements/idcbis/IdcbisLinksGridElement.vue'
import IdcbisHighlightsElement from '../components/elements/idcbis/IdcbisHighlightsElement.vue'
import StatsGridElement from '../components/elements/StatsGridElement.vue'
import ProcessTimelineElement from '../components/elements/ProcessTimelineElement.vue'
import AccordionElement from '../components/elements/AccordionElement.vue'
import CtaBannerElement from '../components/elements/CtaBannerElement.vue'
import DualPanelElement from '../components/elements/DualPanelElement.vue'

const elementComponents = {
  text: markRaw(TextElement),
  heading: markRaw(HeadingElement),
  html: markRaw(HtmlElement),
  image: markRaw(ImageElement),
  button: markRaw(ButtonElement),
  hero: markRaw(HeroBlockElement),
  card: markRaw(CardElement),
  alert: markRaw(AlertElement),
  badge: markRaw(BadgeElement),
  modal: markRaw(ModalElement),
  form: markRaw(FormElement),
  table: markRaw(TableElement),
  navbar: markRaw(NavbarElement),
  carousel: markRaw(CarouselElement),
  container: markRaw(ContainerElement),
  video: markRaw(VideoElement),
  list: markRaw(ListElement),
  quote: markRaw(QuoteElement),
  spacer: markRaw(SpacerElement),
  divider: markRaw(DividerElement),
  'idcbis-hero': markRaw(IdcbisHeroElement),
  'idcbis-services': markRaw(IdcbisServicesElement),
  'idcbis-stats': markRaw(IdcbisStatsElement),
  'idcbis-bubbles': markRaw(IdcbisBubblesElement),
  'idcbis-about': markRaw(IdcbisAboutElement),
  'idcbis-contact': markRaw(IdcbisContactElement),
  'idcbis-hero-carousel': markRaw(IdcbisHeroCarouselElement),
  'idcbis-service-detail': markRaw(IdcbisServiceDetailElement),
  'idcbis-faq': markRaw(IdcbisFaqElement),
  'idcbis-links': markRaw(IdcbisLinksGridElement),
  'idcbis-highlights': markRaw(IdcbisHighlightsElement),
  'stats-grid': markRaw(StatsGridElement),
  'process-timeline': markRaw(ProcessTimelineElement),
  accordion: markRaw(AccordionElement),
  'cta-banner': markRaw(CtaBannerElement),
  'dual-panel': markRaw(DualPanelElement),
}

const IDCBIS_BLOCK_TYPES = [
  'idcbis-hero',
  'idcbis-hero-carousel',
  'idcbis-services',
  'idcbis-stats',
  'idcbis-bubbles',
  'idcbis-about',
  'idcbis-contact',
  'idcbis-service-detail',
  'idcbis-faq',
  'idcbis-links',
  'idcbis-highlights',
]

export function usePageElements() {
  const getComponentType = (type) => elementComponents[type] || elementComponents.text

  const isIdcbisBlock = (type) => IDCBIS_BLOCK_TYPES.includes(type)

  return { elementComponents, getComponentType, isIdcbisBlock, IDCBIS_BLOCK_TYPES }
}
