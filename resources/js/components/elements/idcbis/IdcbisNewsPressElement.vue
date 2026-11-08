<template>
  <!--
    Noticias del home: tres notas del mismo tamaño, con resumen.
    El podcast solo aparece cuando hay un enlace real.
  -->
  <section class="news-press" aria-labelledby="news-press-title" @click.stop="$emit('click', element)">
    <div class="news-press__inner">
      <header class="news-press__header">
        <div class="news-press__intro">
          <p class="news-press__kicker">IDCBIS</p>
          <h2 id="news-press-title">{{ element.sectionTitle || t('ui.newsSection') }}</h2>
          <p v-if="element.sectionSubtitle">{{ element.sectionSubtitle }}</p>
        </div>
        <component
          :is="ctaTag"
          class="news-press__cta"
          v-bind="ctaBindings"
          @click.stop="onCtaClick"
        >
          {{ element.buttonText || t('news.viewAll') }}
        </component>
      </header>

      <ul v-if="news.length" class="news-press__grid">
        <li v-for="(item, index) in news" :key="item.id || index">
          <component
            :is="cardTag(item)"
            class="news-press__card"
            v-bind="cardBindings(item)"
            :aria-labelledby="titleId(item, index)"
          >
            <div class="news-press__media">
              <img
                v-if="item.image"
                :src="item.image"
                :alt="item.imageAlt || ''"
                width="960"
                height="600"
                loading="lazy"
                decoding="async"
              >
              <span v-else class="news-press__placeholder" aria-hidden="true">IDCBIS</span>
            </div>
            <div class="news-press__body">
              <p class="news-press__meta">
                <span v-if="item.category" class="news-press__category">{{ item.category }}</span>
                <time v-if="item.date" :datetime="item.dateIso || undefined">{{ item.date }}</time>
              </p>
              <h3 :id="titleId(item, index)">{{ item.title }}</h3>
              <p v-if="item.excerpt" class="news-press__excerpt">{{ item.excerpt }}</p>
              <span class="news-press__more">
                {{ t('ui.readNews') }}
                <ArrowRight :size="16" aria-hidden="true" />
              </span>
            </div>
          </component>
        </li>
      </ul>

      <p v-else class="news-press__empty">{{ t('ui.newsEmpty') }}</p>

      <div v-if="showPodcast" class="news-press__podcast">
        <p class="news-press__kicker news-press__kicker--gold">{{ t('ui.audio') }}</p>
        <div class="news-press__podcast-copy">
          <h3>{{ element.podcastTitle || t('ui.podcast') }}</h3>
          <p v-if="element.podcastDescription">{{ element.podcastDescription }}</p>
          <p v-if="element.episodeTitle" class="news-press__episode">
            {{ t('ui.latestEpisode', { title: element.episodeTitle }) }}
          </p>
        </div>
        <a
          class="news-press__cta news-press__cta--light"
          :href="element.podcastUrl"
          target="_blank"
          rel="noopener noreferrer"
        >
          {{ t('ui.listen') }}
        </a>
      </div>

      <div v-if="namedCreators.length" class="news-press__creators">
        <h3>{{ t('ui.collaborations') }}</h3>
        <ul>
          <li v-for="creator in namedCreators" :key="creator.id || creator.name">
            {{ creator.name }}
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { RouterLink } from 'vue-router'
import { ArrowRight } from 'lucide-vue-next'
import { useI18n } from '../../../i18n'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

defineEmits(['click', 'focus-part'])
const { t } = useI18n()

const news = computed(() => props.element.news || [])
const namedCreators = computed(() => (props.element.creators || []).filter((creator) => creator.name))
const showPodcast = computed(() => Boolean(props.element.podcastUrl))

const newsHref = (item) => item.url || (item.slug ? `/noticias/${item.slug}` : '/noticias')
const ctaHref = computed(() => props.element.buttonUrl || '/noticias')

const isExternal = (url) => /^https?:\/\//i.test(url || '')

const ctaTag = computed(() => {
  if (!props.preview) return 'button'
  return isExternal(ctaHref.value) ? 'a' : RouterLink
})

const ctaBindings = computed(() => {
  if (!props.preview) return { type: 'button' }
  if (isExternal(ctaHref.value)) {
    return { href: ctaHref.value, target: '_blank', rel: 'noopener noreferrer' }
  }
  return { to: ctaHref.value }
})

const cardTag = (item) => {
  if (!props.preview) return 'div'
  return isExternal(newsHref(item)) ? 'a' : RouterLink
}

const cardBindings = (item) => {
  const href = newsHref(item)
  if (!props.preview) return {}
  if (isExternal(href)) return { href, target: '_blank', rel: 'noopener noreferrer' }
  return { to: href }
}

const titleId = (item, index) => `news-card-${props.element.id || 'home'}-${item.id || index}`

const onCtaClick = (event) => {
  if (!props.preview) event.preventDefault()
}
</script>

<style scoped>
.news-press {
  font-family: var(--font-idcbis);
  background: #f4f7f8;
  padding: 4rem 0 3.5rem;
  cursor: pointer;
}

.news-press__inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1.25rem;
}

.news-press__header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 1.5rem 2rem;
  margin-bottom: 1.75rem;
}

.news-press__intro {
  max-width: 40rem;
}

.news-press__kicker {
  margin: 0 0 0.4rem;
  color: #C4A140;
  font-size: 0.78rem;
  font-weight: 700;
  letter-spacing: 0.16em;
  text-transform: uppercase;
}

.news-press__kicker--gold {
  color: #D9B85A;
}

.news-press__intro h2 {
  margin: 0;
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.8rem, 3vw, 2.5rem);
  font-weight: 800;
  line-height: 1.15;
  color: #0B4F6C;
}

