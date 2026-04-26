<template>
  <div>
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-[#005674]/10">
            <FileText class="w-6 h-6 text-[#005674]" />
          </div>
          <div class="ml-4">
            <p class="text-sm text-gray-500">Total Páginas</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.totalPages }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-green-100">
            <CheckCircle class="w-6 h-6 text-green-600" />
          </div>
          <div class="ml-4">
            <p class="text-sm text-gray-500">Publicadas</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.publishedPages }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-yellow-100">
            <Clock class="w-6 h-6 text-yellow-600" />
          </div>
          <div class="ml-4">
            <p class="text-sm text-gray-500">Borradores</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.draftPages }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-3 rounded-full bg-[#008996]/10">
            <Users class="w-6 h-6 text-[#008996]" />
          </div>
          <div class="ml-4">
            <p class="text-sm text-gray-500">Usuarios</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.totalUsers }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Pages -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">Páginas Recientes</h2>
        <router-link 
          to="/admin/pages"
          class="text-sm text-[#005674] hover:text-[#003C5F]"
        >
          Ver todas
        </router-link>
      </div>
      
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="text-xs text-gray-500 uppercase bg-gray-50">
            <tr>
              <th class="px-6 py-3">Título</th>
              <th class="px-6 py-3">Estado</th>
              <th class="px-6 py-3">Autor</th>
              <th class="px-6 py-3">Última modificación</th>
              <th class="px-6 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="page in recentPages" :key="page.id" class="border-b hover:bg-gray-50">
              <td class="px-6 py-4 font-medium text-gray-900">{{ page.title }}</td>
              <td class="px-6 py-4">
                <span :class="[
                  'px-2 py-1 rounded-full text-xs font-medium',
                  page.status === 'published' ? 'bg-green-100 text-green-800' :
                  page.status === 'draft' ? 'bg-yellow-100 text-yellow-800' :
                  'bg-gray-100 text-gray-800'
                ]">
                  {{ page.status === 'published' ? 'Publicada' : 
                     page.status === 'draft' ? 'Borrador' : 'Archivada' }}
                </span>
              </td>
              <td class="px-6 py-4">{{ page.creator?.name }}</td>
              <td class="px-6 py-4">{{ formatDate(page.updated_at) }}</td>
              <td class="px-6 py-4">
                <router-link 
                  :to="`/admin/pages/${page.id}/edit`"
                  class="text-[#005674] hover:text-[#003C5F] font-medium"
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
