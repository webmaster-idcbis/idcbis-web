import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useMenusStore = defineStore('menus', () => {
  // State
  const menus = ref([]);
  const availablePages = ref([]);
  const loading = ref(false);
  const error = ref(null);

  // Getters
  const headerMenus = computed(() => menus.value.filter(m => m.location === 'header'));
  const footerMenus = computed(() => menus.value.filter(m => m.location === 'footer'));
  const activeMenus = computed(() => menus.value.filter(m => m.is_active));

  // Actions
  const fetchMenus = async () => {
    loading.value = true;
    try {
      const response = await axios.get('/api/menus');
      menus.value = response.data.data;
      return response.data.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al cargar menús';
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const fetchAvailablePages = async () => {
    try {
      const response = await axios.get('/api/menus-available-pages');
      availablePages.value = response.data.data;
      return response.data.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al cargar páginas';
      throw err;
    }
  };

  const createMenu = async (menuData) => {
    loading.value = true;
    try {
      const response = await axios.post('/api/menus', menuData);
      menus.value.push(response.data.data);
      return response.data.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al crear menú';
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const updateMenu = async (id, menuData) => {
    loading.value = true;
    try {
      const response = await axios.put(`/api/menus/${id}`, menuData);
      const index = menus.value.findIndex(m => m.id === id);
      if (index !== -1) {
        menus.value[index] = response.data.data;
      }
      return response.data.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al actualizar menú';
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const deleteMenu = async (id) => {
    loading.value = true;
    try {
      await axios.delete(`/api/menus/${id}`);
      menus.value = menus.value.filter(m => m.id !== id);
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al eliminar menú';
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const getPublicMenu = async (location = 'header') => {
    try {
      const response = await axios.get('/api/menus/public', {
        params: { location }
      });
      return response.data.data;
    } catch (err) {
      console.error('Error al obtener menú público:', err);
      return null;
    }
  };

  return {
    menus,
    availablePages,
    loading,
    error,
    headerMenus,
    footerMenus,
    activeMenus,
    fetchMenus,
    fetchAvailablePages,
    createMenu,
    updateMenu,
    deleteMenu,
    getPublicMenu
  };
});
