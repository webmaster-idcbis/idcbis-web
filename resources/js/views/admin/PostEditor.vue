<template>
  <div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6 gap-4">
      <div class="flex items-center gap-3">
        <router-link
          to="/admin/posts"
          class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#21262d] text-gray-600 dark:text-[#8b949e]"
          title="Volver"
        >
          <ArrowLeft class="w-5 h-5" />
        </router-link>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-[#e6edf3]">
          {{ isEditing ? 'Editar noticia' : 'Nueva noticia' }}
        </h1>
      </div>
      <button
        type="button"
        :disabled="saving"
        class="px-4 py-2 bg-[#005674] dark:bg-[#58a6ff] text-white rounded-lg hover:bg-[#003C5F] dark:hover:bg-[#79c0ff] disabled:opacity-60 flex items-center gap-2"
        @click="save"
      >
        <Save class="w-4 h-4" />
        {{ saving ? 'Guardando…' : 'Guardar' }}
      </button>
    </div>

    <div v-if="loading" class="text-center py-16 text-gray-500">Cargando…</div>

    <form v-else class="space-y-6" @submit.prevent="save">
      <section class="bg-white dark:bg-[#161b22] rounded-xl border border-gray-200 dark:border-[#30363d] p-5 sm:p-6 space-y-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-[#8b949e]">
          Información principal
        </h2>

        <div>
          <label for="post-title" class="block text-sm font-medium text-gray-700 dark:text-[#e6edf3] mb-1">
            Título <span class="text-red-500">*</span>
          </label>
          <input
            id="post-title"
            v-model="form.title"
            type="text"
            required
            maxlength="255"
            placeholder="Ej. IDCBIS fortalece la investigación en terapias avanzadas"
            class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#30363d] rounded-lg bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3] focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff]"
            @blur="syncSlug"
          >
        </div>

        <div>
          <label for="post-excerpt" class="block text-sm font-medium text-gray-700 dark:text-[#e6edf3] mb-1">
            Resumen
          </label>
          <textarea
            id="post-excerpt"
            v-model="form.excerpt"
            rows="3"
            maxlength="500"
            placeholder="Una o dos líneas que aparecerán en la tarjeta del listado."
            class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#30363d] rounded-lg bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3] focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff]"
          />
          <p class="mt-1 text-xs text-gray-500">{{ form.excerpt.length }}/500</p>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label for="post-category" class="block text-sm font-medium text-gray-700 dark:text-[#e6edf3] mb-1">
              Categoría
            </label>
            <select
              id="post-category"
              v-model="form.category"
              class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#30363d] rounded-lg bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3] focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff]"
            >
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.label }}</option>
            </select>
          </div>
          <div>
            <label for="post-status" class="block text-sm font-medium text-gray-700 dark:text-[#e6edf3] mb-1">
              Estado
            </label>
            <select
              id="post-status"
              v-model="form.status"
              class="w-full px-4 py-2.5 border border-gray-300 dark:border-[#30363d] rounded-lg bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3] focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff]"
            >
              <option value="draft">Borrador</option>
              <option value="published">Publicada</option>
              <option value="archived">Archivada</option>
            </select>
          </div>
        </div>

        <div>
          <label for="post-published-at" class="block text-sm font-medium text-gray-700 dark:text-[#e6edf3] mb-1">
            Fecha de publicación
          </label>
          <input
            id="post-published-at"
            v-model="form.published_at"
            type="datetime-local"
            class="w-full max-w-sm px-4 py-2.5 border border-gray-300 dark:border-[#30363d] rounded-lg bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3] focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff]"
          >
          <p class="mt-1 text-xs text-gray-500 dark:text-[#8b949e]">
            Es la fecha que verán los lectores. Si publicas sin indicar fecha, se usará el momento actual.
            También puedes usar una fecha futura para programar cuándo aparecerá en el sitio.
          </p>
        </div>
      </section>

      <section class="bg-white dark:bg-[#161b22] rounded-xl border border-gray-200 dark:border-[#30363d] p-5 sm:p-6 space-y-4">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-[#8b949e]">
          Imagen destacada
        </h2>

        <div v-if="form.featured_image" class="relative max-w-md">
          <img
            :src="form.featured_image"
            alt="Vista previa"
            class="w-full rounded-lg border border-gray-200 dark:border-[#30363d] object-cover max-h-56"
            @error="onFeaturedImageError"
          >
          <button
            type="button"
            class="absolute top-2 right-2 p-1.5 bg-white/90 dark:bg-[#161b22]/90 rounded-full text-red-600"
            title="Quitar imagen"
            @click="form.featured_image = ''"
          >
            <X class="w-4 h-4" />
          </button>
        </div>

        <p v-if="featuredImageHint" class="text-sm text-gray-600 dark:text-[#8b949e] flex items-center gap-2">
          <Check class="w-4 h-4" aria-hidden="true" />
          {{ featuredImageHint }}
        </p>

        <label class="flex flex-col items-center justify-center w-full max-w-md h-36 border-2 border-dashed border-gray-300 dark:border-[#30363d] rounded-xl cursor-pointer hover:border-[#005674] dark:hover:border-[#58a6ff] transition-colors">
          <Upload class="w-8 h-8 text-gray-400 mb-2" />
          <span class="text-sm text-gray-600 dark:text-[#8b949e]">
            {{ preparingImage ? 'Preparando imagen…' : 'Haz clic o arrastra una imagen (JPG/PNG, máx. 2 MB)' }}
          </span>
          <input
            type="file"
            accept="image/jpeg,image/png,image/webp"
            class="hidden"
            :disabled="preparingImage"
            @change="onImageSelect"
          >
        </label>
      </section>

      <section class="bg-white dark:bg-[#161b22] rounded-xl border border-gray-200 dark:border-[#30363d] p-5 sm:p-6 space-y-3">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-[#8b949e]">
          Contenido
        </h2>
        <p class="text-xs text-gray-500 dark:text-[#8b949e]">
          Usa la barra de herramientas para negrita, enlaces, imágenes dentro del texto o un botón destacado con enlace.
        </p>
        <SimpleRichTextEditor ref="contentEditorRef" v-model="form.content" />
      </section>

      <details class="bg-white dark:bg-[#161b22] rounded-xl border border-gray-200 dark:border-[#30363d] p-5 sm:p-6">
        <summary class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-[#8b949e] cursor-pointer">
          Opciones avanzadas (SEO)
        </summary>
        <div class="mt-4 space-y-4">
          <div>
            <label for="post-slug" class="block text-sm font-medium mb-1">Enlace (slug)</label>
            <div class="flex items-center gap-2">
              <span class="text-sm text-gray-500">/noticias/</span>
              <input
                id="post-slug"
                v-model="form.slug"
                type="text"
                class="flex-1 px-4 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg bg-white dark:bg-[#0f1419]"
                @input="slugTouched = true"
              >
            </div>
          </div>
          <div>
            <label for="post-meta-title" class="block text-sm font-medium mb-1">Título SEO</label>
            <input
              id="post-meta-title"
              v-model="form.meta_title"
              type="text"
              maxlength="70"
              class="w-full px-4 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg bg-white dark:bg-[#0f1419]"
            >
          </div>
          <div>
            <label for="post-meta-desc" class="block text-sm font-medium mb-1">Descripción SEO</label>
            <textarea
              id="post-meta-desc"
              v-model="form.meta_description"
              rows="2"
              maxlength="500"
              class="w-full px-4 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg bg-white dark:bg-[#0f1419]"
            />
          </div>
        </div>
      </details>

      <p v-if="error" class="text-sm text-red-600 dark:text-red-400">{{ error }}</p>
      <p v-if="success" class="text-sm text-green-600 dark:text-green-400">{{ success }}</p>
    </form>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { ArrowLeft, Save, Upload, X, Check } from 'lucide-vue-next'
import { usePostsStore } from '../../stores/posts'
import { useUiStore } from '../../stores/ui'
import { NEWS_CATEGORIES } from '../../config/newsCategories'
import { fileToDataUrl } from '../../utils/imageToDataUrl'
import SimpleRichTextEditor from '../../components/admin/SimpleRichTextEditor.vue'

const route = useRoute()
const router = useRouter()
const postsStore = usePostsStore()
const uiStore = useUiStore()

const categories = NEWS_CATEGORIES
const loading = ref(false)
const saving = ref(false)
const preparingImage = ref(false)
const error = ref('')
const success = ref('')
const featuredImageHint = ref('')
const slugTouched = ref(false)
const contentEditorRef = ref(null)

const form = ref({
  title: '',
  slug: '',
  excerpt: '',
  content: '',
  category: 'sin-categoria',
  featured_image: '',
  status: 'draft',
  published_at: '',
  meta_title: '',
  meta_description: '',
})

const isEditing = computed(() => !!route.params.id)

const toDatetimeLocal = (value) => {
  if (!value) return ''
  const date = new Date(value)
  if (Number.isNaN(date.getTime())) return ''
  const pad = (n) => String(n).padStart(2, '0')
  return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`
}

const slugify = (text) => text
  .toLowerCase()
  .normalize('NFD')
  .replace(/[\u0300-\u036f]/g, '')
  .replace(/[^a-z0-9]+/g, '-')
  .replace(/^-+|-+$/g, '')

const syncSlug = () => {
  if (!slugTouched.value && form.value.title) {
    form.value.slug = slugify(form.value.title)
  }
}

const onFeaturedImageError = () => {
  error.value = 'No se pudo mostrar la vista previa. Vuelve a seleccionar la imagen.'
}

const onImageSelect = async (event) => {
  const file = event.target.files?.[0]
  if (!file) return

  preparingImage.value = true
  featuredImageHint.value = ''
  error.value = ''

  try {
    form.value.featured_image = await fileToDataUrl(file)
    featuredImageHint.value = 'Imagen lista. Se guardará en el servidor al pulsar Guardar.'
  } catch (err) {
    const message = err.message || 'No se pudo preparar la imagen'
    error.value = message
    uiStore.setFlash(message, 'error')
  } finally {
    preparingImage.value = false
    event.target.value = ''
  }
}

const loadPost = async () => {
  if (!isEditing.value) return
  loading.value = true
  try {
    const post = await postsStore.fetchPost(route.params.id)
    form.value = {
      title: post.title || '',
      slug: post.slug || '',
      excerpt: post.excerpt || '',
      content: post.content || '',
      category: post.category || 'sin-categoria',
      featured_image: post.featured_image || '',
      status: post.status || 'draft',
      published_at: toDatetimeLocal(post.published_at),
      meta_title: post.meta_title || '',
      meta_description: post.meta_description || '',
    }
    slugTouched.value = true
  } catch {
    error.value = 'No se pudo cargar la noticia'
  } finally {
    loading.value = false
  }
}

const save = async () => {
  if (!form.value.title.trim()) {
    error.value = 'El título es obligatorio'
    return
  }
  if (!form.value.slug.trim()) {
    form.value.slug = slugify(form.value.title)
  }

  contentEditorRef.value?.flush?.()

  saving.value = true
  error.value = ''
  success.value = ''
  const payload = {
    ...form.value,
    published_at: form.value.published_at || null,
  }
  try {
    if (isEditing.value) {
      const updated = await postsStore.updatePost(route.params.id, payload)

      if (updated.content_saved === false) {
        throw new Error('El contenido no llegó al servidor. Reduce el tamaño de las imágenes e intenta de nuevo.')
      }

      form.value.featured_image = updated.featured_image || form.value.featured_image
      form.value.content = updated.content || form.value.content
      featuredImageHint.value = ''
      success.value = 'Noticia actualizada correctamente.'
      uiStore.setFlash('Noticia actualizada correctamente')
    } else {
      const created = await postsStore.createPost(payload)
      uiStore.setFlash('Noticia creada correctamente')
      router.push({ path: `/admin/posts/${created.id}/edit`, query: { saved: '1' } })
      return
    }
  } catch (err) {
    const message = err.response?.data?.message || 'No se pudo guardar la noticia'
    error.value = message
    uiStore.setFlash(message, 'error')
  } finally {
    saving.value = false
  }
}

onMounted(async () => {
  await loadPost()
  if (route.query.saved === '1') {
    success.value = 'Noticia guardada correctamente.'
    uiStore.setFlash('Noticia guardada correctamente')
    router.replace({ query: {} })
  }
})
</script>
