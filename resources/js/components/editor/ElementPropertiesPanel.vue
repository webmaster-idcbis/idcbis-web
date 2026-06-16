<template>
  <div class="props-panel">
    <div class="props-panel__header">
      <p class="props-panel__label">Tipo de elemento</p>
      <p class="props-panel__type">{{ typeLabel }}</p>
      <p v-if="breadcrumbs.length" class="props-panel__path">
        {{ breadcrumbs.join(' › ') }}
      </p>
    </div>

    <div class="props-panel__section">
      <ContainerProperties
        v-if="element.type === 'container'"
        :element="element"
        @select-child="$emit('select-child', $event)"
        @move-child="$emit('move-child', $event)"
        @remove-child="$emit('remove-child', $event)"
      />

      <CarouselProperties v-else-if="element.type === 'carousel'" :element="element" />

      <component :is="contentPanel" v-else-if="contentPanel" :element="element" />

      <p v-else class="text-xs text-gray-500 italic">
        Sin opciones de contenido para este elemento.
      </p>
    </div>

    <details v-if="element.type !== 'container'" class="props-details">
      <summary>Diseño y posición</summary>
      <div class="props-details__body">
        <LayoutProperties :element="element" :parent-container="parentContainer" />
      </div>
    </details>

    <details v-if="showVisualStyle" class="props-details">
      <summary>Estilo visual</summary>
      <div class="props-details__body">
        <VisualStyleProperties :element="element" />
      </div>
    </details>

    <slot name="actions" />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import LayoutProperties from './properties/LayoutProperties.vue'
import VisualStyleProperties from './properties/VisualStyleProperties.vue'
import ContainerProperties from './properties/ContainerProperties.vue'
import CarouselProperties from './properties/CarouselProperties.vue'
import TextContentProperties from './properties/TextContentProperties.vue'
import ButtonContentProperties from './properties/ButtonContentProperties.vue'
import ImageContentProperties from './properties/ImageContentProperties.vue'
import CardContentProperties from './properties/CardContentProperties.vue'
import AlertContentProperties from './properties/AlertContentProperties.vue'
import BadgeContentProperties from './properties/BadgeContentProperties.vue'
import FormContentProperties from './properties/FormContentProperties.vue'
import TableContentProperties from './properties/TableContentProperties.vue'
import NavbarContentProperties from './properties/NavbarContentProperties.vue'
import ModalContentProperties from './properties/ModalContentProperties.vue'
import HtmlContentProperties from './properties/HtmlContentProperties.vue'
import HeadingContentProperties from './properties/HeadingContentProperties.vue'
import HeroContentProperties from './properties/HeroContentProperties.vue'
import VideoContentProperties from './properties/VideoContentProperties.vue'
import ListContentProperties from './properties/ListContentProperties.vue'
import QuoteContentProperties from './properties/QuoteContentProperties.vue'
import SpacerContentProperties from './properties/SpacerContentProperties.vue'
import DividerContentProperties from './properties/DividerContentProperties.vue'
import StatsGridContentProperties from './properties/StatsGridContentProperties.vue'
import ProcessTimelineContentProperties from './properties/ProcessTimelineContentProperties.vue'
import AccordionContentProperties from './properties/AccordionContentProperties.vue'
import DualPanelContentProperties from './properties/DualPanelContentProperties.vue'
import CtaBannerContentProperties from './properties/CtaBannerContentProperties.vue'
import IdcbisHeroContentProperties from './properties/IdcbisHeroContentProperties.vue'
import IdcbisServicesContentProperties from './properties/IdcbisServicesContentProperties.vue'
import IdcbisStatsContentProperties from './properties/IdcbisStatsContentProperties.vue'
import IdcbisBubblesContentProperties from './properties/IdcbisBubblesContentProperties.vue'
import IdcbisAboutContentProperties from './properties/IdcbisAboutContentProperties.vue'
import IdcbisContactContentProperties from './properties/IdcbisContactContentProperties.vue'
import IdcbisHeroCarouselContentProperties from './properties/IdcbisHeroCarouselContentProperties.vue'
import IdcbisServiceDetailContentProperties from './properties/IdcbisServiceDetailContentProperties.vue'
import IdcbisFaqContentProperties from './properties/IdcbisFaqContentProperties.vue'
import IdcbisLinksGridContentProperties from './properties/IdcbisLinksGridContentProperties.vue'
import IdcbisHighlightsContentProperties from './properties/IdcbisHighlightsContentProperties.vue'
import { paletteCategories } from '../../config/pageElementPalette'

