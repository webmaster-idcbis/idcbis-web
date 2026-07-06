<template>
  <section class="sitemap" @click.stop="!preview && $emit('click', element)">
    <!-- Cabecera -->
    <header v-if="showHero" class="sitemap__hero">
      <div class="sitemap__hero-inner">
        <p class="sitemap__eyebrow">Navegación</p>
        <h1 class="sitemap__title">{{ element.title || 'Mapa del sitio' }}</h1>
        <p v-if="element.subtitle" class="sitemap__subtitle">{{ element.subtitle }}</p>

        <div class="sitemap__search-wrap">
          <Search class="sitemap__search-icon" aria-hidden="true" />
          <input
            v-model="searchQuery"
            type="search"
            class="sitemap__search-input"
            placeholder="Buscar sección o página…"
            aria-label="Filtrar mapa del sitio"
          >
          <button
            v-if="searchQuery"
            type="button"
            class="sitemap__search-clear"
            aria-label="Limpiar búsqueda"
            @click="searchQuery = ''"
          >
            <X class="h-4 w-4" />
          </button>
        </div>

        <div class="sitemap__stats">
          <span><strong>{{ totalPages }}</strong> páginas</span>
          <span class="sitemap__stats-dot" aria-hidden="true">·</span>
          <span><strong>{{ publishedCount }}</strong> disponibles</span>
        </div>
      </div>
    </header>

    <!-- Accesos rápidos -->
    <div v-if="!searchQuery && quickAnchors.length" class="sitemap__anchors">
      <div class="sitemap__anchors-inner">
        <button
          v-for="anchor in quickAnchors"
          :key="anchor.id"
          type="button"
          class="sitemap__anchor"
          @click="scrollTo(anchor.id)"
        >
          <span aria-hidden="true">{{ anchor.icon }}</span>
          {{ anchor.label }}
        </button>
      </div>
    </div>

    <div class="sitemap__body">
      <!-- Sin resultados -->
      <div v-if="isEmpty" class="sitemap__empty">
        <p>No hay resultados para «{{ searchQuery }}».</p>
        <button type="button" class="sitemap__empty-btn" @click="searchQuery = ''">
          Ver todo el mapa
        </button>
      </div>

      <!-- Secciones principales -->
      <div v-if="filtered.sections.length" class="sitemap__main-grid">
        <article
          v-for="section in filtered.sections"
          :id="`sitemap-${section.slug}`"
          :key="section.slug"
          class="sitemap__card"
        >
          <div class="sitemap__card-head">
            <span class="sitemap__card-icon" aria-hidden="true">{{ section.icon || '📄' }}</span>
            <div class="sitemap__card-head-text">
              <SitemapLink
                :slug="section.slug"
                :preview="preview"
                class="sitemap__card-title"
                @navigate="onLinkClick"
              >
                {{ section.title }}
              </SitemapLink>
              <p v-if="section.description" class="sitemap__card-desc">{{ section.description }}</p>
            </div>
            <span
              class="sitemap__status"
              :class="isPublished(section.slug) ? 'sitemap__status--live' : 'sitemap__status--soon'"
            >
              {{ isPublished(section.slug) ? 'Disponible' : 'En preparación' }}
            </span>
          </div>

          <ul v-if="section.children?.length" class="sitemap__child-list">
            <li v-for="child in section.children" :key="child.slug">
              <SitemapLink
                :slug="child.slug"
                :preview="preview"
                class="sitemap__child-link"
                @navigate="onLinkClick"
              >
                <span v-if="child.icon" class="sitemap__child-icon" aria-hidden="true">{{ child.icon }}</span>
                <span class="sitemap__child-label">{{ child.title }}</span>
                <ChevronRight class="sitemap__child-arrow" aria-hidden="true" />
              </SitemapLink>
            </li>
          </ul>
        </article>
      </div>

      <!-- Enlaces agrupados -->
      <div
        v-for="group in filtered.quickLinks"
        :id="`sitemap-group-${slugify(group.group)}`"
        :key="group.group"
        class="sitemap__group"
      >
        <div class="sitemap__group-head">
          <span class="sitemap__group-icon" aria-hidden="true">{{ group.icon }}</span>
          <h2 class="sitemap__group-title">{{ group.group }}</h2>
        </div>
        <ul class="sitemap__quick-grid">
          <li v-for="item in group.items" :key="item.slug">
            <SitemapLink
              :slug="item.slug"
              :preview="preview"
              class="sitemap__quick-link"
              @navigate="onLinkClick"
            >
              <span v-if="item.icon" class="sitemap__quick-icon" aria-hidden="true">{{ item.icon }}</span>
              <span>{{ item.title }}</span>
              <span
                class="sitemap__quick-dot"
                :class="isPublished(item.slug) ? 'sitemap__quick-dot--live' : ''"
                :title="isPublished(item.slug) ? 'Disponible' : 'En preparación'"
              />
            </SitemapLink>
          </li>
        </ul>
      </div>

      <aside v-if="element.showNote !== false && !searchQuery" class="sitemap__help">
        <Info class="sitemap__help-icon" aria-hidden="true" />
        <p>
          Usa el buscador para encontrar rápidamente una sección.
          Las páginas «En preparación» se irán publicando progresivamente.
        </p>
      </aside>
    </div>
  </section>
