import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'

export function usePageTemplates() {
  const templates = ref([])
  const loading = ref(false)
  const error = ref(null)

  const fetchTemplates = async () => {
    const authStore = useAuthStore()
    if (!authStore.token) return []

    loading.value = true
    error.value = null

    try {
      const response = await fetch('/api/page-templates', {
        headers: {
          Accept: 'application/json',
          Authorization: `Bearer ${authStore.token}`,
        },
      })

      if (!response.ok) {
        throw new Error('No se pudieron cargar las plantillas')
      }

      const result = await response.json()
      templates.value = result.data || []
      return templates.value
    } catch (e) {
      error.value = e.message
      return []
    } finally {
      loading.value = false
    }
  }

  const saveTemplate = async ({ name, description, content, metaTitle, metaDescription }) => {
    const authStore = useAuthStore()
    if (!authStore.token) throw new Error('No autenticado')

    const response = await fetch('/api/page-templates', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },
      body: JSON.stringify({
        name,
        description,
        content,
        meta_title: metaTitle || null,
        meta_description: metaDescription || null,
      }),
    })

    const result = await response.json()
    if (!response.ok) {
      const msg = result.errors
        ? Object.values(result.errors).flat().join('\n')
        : result.message || 'Error al guardar plantilla'
      throw new Error(msg)
    }

    templates.value = [...templates.value, result.data]
    return result.data
  }

  const deleteTemplate = async (id) => {
    const authStore = useAuthStore()
    const response = await fetch(`/api/page-templates/${id}`, {
      method: 'DELETE',
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },
    })

    if (!response.ok) {
      const result = await response.json()
      throw new Error(result.message || 'Error al eliminar plantilla')
    }

    templates.value = templates.value.filter((t) => t.id !== id)
  }

  return {
    templates,
    loading,
    error,
    fetchTemplates,
    saveTemplate,
    deleteTemplate,
  }
}
