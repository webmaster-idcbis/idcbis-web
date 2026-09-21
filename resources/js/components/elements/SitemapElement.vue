<template>
  <section
    class="sitemap"
    :class="{ 'sitemap--editor': !preview }"
    @click.stop="!preview && $emit('click', element)"
  >
    <header v-if="showHero" class="sitemap__hero">
      <div class="sitemap__hero-inner">
        <p class="sitemap__eyebrow">Navegación</p>
        <h1 class="sitemap__title">{{ element.title || 'Mapa del sitio' }}</h1>
        <p v-if="element.subtitle" class="sitemap__subtitle">{{ element.subtitle }}</p>
      </div>
    </header>

    <div class="sitemap__sheet">
      <div class="sitemap__panel">
        <div class="sitemap__toolbar">
        <div class="sitemap__search-wrap">
          <label class="sitemap__search-label" :for="searchFieldId">Buscar en el mapa del sitio</label>
          <Search class="sitemap__search-icon" aria-hidden="true" />
          <input
            :id="searchFieldId"
            v-model="searchQuery"
            type="search"
            class="sitemap__search-input"
            placeholder="Buscar sección o página…"
            autocomplete="off"
            @click.stop
          >
          <button
            v-if="searchQuery"
            type="button"
            class="sitemap__search-clear"
            aria-label="Limpiar búsqueda"
            @click.stop="searchQuery = ''"
          >
            <X class="h-4 w-4" aria-hidden="true" />
          </button>
        </div>

        <nav
          v-if="!searchQuery && quickAnchors.length"
          class="sitemap__index"
          aria-label="Ir a una sección del mapa"
        >
          <span class="sitemap__index-label">Índice</span>
          <ul class="sitemap__index-list">
            <li v-for="anchor in quickAnchors" :key="anchor.id">
              <button
                type="button"
                class="sitemap__index-link"
                @click.stop="scrollTo(anchor.id)"
              >
                {{ anchor.label }}
              </button>
            </li>
          </ul>
        </nav>
      </div>

      <div v-if="isEmpty" class="sitemap__empty">
        <p>No hay resultados para «{{ searchQuery }}».</p>
        <button type="button" class="sitemap__empty-btn" @click="searchQuery = ''">
          Ver todo el mapa
        </button>
      </div>

      <nav v-else class="sitemap__directory" aria-label="Mapa del sitio">
        <section
          v-for="section in filtered.sections"
          :id="branchId(section)"
          :key="branchId(section)"
          class="sitemap__branch"
        >
          <h2 class="sitemap__branch-title">
            <SitemapLink
              v-if="section.slug"
              :slug="section.slug"
              :preview="preview"
              class="sitemap__branch-link"
              @navigate="onLinkClick"
            >
              <ContentIcon v-if="section.icon" :value="section.icon" class="sitemap__branch-icon" />
              <span>{{ section.title }}</span>
            </SitemapLink>
            <span v-else class="sitemap__branch-label">
              <ContentIcon v-if="section.icon" :value="section.icon" class="sitemap__branch-icon" />
              <span>{{ section.title }}</span>
            </span>
          </h2>
          <p v-if="section.description" class="sitemap__branch-desc">{{ section.description }}</p>

          <ul v-if="section.children?.length" class="sitemap__list">
            <li v-for="child in section.children" :key="child.slug" class="sitemap__item">
              <SitemapLink
                :slug="child.slug"
                :preview="preview"
                class="sitemap__link"
                :class="{ 'sitemap__link--pending': !isPublished(child.slug) }"
                @navigate="onLinkClick"
              >
                <span class="sitemap__bullet" aria-hidden="true" />
                <span class="sitemap__link-text">{{ child.title }}</span>
                <span v-if="!isPublished(child.slug)" class="sitemap__soon">En preparación</span>
              </SitemapLink>

              <ul v-if="child.children?.length" class="sitemap__list sitemap__list--nested">
                <li v-for="grand in child.children" :key="grand.slug" class="sitemap__item">
                  <SitemapLink
                    :slug="grand.slug"
                    :preview="preview"
                    class="sitemap__link"
                    :class="{ 'sitemap__link--pending': !isPublished(grand.slug) }"
                    @navigate="onLinkClick"
                  >
                    <span class="sitemap__bullet sitemap__bullet--nested" aria-hidden="true" />
                    <span class="sitemap__link-text">{{ grand.title }}</span>
                    <span v-if="!isPublished(grand.slug)" class="sitemap__soon">En preparación</span>
                  </SitemapLink>
                </li>
              </ul>
            </li>
          </ul>
        </section>
      </nav>
      </div>

      <aside v-if="element.showNote !== false && !searchQuery" class="sitemap__help">
        <Info class="sitemap__help-icon" aria-hidden="true" />
        <p>
          Las páginas marcadas como «En preparación» se irán publicando de forma progresiva.
        </p>
      </aside>
    </div>
  </section>
</template>