</template>

<script setup>
import { computed, ref, defineComponent, h } from 'vue';
import { RouterLink } from 'vue-router';
import { Search, X, ChevronRight, Info } from 'lucide-vue-next';
import {
  SITE_SITEMAP,
  SITEMAP_QUICK_LINKS,
  isSitemapPublished,
  sitemapItemUrl,
  countSitemapPages,
  countPublishedPages,
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

const filtered = computed(() => filterSitemapTree(searchQuery.value));
const totalPages = countSitemapPages();
const publishedCount = countPublishedPages();
const isPublished = isSitemapPublished;

const isEmpty = computed(
  () => !filtered.value.sections.length && !filtered.value.quickLinks.length,
);

const quickAnchors = computed(() => [
  ...SITE_SITEMAP.map((s) => ({ id: `sitemap-${s.slug}`, label: s.title, icon: s.icon || '📄' })),
  ...SITEMAP_QUICK_LINKS.map((g) => ({
    id: `sitemap-group-${slugify(g.group)}`,
    label: g.group,
    icon: g.icon,
  })),
]);

const slugify = (text) =>
  text
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-|-$/g, '');

const scrollTo = (id) => {
  if (!props.preview) return;
  const el = document.getElementById(id);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
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
  background: #f0f5f8;
  cursor: pointer;
}

.sitemap__hero {
  background: linear-gradient(145deg, #0b4f6c 0%, #2c8c99 55%, #4ecdc4 100%);
  color: #fff;
  padding: 3rem 1.5rem 2.75rem;
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
  font-size: clamp(1.875rem, 4vw, 2.75rem);
  font-weight: 800;
  line-height: 1.15;
  margin-bottom: 0.75rem;
}

.sitemap__subtitle {
  color: rgba(255, 255, 255, 0.88);
  line-height: 1.6;
  margin-bottom: 1.75rem;
  font-size: 1.0625rem;
}

.sitemap__search-wrap {
  position: relative;
  max-width: 480px;
  margin: 0 auto 1rem;
}

.sitemap__search-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  width: 1.125rem;
  height: 1.125rem;
  color: #64748b;
  pointer-events: none;
}

.sitemap__search-input {
  width: 100%;
  height: 48px;
  padding: 0 2.75rem 0 2.75rem;
  border: 0;
  border-radius: 9999px;
  font-size: 1rem;
  color: #1e293b;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
  outline: none;
}

.sitemap__search-input:focus {
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18), 0 0 0 3px rgba(255, 209, 102, 0.45);
}

.sitemap__search-clear {
  position: absolute;
  right: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  color: #94a3b8;
  padding: 0.25rem;
}

.sitemap__search-clear:hover {
  color: #475569;
}

.sitemap__stats {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  font-size: 0.875rem;
  color: rgba(255, 255, 255, 0.85);
}

.sitemap__stats strong {
  color: #C4A140;
  font-weight: 700;
}

.sitemap__stats-dot {
  opacity: 0.5;
}

.sitemap__anchors {
  background: #fff;
  border-bottom: 1px solid #e2e8f0;
  position: sticky;
  top: 0;
  z-index: 20;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.sitemap__anchors-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0.75rem 1rem;
  display: flex;
  gap: 0.5rem;
  overflow-x: auto;
  scrollbar-width: none;
}

.sitemap__anchors-inner::-webkit-scrollbar {
  display: none;
}

.sitemap__anchor {
  flex-shrink: 0;
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  padding: 0.5rem 1rem;
  border-radius: 9999px;
  border: 1px solid #e2e8f0;
  background: #f8fafc;
  color: #0b4f6c;
  font-size: 0.8125rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, transform 0.15s;
  white-space: nowrap;
}

.sitemap__anchor:hover {
  background: #e8f4f8;
  border-color: #2c8c99;
  transform: translateY(-1px);
}

.sitemap__body {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem 1rem 3rem;
}

.sitemap__main-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
  margin-bottom: 2.5rem;
}

