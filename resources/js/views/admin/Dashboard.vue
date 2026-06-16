<template>
  <div>
    <h1 class="text-xl font-bold text-gray-900 dark:text-[#e6edf3] mb-4">Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6">
      <div class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d] p-4">
        <div class="flex items-center">
          <div class="p-2 rounded-full bg-[#005674]/10 dark:bg-[#58a6ff]/20">
            <FileText class="w-5 h-5 text-[#005674] dark:text-[#58a6ff]" />
          </div>
          <div class="ml-3">
            <p class="text-xs text-gray-500 dark:text-[#8b949e]">Total Páginas</p>
            <p class="text-xl font-bold text-gray-900 dark:text-[#e6edf3]">{{ stats.totalPages }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d] p-4">
        <div class="flex items-center">
          <div class="p-2 rounded-full bg-green-100 dark:bg-green-900/30">
            <CheckCircle class="w-5 h-5 text-green-600 dark:text-green-400" />
          </div>
          <div class="ml-3">
            <p class="text-xs text-gray-500 dark:text-[#8b949e]">Publicadas</p>
            <p class="text-xl font-bold text-gray-900 dark:text-[#e6edf3]">{{ stats.publishedPages }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d] p-4">
        <div class="flex items-center">
          <div class="p-2 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
            <Clock class="w-5 h-5 text-yellow-600 dark:text-yellow-400" />
          </div>
          <div class="ml-3">
            <p class="text-xs text-gray-500 dark:text-[#8b949e]">Borradores</p>
            <p class="text-xl font-bold text-gray-900 dark:text-[#e6edf3]">{{ stats.draftPages }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d] p-4">
        <div class="flex items-center">
          <div class="p-2 rounded-full bg-[#008996]/10 dark:bg-[#79c0ff]/20">
            <Users class="w-5 h-5 text-[#008996] dark:text-[#79c0ff]" />
          </div>
          <div class="ml-3">
            <p class="text-xs text-gray-500 dark:text-[#8b949e]">Usuarios</p>
            <p class="text-xl font-bold text-gray-900 dark:text-[#e6edf3]">{{ stats.totalUsers }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Pages -->
    <div class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d]">
      <div class="px-4 py-3 border-b border-gray-200 dark:border-[#30363d] flex justify-between items-center">
        <h2 class="text-base font-semibold text-gray-900 dark:text-[#e6edf3]">Páginas Recientes</h2>
        <router-link 
          to="/admin/pages"
          class="text-xs text-[#005674] dark:text-[#58a6ff] hover:text-[#003C5F] dark:hover:text-[#79c0ff]"
        >
          Ver todas
        </router-link>
      </div>
      
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="text-xs text-gray-500 dark:text-[#8b949e] uppercase bg-gray-50 dark:bg-[#21262d]">
            <tr>
              <th class="px-4 py-2">Título</th>
              <th class="px-4 py-2">Estado</th>
              <th class="px-4 py-2">Autor</th>
              <th class="px-4 py-2">Modificado</th>
              <th class="px-4 py-2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="page in recentPages" :key="page.id" class="border-b border-gray-200 dark:border-[#30363d] hover:bg-gray-50 dark:hover:bg-[#21262d]">
              <td class="px-4 py-2 font-medium text-gray-900 dark:text-[#e6edf3]">{{ page.title }}</td>
              <td class="px-4 py-2">
                <span :class="[
                  'px-2 py-0.5 rounded-full text-xs font-medium',
                  page.status === 'published' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' :
                  page.status === 'draft' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400' :
                  'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-400'
                ]">
                  {{ page.status === 'published' ? 'Publicada' : 
                     page.status === 'draft' ? 'Borrador' : 'Archivada' }}
                </span>
              </td>
              <td class="px-4 py-2 text-xs text-gray-500 dark:text-[#8b949e]">{{ page.creator?.name }}</td>
              <td class="px-4 py-2 text-xs text-gray-500 dark:text-[#8b949e]">{{ formatDate(page.updated_at) }}</td>
              <td class="px-4 py-2">
                <router-link 
                  :to="`/admin/pages/${page.id}/edit`"
                  class="text-xs text-[#005674] dark:text-[#58a6ff] hover:text-[#003C5F] dark:hover:text-[#79c0ff] font-medium"
                >
                  Editar
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { FileText, CheckCircle, Clock, Users } from 'lucide-vue-next';
import { useCmsStore } from '../../stores/cms';

const cmsStore = useCmsStore();

const stats = ref({
  totalPages: 0,
  publishedPages: 0,
  draftPages: 0,
  totalUsers: 0
});

const recentPages = ref([]);

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-CO', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

onMounted(async () => {
  await cmsStore.fetchPages();
  recentPages.value = cmsStore.pages.slice(0, 5);
  stats.value.totalPages = cmsStore.pages.length;
  stats.value.publishedPages = cmsStore.pages.filter(p => p.status === 'published').length;
  stats.value.draftPages = cmsStore.pages.filter(p => p.status === 'draft').length;
});
</script>
