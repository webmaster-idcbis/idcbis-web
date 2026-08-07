<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-[#e6edf3]">Noticias</h1>
      <router-link
        v-if="authStore.hasPermission('posts.create')"
        to="/admin/posts/create"
        class="px-4 py-2 bg-[#005674] dark:bg-[#58a6ff] text-white rounded-lg hover:bg-[#003C5F] dark:hover:bg-[#79c0ff] transition-colors flex items-center gap-2"
      >
        <Plus class="w-5 h-5" />
        Nueva noticia
      </router-link>
    </div>

    <div class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d] p-4 mb-6">
      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
          <input
            v-model="search"
            type="search"
            placeholder="Buscar noticias..."
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
        <select
          v-model="categoryFilter"
          class="px-4 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
        >
          <option value="">Todas las categorías</option>
          <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.label }}</option>
        </select>
      </div>
    </div>

    <div class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d] overflow-hidden">
      <table class="w-full text-sm text-left">
        <thead class="text-xs text-gray-500 dark:text-[#8b949e] uppercase bg-gray-50 dark:bg-[#21262d]">
          <tr>
            <th class="px-6 py-3">Título</th>
            <th class="px-6 py-3">Categoría</th>
            <th class="px-6 py-3">Estado</th>
            <th class="px-6 py-3">Publicación</th>
            <th class="px-6 py-3 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="post in filteredPosts"
            :key="post.id"
            class="border-b border-gray-200 dark:border-[#30363d] hover:bg-gray-50 dark:hover:bg-[#21262d]"
          >
            <td class="px-6 py-4 font-medium text-gray-900 dark:text-[#e6edf3] max-w-xs">
              <span class="line-clamp-2">{{ post.title }}</span>
            </td>
            <td class="px-6 py-4 text-gray-500 dark:text-[#8b949e]">
              {{ categoryLabel(post.category) }}
            </td>
            <td class="px-6 py-4">
              <span :class="statusClass(post.status)">
                {{ statusLabel(post.status) }}
              </span>
            </td>
            <td class="px-6 py-4 text-gray-500 dark:text-[#8b949e] whitespace-nowrap">
              {{ formatDate(post.published_at) }}
            </td>
            <td class="px-6 py-4 text-right">
              <div class="flex items-center justify-end gap-2">
                <button
                  v-if="post.status !== 'published' && authStore.hasPermission('posts.publish')"
                  type="button"
                  @click="publishPost(post.id)"
                  class="p-2 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 rounded"
                  title="Publicar"
                >
                  <CheckCircle class="w-4 h-4" />
                </button>
                <router-link
                  v-if="post.status === 'published'"
                  :to="`/noticias/${post.slug}`"
                  target="_blank"
                  class="p-2 text-gray-500 dark:text-[#8b949e] hover:bg-gray-100 dark:hover:bg-[#21262d] rounded"
                  title="Ver en el sitio"
                >
                  <Eye class="w-4 h-4" />
                </router-link>
                <router-link
                  v-if="authStore.hasPermission('posts.edit')"
                  :to="`/admin/posts/${post.id}/edit`"
                  class="p-2 text-[#005674] dark:text-[#58a6ff] hover:bg-[#005674]/10 dark:hover:bg-[#58a6ff]/10 rounded"
                  title="Editar"
                >
                  <Pencil class="w-4 h-4" />
                </router-link>
                <button
                  v-if="authStore.hasPermission('posts.delete')"
                  type="button"
                  @click="deletePost(post)"
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

      <div v-if="postsStore.loading" class="text-center py-12 text-gray-500 dark:text-[#8b949e]">
        Cargando noticias…
      </div>
      <div v-else-if="filteredPosts.length === 0" class="text-center py-12 text-gray-500 dark:text-[#8b949e]">
        No se encontraron noticias
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Plus, Pencil, Trash2, Eye, CheckCircle } from 'lucide-vue-next'
import { usePostsStore } from '../../stores/posts'
import { useAuthStore } from '../../stores/auth'
import { NEWS_CATEGORIES } from '../../config/newsCategories'

const postsStore = usePostsStore()
const authStore = useAuthStore()

const search = ref('')
const statusFilter = ref('')
const categoryFilter = ref('')
const categories = NEWS_CATEGORIES

const filteredPosts = computed(() => {
  let list = postsStore.posts

  if (search.value) {
    const q = search.value.toLowerCase()
    list = list.filter((p) =>
      p.title?.toLowerCase().includes(q) ||
      p.slug?.toLowerCase().includes(q) ||
      p.excerpt?.toLowerCase().includes(q),
    )
  }

  if (statusFilter.value) {
    list = list.filter((p) => p.status === statusFilter.value)
  }

  if (categoryFilter.value) {
    list = list.filter((p) => p.category === categoryFilter.value)
  }

  return list
})

const categoryLabel = (id) => NEWS_CATEGORIES.find((c) => c.id === id)?.label || id

const statusLabel = (status) => ({
  published: 'Publicada',
  draft: 'Borrador',
  archived: 'Archivada',
}[status] || status)

const statusClass = (status) => [
  'px-2 py-1 rounded-full text-xs font-medium',
  status === 'published' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' :
  status === 'draft' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400' :
  'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-400',
]

const formatDate = (date) => {
  if (!date) return '—'
  return new Date(date).toLocaleString('es-CO', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}

const publishPost = async (id) => {
  if (!confirm('¿Publicar esta noticia?')) return
  try {
    await postsStore.publishPost(id)
    await postsStore.fetchPosts()
  } catch {
    alert('No se pudo publicar la noticia')
  }
}

const deletePost = async (post) => {
  if (!confirm(`¿Eliminar "${post.title}"? Esta acción no se puede deshacer.`)) return
  try {
    await postsStore.deletePost(post.id)
  } catch {
    alert('No se pudo eliminar la noticia')
  }
}

onMounted(() => postsStore.fetchPosts())
</script>
