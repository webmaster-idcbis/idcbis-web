<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-[#e6edf3]">Gestión de Páginas</h1>
      <router-link
        v-if="authStore.hasPermission('pages.create')"
        to="/admin/pages/create"
        class="px-4 py-2 bg-[#005674] dark:bg-[#58a6ff] text-white rounded-lg hover:bg-[#003C5F] dark:hover:bg-[#79c0ff] transition-colors flex items-center gap-2"
      >
        <Plus class="w-5 h-5" />
        Nueva Página
      </router-link>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d] p-4 mb-6">
      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
          <input 
            v-model="search"
            type="text" 
            placeholder="Buscar páginas..."
            class="w-full px-4 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
          >
        </div>
        <select 
          v-model="statusFilter"
          class="px-4 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
        >
          <option value="">Todos los estados</option>
          <option value="published">Publicadas</option>
          <option value="draft">Borradores</option>
          <option value="archived">Archivadas</option>
        </select>
      </div>
    </div>

    <!-- Pages Table -->
    <div class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d] overflow-hidden">
      <table class="w-full text-sm text-left">
        <thead class="text-xs text-gray-500 dark:text-[#8b949e] uppercase bg-gray-50 dark:bg-[#21262d]">
          <tr>
            <th class="px-6 py-3">Título</th>
            <th class="px-6 py-3">Slug</th>
            <th class="px-6 py-3">Estado</th>
            <th class="px-6 py-3">Autor</th>
            <th class="px-6 py-3">Modificado</th>
            <th class="px-6 py-3 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="page in filteredPages" :key="page.id" class="border-b border-gray-200 dark:border-[#30363d] hover:bg-gray-50 dark:hover:bg-[#21262d]">
            <td class="px-6 py-4 font-medium text-gray-900 dark:text-[#e6edf3]">{{ page.title }}</td>
            <td class="px-6 py-4 text-gray-500 dark:text-[#8b949e]">/{{ page.slug }}</td>
            <td class="px-6 py-4">
              <span :class="[
                'px-2 py-1 rounded-full text-xs font-medium',
                page.status === 'published' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' :
                page.status === 'draft' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400' :
                'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-400'
              ]">
                {{ page.status === 'published' ? 'Publicada' : 
                   page.status === 'draft' ? 'Borrador' : 'Archivada' }}
              </span>
            </td>
            <td class="px-6 py-4 text-gray-500 dark:text-[#8b949e]">{{ page.creator?.name }}</td>
            <td class="px-6 py-4 text-gray-500 dark:text-[#8b949e]">{{ formatDate(page.updated_at) }}</td>
            <td class="px-6 py-4 text-right">
              <div class="flex items-center justify-end gap-2">
                <button
                  v-if="page.status !== 'published' && authStore.hasPermission('pages.publish')"
                  @click="publishPage(page.id)"
                  class="p-2 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 rounded"
                  title="Publicar"
                >
                  <CheckCircle class="w-4 h-4" />
                </button>
                <router-link
                  :to="`/${page.slug}`"
                  target="_blank"
                  class="p-2 text-gray-600 dark:text-[#8b949e] hover:bg-gray-100 dark:hover:bg-[#21262d] rounded"
                  title="Ver"
                >
                  <Eye class="w-4 h-4" />
                </router-link>
                <router-link
                  v-if="authStore.hasPermission('pages.edit')"
                  :to="`/admin/pages/${page.id}/edit`"
                  class="p-2 text-[#005674] dark:text-[#58a6ff] hover:bg-[#005674]/10 dark:hover:bg-[#58a6ff]/10 rounded"
                  title="Editar"
                >
                  <Pencil class="w-4 h-4" />
                </router-link>
                <button
                  v-if="authStore.hasPermission('pages.delete')"
                  @click="deletePage(page.id)"
                  class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded"
                  title="Eliminar"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      
      <div v-if="filteredPages.length === 0" class="text-center py-12 text-gray-500">
        No se encontraron páginas
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Plus, Pencil, Trash2, Eye, CheckCircle } from 'lucide-vue-next';
import { useCmsStore } from '../../stores/cms';
import { useAuthStore } from '../../stores/auth';

const cmsStore = useCmsStore();
const authStore = useAuthStore();

const search = ref('');
const statusFilter = ref('');

const filteredPages = computed(() => {
  let pages = cmsStore.pages;
  
  if (search.value) {
    pages = pages.filter(p => 
      p.title.toLowerCase().includes(search.value.toLowerCase()) ||
      p.slug.toLowerCase().includes(search.value.toLowerCase())
    );
  }
  
  if (statusFilter.value) {
    pages = pages.filter(p => p.status === statusFilter.value);
  }
  
  return pages;
});

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-CO', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const publishPage = async (id) => {
  console.log('Intentando publicar página con ID:', id, 'tipo:', typeof id);
  
  // Validar que el ID sea válido
  if (!id || typeof id !== 'number') {
    alert('ID de página inválido');
    return;
  }
  
  // Buscar la página en la lista actual
  const page = cmsStore.pages.find(p => p.id === id);
  if (!page) {
    alert('La página no existe en la lista actual. Recargando...');
    await cmsStore.fetchPages();
    return;
  }
  
  if (!confirm(`¿Estás seguro de publicar la página "${page.title}"?`)) return;
  
  try {
    await cmsStore.publishPage(id);
    alert('Página publicada exitosamente');
    await cmsStore.fetchPages();
  } catch (error) {
    console.error('Error completo:', error);
    console.error('Response data:', error.response?.data);
    if (error.response?.status === 404) {
      alert('La página no existe en el servidor. La lista se ha actualizada.');
      await cmsStore.fetchPages();
    } else {
      alert('Error al publicar la página: ' + (error.response?.data?.message || error.message));
    }
  }
};

const deletePage = async (id) => {
  if (!confirm('¿Estás seguro de eliminar esta página? Esta acción no se puede deshacer.')) return;
  try {
    await cmsStore.deletePage(id);
  } catch (error) {
    alert('Error al eliminar la página');
  }
};

onMounted(async () => {
  await cmsStore.fetchPages();
  console.log('Páginas cargadas:', cmsStore.pages);
});
</script>