<script setup>
import { computed, ref, defineComponent, h } from 'vue';
import { RouterLink } from 'vue-router';
import { Search, X, Info } from 'lucide-vue-next';
import ContentIcon from './ContentIcon.vue';
import {
  isSitemapPublished,
  sitemapItemUrl,
  filterSitemapTree,
} from '../../config/siteSitemap';

const SitemapLink = defineComponent({
  name: 'SitemapLink',
  props: {
    slug: { type: String, required: true },
    preview: { type: Boolean, default: false },
  },
  emits: ['navigate'],
  setup(props, { slots, emit }) {
    return () => {
      if (props.preview) {
        return h(
          RouterLink,
          { to: sitemapItemUrl(props.slug), class: 'sitemap-link' },
          () => slots.default?.(),
        );
      }
      return h(
        'a',
        {
          href: '#',
          class: 'sitemap-link',
          onClick: (e) => emit('navigate', e),
        },
        slots.default?.(),
      );
    };
  },
});

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
});

defineEmits(['click']);

const searchQuery = ref('');
const showHero = computed(() => props.element.showHero !== false);
const searchFieldId = computed(() => `sitemap-search-${props.element.id || 'main'}`);

const filtered = computed(() => filterSitemapTree(searchQuery.value));
const isPublished = isSitemapPublished;

const isEmpty = computed(() => !filtered.value.sections.length);

const slugify = (text) =>
  (text || '')
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-|-$/g, '');

const branchId = (section) => `sitemap-${section.slug || slugify(section.title)}`;

const quickAnchors = computed(() =>
  (filtered.value.sections || []).map((section) => ({
    id: branchId(section),
    label: section.title,
  })),
);

const scrollTo = (id) => {
  if (!props.preview) return;
  const el = document.getElementById(id);
  if (!el) return;
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  el.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
};

const onLinkClick = (event) => {
  if (!props.preview) {
    event.preventDefault();
    event.stopPropagation();
  }
};
</script>

<style scoped>
.sitemap {
  font-family: var(--font-idcbis);
  background: #f8f9fa;
  color: #1a1a1a;
}

.sitemap--editor {
  cursor: pointer;
}

.sitemap__hero {
  background: linear-gradient(135deg, #005674 0%, #003d52 100%);
  color: #fff;
  padding: 3rem 1.5rem 2.5rem;
}

.sitemap__hero-inner {
  max-width: 720px;
  margin: 0 auto;
  text-align: center;
}

.sitemap__eyebrow {
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.75);
  margin-bottom: 0.5rem;
}

.sitemap__title {
  font-family: var(--font-idcbis-display);
  font-size: clamp(1.875rem, 4vw, 2.75rem);
  font-weight: 800;
  line-height: 1.15;
  margin-bottom: 0.75rem;
}

.sitemap__subtitle {
  color: rgba(255, 255, 255, 0.88);
  line-height: 1.6;
  margin: 0;
  font-size: 1.0625rem;
}

.sitemap__sheet {
  max-width: 1100px;
  margin: 0 auto;
  padding: 1.5rem 1rem 3.5rem;
}

@media (min-width: 640px) {
  .sitemap__sheet {
    padding: 2rem 1.25rem 4rem;
  }
}

.sitemap__panel {
  background: #fff;
  border: 1px solid #e4ecef;
  border-radius: 12px;
  overflow: hidden;
}

.sitemap__toolbar {
  padding: 1.25rem 1.25rem 1rem;
}

@media (min-width: 640px) {
  .sitemap__toolbar {
    padding: 1.5rem 1.75rem 1.15rem;
  }
}

.sitemap__search-wrap {
  position: relative;
  max-width: 36rem;
}

.sitemap__search-label {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

.sitemap__search-icon {
  position: absolute;
  left: 0.9rem;
  top: 50%;
  transform: translateY(-50%);
  width: 1.125rem;
  height: 1.125rem;
  color: #607d8b;
  pointer-events: none;
}

.sitemap__search-input {
  width: 100%;
  min-height: 48px;
  padding: 0 2.75rem 0 2.75rem;
  border: 1px solid #d4e0e6;
  border-radius: 8px;
  font-size: 1rem;
  color: #1a1a1a;
  background: #fff;
  outline: none;
}

.sitemap__search-input:focus {
  border-color: #005674;
  box-shadow: 0 0 0 3px rgba(0, 86, 116, 0.18);
}

.sitemap__search-clear {
  position: absolute;
  right: 0.5rem;
  top: 50%;
  transform: translateY(-50%);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 44px;
  height: 44px;
  color: #607d8b;
  border-radius: 8px;
}

.sitemap__search-clear:hover {
  color: #003c5f;
}

.sitemap__search-clear:focus-visible {
  outline: 2px solid #005674;
  outline-offset: 2px;
}

.sitemap__index {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem 1rem;
  margin-top: 1rem;
  padding-top: 0.9rem;
  border-top: 1px solid #e8eef2;
}

.sitemap__index-label {
  flex-shrink: 0;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: #607d8b;
  padding-top: 0.55rem;
}

.sitemap__index-list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-wrap: wrap;
  gap: 0.25rem 0.15rem;
}

