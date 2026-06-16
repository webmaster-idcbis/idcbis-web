import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';

export const useSearchStore = defineStore('search', () => {
  const results = ref([]);
  const loading = ref(false);
  const error = ref(null);
  const lastQuery = ref('');

  const search = async (query, limit = 20) => {
    const trimmed = (query || '').trim();
    lastQuery.value = trimmed;

    if (trimmed.length < 2) {
      results.value = [];
      return [];
    }

    loading.value = true;
    error.value = null;

    try {
      const response = await axios.get('/api/search', {
        params: { q: trimmed, limit },
      });
      results.value = response.data.data || [];
      return results.value;
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al buscar';
      results.value = [];
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const clear = () => {
    results.value = [];
    lastQuery.value = '';
    error.value = null;
  };

  return {
    results,
    loading,
    error,
    lastQuery,
    search,
    clear,
  };
});