.news-press__intro h2::after {
  content: "";
  display: block;
  width: 3.5rem;
  height: 3px;
  margin: 0.75rem 0 0;
  background: #C4A140;
  border-radius: 999px;
}

.news-press__intro p {
  margin: 0.75rem 0 0;
  color: #607d8b;
  font-size: 1.05rem;
  line-height: 1.55;
}

.news-press__grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.15rem;
  align-items: stretch;
}

.news-press__card {
  display: flex;
  flex-direction: column;
  height: 100%;
  background: #ffffff;
  border: 1px solid #e2e8ec;
  border-radius: 1rem;
  overflow: hidden;
  text-decoration: none;
  color: inherit;
  box-shadow: 0 10px 24px -18px rgba(0, 60, 95, 0.45);
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.news-press__card:hover {
  transform: translateY(-3px);
  border-color: #008996;
  box-shadow: 0 18px 32px -18px rgba(11, 79, 108, 0.4);
}

.news-press__card:focus-visible,
.news-press__cta:focus-visible {
  outline: 3px solid #005674;
  outline-offset: 3px;
}

.news-press__media {
  position: relative;
  aspect-ratio: 16 / 9;
  background: #0B4F6C;
  overflow: hidden;
}

.news-press__media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center 22%;
  display: block;
}

.news-press__placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  color: rgba(255, 255, 255, 0.72);
  font-weight: 800;
  letter-spacing: 0.08em;
}

.news-press__body {
  display: flex;
  flex-direction: column;
  flex: 1;
  gap: 0.55rem;
  padding: 1.05rem 1.15rem 1.15rem;
}

.news-press__meta {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.45rem 0.7rem;
  margin: 0;
  color: #607d8b;
  font-size: 0.84rem;
  line-height: 1.3;
}

.news-press__category {
  display: inline-flex;
  align-items: center;
  min-height: 1.6rem;
  padding: 0.15rem 0.6rem;
  border-radius: 999px;
  background: #e7f3f5;
  color: #005674;
  font-size: 0.72rem;
  font-weight: 800;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

.news-press__body h3 {
  margin: 0;
  font-family: var(--font-idcbis-display);
  font-size: 1.12rem;
  font-weight: 800;
  line-height: 1.3;
  color: #0B4F6C;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.news-press__excerpt {
  margin: 0;
  color: #3d4f58;
  font-size: 0.95rem;
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.news-press__more {
  margin-top: auto;
  padding-top: 0.35rem;
  min-height: 44px;
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-weight: 700;
  color: #005674;
}

.news-press__card:hover .news-press__more {
  color: #003C5F;
}

.news-press__empty {
  margin: 0;
  padding: 2rem 1rem;
  text-align: center;
  color: #607d8b;
  background: #ffffff;
  border: 1px dashed #c5d0d6;
  border-radius: 1rem;
}

.news-press__podcast {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.25rem 2rem;
  margin-top: 1.5rem;
  padding: 1.35rem 1.4rem;
  border-radius: 1rem;
  background:
    radial-gradient(circle at 100% 0%, rgba(196, 161, 64, 0.28), transparent 36%),
    linear-gradient(135deg, #003C5F, #0B4F6C 58%, #008996);
  color: #ffffff;
}

.news-press__podcast-copy {
  min-width: 0;
}

.news-press__podcast h3 {
  margin: 0;
  font-family: var(--font-idcbis-display);
  font-size: 1.35rem;
  font-weight: 800;
  line-height: 1.2;
}

.news-press__podcast p {
  margin: 0.4rem 0 0;
  color: rgba(255, 255, 255, 0.92);
  line-height: 1.5;
}

.news-press__episode {
  font-weight: 700;
  color: #ffffff;
}

.news-press__creators {
  margin-top: 1.75rem;
}

.news-press__creators h3 {
  margin: 0;
  font-size: 0.95rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: #0B4F6C;
}

.news-press__creators ul {
  list-style: none;
  margin: 0.85rem 0 0;
  padding: 0;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 0.75rem;
}

.news-press__creators li {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 4.75rem;
  padding: 0.65rem 0.85rem;
  text-align: center;
  color: #003C5F;
  font-weight: 700;
  line-height: 1.25;
  background: #ffffff;
  border-radius: 0.85rem;
}

.news-press__cta {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  min-height: 44px;
  padding: 0.7rem 1.25rem;
  border-radius: 999px;
  border: 2px solid #005674;
  background: #005674;
  color: #ffffff;
  font-weight: 700;
  text-decoration: none;
  cursor: pointer;
}

.news-press__cta--light {
  background: #C4A140;
  border-color: #C4A140;
  color: #003C5F;
}

.news-press__cta:hover {
  background: #003C5F;
  border-color: #003C5F;
  color: #ffffff;
}

.news-press__cta--light:hover {
  background: #D9B85A;
  border-color: #D9B85A;
  color: #003C5F;
}

@media (min-width: 700px) and (max-width: 959px) {
  .news-press__card {
    flex-direction: row;
  }

  .news-press__media {
    flex: 0 0 38%;
    aspect-ratio: auto;
    min-height: 11.5rem;
  }
}

@media (min-width: 960px) {
  .news-press__grid {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}

@media (max-width: 699px) {
  .news-press__header {
    flex-direction: column;
    align-items: stretch;
  }

  .news-press__cta {
    width: 100%;
  }

  .news-press__podcast {
    flex-direction: column;
    align-items: flex-start;
  }

  .news-press__podcast .news-press__cta {
    width: auto;
  }

  .news-press__creators ul {
    grid-template-columns: 1fr;
  }
}

@media (prefers-reduced-motion: reduce) {
  .news-press__card {
    transition: none;
  }

  .news-press__card:hover {
    transform: none;
  }
}
</style>
