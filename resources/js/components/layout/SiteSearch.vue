<template>
  <div ref="rootRef" class="site-search relative">
    <form class="relative" @submit.prevent="goToResults">
      <label :for="inputId" class="sr-only">Buscar en el sitio</label>
      <Search class="site-search__icon" aria-hidden="true" />
      <input
        :id="inputId"
        v-model="query"
        type="search"
        autocomplete="off"
        placeholder="Buscar…"
        class="site-search__input"
        @focus="openDropdown = true"
        @keydown.escape="closeDropdown"
        @keydown.down.prevent="moveHighlight(1)"
        @keydown.up.prevent="moveHighlight(-1)"
        @keydown.enter.prevent="submitSearch"
      >
      <button
        v-if="query"
        type="button"
        class="site-search__clear"
        aria-label="Limpiar búsqueda"
        @click="clearSearch"
      >
        <X class="h-4 w-4" />
      </button>
    </form>

    <div
      v-if="openDropdown && (loading || results.length || (query.length >= 2 && !loading))"
      class="site-search__dropdown"
    >
      <div v-if="loading" class="site-search__status">Buscando…</div>

      <template v-else-if="results.length">
        <p class="site-search__summary">{{ results.length }} resultado(s)</p>
        <ul class="site-search__list">
          <li v-for="(item, index) in results.slice(0, 6)" :key="item.id">
            <router-link
              :to="item.url"
              class="site-search__item"
              :class="{ 'site-search__item--active': highlightedIndex === index }"
              @click="closeDropdown"
              @mouseenter="highlightedIndex = index"
            >
              <span class="site-search__item-title">{{ item.title }}</span>
              <span v-if="item.excerpt" class="site-search__item-excerpt">{{ item.excerpt }}</span>
            </router-link>
          </li>
        </ul>
        <button type="button" class="site-search__view-all" @click="goToResults">
          Ver todos los resultados
        </button>
      </template>

      <div v-else-if="query.length >= 2" class="site-search__status">
        No se encontraron resultados para “{{ query }}”.
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';
import { useRouter } from 'vue-router';
import { Search, X } from 'lucide-vue-next';
import { useSearchStore } from '../../stores/search';

const props = defineProps({
  compact: { type: Boolean, default: false },
});

const router = useRouter();
const searchStore = useSearchStore();

const inputId = `site-search-${Math.random().toString(36).slice(2, 8)}`;
const rootRef = ref(null);
const query = ref('');
const openDropdown = ref(false);
const highlightedIndex = ref(-1);
const results = ref([]);
const loading = ref(false);

let debounceTimer = null;

const runSearch = async (value) => {
  if ((value || '').trim().length < 2) {
    results.value = [];
    return;
  }

  loading.value = true;
  try {
    results.value = await searchStore.search(value, props.compact ? 6 : 8);
    highlightedIndex.value = results.value.length ? 0 : -1;
  } catch {
    results.value = [];
  } finally {
    loading.value = false;
  }
};

watch(query, (value) => {
  openDropdown.value = true;
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => runSearch(value), 300);
});

const closeDropdown = () => {
  openDropdown.value = false;
  highlightedIndex.value = -1;
};

const clearSearch = () => {
  query.value = '';
  results.value = [];
  closeDropdown();
};

const goToResults = () => {
  const trimmed = query.value.trim();
  if (trimmed.length < 2) return;
  closeDropdown();
  router.push({ name: 'Search', query: { q: trimmed } });
};

const submitSearch = () => {
  if (highlightedIndex.value >= 0 && results.value[highlightedIndex.value]) {
    closeDropdown();
    router.push(results.value[highlightedIndex.value].url);
    return;
  }
  goToResults();
};

const moveHighlight = (direction) => {
  if (!results.value.length) return;
  const max = Math.min(results.value.length, 6) - 1;
  if (highlightedIndex.value < 0) {
    highlightedIndex.value = direction > 0 ? 0 : max;
    return;
  }
  highlightedIndex.value = Math.max(0, Math.min(max, highlightedIndex.value + direction));
};

const onClickOutside = (event) => {
  if (rootRef.value && !rootRef.value.contains(event.target)) {
    closeDropdown();
  }
};

onMounted(() => {
  document.addEventListener('click', onClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener('click', onClickOutside);
  clearTimeout(debounceTimer);
});
</script>

<style scoped>
.site-search {
  width: 100%;
  max-width: 220px;
}

.site-search__input {
  width: 100%;
  height: 38px;
  padding: 0 2.25rem 0 2.5rem;
  border-radius: 9999px;
  border: 1px solid rgba(255, 255, 255, 0.25);
  background: rgba(255, 255, 255, 0.12);
  color: #fff;
  font-size: 0.875rem;
  outline: none;
  transition: background 0.2s ease, border-color 0.2s ease;
}

.site-search__input::placeholder {
  color: rgba(255, 255, 255, 0.65);
}

.site-search__input:focus {
  background: rgba(255, 255, 255, 0.18);
  border-color: rgba(255, 255, 255, 0.45);
}

.site-search__icon {
  position: absolute;
  left: 0.85rem;
  top: 50%;
  transform: translateY(-50%);
  width: 1rem;
  height: 1rem;
  color: rgba(255, 255, 255, 0.75);
  pointer-events: none;
}

.site-search__clear {
  position: absolute;
  right: 0.5rem;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: rgba(255, 255, 255, 0.75);
}

.site-search__clear:hover {
  color: #fff;
}

.site-search__dropdown {
  position: absolute;
  top: calc(100% + 0.5rem);
  left: 0;
  right: 0;
  min-width: 280px;
  background: #fff;
  color: #1e293b;
  border-radius: 12px;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.18);
  overflow: hidden;
  z-index: 50;
}

.site-search__summary {
  padding: 0.65rem 1rem 0;
  font-size: 0.75rem;
  color: #64748b;
}

.site-search__list {
  list-style: none;
  margin: 0;
  padding: 0.35rem 0;
}

.site-search__item {
  display: block;
  padding: 0.65rem 1rem;
  text-decoration: none;
  color: inherit;
}

.site-search__item:hover,
.site-search__item--active {
  background: #f1f5f9;
}

.site-search__item-title {
  display: block;
  font-size: 0.875rem;
  font-weight: 600;
  color: #005674;
}

.site-search__item-excerpt {
  display: block;
  margin-top: 0.15rem;
  font-size: 0.75rem;
  line-height: 1.4;
  color: #64748b;
}

.site-search__view-all {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 0;
  border-top: 1px solid #e2e8f0;
  background: #f8fafc;
  color: #005674;
  font-size: 0.8125rem;
  font-weight: 600;
  cursor: pointer;
}

.site-search__view-all:hover {
  background: #eef2f7;
}

.site-search__status {
  padding: 1rem;
  font-size: 0.875rem;
  color: #64748b;
}

.sr-only {
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

@media (min-width: 1024px) {
  .site-search {
    max-width: 240px;
  }
}
</style>
