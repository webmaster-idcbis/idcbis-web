<template>
  <div class="qs-page" @click.stop="onPageClick">
    <!-- Hero -->
    <header
      class="qs-hero"
      :class="partClasses('hero')"
      :style="heroStyle"
      @click.stop="focusPart('hero', element.heroTitle || 'Encabezado')"
    >
      <div class="qs-hero__overlay">
        <p class="qs-hero__eyebrow">{{ element.heroEyebrow || 'Instituto IDCBIS' }}</p>
        <h1>{{ element.heroTitle || 'Quiénes Somos' }}</h1>
        <p v-if="element.heroSubtitle" class="qs-hero__subtitle">{{ element.heroSubtitle }}</p>
      </div>
    </header>

    <!-- Intro -->
    <section class="qs-section qs-section--white">
      <div class="qs-container qs-container--narrow">
        <p
          v-for="(para, i) in introParagraphs"
          :key="i"
          class="qs-intro"
          :class="partClasses(buildIntroFocusAnchor(i))"
          @click.stop="focusPart(buildIntroFocusAnchor(i), `Párrafo ${i + 1}`)"
        >{{ para }}</p>
      </div>
    </section>

    <!-- Misión / Visión -->
    <section class="qs-section qs-section--muted">
      <div class="qs-container qs-mv-grid">
        <article
          class="qs-mv-card"
          :class="partClasses('mission')"
          @click.stop="focusPart('mission', 'Misión')"
        >
          <ContentIcon value="/img/Iconos/mision.svg" class="qs-mv-card__icon" />
          <h2>{{ t('about.mission') }}</h2>
          <p>{{ element.mission }}</p>
        </article>
        <article
          class="qs-mv-card"
          :class="partClasses('vision')"
          @click.stop="focusPart('vision', 'Visión 2030')"
        >
          <ContentIcon value="/img/Iconos/vision.svg" class="qs-mv-card__icon" />
          <h2>{{ t('about.vision') }}</h2>
          <p>{{ element.vision }}</p>
        </article>
      </div>
    </section>

    <!-- Propósito -->
    <section
      class="qs-purpose"
      :class="partClasses('purpose')"
      @click.stop="focusPart('purpose', 'Propósito superior')"
    >
      <div class="qs-container">
        <h2>{{ t('about.purpose') }}</h2>
        <p>{{ element.purpose }}</p>
      </div>
    </section>

    <!-- Principios rectores — imagen con transición al texto -->
    <section class="qs-section qs-section--white">
      <div class="qs-container">
        <h2 class="qs-section-title">{{ t('about.principles') }}</h2>
        <ul class="qs-principles">
          <li
            v-for="(item, index) in principles"
            :key="item.id || index"
            class="qs-principle"
            :class="partClasses(buildPrincipleFocusAnchor(item.id || index))"
            @click.stop="focusPart(buildPrincipleFocusAnchor(item.id || index), item.title)"
          >
            <img
              v-if="item.image"
              :src="item.image"
              :alt="item.imageAlt || item.title"
              class="qs-principle__photo"
              loading="lazy"
              width="480"
              height="640"
            >
            <div v-else class="qs-principle__fallback" aria-hidden="true" />
            <div class="qs-principle__scrim" aria-hidden="true" />
            <div class="qs-principle__content">
              <span class="qs-principle__label">{{ item.title }}</span>
            </div>
          </li>
        </ul>
      </div>
    </section>

    <!-- Director -->
    <section v-if="director" class="qs-section qs-section--muted">
      <div class="qs-container">
        <article
          class="qs-director"
          :class="partClasses('director')"
          @click.stop="focusPart('director', director.name)"
        >
          <div class="qs-director__photo-wrap">
            <img
              :src="photoSrc(director)"
              :alt="director.name"
              class="qs-director__photo"
              @error="onPhotoError($event, director)"
            >
          </div>
          <div class="qs-director__body">
            <p class="qs-director__role">{{ director.role }}</p>
            <h2 class="qs-director__name">{{ director.name }}</h2>
            <p v-if="director.credentials" class="qs-director__credentials">{{ director.credentials }}</p>
            <p class="qs-director__bio">{{ director.bio }}</p>
            <a
              v-if="director.email && preview"
              :href="`mailto:${director.email}`"
              class="qs-director__email"
              @click.stop
            >{{ director.email }}</a>
            <span v-else-if="director.email" class="qs-director__email">{{ director.email }}</span>
          </div>
        </article>
      </div>
    </section>

    <!-- Secciones plegables -->
    <section class="qs-section qs-section--white qs-accordion-wrap">
      <div class="qs-container">
        <h2 class="qs-section-title">{{ t('about.moreInfo') }}</h2>
        <div class="qs-accordion">
          <div
            v-for="(section, index) in sections"
            :key="section.id || index"
            class="qs-accordion__item"
            :class="{ 'qs-accordion__item--open': openIndex === index }"
          >
            <button
              type="button"
              class="qs-accordion__trigger"
              :class="partClasses(buildSectionFocusAnchor(section.id || index))"
              :aria-expanded="openIndex === index"
              @click.stop="onSectionTrigger(index, section)"
            >
              <ContentIcon :value="sectionIcon(section)" class="qs-accordion__trigger-icon" />
              <span class="qs-accordion__trigger-text">{{ section.title }}</span>
              <ChevronDown class="qs-accordion__chevron" aria-hidden="true" />
            </button>
            <div class="qs-accordion__panel" :aria-hidden="openIndex !== index">
              <div class="qs-accordion__panel-inner">
                <!-- Organigrama -->
                <figure v-if="section.layout === 'organigrama'" class="qs-orgchart">
                  <p v-if="section.description" class="qs-orgchart__desc">{{ section.description }}</p>
                  <button
                    v-if="section.image"
                    type="button"
                    class="qs-orgchart__media"
                    :aria-label="t('about.enlarge', { title: section.title || t('about.orgChart') })"
                    @click.stop="onOrgChartClick(section)"
                  >
                    <img
                      :src="section.image"
                      :alt="section.imageAlt || section.title || t('about.orgChartAlt')"
                      class="qs-orgchart__image"
                      loading="lazy"
                      width="1364"
                      height="1216"
                    >
                  </button>
                  <figcaption v-if="section.caption" class="qs-orgchart__caption">{{ section.caption }}</figcaption>
                </figure>

                <!-- Lista de funciones -->
                <ul v-else-if="section.layout === 'list'" class="qs-list">
                  <li v-for="(line, i) in section.items" :key="i">{{ line }}</li>
                </ul>

                <!-- Miembros fundadores -->
                <ul v-else-if="section.layout === 'founders'" class="qs-founders">
                  <li
                    v-for="(item, i) in section.items"
                    :key="founderMeta(item).name + i"
                    class="qs-founder"
                  >
                    <component
                      :is="preview && founderMeta(item).url ? 'a' : 'div'"
                      :href="preview && founderMeta(item).url ? founderMeta(item).url : undefined"
                      :target="preview && founderMeta(item).url ? '_blank' : undefined"
                      :rel="preview && founderMeta(item).url ? 'noopener noreferrer' : undefined"
                      class="qs-founder__card"
                      :aria-label="founderMeta(item).url
                        ? t('about.visitSite', { name: founderMeta(item).name })
                        : undefined"
                      @click.stop
                    >
                      <span
                        class="qs-founder__logo-wrap"
                        :class="{ 'qs-founder__logo-wrap--dark': founderMeta(item).logoOnDark }"
                      >
                        <img
                          v-if="founderMeta(item).logo"
                          :src="founderMeta(item).logo"
                          :alt="t('about.logoOf', { name: founderMeta(item).name })"
                          class="qs-founder__logo"
                          loading="lazy"
                          @error="onFounderLogoError"
                        >
                        <span v-else class="qs-founder__logo-fallback" aria-hidden="true">
                          {{ founderInitials(founderMeta(item).name) }}
                        </span>
                      </span>
                      <span class="qs-founder__name">{{ founderMeta(item).name }}</span>
                    </component>
                  </li>
                </ul>

                <!-- Equipo con fotos -->
                <div v-else-if="section.layout === 'team'" class="qs-team-grid">
                  <article
                    v-for="(member, mi) in section.members"
                    :key="member.id || mi"
                    class="qs-team-card"
                    :class="partClasses(buildTeamFocusAnchor(member.id || mi))"
                    @click.stop="focusTeamMember(member, section, index)"
                  >
                    <div class="qs-team-card__photo-wrap">
                      <img
                        :src="photoSrc(member)"
                        :alt="member.name"
                        class="qs-team-card__photo"
                        loading="lazy"
                        @error="onPhotoError($event, member)"
                      >
                    </div>
                    <div class="qs-team-card__body">
                      <h3>{{ member.name }}</h3>
                      <p class="qs-team-card__role">{{ member.role }}</p>
                      <p v-if="member.credentials" class="qs-team-card__credentials">{{ member.credentials }}</p>
                      <a
                        v-if="member.email && preview"
                        :href="`mailto:${member.email}`"
                        class="qs-team-card__email"
                        @click.stop
                      >{{ member.email }}</a>
                      <span v-else-if="member.email" class="qs-team-card__email">{{ member.email }}</span>
                    </div>
                  </article>
                </div>

                <!-- Políticas -->
                <ul v-else-if="section.layout === 'policies'" class="qs-policies">
                  <li v-for="(pol, pi) in section.items" :key="pi">
                    <component
                      :is="preview && pol.url ? 'a' : 'div'"
                      :href="preview && pol.url ? pol.url : undefined"
                      class="qs-policy-card"
                      :target="preview && pol.url?.startsWith('http') ? '_blank' : undefined"
                    >
                      <ContentIcon :value="pol.icon || '📋'" class="qs-policy-card__icon" />
                      <div>
                        <strong>{{ pol.title }}</strong>
                        <p v-if="pol.description">{{ pol.description }}</p>
                      </div>
                    </component>
                  </li>
                </ul>

                <!-- Contacto / horarios -->
                <div v-else-if="section.layout === 'contact'" class="qs-contact-grid">
                  <div v-for="(block, ci) in section.items" :key="ci" class="qs-contact-card">
                    <h3>{{ block.title }}</h3>
                    <p>{{ block.text }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <Teleport to="body">
      <div
        v-if="orgChartOpen && orgChartActive"
        class="qs-orgchart-lightbox"
        role="dialog"
        aria-modal="true"
        :aria-label="orgChartActive.title || t('about.orgChart')"
        @click.self="closeOrgChart"
      >
        <div class="qs-orgchart-lightbox__bar">
          <button type="button" class="qs-orgchart-lightbox__btn" @click="zoomOrgChart(-0.2)">−</button>
          <button type="button" class="qs-orgchart-lightbox__btn" @click="zoomOrgChart(0.2)">+</button>
          <button type="button" class="qs-orgchart-lightbox__btn qs-orgchart-lightbox__btn--close" @click="closeOrgChart">
            {{ t('about.close') }}
          </button>
        </div>
        <div class="qs-orgchart-lightbox__stage">
          <img
            :src="orgChartActive.image"
            :alt="orgChartActive.imageAlt || orgChartActive.title || t('about.orgChartAlt')"
            class="qs-orgchart-lightbox__image"
            :style="{ transform: `scale(${orgChartZoom})` }"
          >
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue'
import { ChevronDown } from 'lucide-vue-next'
import { useI18n } from '../../../i18n'
import { teamPhotoUrl, avatarFallbackUrl } from '../../../config/idcbisTeamPhotos'
import ContentIcon from '../ContentIcon.vue'
import {
  buildIntroFocusAnchor,
  buildPrincipleFocusAnchor,
  buildSectionFocusAnchor,
  buildTeamFocusAnchor,
} from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

const emit = defineEmits(['click', 'focus-part'])
const { t } = useI18n()

const openIndex = ref(props.preview ? 0 : -1)
const orgChartOpen = ref(false)
const orgChartZoom = ref(1)
const orgChartActive = ref(null)

const introParagraphs = computed(() => props.element.intro || [])
const principles = computed(() => props.element.principles || [])
const director = computed(() => props.element.director || null)
const sections = computed(() => props.element.sections || [])

const onOrgChartClick = (section) => {
  if (!props.preview) return
  openOrgChart(section)
}

const openOrgChart = (section) => {
  if (!section?.image) return
  orgChartActive.value = section
  orgChartZoom.value = 1
  orgChartOpen.value = true
  document.body.style.overflow = 'hidden'
}

const closeOrgChart = () => {
  orgChartOpen.value = false
  orgChartActive.value = null
  orgChartZoom.value = 1
  document.body.style.overflow = ''
}

const zoomOrgChart = (delta) => {
  orgChartZoom.value = Math.min(2.5, Math.max(0.6, Number((orgChartZoom.value + delta).toFixed(2))))
}

const onOrgChartKeydown = (event) => {
  if (!orgChartOpen.value) return
  if (event.key === 'Escape') closeOrgChart()
  if (event.key === '+' || event.key === '=') zoomOrgChart(0.2)
  if (event.key === '-') zoomOrgChart(-0.2)
}

onMounted(() => window.addEventListener('keydown', onOrgChartKeydown))
onBeforeUnmount(() => {
  window.removeEventListener('keydown', onOrgChartKeydown)
  document.body.style.overflow = ''
})

const sectionIcons = {
  organigrama: '/img/Iconos/organigrama.svg',
  list: '/img/Iconos/Funciones IDCBIS.svg',
  founders: '/img/Iconos/miembros fundadores.svg',
  team: '/img/Iconos/gestores lideres.svg',
  policies: '/img/Iconos/politicas y lineamientos.svg',
  contact: '/img/Iconos/horario y contacto.svg',
}

const sectionIcon = (section) => sectionIcons[section.layout] || section.icon || '📄'

const founderMeta = (item) => {
  if (typeof item === 'string') {
    return { name: item, logo: '', url: '', logoOnDark: false }
  }
  return {
    name: item?.name || '',
    logo: item?.logo || '',
    url: item?.url || '',
    logoOnDark: Boolean(item?.logoOnDark),
  }
}

const founderInitials = (name) => {
  const words = String(name || '').split(/\s+/).filter(Boolean)
  if (!words.length) return '·'
  return words.slice(0, 2).map((w) => w[0]).join('').toUpperCase()
}

const onFounderLogoError = (event) => {
  const img = event.target
  if (!img) return
  img.style.display = 'none'
  const wrap = img.parentElement
  if (wrap && !wrap.querySelector('.qs-founder__logo-fallback')) {
    const fallback = document.createElement('span')
    fallback.className = 'qs-founder__logo-fallback'
    fallback.setAttribute('aria-hidden', 'true')
    fallback.textContent = '·'
    wrap.appendChild(fallback)
  }
}

const partClasses = (anchor) => {
  if (props.preview) return {}
  return {
    'editor-part-target': true,
    'editor-part-target--active': props.focusedPart === anchor,
  }
}

const focusPart = (anchor, label = '') => {
  if (props.preview) return
  emit('focus-part', { anchor, label })
}

const onPageClick = () => {
  if (!props.preview) emit('click', props.element)
}

const focusTeamMember = (member, section, sectionIndex) => {
  if (props.preview) return
  openIndex.value = sectionIndex
  focusPart(buildTeamFocusAnchor(member.id), member.name || 'Miembro del equipo')
}

const onSectionTrigger = (index, section) => {
  toggle(index)
  if (!props.preview) {
    focusPart(buildSectionFocusAnchor(section.id), section.title || 'Sección')
  }
}

watch(() => props.focusedPart, (anchor) => {
  if (!anchor || props.preview) return

  if (anchor.startsWith('team:')) {
    const memberId = anchor.slice(5)
    const idx = sections.value.findIndex(
      (s) => s.layout === 'team' && s.members?.some((m) => m.id === memberId),
    )
    if (idx >= 0) openIndex.value = idx
    return
  }

  if (anchor.startsWith('section:')) {
    const sectionId = anchor.slice(8)
    const idx = sections.value.findIndex((s) => s.id === sectionId)
    if (idx >= 0) openIndex.value = idx
  }
})

const heroStyle = computed(() => {
  const img = props.element.heroImage
  if (!img) {
    return { background: 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)' }
  }
  return {
    backgroundImage: `linear-gradient(rgba(11, 79, 108, 0.82), rgba(44, 140, 153, 0.75)), url(${img})`,
    backgroundSize: 'cover',
    backgroundPosition: 'center',
  }
})

const photoSrc = (person) => teamPhotoUrl(person)

const onPhotoError = (event, person) => {
  const img = event.target
  if (img.dataset.fallbackApplied) return
  img.dataset.fallbackApplied = '1'
  img.src = avatarFallbackUrl(person.name)
}

const toggle = (index) => {
  openIndex.value = openIndex.value === index ? -1 : index
}
</script>

<style scoped>
.qs-page {
  font-family: var(--font-idcbis);
  color: #1e293b;
  cursor: pointer;
}

.qs-hero {
  min-height: 380px;
  display: flex;
  align-items: flex-end;
  padding: 4rem 1.5rem 3rem;
}

.qs-hero__overlay {
  max-width: 900px;
  margin: 0 auto;
  width: 100%;
  color: #fff;
}

.qs-hero__eyebrow {
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  opacity: 0.85;
  margin-bottom: 0.5rem;
}

.qs-hero h1 {
  font-size: clamp(2rem, 5vw, 3rem);
  font-weight: 800;
  line-height: 1.15;
  margin: 0 0 0.75rem;
}

.qs-hero__subtitle {
  font-size: 1.125rem;
  opacity: 0.92;
  max-width: 36rem;
  line-height: 1.5;
  margin: 0;
}

.qs-section {
  padding: 4rem 1.5rem;
}

.qs-section--white {
  background: #fff;
}

.qs-section--muted {
  background: #f0f5f8;
}

.qs-container {
  max-width: 1140px;
  margin: 0 auto;
}

.qs-container--narrow {
  max-width: 820px;
}

.qs-section-title {
  text-align: center;
  font-size: clamp(1.5rem, 3vw, 2rem);
  font-weight: 800;
  color: #0b4f6c;
  margin: 0 0 2.5rem;
}

.qs-intro {
  font-size: 1.0625rem;
  line-height: 1.8;
  color: #475569;
  text-align: center;
  margin: 0 0 1.25rem;
}

.qs-intro:last-child {
  margin-bottom: 0;
}

.qs-mv-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
}

