<template>
  <MainLayout>
    <section class="search-page">
      <div class="search-page__hero">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <h1 class="search-page__title">Buscar en IDCBIS</h1>
          <p class="search-page__subtitle">
            Encuentra información en todas las páginas publicadas del sitio.
          </p>
          <form class="search-page__form" @submit.prevent="performSearch">
            <input
              v-model="query"
              type="search"
              placeholder="¿Qué estás buscando?"
              class="search-page__input"
              autofocus
            >
            <button type="submit" class="search-page__button" :disabled="loading">
              {{ loading ? 'Buscando…' : 'Buscar' }}
            </button>
          </form>
        </div>
      </div>

      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div v-if="!hasSearched" class="search-page__hint">
          Escribe al menos 2 caracteres para iniciar la búsqueda.
        </div>

        <div v-else-if="loading" class="flex justify-center py-12">
          <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-[#005674]" />
        </div>

        <div v-else-if="error" class="search-page__error">
          {{ error }}
        </div>

        <div v-else-if="results.length === 0" class="search-page__empty">
          <p>No encontramos resultados para <strong>“{{ lastQuery }}”</strong>.</p>
          <p class="mt-2 text-sm text-gray-500">Prueba con otras palabras o términos más generales.</p>
        </div>

        <div v-else>
          <p class="search-page__count">
            {{ results.length }} resultado(s) para “{{ lastQuery }}”
          </p>
          <ul class="search-page__results">
            <li v-for="item in results" :key="item.id" class="search-page__result">
              <router-link :to="item.url" class="search-page__result-link">
                <h2>{{ item.title }}</h2>
                <p v-if="item.excerpt">{{ item.excerpt }}</p>
                <span class="search-page__result-url">{{ item.url }}</span>
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </section>
  </MainLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import MainLayout from '../components/layout/MainLayout.vue';
import { useSearchStore } from '../stores/search';

const route = useRoute();
const router = useRouter();
const searchStore = useSearchStore();

const query = ref('');
const hasSearched = ref(false);

const results = computed(() => searchStore.results);
const loading = computed(() => searchStore.loading);
const error = computed(() => searchStore.error);
const lastQuery = computed(() => searchStore.lastQuery);

const performSearch = async () => {
  const trimmed = query.value.trim();

  if (trimmed !== (route.query.q || '')) {
    await router.replace({ name: 'Search', query: trimmed ? { q: trimmed } : {} });
  }

  if (trimmed.length < 2) {
    searchStore.clear();
    hasSearched.value = false;
    return;
  }

  hasSearched.value = true;
  await searchStore.search(trimmed, 30);
};

watch(
  () => route.query.q,
  (value) => {
    query.value = typeof value === 'string' ? value : '';
    if (query.value.trim().length >= 2) {
      performSearch();
    }
  },
  { immediate: true },
);
</script>

<style scoped>
.search-page__hero {
  background: linear-gradient(135deg, #005674 0%, #008996 100%);
  color: #fff;
  padding: 3rem 0 2.5rem;
}

.search-page__title {
  font-size: clamp(1.75rem, 4vw, 2.5rem);
  font-weight: 700;
  margin-bottom: 0.5rem;
}

.search-page__subtitle {
  color: rgba(255, 255, 255, 0.85);
  margin-bottom: 1.5rem;
}

.search-page__form {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

@media (min-width: 640px) {
  .search-page__form {
    flex-direction: row;
  }
}

.search-page__input {
  flex: 1;
  height: 48px;
  border-radius: 9999px;
  border: 0;
  padding: 0 1.25rem;
  color: #1e293b;
  font-size: 1rem;
}

.search-page__button {
  height: 48px;
  padding: 0 1.5rem;
  border: 0;
  border-radius: 9999px;
  background: #fff;
  color: #005674;
  font-weight: 700;
  cursor: pointer;
}

.search-page__button:disabled {
  opacity: 0.7;
  cursor: wait;
}

.search-page__hint,
.search-page__empty,
.search-page__error {
  text-align: center;
  color: #64748b;
  padding: 2rem 0;
}

.search-page__error {
  color: #b91c1c;
}

.search-page__count {
  margin-bottom: 1rem;
  color: #64748b;
  font-size: 0.9375rem;
}

.search-page__results {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  gap: 1rem;
}

.search-page__result {
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  overflow: hidden;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.search-page__result:hover {
  border-color: #94a3b8;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
}

.search-page__result-link {
  display: block;
  padding: 1.25rem 1.5rem;
  text-decoration: none;
  color: inherit;
}

.search-page__result-link h2 {
  font-size: 1.125rem;
  font-weight: 700;
  color: #005674;
  margin-bottom: 0.35rem;
}

.search-page__result-link p {
  color: #475569;
  line-height: 1.6;
  margin-bottom: 0.5rem;
}

.search-page__result-url {
  font-size: 0.8125rem;
  color: #94a3b8;
}
</style>
