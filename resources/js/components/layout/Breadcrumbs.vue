<template>
  <nav
    v-if="visible && items.length > 1"
    class="breadcrumbs"
    :aria-label="t('breadcrumbs.aria')"
  >
    <ol
      class="breadcrumbs__list"
      itemscope
      itemtype="https://schema.org/BreadcrumbList"
    >
      <li
        v-for="(item, index) in items"
        :key="`${item.to}-${index}`"
        class="breadcrumbs__item"
        itemprop="itemListElement"
        itemscope
        itemtype="https://schema.org/ListItem"
      >
        <span v-if="index > 0" class="breadcrumbs__sep" aria-hidden="true">/</span>
        <router-link
          v-if="!item.current"
          :to="item.to"
          class="breadcrumbs__link"
          itemprop="item"
        >
          <span itemprop="name">{{ item.label }}</span>
        </router-link>
        <span
          v-else
          class="breadcrumbs__current"
          itemprop="name"
          aria-current="page"
        >
          {{ item.label }}
        </span>
        <meta itemprop="position" :content="String(index + 1)">
      </li>
    </ol>
  </nav>
</template>

<script setup>
import { useI18n } from '../../i18n'
import { useBreadcrumbs } from '../../composables/useBreadcrumbs'

const { t } = useI18n()
const { visible, items } = useBreadcrumbs()
</script>

<style scoped>
.breadcrumbs {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  z-index: 6;
  pointer-events: none;
  margin: 0;
  padding: 1.15rem 1rem 0;
  background: none;
  border: 0;
  font-family: var(--font-idcbis);
}

@media (min-width: 640px) {
  .breadcrumbs {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
  }
}

@media (min-width: 1024px) {
  .breadcrumbs {
    padding-left: 2rem;
    padding-right: 2rem;
  }
}

.breadcrumbs__list {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  max-width: 80rem;
  margin: 0 auto;
  padding: 0;
  list-style: none;
  pointer-events: auto;
}

.breadcrumbs__item {
  display: inline-flex;
  align-items: center;
  min-width: 0;
  max-width: 100%;
}

.breadcrumbs__sep {
  margin: 0 0.45rem;
  color: inherit;
  opacity: 0.55;
  font-weight: 500;
}

.breadcrumbs__link,
.breadcrumbs__current {
  font-size: 0.8125rem;
  font-weight: 600;
  line-height: 1.4;
  letter-spacing: 0.01em;
}

.breadcrumbs__link {
  color: inherit;
  text-decoration: none;
  border-radius: 2px;
}

.breadcrumbs__link:hover {
  color: #c4a140;
  text-decoration: underline;
  text-underline-offset: 3px;
}

.breadcrumbs__link:focus-visible {
  outline: 2px solid #c4a140;
  outline-offset: 3px;
}

.breadcrumbs__current {
  opacity: 0.92;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  max-width: min(42ch, 68vw);
}
</style>