@media (max-width: 768px) {
  .qs-mv-grid {
    grid-template-columns: 1fr;
  }
}

.qs-mv-card {
  background: #fff;
  border-radius: 20px;
  padding: 2rem;
  box-shadow: 0 8px 30px rgba(11, 79, 108, 0.08);
  display: flex;
  flex-direction: column;
  min-height: 100%;
}

.qs-mv-card__icon {
  font-size: 2rem;
  margin-bottom: 0.75rem;
}

.qs-mv-card h2 {
  font-size: 1.35rem;
  font-weight: 800;
  color: #0b4f6c;
  margin: 0 0 1rem;
}

.qs-mv-card p {
  margin: 0;
  line-height: 1.7;
  color: #475569;
  flex: 1;
}

.qs-purpose {
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  color: #fff;
  padding: 3.5rem 1.5rem;
  text-align: center;
}

.qs-purpose h2 {
  font-size: 1.25rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: #C4A140;
  margin: 0 0 0.75rem;
}

.qs-purpose p {
  font-size: clamp(1.125rem, 2.5vw, 1.5rem);
  font-weight: 600;
  max-width: 720px;
  margin: 0 auto;
  line-height: 1.5;
}

/* Principios — overlay limpio con transición imagen → texto */
.qs-principles {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 0.875rem;
  align-items: stretch;
}