.sitemap__index-link {
  min-height: 44px;
  padding: 0.35rem 0.7rem;
  border: 0;
  background: transparent;
  color: #005674;
  font-size: 0.875rem;
  font-weight: 600;
  cursor: pointer;
  border-radius: 6px;
}

.sitemap__index-link:hover {
  background: #eef6f8;
  color: #003c5f;
}

.sitemap__index-link:focus-visible {
  outline: 2px solid #005674;
  outline-offset: 2px;
}

.sitemap__directory {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2.25rem 3.5rem;
  align-items: start;
  padding: 0.5rem 1.25rem 1.75rem;
  border-top: 1px solid #e8eef2;
}

@media (min-width: 640px) {
  .sitemap__directory {
    padding: 0.75rem 1.75rem 2rem;
  }
}

@media (min-width: 900px) {
  .sitemap__directory {
    grid-template-columns: 1fr 1fr;
  }
}

.sitemap__branch {
  scroll-margin-top: 5.5rem;
  min-width: 0;
}

.sitemap__branch-title {
  font-family: var(--font-idcbis-display);
  font-size: 1.125rem;
  font-weight: 800;
  line-height: 1.3;
  color: #003c5f;
  margin: 0 0 0.4rem;
  padding-bottom: 0.65rem;
  border-bottom: 2px solid #005674;
}

.sitemap__branch-link,
.sitemap__branch-label {
  display: inline-flex;
  align-items: center;
  gap: 0.55rem;
  color: inherit;
  text-decoration: none;
  border-radius: 4px;
}

.sitemap__branch-link:hover {
  color: #008996;
}

.sitemap__branch-link:focus-visible {
  outline: 2px solid #005674;
  outline-offset: 3px;
}

.sitemap__branch-icon {
  font-size: 1.2rem;
  color: #005674;
}

.sitemap__branch-desc {
  margin: 0 0 0.65rem;
  font-size: 0.8125rem;
  line-height: 1.5;
  color: #607d8b;
}

.sitemap__list {
  list-style: none;
  margin: 0;
  padding: 0;
}

.sitemap__list--nested {
  margin: 0 0 0.25rem 1.35rem;
  padding-left: 0.85rem;
  border-left: 1px solid #d4e4ea;
}

.sitemap__item + .sitemap__item {
  border-top: 1px solid #f0f4f6;
}

.sitemap__link {
  display: flex;
  align-items: center;
  gap: 0.7rem;
  min-height: 44px;
  padding: 0.35rem 0.4rem 0.35rem 0.15rem;
  color: #1a1a1a;
  text-decoration: none;
  font-size: 0.95rem;
  line-height: 1.4;
  border-radius: 6px;
}

.sitemap__link:hover {
  color: #005674;
  background: #eef6f8;
}

.sitemap__link:focus-visible {
  outline: 2px solid #005674;
  outline-offset: 2px;
}

.sitemap__link--pending {
  color: #4a5d66;
}

.sitemap__link-text {
  flex: 1;
  min-width: 0;
}

.sitemap__bullet {
  width: 6px;
  height: 6px;
  border-radius: 1px;
  background: #c4a140;
  flex-shrink: 0;
}

.sitemap__bullet--nested {
  background: #008996;
  border-radius: 50%;
}

.sitemap__soon {
  flex-shrink: 0;
  font-size: 0.6875rem;
  font-weight: 600;
  letter-spacing: 0.02em;
  color: #607d8b;
}

.sitemap__empty {
  text-align: center;
  padding: 3rem 1rem;
  color: #607d8b;
  border-top: 1px solid #e8eef2;
}

.sitemap__empty-btn {
  margin-top: 1rem;
  min-height: 44px;
  padding: 0.625rem 1.25rem;
  border-radius: 8px;
  border: 0;
  background: #005674;
  color: #fff;
  font-weight: 600;
  font-size: 0.875rem;
  cursor: pointer;
}

.sitemap__empty-btn:hover {
  background: #003c5f;
}

.sitemap__empty-btn:focus-visible {
  outline: 2px solid #005674;
  outline-offset: 3px;
}

.sitemap__help {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  margin-top: 1.25rem;
  padding: 1rem 1.15rem;
  background: transparent;
  border-radius: 0;
  border: 0;
  color: #607d8b;
  font-size: 0.875rem;
  line-height: 1.55;
}

.sitemap__help-icon {
  width: 1.15rem;
  height: 1.15rem;
  color: #005674;
  flex-shrink: 0;
  margin-top: 0.1rem;
}

.sitemap__help p {
  margin: 0;
}

:deep(.sitemap-link) {
  text-decoration: none;
  color: inherit;
}

@media (prefers-reduced-motion: reduce) {
  .sitemap__link,
  .sitemap__index-link,
  .sitemap__branch-link {
    transition: none;
  }
}
</style>