const props = defineProps({
  element: { type: Object, required: true },
  parentContainer: { type: Object, default: null },
  breadcrumbs: { type: Array, default: () => [] },
})

defineEmits(['select-child', 'move-child', 'remove-child'])

const panels = {
  text: TextContentProperties,
  heading: HeadingContentProperties,
  html: HtmlContentProperties,
  button: ButtonContentProperties,
  image: ImageContentProperties,
  hero: HeroContentProperties,
  card: CardContentProperties,
  alert: AlertContentProperties,
  badge: BadgeContentProperties,
  form: FormContentProperties,
  table: TableContentProperties,
  navbar: NavbarContentProperties,
  modal: ModalContentProperties,
  video: VideoContentProperties,
  list: ListContentProperties,
  quote: QuoteContentProperties,
  spacer: SpacerContentProperties,
  divider: DividerContentProperties,
  'stats-grid': StatsGridContentProperties,
  'process-timeline': ProcessTimelineContentProperties,
  accordion: AccordionContentProperties,
  'dual-panel': DualPanelContentProperties,
  'cta-banner': CtaBannerContentProperties,
  'idcbis-hero': IdcbisHeroContentProperties,
  'idcbis-hero-carousel': IdcbisHeroCarouselContentProperties,
  'idcbis-services': IdcbisServicesContentProperties,
  'idcbis-stats': IdcbisStatsContentProperties,
  'idcbis-bubbles': IdcbisBubblesContentProperties,
  'idcbis-about': IdcbisAboutContentProperties,
  'idcbis-contact': IdcbisContactContentProperties,
  'idcbis-service-detail': IdcbisServiceDetailContentProperties,
  'idcbis-faq': IdcbisFaqContentProperties,
  'idcbis-links': IdcbisLinksGridContentProperties,
  'idcbis-highlights': IdcbisHighlightsContentProperties,
}

const typeLabelMap = Object.fromEntries(
  paletteCategories.flatMap((c) => c.items.map((i) => [i.type, i.label]))
)

const contentPanel = computed(() => panels[props.element.type] || null)
const typeLabel = computed(() => typeLabelMap[props.element.type] || props.element.type)
const showVisualStyle = computed(() => !['spacer', 'divider'].includes(props.element.type))
</script>

<style scoped>
.props-panel {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.props-panel__header {
  padding-bottom: 0.75rem;
  border-bottom: 1px solid #e5e7eb;
}

.props-panel__label {
  font-size: 0.6875rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  color: #9ca3af;
  margin-bottom: 0.25rem;
}

.props-panel__type {
  font-size: 0.9375rem;
  font-weight: 600;
  color: #111827;
}

.props-panel__path {
  margin-top: 0.375rem;
  font-size: 0.75rem;
  color: #4f46e5;
  line-height: 1.4;
}

.props-panel__section {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.props-details {
  border-top: 1px solid #e5e7eb;
  padding-top: 0.5rem;
}

.props-details summary {
  cursor: pointer;
  font-size: 0.8125rem;
  font-weight: 600;
  color: #374151;
  list-style: none;
  user-select: none;
  padding: 0.375rem 0;
}

.props-details summary::-webkit-details-marker {
  display: none;
}

.props-details summary::before {
  content: '▸';
  display: inline-block;
  width: 0.875rem;
  font-size: 0.625rem;
  color: #9ca3af;
  transition: transform 0.15s ease;
}

.props-details[open] summary::before {
  transform: rotate(90deg);
}

.props-details__body {
  padding: 0.5rem 0 0.25rem;
}
</style>