@media (max-width: 1024px) {
  .qs-principles {
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
  }
}

@media (max-width: 640px) {
  .qs-principles {
    grid-template-columns: 1fr 1fr;
  }
}

.qs-principle {
  position: relative;
  isolation: isolate;
  aspect-ratio: 3 / 4;
  min-height: 260px;
  overflow: hidden;
  border-radius: 12px;
  background: #003C5F;
  cursor: pointer;
}

.qs-principle:focus-visible {
  outline: 2px solid #005674;
  outline-offset: 3px;
}

.qs-principle__photo {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center top;
  display: block;
  transform: scale(1.01);
  transition: transform 0.55s ease, filter 0.45s ease;
}

.qs-principle__fallback {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(160deg, #0b4f6c, #008996);
}

.qs-principle__scrim {
  position: absolute;
  inset: 0;
  z-index: 1;
  pointer-events: none;
  background:
    linear-gradient(
      185deg,
      rgba(0, 60, 95, 0) 0%,
      rgba(0, 60, 95, 0.04) 32%,
      rgba(0, 54, 86, 0.32) 56%,
      rgba(0, 42, 68, 0.7) 76%,
      rgba(0, 28, 46, 0.94) 100%
    );
}

.qs-principle__scrim::after {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(0, 36, 58, 0.28);
  opacity: 0;
  transition: opacity 0.4s ease;
}

.qs-principle__content {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 2;
  padding: 1.5rem 1.15rem 1.35rem;
  color: #fff;
}

.qs-principle__label {
  font-family: var(--font-idcbis-display);
  font-size: clamp(0.9rem, 1.05vw, 1.05rem);
  font-weight: 800;
  line-height: 1.3;
  letter-spacing: 0.01em;
  text-wrap: balance;
  text-shadow: 0 1px 12px rgba(0, 24, 40, 0.4);
}

.qs-principle:hover .qs-principle__photo,
.qs-principle:focus-within .qs-principle__photo {
  transform: scale(1.05);
}

.qs-principle:hover .qs-principle__scrim::after,
.qs-principle:focus-within .qs-principle__scrim::after {
  opacity: 1;
}

@media (prefers-reduced-motion: reduce) {
  .qs-principle__photo,
  .qs-principle__scrim::after {
    transition: none;
  }

  .qs-principle:hover .qs-principle__photo,
  .qs-principle:focus-within .qs-principle__photo {
    transform: none;
  }
}

/* Organigrama (acordeón) */
.qs-orgchart {
  margin: 0;
}

.qs-orgchart__desc {
  margin: 0 0 1rem;
  color: #475569;
  line-height: 1.65;
  font-size: 0.95rem;
}

.qs-orgchart__media {
  display: block;
  width: 100%;
  margin: 0;
  padding: 0.75rem;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  background: #0f172a;
  cursor: zoom-in;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.qs-orgchart__media:hover {
  border-color: #008996;
  box-shadow: 0 10px 24px rgba(11, 79, 108, 0.12);
}

.qs-orgchart__media:focus-visible {
  outline: 2px solid #005674;
  outline-offset: 2px;
}

.qs-orgchart__image {
  display: block;
  width: 100%;
  height: auto;
  border-radius: 8px;
}

.qs-orgchart__caption {
  margin: 0.75rem 0 0;
  text-align: center;
  font-size: 0.8125rem;
  color: #64748b;
}

.qs-orgchart-lightbox {
  position: fixed;
  inset: 0;
  z-index: 80;
  display: flex;
  flex-direction: column;
  background: rgba(15, 23, 42, 0.92);
}

.qs-orgchart-lightbox__bar {
  display: flex;
  justify-content: flex-end;
  gap: 0.5rem;
  padding: 1rem 1.25rem;
}

.qs-orgchart-lightbox__btn {
  min-width: 44px;
  min-height: 44px;
  padding: 0 0.9rem;
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.08);
  color: #fff;
  font-size: 1.1rem;
  font-weight: 700;
  cursor: pointer;
}

.qs-orgchart-lightbox__btn:hover,
.qs-orgchart-lightbox__btn:focus-visible {
  background: rgba(0, 137, 150, 0.45);
  outline: none;
}

.qs-orgchart-lightbox__btn--close {
  font-size: 0.875rem;
}

.qs-orgchart-lightbox__stage {
  flex: 1;
  overflow: auto;
  display: grid;
  place-items: center;
  padding: 0.5rem 1rem 2rem;
}

.qs-orgchart-lightbox__image {
  max-width: min(96vw, 1200px);
  width: 100%;
  height: auto;
  transform-origin: center center;
  transition: transform 0.2s ease;
}

@media (prefers-reduced-motion: reduce) {
  .qs-orgchart__media,
  .qs-orgchart-lightbox__image {
    transition: none;
  }
}

/* Director */
.qs-director {
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 2.5rem;
  align-items: start;
  background: #fff;
  border-radius: 24px;
  padding: 2rem;
  box-shadow: 0 12px 40px rgba(11, 79, 108, 0.08);
}

@media (max-width: 768px) {
  .qs-director {
    grid-template-columns: 1fr;
    text-align: center;
  }
}

.qs-director__photo-wrap {
  border-radius: 20px;
  overflow: hidden;
  aspect-ratio: 3 / 4;
  background: #e2e8f0;
}

.qs-director__photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.qs-director__role {
  font-size: 0.8125rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: #2c8c99;
  margin: 0 0 0.35rem;
}

.qs-director__name {
  font-size: 1.75rem;
  font-weight: 800;
  color: #0b4f6c;
  margin: 0 0 0.25rem;
}

.qs-director__credentials {
  font-size: 0.9375rem;
  color: #64748b;
  font-weight: 600;
  margin: 0 0 1rem;
}

.qs-director__bio {
  line-height: 1.75;
  color: #475569;
  margin: 0 0 1rem;
  text-align: justify;
}

.qs-director__email {
  font-size: 0.9375rem;
  font-weight: 600;
  color: #0b4f6c;
  text-decoration: none;
}

.qs-director__email:hover {
  text-decoration: underline;
}

/* Acordeón */
.qs-accordion-wrap {
  padding-bottom: 5rem;
}

.qs-accordion {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.qs-accordion__item {
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
}

.qs-accordion__trigger {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1.15rem 1.5rem;
  border: 0;
  background: #fafcfd;
  cursor: pointer;
  font-family: inherit;
  text-align: left;
  transition: background 0.2s;
}

.qs-accordion__trigger:hover {
  background: #f0f7f9;
}

.qs-accordion__item--open .qs-accordion__trigger {
  background: #e8f4f8;
  border-bottom: 1px solid #e2e8f0;
}

.qs-accordion__trigger-icon {
  font-size: 1.35rem;
  flex-shrink: 0;
  color: #1a1a1a;
}

.qs-accordion__trigger-text {
  flex: 1;
  font-size: 1.0625rem;
  font-weight: 700;
  color: #0b4f6c;
}

.qs-accordion__chevron {
  width: 1.25rem;
  height: 1.25rem;
  color: #94a3b8;
  flex-shrink: 0;
  transition: transform 0.25s ease;
}

.qs-accordion__item--open .qs-accordion__chevron {
  transform: rotate(180deg);
  color: #2c8c99;
}

.qs-accordion__panel {
  display: grid;
  grid-template-rows: 0fr;
  transition: grid-template-rows 0.35s ease;
}

.qs-accordion__item--open .qs-accordion__panel {
  grid-template-rows: 1fr;
}

.qs-accordion__panel-inner {
  overflow: hidden;
  padding: 0 1.5rem;
}

.qs-accordion__item--open .qs-accordion__panel-inner {
  padding: 1.5rem;
}

/* Listas */
.qs-list {
  margin: 0;
  padding: 0;
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.qs-list li {
  position: relative;
  padding-left: 1.75rem;
  line-height: 1.65;
  color: #475569;
}

.qs-list li::before {
  content: '✓';
  position: absolute;
  left: 0;
  top: 0.1rem;
  width: 1.25rem;
  height: 1.25rem;
  background: #4ecdc4;
  color: #fff;
  border-radius: 50%;
  font-size: 0.65rem;
  font-weight: 800;
  display: flex;
  align-items: center;
  justify-content: center;
}

.qs-founders {
  margin: 0;
  padding: 0;
  list-style: none;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 0.875rem;
}

.qs-founder {
  min-width: 0;
}

.qs-founder__card {
  display: grid;
  grid-template-columns: 72px 1fr;
  column-gap: 0.9rem;
  align-items: center;
  min-height: 88px;
  padding: 0.85rem 1rem;
  background: #fff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  text-decoration: none;
  color: inherit;
  transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
}

a.qs-founder__card:hover {
  border-color: #008996;
  box-shadow: 0 10px 24px rgba(11, 79, 108, 0.1);
  transform: translateY(-2px);
}

a.qs-founder__card:focus-visible {
  outline: 2px solid #005674;
  outline-offset: 2px;
}

.qs-founder__logo-wrap {
  width: 72px;
  height: 72px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.45rem;
  border-radius: 12px;
  background: #f4f7f9;
  overflow: hidden;
}

.qs-founder__logo-wrap--dark {
  background: #0b4f6c;
}

.qs-founder__logo {
  max-width: 100%;
  max-height: 100%;
  width: auto;
  height: auto;
  object-fit: contain;
  display: block;
}

.qs-founder__logo-fallback {
  font-family: var(--font-idcbis-display);
  font-size: 1rem;
  font-weight: 800;
  color: #0b4f6c;
}

.qs-founder__name {
  font-size: 0.875rem;
  font-weight: 700;
  color: #0b4f6c;
  line-height: 1.35;
}

@media (prefers-reduced-motion: reduce) {
  .qs-founder__card,
  a.qs-founder__card:hover {
    transition: none;
    transform: none;
  }
}

/* Equipo — compacto: 4–5 por fila */
.qs-team-grid {
  display: grid;
  grid-template-columns: repeat(5, minmax(0, 1fr));
  gap: 0.85rem 0.75rem;
}

@media (max-width: 1100px) {
  .qs-team-grid {
    grid-template-columns: repeat(4, minmax(0, 1fr));
  }
}

@media (max-width: 768px) {
  .qs-team-grid {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}

@media (max-width: 480px) {
  .qs-team-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

.qs-team-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 0.75rem 0.5rem 0.9rem;
  background: #fff;
  border-radius: 12px;
  border: 1px solid #e8eef2;
  transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
}

.qs-team-card:hover {
  border-color: #b6d6de;
  box-shadow: 0 8px 18px rgba(11, 79, 108, 0.08);
  transform: translateY(-2px);
}

.qs-team-card__photo-wrap {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  background: #dde8ec;
  overflow: hidden;
  flex-shrink: 0;
  margin-bottom: 0.65rem;
  box-shadow: 0 0 0 2px #fff, 0 0 0 3px #c5dde4;
}

.qs-team-card__photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: top center;
  display: block;
}

.qs-team-card__body {
  padding: 0;
  min-width: 0;
  width: 100%;
}

.qs-team-card__body h3 {
  font-size: 0.8125rem;
  font-weight: 800;
  color: #0b4f6c;
  margin: 0 0 0.3rem;
  line-height: 1.25;
}

.qs-team-card__role {
  font-size: 0.6875rem;
  color: #008996;
  font-weight: 600;
  margin: 0 0 0.25rem;
  line-height: 1.35;
}

.qs-team-card__credentials {
  font-size: 0.625rem;
  color: #64748b;
  margin: 0 0 0.35rem;
  line-height: 1.35;
}

.qs-team-card__email {
  font-size: 0.625rem;
  color: #0b4f6c;
  font-weight: 600;
  word-break: break-all;
  text-decoration: none;
}

.qs-team-card__email:hover {
  text-decoration: underline;
}

@media (prefers-reduced-motion: reduce) {
  .qs-team-card,
  .qs-team-card:hover {
    transition: none;
    transform: none;
  }
}

/* Políticas */
.qs-policies {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.qs-policy-card {
  display: flex;
  gap: 1rem;
  align-items: flex-start;
  padding: 1.15rem 1.25rem;
  background: #f8fafc;
  border-radius: 12px;
  text-decoration: none;
  color: inherit;
  border: 1px solid #e2e8f0;
  transition: border-color 0.2s, background 0.2s;
}

a.qs-policy-card:hover {
  border-color: #2c8c99;
  background: #f0f9fb;
}

.qs-policy-card__icon {
  font-size: 1.5rem;
  flex-shrink: 0;
}

.qs-policy-card strong {
  display: block;
  color: #0b4f6c;
  margin-bottom: 0.25rem;
}

.qs-policy-card p {
  margin: 0;
  font-size: 0.875rem;
  color: #64748b;
}

/* Contacto */
.qs-contact-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1rem;
}

.qs-contact-card {
  background: #f8f9fa;
  color: #1a1a1a;
  padding: 1.25rem 1.5rem;
  border-left: 3px solid #005674;
}

.qs-contact-card h3 {
  font-size: 1rem;
  font-weight: 700;
  color: #0b4f6c;
  margin: 0 0 0.5rem;
}

.qs-contact-card p {
  margin: 0;
  font-size: 0.9rem;
  line-height: 1.65;
  white-space: pre-line;
  color: #475569;
}
</style>