@media (min-width: 768px) {
  .sitemap__main-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

.sitemap__card {
  background: #fff;
  border-radius: 20px;
  border: 1px solid #e8eef2;
  box-shadow: 0 4px 20px rgba(11, 79, 108, 0.06);
  overflow: hidden;
  scroll-margin-top: 5rem;
  transition: box-shadow 0.25s ease, transform 0.25s ease;
}

.sitemap__card:hover {
  box-shadow: 0 12px 32px rgba(11, 79, 108, 0.1);
  transform: translateY(-2px);
}

.sitemap__card-head {
  display: flex;
  align-items: flex-start;
  gap: 0.875rem;
  padding: 1.25rem 1.25rem 1rem;
  border-bottom: 1px solid #f1f5f9;
  background: linear-gradient(180deg, #fafcfd 0%, #fff 100%);
}

.sitemap__card-icon {
  font-size: 1.75rem;
  line-height: 1;
  flex-shrink: 0;
}

.sitemap__card-head-text {
  flex: 1;
  min-width: 0;
}

.sitemap__card-title {
  display: block;
  font-size: 1.125rem;
  font-weight: 800;
  color: #0b4f6c;
  text-decoration: none;
  line-height: 1.3;
  margin-bottom: 0.25rem;
}

.sitemap__card-title:hover {
  color: #2c8c99;
}

.sitemap__card-desc {
  font-size: 0.8125rem;
  color: #64748b;
  line-height: 1.45;
  margin: 0;
}

.sitemap__status {
  flex-shrink: 0;
  font-size: 0.625rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  padding: 0.25rem 0.5rem;
  border-radius: 6px;
}

.sitemap__status--live {
  background: #dcfce7;
  color: #166534;
}

.sitemap__status--soon {
  background: #f1f5f9;
  color: #64748b;
}

.sitemap__child-list {
  list-style: none;
  margin: 0;
  padding: 0.5rem 0;
}

.sitemap__child-link {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.7rem 1.25rem;
  color: #334155;
  text-decoration: none;
  font-size: 0.9rem;
  line-height: 1.4;
  transition: background 0.15s, color 0.15s, padding-left 0.15s;
}

.sitemap__child-link:hover {
  background: #f0f9fb;
  color: #0b4f6c;
  padding-left: 1.5rem;
}

.sitemap__child-icon {
  flex-shrink: 0;
  font-size: 1rem;
}

.sitemap__child-label {
  flex: 1;
}

.sitemap__child-arrow {
  width: 1rem;
  height: 1rem;
  color: #94a3b8;
  flex-shrink: 0;
  transition: transform 0.15s, color 0.15s;
}

.sitemap__child-link:hover .sitemap__child-arrow {
  color: #2c8c99;
  transform: translateX(3px);
}

.sitemap__group {
  margin-bottom: 2rem;
  scroll-margin-top: 5rem;
}

.sitemap__group-head {
  display: flex;
  align-items: center;
  gap: 0.625rem;
  margin-bottom: 1rem;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid #e2e8f0;
}

.sitemap__group-icon {
  font-size: 1.5rem;
}

.sitemap__group-title {
  font-size: 1.25rem;
  font-weight: 800;
  color: #0b4f6c;
  margin: 0;
}

.sitemap__quick-grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: 1fr;
  gap: 0.5rem;
}

@media (min-width: 640px) {
  .sitemap__quick-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .sitemap__quick-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.sitemap__quick-link {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.875rem 1rem;
  background: #fff;
  border: 1px solid #e8eef2;
  border-radius: 12px;
  color: #334155;
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 500;
  line-height: 1.35;
  transition: border-color 0.2s, background 0.2s, color 0.2s, box-shadow 0.2s;
}

.sitemap__quick-link:hover {
  border-color: #2c8c99;
  background: #f0f9fb;
  color: #0b4f6c;
  box-shadow: 0 4px 12px rgba(44, 140, 153, 0.12);
}

.sitemap__quick-icon {
  flex-shrink: 0;
}

.sitemap__quick-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #cbd5e1;
  margin-left: auto;
  flex-shrink: 0;
}

.sitemap__quick-dot--live {
  background: #22c55e;
  box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2);
}

.sitemap__empty {
  text-align: center;
  padding: 3rem 1rem;
  color: #64748b;
}

.sitemap__empty-btn {
  margin-top: 1rem;
  padding: 0.625rem 1.25rem;
  border-radius: 9999px;
  border: 0;
  background: #0b4f6c;
  color: #fff;
  font-weight: 600;
  font-size: 0.875rem;
  cursor: pointer;
}

.sitemap__help {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  margin-top: 2rem;
  padding: 1rem 1.25rem;
  background: #fff;
  border-radius: 14px;
  border: 1px dashed #cbd5e1;
  color: #64748b;
  font-size: 0.875rem;
  line-height: 1.55;
}

.sitemap__help-icon {
  width: 1.25rem;
  height: 1.25rem;
  color: #2c8c99;
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
</style>
