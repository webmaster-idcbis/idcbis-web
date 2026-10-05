<template>
  <!--
    Noticias y prensa del home.
    No sustituye /noticias: tres notas y podcast, con enlace al listado.
  -->
  <section class="news-press" aria-labelledby="news-press-title" @click.stop="$emit('click', element)">
    <div class="news-press__inner">
      <header class="news-press__header">
        <p class="news-press__kicker">IDCBIS</p>
        <h2 id="news-press-title">{{ element.sectionTitle || 'Noticias y Prensa' }}</h2>
        <p v-if="element.sectionSubtitle">{{ element.sectionSubtitle }}</p>
      </header>

      <ul class="news-press__grid">
        <li
          v-for="(item, index) in news"
          :key="item.id || index"
          :class="{ 'news-press__lead': index === 0 }"
        >
          <component
            :is="preview ? 'a' : 'div'"
            class="news-press__card"
            :href="preview ? newsHref(item) : undefined"
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
              <span v-if="item.category" class="news-press__category">{{ item.category }}</span>
            </div>
            <div class="news-press__body">
              <p v-if="item.date" class="news-press__date"><time>{{ item.date }}</time></p>
              <h3>{{ item.title }}</h3>
              <span class="news-press__more">Leer más</span>
            </div>
          </component>
        </li>
      </ul>
    </div>

    <div class="news-press__podcast">
      <div class="news-press__inner news-press__podcast-inner">
        <p class="news-press__kicker news-press__kicker--gold">Audio</p>
        <h3>{{ element.podcastTitle || 'Nuestro Podcast' }}</h3>
        <p v-if="element.podcastDescription">{{ element.podcastDescription }}</p>
        <p v-if="element.episodeTitle" class="news-press__episode">
          Último episodio: {{ element.episodeTitle }}
        </p>
        <!-- Sin URL oficial no se incrusta un reproductor falso. -->
        <p v-if="!element.podcastUrl" class="news-press__pending">Pronto en Spotify y YouTube</p>
        <a
          v-else
          class="news-press__cta news-press__cta--light"
          :href="element.podcastUrl"
          target="_blank"
          rel="noopener noreferrer"
        >
          Escuchar el episodio
        </a>
      </div>
    </div>

    <div class="news-press__inner">
      <!-- Solo se muestran colaboraciones con nombre. Los espacios vacíos no se pintan. -->
      <div v-if="namedCreators.length" class="news-press__creators">
        <h3>Colaboraciones</h3>
        <ul>
          <li v-for="creator in namedCreators" :key="creator.id || creator.name">
            {{ creator.name }}
          </li>
        </ul>
      </div>

      <div class="news-press__actions">
        <component
          :is="preview ? 'a' : 'button'"
          class="news-press__cta"
          :href="preview ? (element.buttonUrl || '/noticias') : undefined"
          type="button"
          @click.stop="!preview && $event.preventDefault()"
        >
          {{ element.buttonText || 'Ver todas las noticias' }}
        </component>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
  focusedPart: { type: String, default: null },
})

defineEmits(['click', 'focus-part'])

const news = computed(() => props.element.news || [])
const namedCreators = computed(() => (props.element.creators || []).filter((creator) => creator.name))

const newsHref = (item) => item.url || (item.slug ? `/noticias/${item.slug}` : '/noticias')
</script>

<style scoped>
.news-press {
  font-family: var(--font-idcbis);
  background: #ffffff;
  padding: 4.5rem 0 3.5rem;
  cursor: pointer;
}

.news-press__inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1.25rem;
}

.news-press__header {
  text-align: center;
  max-width: 40rem;
  margin: 0 auto 2.25rem;
}

.news-press__kicker {
  margin: 0 0 0.45rem;
  color: #C4A140;
  font-size: 0.78rem;
  font-weight: 700;
  letter-spacing: 0.16em;
  text-transform: uppercase;
}

.news-press__kicker--gold {
  color: #D9B85A;
}

.news-press__header h2 {
  margin: 0;
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.8rem, 3vw, 2.6rem);
  font-weight: 800;
  line-height: 1.15;
  color: #0B4F6C;
}

.news-press__header h2::after {
  content: "";
  display: block;
  width: 3.5rem;
  height: 3px;
  margin: 0.85rem auto 0;
  background: #C4A140;
  border-radius: 999px;
}

