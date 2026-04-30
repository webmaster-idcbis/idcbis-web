import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useCmsStore = defineStore('cms', () => {
  const pages = ref([]);
  const currentPage = ref(null);
  const components = ref([]);
  const loading = ref(false);

  const availableComponents = computed(() => [
    {
      type: 'hero',
      name: 'Hero Section',
      icon: 'Layout',
      defaultData: {
        title: 'Título Principal',
        subtitle: 'Subtítulo descriptivo',
        backgroundImage: '',
        ctaText: 'Ver más',
        ctaLink: '#'
      }
    },
    {
      type: 'text',
      name: 'Bloque de Texto',
      icon: 'Type',
      defaultData: {
        content: 'Contenido de texto aquí...',
        alignment: 'left'
      }
    },
    {
      type: 'cards',
      name: 'Tarjetas',
      icon: 'Grid3X3',
      defaultData: {
        columns: 3,
        items: [
          { title: 'Card 1', description: 'Descripción', image: '' },
          { title: 'Card 2', description: 'Descripción', image: '' },
          { title: 'Card 3', description: 'Descripción', image: '' }
        ]
      }
    },
    {
      type: 'image',
      name: 'Imagen',
      icon: 'Image',
      defaultData: {
        src: '',
        alt: '',
        caption: ''
      }
    },
    {
      type: 'gallery',
      name: 'Galería',
      icon: 'Images',
      defaultData: {
        images: []
      }
    },
    {
      type: 'button',
      name: 'Botón',
      icon: 'MousePointer',
      defaultData: {
        text: 'Click aquí',
        link: '#',
        style: 'primary'
      }
    },
    {
      type: 'news',
      name: 'Noticias/Posts',
      icon: 'Newspaper',
      defaultData: {
        category: '',
        limit: 3
      }
    }
  ]);

  const fetchPages = async () => {
    loading.value = true;
    try {
      const response = await axios.get('/api/pages');
      pages.value = response.data.data;
    } finally {
      loading.value = false;
    }
  };

  const fetchPage = async (id) => {
    loading.value = true;
    try {
      const response = await axios.get(`/api/pages/${id}`);
      currentPage.value = response.data.data;
      return currentPage.value;
    } finally {
      loading.value = false;
    }
  };

  const fetchPageBySlug = async (slug) => {
    loading.value = true;
    try {
      const response = await axios.get(`/api/pages/slug/${slug}`);
      currentPage.value = response.data.data;
      return currentPage.value;
    } finally {
      loading.value = false;
    }
  };

  const createPage = async (pageData) => {
    const response = await axios.post('/api/pages', pageData);
    pages.value.push(response.data.data);
    return response.data.data;
  };

  const updatePage = async (id, pageData) => {
    const response = await axios.put(`/api/pages/${id}`, pageData);
    const index = pages.value.findIndex(p => p.id === id);
    if (index !== -1) {
      pages.value[index] = response.data.data;
    }
    return response.data.data;
  };

  const deletePage = async (id) => {
    await axios.delete(`/api/pages/${id}`);
    pages.value = pages.value.filter(p => p.id !== id);
  };

  const publishPage = async (id) => {
    try {
      const response = await axios.patch(`/api/pages/${id}/publish`);
      const index = pages.value.findIndex(p => p.id === id);
      if (index !== -1) {
        pages.value[index] = response.data.data;
      }
      return response.data.data;
    } catch (error) {
      if (error.response?.status === 404) {
        // Página no existe en el servidor, eliminar del store
        pages.value = pages.value.filter(p => p.id !== id);
        throw new Error('La página no existe en el servidor. La lista será actualizada.');
      }
      throw error;
    }
  };

  return {
    pages,
    currentPage,
    components,
    loading,
    availableComponents,
    fetchPages,
    fetchPage,
    fetchPageBySlug,
    createPage,
    updatePage,
    deletePage,
    publishPage
  };
});