.news-press__header p {
  margin: 0.85rem 0 0;
  color: #607d8b;
  font-size: 1.05rem;
  line-height: 1.55;
}

.news-press__grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 1rem;
}

.news-press__card {
  display: flex;
  flex-direction: column;
  height: 100%;
  background: #ffffff;
  border-radius: 1.15rem;
  overflow: hidden;
  text-decoration: none;
  color: inherit;
  box-shadow: 0 16px 32px -22px rgba(0, 60, 95, 0.55);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.news-press__card:hover {
  transform: translateY(-4px);
  box-shadow: 0 22px 36px -18px rgba(11, 79, 108, 0.45);
}

.news-press__card:focus-visible,
.news-press__cta:focus-visible {
  outline: 3px solid #005674;
  outline-offset: 3px;
}

.news-press__media {
  position: relative;
  aspect-ratio: 16 / 10;
  background: #0B4F6C;
}

.news-press__media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.news-press__category {
  position: absolute;
  left: 0.8rem;
  bottom: 0.8rem;
  padding: 0.28rem 0.65rem;
  border-radius: 999px;
  background: #C4A140;
  color: #003C5F;
  font-size: 0.72rem;
  font-weight: 800;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

.news-press__body {
  display: flex;
  flex-direction: column;
  flex: 1;
  padding: 0.95rem 1rem 1rem;
}

.news-press__date {
  margin: 0 0 0.35rem;
  color: #607d8b;
  font-size: 0.85rem;
}

.news-press__body h3 {
  margin: 0;
  font-size: 1.05rem;
  line-height: 1.35;
  color: #0B4F6C;
}

.news-press__more {
  margin-top: auto;
  padding-top: 0.85rem;
  min-height: 44px;
  display: inline-flex;
  align-items: center;
  font-weight: 700;
  color: #005674;
}

.news-press__more::after {
  content: " →";
}

.news-press__podcast {
  margin-top: 2.5rem;
  padding: 2.75rem 0;
  background:
    radial-gradient(circle at 90% 20%, rgba(196, 161, 64, 0.28), transparent 32%),
    linear-gradient(135deg, #003C5F, #0B4F6C 55%, #008996);
  color: #ffffff;
}

.news-press__podcast-inner {
  max-width: 40rem;
}

.news-press__podcast h3 {
  margin: 0;
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  font-weight: 800;
  line-height: 1.15;
}

.news-press__podcast p {
  margin: 0.7rem 0 0;
  color: rgba(255, 255, 255, 0.92);
  line-height: 1.55;
  max-width: 36rem;
}

.news-press__episode {
  font-weight: 700;
  color: #ffffff;
}

.news-press__pending {
  display: inline-flex;
  margin-top: 1rem;
  padding: 0.35rem 0.75rem;
  border: 1px solid rgba(255, 255, 255, 0.45);
  border-radius: 999px;
  font-size: 0.85rem;
  font-weight: 700;
  letter-spacing: 0.03em;
}

.news-press__creators {
  margin-top: 2.25rem;
  text-align: center;
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
  margin: 1rem 0 0;
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
  height: 4.75rem;
  padding: 0.65rem 0.85rem;
  text-align: center;
  color: #003C5F;
  font-weight: 700;
  line-height: 1.25;
  background: #f8f9fa;
  border-radius: 0.85rem;
}

.news-press__actions {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
}

.news-press__cta {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 44px;
  padding: 0.75rem 1.4rem;
  border-radius: 999px;
  border: 2px solid #005674;
  background: #005674;
  color: #ffffff;
  font-weight: 700;
  text-decoration: none;
}

.news-press__cta--light {
  margin-top: 1.15rem;
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

@media (min-width: 900px) {
  .news-press__grid {
    grid-template-columns: 1.35fr 1fr;
    grid-template-rows: 1fr 1fr;
    gap: 1.15rem;
    min-height: 32rem;
  }

  .news-press__lead {
    grid-row: 1 / span 2;
  }

  .news-press__lead .news-press__media {
    flex: 1;
    aspect-ratio: auto;
    min-height: 16rem;
  }

  .news-press__lead .news-press__body h3 {
    font-size: 1.55rem;
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
