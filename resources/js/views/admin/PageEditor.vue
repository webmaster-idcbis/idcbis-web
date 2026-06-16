<template>
  <div class="h-screen flex flex-col bg-gray-100 overflow-hidden">
    <!-- Barra superior compacta -->
    <header class="shrink-0 bg-white border-b border-gray-200 z-10">
      <div class="flex items-center justify-between gap-3 px-4 py-2">
        <div class="flex items-center gap-3 min-w-0">
          <router-link to="/admin/pages" class="text-gray-600 hover:text-gray-900 shrink-0">
            <ArrowLeft class="w-5 h-5" />
          </router-link>
          <h1 class="text-base font-semibold text-gray-900 truncate">
            {{ isEditing ? 'Editar página' : 'Nueva página' }}
          </h1>
          <button
            type="button"
            @click="showPageSettings = !showPageSettings"
            class="shrink-0 px-2 py-1 text-xs border border-gray-300 rounded hover:bg-gray-50 text-gray-600"
          >
            {{ showPageSettings ? 'Ocultar datos' : 'Datos de página' }}
          </button>
        </div>
        <div class="flex items-center gap-2 shrink-0">
          <button
            type="button"
            data-cy="btn-save-template"
            class="px-2 py-1 text-xs border border-[#0B4F6C] text-[#0B4F6C] rounded hover:bg-slate-50"
            @click="showSaveTemplateModal = true"
          >
            Guardar plantilla
          </button>
          <select
            v-model="pageForm.status"
            data-cy="select-status"
            class="px-2 py-1 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
          >
            <option value="draft">Borrador</option>
            <option value="published">Publicado</option>
          </select>
          <button
            @click="savePage"
            :disabled="saving"
            data-cy="btn-save"
            class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50 flex items-center gap-1.5"
          >
            <Save class="w-4 h-4" />
            {{ saving ? 'Guardando...' : 'Guardar' }}
          </button>
        </div>
      </div>

      <!-- Campos de página: colapsable + scroll -->
      <div
        v-show="showPageSettings"
        class="border-t border-gray-200 max-h-[min(28vh,220px)] overflow-y-auto"
      >
        <div class="px-4 py-3 space-y-3">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="sm:col-span-2">
              <label class="block text-xs font-medium text-gray-700 mb-0.5">Título</label>
              <input
                v-model="pageForm.title"
                type="text"
                data-cy="input-title"
                placeholder="Título de la página"
                class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500"
              >
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-0.5">Slug (URL)</label>
              <input
                v-model="pageForm.slug"
                type="text"
                data-cy="input-slug"
                placeholder="mi-pagina"
                class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500"
              >
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-0.5">Ruta alternativa</label>
              <input
                v-model="pageForm.route"
                type="text"
                placeholder="opcional"
                class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500"
              >
            </div>
          </div>
          <div>
            <label class="block text-xs font-medium text-gray-700 mb-0.5">Descripción breve</label>
            <textarea
              v-model="pageForm.description"
              rows="1"
              placeholder="Descripción corta"
              class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 resize-none"
            ></textarea>
          </div>
          <div>
            <button
              type="button"
              @click="showSeoFields = !showSeoFields"
              class="flex items-center gap-1.5 text-xs text-gray-600 hover:text-gray-900"
            >
              <svg
                :class="['w-3.5 h-3.5 transition-transform', showSeoFields ? 'rotate-90' : '']"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
              SEO (opcional)
            </button>
            <div v-if="showSeoFields" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mt-2">
              <div>
                <label class="block text-xs text-gray-600 mb-0.5">Meta title</label>
                <input v-model="pageForm.metaTitle" type="text" maxlength="70" data-cy="input-meta-title" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm">
              </div>
              <div class="sm:col-span-2">
                <label class="block text-xs text-gray-600 mb-0.5">Meta description</label>
                <input v-model="pageForm.metaDescription" type="text" maxlength="160" data-cy="input-meta-description" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm">
              </div>
              <div>
                <label class="block text-xs text-gray-600 mb-0.5">Keywords</label>
                <input v-model="pageForm.metaKeywords" type="text" data-cy="input-meta-keywords" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm">
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Editor: ocupa el resto de la pantalla -->
    <div class="flex-1 min-h-0 flex overflow-hidden">
      <!-- Element Palette Sidebar -->
      <aside
        :class="['min-h-0 bg-white border-r border-gray-200 flex flex-col shrink-0 transition-all duration-300', sidebarCollapsed ? 'w-16' : 'w-80']"
        @dragend="handleDragEnd"
      >
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
          <h3 v-if="!sidebarCollapsed" class="text-sm font-semibold text-gray-900">Elementos</h3>
          <button
            @click="toggleSidebar"
            class="p-2 hover:bg-gray-100 rounded transition-colors"
          >
            <svg v-if="sidebarCollapsed" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
            </svg>
            <svg v-else class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
          </button>
        </div>

        <div class="flex-1 overflow-y-auto p-3 space-y-3">
          <ElementPalette
            :collapsed="sidebarCollapsed"
            @drag-start="handleDragStart"
          />
          <button
            v-if="!sidebarCollapsed"
            type="button"
            class="w-full px-3 py-2 text-xs font-medium text-white bg-[#0B4F6C] rounded-lg hover:bg-[#145C7A] transition-colors"
            data-cy="btn-template-propuesta-azul"
            @click="loadPropuestaAzulTemplate"
          >
            Plantilla Propuesta Azul
          </button>
          <button
            v-if="!sidebarCollapsed"
            type="button"
            class="w-full px-3 py-2 text-xs font-medium text-[#0B4F6C] bg-white border border-[#0B4F6C] rounded-lg hover:bg-slate-50 transition-colors"
            data-cy="btn-template-servicios"
            @click="loadServiciosTemplate"
          >
            Plantilla Servicios
          </button>

          <div v-if="!sidebarCollapsed" class="pt-2 border-t border-gray-200 space-y-2">
            <h4 class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Mis plantillas</h4>
            <div v-if="templatesLoading" class="text-xs text-gray-500">Cargando...</div>
            <div v-else-if="savedTemplates.length === 0" class="text-xs text-gray-500">
              Guarda una página como plantilla para reutilizarla.
            </div>
            <button
              v-for="tpl in savedTemplates"
              :key="tpl.id"
              type="button"
              class="w-full px-3 py-2 text-xs text-left border border-gray-200 rounded-lg hover:bg-gray-50"
              :data-cy="`btn-template-${tpl.id}`"
              @click="loadSavedTemplate(tpl)"
            >
              <span class="block font-medium text-gray-800">{{ tpl.name }}</span>
              <span v-if="tpl.description" class="block text-gray-500 truncate">{{ tpl.description }}</span>
            </button>
          </div>
        </div>
      </aside>

      <!-- Canvas -->
      <main class="flex-1 min-h-0 bg-gray-50 overflow-y-auto">
        <div
          class="max-w-6xl mx-auto p-6 min-h-full"
          @dragover.prevent="handleDragOver"
          @dragleave="handleDragLeave"
          @drop="handleDrop"
          :class="{ 'bg-blue-50': isDragging }"
        >
          <div v-if="elements.length === 0" class="text-center py-32 text-gray-400 border-2 border-dashed border-gray-300 rounded-xl bg-white">
            <p class="text-lg font-medium text-gray-500">Arrastra elementos aquí</p>
            <p class="text-sm text-gray-400 mt-2">O usa los elementos del menú lateral</p>
          </div>

          <div v-else class="space-y-4">
            <div
              v-for="(element, index) in elements"
              :key="element.id"
              class="relative group cursor-pointer hover:bg-gray-50 p-2 rounded"
              :class="{ 'ring-2 ring-blue-500': isSelectedOrChild(element) }"
              @click.self="selectElement(element)"
            >
              <component
                :is="getComponentType(element.type)"
                :element="element"
                :is-selected="selectedElement?.id === element.id"
                :selected-element-id="selectedElement?.id"
                :preview="false"
                @select="selectElement"
                @click="selectElement"
                @add-child="handleAddChild"
                @delete-child="handleDeleteChild"
                @duplicate-child="handleDuplicateChild"
                @move-child="handleMoveChild"
                class="w-full"
              />

              <!-- Controls -->
              <div
                v-if="selectedElement?.id === element.id"
                class="absolute -top-2 -right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity"
              >
                <button
                  @click.stop="duplicateElement(element)"
                  class="w-6 h-6 bg-green-500 text-white rounded text-xs hover:bg-green-600"
                >
                  📋
                </button>
                <button
                  @click.stop="deleteElement"
                  class="w-6 h-6 bg-red-500 text-white rounded text-xs hover:bg-red-600"
                >
                  🗑
                </button>
              </div>
            </div>
          </div>
        </div>
      </main>

      <!-- Properties Panel -->
      <aside class="w-80 min-h-0 bg-white border-l border-gray-200 flex flex-col shrink-0">
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
          <h3 class="text-sm font-semibold text-gray-900">Propiedades</h3>
          <p v-if="selectedElement" class="text-xs text-gray-500 mt-0.5">Edita el elemento seleccionado</p>
        </div>

        <div class="flex-1 overflow-y-auto p-4">
          <ElementPropertiesPanel
            v-if="selectedElement"
            :element="selectedElement"
            :parent-container="selectedParent"
            :breadcrumbs="selectionBreadcrumbs"
            @select-child="selectElement"
            @move-child="moveContainerChild"
            @remove-child="removeContainerChild"
          >
            <template #actions>
            <div class="pt-3 mt-1 border-t border-gray-200 space-y-2">
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Acciones</p>

              <div class="grid grid-cols-2 gap-2">
                <button
                  type="button"
                  @click="duplicateElement(selectedElement)"
                  class="px-2 py-1.5 text-xs bg-white border border-gray-300 rounded hover:bg-gray-50 text-gray-700"
                >
                  Duplicar
                </button>
                <button
                  type="button"
                  @click="deleteElement"
                  class="px-2 py-1.5 text-xs bg-white border border-red-200 rounded hover:bg-red-50 text-red-600"
                >
                  Eliminar
                </button>
              </div>

              <button
                type="button"
                @click="moveElementUp"
                class="w-full px-2 py-1.5 text-xs bg-white border border-gray-300 rounded hover:bg-gray-50 text-gray-700"
              >
                ↑ Subir
              </button>

              <button
                type="button"
                @click="moveElementDown"
                class="w-full px-2 py-1.5 text-xs bg-white border border-gray-300 rounded hover:bg-gray-50 text-gray-700"
              >
                ↓ Bajar
              </button>
            </div>
            </template>
          </ElementPropertiesPanel>

          <div v-else class="text-center py-8 text-gray-500">
            <div class="mb-4">
              <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <p class="text-sm font-medium">Selecciona un elemento para editar sus propiedades</p>
            <p class="text-xs text-gray-400 mt-1">Haz clic en cualquier elemento del canvas para ver sus propiedades aquí</p>
          </div>
        </div>
      </aside>
    </div>

    <!-- Modal guardar plantilla -->
    <div
      v-if="showSaveTemplateModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
      @click.self="showSaveTemplateModal = false"
    >
      <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-5 space-y-4" data-cy="modal-save-template">
        <h3 class="text-lg font-semibold text-gray-900">Guardar como plantilla</h3>
        <p class="text-sm text-gray-600">
          Se guardará el contenido actual de la página (elementos y bloques) para reutilizarlo al crear nuevas páginas.
        </p>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Nombre de la plantilla</label>
          <input
            v-model="templateForm.name"
            type="text"
            data-cy="input-template-name"
            class="editor-field-input"
            placeholder="Ej: Página de servicios clínicos"
          >
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Descripción (opcional)</label>
          <textarea
            v-model="templateForm.description"
            rows="2"
            data-cy="input-template-description"
            class="editor-field-input"
            placeholder="Para qué sirve esta plantilla"
          />
        </div>
        <p v-if="templateError" class="text-sm text-red-600">{{ templateError }}</p>
        <div class="flex gap-2 justify-end">
          <button
            type="button"
            class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50"
            @click="showSaveTemplateModal = false"
          >
            Cancelar
          </button>
          <button
            type="button"
            data-cy="btn-confirm-save-template"
            class="px-4 py-2 text-sm bg-[#0B4F6C] text-white rounded-lg hover:bg-[#145C7A] disabled:opacity-50"
            :disabled="savingTemplate"
            @click="saveAsTemplate"
          >
            {{ savingTemplate ? 'Guardando...' : 'Guardar plantilla' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { ArrowLeft, Save } from 'lucide-vue-next'

import { useAuthStore } from '../../stores/auth'
import { usePageElements } from '../../composables/usePageElements'
import { usePageTemplates } from '../../composables/usePageTemplates'
import { createElement, generateId } from '../../utils/pageElementFactory'
import ElementPropertiesPanel from '../../components/editor/ElementPropertiesPanel.vue'
import ElementPalette from '../../components/editor/ElementPalette.vue'
import { buildPropuestaAzulPage, PROPUESTA_AZUL_PAGE_META } from '../../config/pageTemplates/propuestaAzulIdcbis'
import { buildServiciosPage, SERVICIOS_PAGE_META } from '../../config/pageTemplates/servicios'
import { paletteTypeLabels } from '../../config/pageElementPalette'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()
const { getComponentType } = usePageElements()
const {
  templates: savedTemplates,
  loading: templatesLoading,
  fetchTemplates,
  saveTemplate,
} = usePageTemplates()

// Estado
const sidebarCollapsed = ref(false)
const isDragging = ref(false)
const saving = ref(false)
const selectedElement = ref(null)
const elements = ref([])
const showPageSettings = ref(false)
const showSeoFields = ref(false)
const showSaveTemplateModal = ref(false)
const savingTemplate = ref(false)
const templateError = ref('')
const templateForm = ref({ name: '', description: '' })

// Formulario de página
const pageForm = ref({
  title: '',
  slug: '',
  description: '',
  metaTitle: '',
  metaDescription: '',
  metaKeywords: '',
  route: '',
  status: 'draft',
  publishedAt: null
})

// Computed
const isEditing = computed(() => !!route.params.id)

// Métodos
const toggleSidebar = () => {
  sidebarCollapsed.value = !sidebarCollapsed.value
}

const loadPropuestaAzulTemplate = () => {
  if (elements.value.length > 0 && !window.confirm('¿Reemplazar el contenido actual con la plantilla Propuesta Azul?')) {
    return
  }
  elements.value = buildPropuestaAzulPage()
  pageForm.value.title = PROPUESTA_AZUL_PAGE_META.title
  pageForm.value.slug = PROPUESTA_AZUL_PAGE_META.slug
  pageForm.value.description = PROPUESTA_AZUL_PAGE_META.description
  pageForm.value.metaTitle = PROPUESTA_AZUL_PAGE_META.metaTitle
  pageForm.value.metaDescription = PROPUESTA_AZUL_PAGE_META.metaDescription
  selectedElement.value = elements.value[0] || null
}

const loadServiciosTemplate = () => {
  if (elements.value.length > 0 && !window.confirm('¿Reemplazar el contenido con la plantilla Servicios?')) {
    return
  }
  elements.value = buildServiciosPage()
  pageForm.value.title = SERVICIOS_PAGE_META.title
  pageForm.value.slug = SERVICIOS_PAGE_META.slug
  pageForm.value.description = SERVICIOS_PAGE_META.description
  pageForm.value.metaTitle = SERVICIOS_PAGE_META.metaTitle
  pageForm.value.metaDescription = SERVICIOS_PAGE_META.metaDescription
  selectedElement.value = elements.value[0] || null
}

const loadSavedTemplate = (tpl) => {
  if (elements.value.length > 0 && !window.confirm(`¿Reemplazar el contenido con la plantilla «${tpl.name}»?`)) {
    return
  }
  elements.value = normalizeLoadedElements(JSON.parse(JSON.stringify(tpl.content || [])))
  if (tpl.meta_title) pageForm.value.metaTitle = tpl.meta_title
  if (tpl.meta_description) pageForm.value.metaDescription = tpl.meta_description
  selectedElement.value = elements.value[0] || null
}

const saveAsTemplate = async () => {
  templateError.value = ''
  if (!templateForm.value.name.trim()) {
    templateError.value = 'El nombre de la plantilla es obligatorio'
    return
  }
  if (elements.value.length === 0) {
    templateError.value = 'Agrega al menos un elemento antes de guardar la plantilla'
    return
  }

  savingTemplate.value = true
  try {
    await saveTemplate({
      name: templateForm.value.name.trim(),
      description: templateForm.value.description.trim() || null,
      content: elements.value,
      metaTitle: pageForm.value.metaTitle,
      metaDescription: pageForm.value.metaDescription,
    })
    showSaveTemplateModal.value = false
    templateForm.value = { name: '', description: '' }
    alert('Plantilla guardada correctamente')
  } catch (e) {
    templateError.value = e.message
  } finally {
    savingTemplate.value = false
  }
}

// Funciones para manejar contenedores
const handleAddChild = ({ type, containerId }) => {
  const newElement = createElement(type)

  // Encontrar el contenedor y agregar el elemento hijo
  const container = findElementById(containerId)
  if (container) {
    if (!container.children) container.children = []
    container.children.push(newElement)
    selectElement(newElement)
  }
}

const handleDeleteChild = ({ containerId, index }) => {
  const container = findElementById(containerId)
  if (container?.children) {
    const removed = container.children[index]
    container.children.splice(index, 1)
    if (selectedElement.value?.id === removed?.id) {
      selectedElement.value = container
    }
  }
}

const handleDuplicateChild = ({ containerId, child }) => {
  const container = findElementById(containerId)
  if (container?.children && child) {
    container.children.push({
      ...JSON.parse(JSON.stringify(child)),
      id: generateId(),
    })
  }
}

const handleMoveChild = ({ containerId, index, direction }) => {
  const container = findElementById(containerId)
  if (!container?.children) return
  const newIndex = index + direction
  if (newIndex < 0 || newIndex >= container.children.length) return
  const [item] = container.children.splice(index, 1)
  container.children.splice(newIndex, 0, item)
}

const moveContainerChild = ({ index, direction }) => {
  if (selectedElement.value?.type !== 'container') return
  const list = selectedElement.value.children
  const newIndex = index + direction
  if (!list || newIndex < 0 || newIndex >= list.length) return
  const [item] = list.splice(index, 1)
  list.splice(newIndex, 0, item)
}

const removeContainerChild = (index) => {
  if (selectedElement.value?.type !== 'container') return
  selectedElement.value.children.splice(index, 1)
}

const findElementById = (id, elementList = elements.value) => {
  for (const element of elementList) {
    if (element.id === id) {
      return element
    }
    if (element.children) {
      const found = findElementById(id, element.children)
      if (found) return found
    }
  }
  return null
}

const findElementContext = (id, list = elements.value, parent = null) => {
  for (let i = 0; i < list.length; i++) {
    if (list[i].id === id) {
      return { parent, list, index: i, element: list[i] }
    }
    if (list[i].children?.length) {
      const found = findElementContext(id, list[i].children, list[i])
      if (found) return found
    }
  }
  return null
}

const selectedParent = computed(() => {
  if (!selectedElement.value) return null
  const ctx = findElementContext(selectedElement.value.id)
  return ctx?.parent || null
})

const buildBreadcrumbPath = (id, list = elements.value, path = []) => {
  for (const el of list) {
    const label = paletteTypeLabels[el.type] || el.type
    if (el.id === id) {
      return [...path, label]
    }
    if (el.children?.length) {
      const childPath = buildBreadcrumbPath(id, el.children, [...path, label])
      if (childPath) return childPath
    }
  }
  return null
}

const selectionBreadcrumbs = computed(() => {
  if (!selectedElement.value) return []
  return buildBreadcrumbPath(selectedElement.value.id) || []
})

const isSelectedOrChild = (element) => {
  if (!selectedElement.value) return false
  if (selectedElement.value.id === element.id) return true
  const findInChildren = (children) => {
    if (!children) return false
    return children.some((c) => c.id === selectedElement.value.id || findInChildren(c.children))
  }
  return findInChildren(element.children)
}

const normalizeLoadedElements = (list) => {
  return list.map((el) => {
    const normalized = { ...el }
    if (el.type === 'html' && el.htmlCode == null && el.content) {
      normalized.htmlCode = el.content
    }
    if (el.type === 'list' && !Array.isArray(el.items)) {
      normalized.items = []
    }
    if (el.type === 'carousel' && el.slides) {
      normalized.slides = el.slides.map((slide, i) => ({
        buttonText: '',
        buttonUrl: '',
        link: '',
        ...slide,
        id: slide.id || `slide_${i}_${Date.now()}`,
      }))
    }
    if (el.children?.length) {
      normalized.children = normalizeLoadedElements(el.children)
    }
    return normalized
  })
}

const normalizeSlug = (value) => {
  if (!value) return ''
  return value
    .trim()
    .replace(/^\/+/, '')
    .toLowerCase()
    .replace(/\s+/g, '-')
    .replace(/[^a-z0-9-]/g, '')
}

// Drag & Drop
const handleDragStart = (event, elementType) => {
  if (!event?.dataTransfer || !elementType) return
  isDragging.value = true
  event.dataTransfer.setData('elementType', elementType)
  event.dataTransfer.setData('text/plain', elementType)
  event.dataTransfer.effectAllowed = 'copy'
}

const handleDragEnd = () => {
  isDragging.value = false
}

const handleDragOver = (event) => {
  event.preventDefault()
}

const handleDragLeave = () => {
  isDragging.value = false
}

const handleDrop = (event) => {
  event.preventDefault()
  isDragging.value = false

  const elementType = event.dataTransfer.getData('elementType') || event.dataTransfer.getData('text/plain')
  if (elementType) {
    const newElement = createElement(elementType)
    elements.value.push(newElement)
  }
}

// Selección
const selectElement = (element) => {
  if (!element || typeof element !== 'object' || !element.id) return
  selectedElement.value = element
}

const updateElement = () => {
  // La reactividad de Vue se encarga de actualizar
}

const deleteElement = () => {
  if (!selectedElement.value) return
  const ctx = findElementContext(selectedElement.value.id)
  if (ctx) {
    ctx.list.splice(ctx.index, 1)
    selectedElement.value = null
  }
}

const duplicateElement = (element) => {
  if (!element?.id) return
  const ctx = findElementContext(element.id)
  if (!ctx) return

  const clone = JSON.parse(JSON.stringify(element))
  clone.id = generateId()

  const reassignIds = (el) => {
    if (el.children?.length) {
      el.children = el.children.map((child) => {
        const next = { ...child, id: generateId() }
        reassignIds(next)
        return next
      })
    }
    if (el.slides?.length) {
      el.slides = el.slides.map((s) => ({ ...s, id: generateId() }))
    }
    if (el.items?.length) {
      el.items = el.items.map((i) => ({ ...i, id: generateId() }))
    }
    if (el.steps?.length) {
      el.steps = el.steps.map((s) => ({ ...s, id: generateId() }))
    }
    if (el.buttons?.length) {
      el.buttons = el.buttons.map((b) => ({ ...b, id: generateId() }))
    }
    if (el.panels?.length) {
      el.panels = el.panels.map((p) => ({ ...p, id: generateId() }))
    }
    if (el.cards?.length) {
      el.cards = el.cards.map((c) => ({ ...c, id: generateId() }))
    }
  }
  reassignIds(clone)

  ctx.list.splice(ctx.index + 1, 0, clone)
  selectedElement.value = clone
}

const moveElementInList = (direction) => {
  if (!selectedElement.value) return
  const ctx = findElementContext(selectedElement.value.id)
  if (!ctx) return
  const newIndex = ctx.index + direction
  if (newIndex < 0 || newIndex >= ctx.list.length) return
  const [item] = ctx.list.splice(ctx.index, 1)
  ctx.list.splice(newIndex, 0, item)
}

const moveElementUp = () => moveElementInList(-1)
const moveElementDown = () => moveElementInList(1)

// Guardar página - VERSIÓN BASE DE DATOS CON TOKEN SANCTUM
const savePage = async () => {
  console.log('=== GUARDANDO EN BASE DE DATOS ===')

  saving.value = true

  try {
    // 1. Verificar autenticación
    console.log('1. Verificando autenticación...')
    if (!authStore.token) {
      console.log('ERROR: No hay token de autenticación')
      alert('No estás autenticado. Por favor inicia sesión nuevamente.')
      window.location.href = '/login'
      return
    }

    console.log('Token disponible:', !!authStore.token)

    // 2. Validación básica
    console.log('2. Validando...')
    if (!pageForm.value.title) {
      console.log('ERROR: Falta título')
      alert('El título es obligatorio')
      saving.value = false
      return
    }

    // 3. Preparar datos para la API
    console.log('3. Preparando datos...')
    const slug = normalizeSlug(pageForm.value.slug)
      || normalizeSlug(pageForm.value.route)
      || null

    const apiData = {
      title: pageForm.value.title,
      slug,
      meta_description: pageForm.value.metaDescription || pageForm.value.description || null,
      meta_title: pageForm.value.metaTitle || null,
      meta_keywords: pageForm.value.metaKeywords || null,
      content: elements.value,
      status: pageForm.value.status || 'draft',
      no_index: false,
    }

    console.log('DATOS PARA API:', apiData)

    // 4. Determinar si es creación o actualización
    const isEditing = !!route.params.id
    const url = isEditing
      ? `/api/pages/${route.params.id}`
      : '/api/pages'
    const method = isEditing ? 'PUT' : 'POST'

    console.log('4. Enviando a API:', url, method)

    // 5. Preparar headers con token Sanctum
    const headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'Authorization': `Bearer ${authStore.token}`
    }

    console.log('Headers:', headers)

    // 6. Llamada a la API
    const response = await fetch(url, {
      method: method,
      headers: headers,
      body: JSON.stringify(apiData)
    })

    console.log('5. Respuesta recibida:', response.status)

    // 7. Procesar respuesta
    const result = await response.json()
    console.log('6. Resultado:', result)

    if (response.ok) {
      alert(`Página guardada: ${pageForm.value.title}`)
      router.push('/admin/pages')
    } else {
      console.log('❌ ERROR EN API:', result)

      if (result.message === 'Unauthenticated') {
        alert('❌ Error de autenticación. Tu sesión ha expirado. Por favor inicia sesión nuevamente.')
        authStore.clearAuth()
        window.location.href = '/login'
      } else if (result.errors) {
        const errores = Object.values(result.errors).flat().join('\n')
        alert('Errores de validación:\n' + errores)
      } else {
        alert('Error: ' + (result.message || 'Error desconocido'))
      }
    }

  } catch (error) {
    console.log('❌ ERROR GENERAL:', error)
    alert('Error de conexión: ' + error.message)
  } finally {
    saving.value = false
    console.log('=== GUARDADO FINALIZADO ===')
  }
}

// Verificar estado del almacenamiento
const checkStorageStatus = () => {
  try {
    const testKey = 'test_storage'
    localStorage.setItem(testKey, 'test')
    localStorage.removeItem(testKey)

    console.log('✅ localStorage está disponible')

    // Mostrar claves existentes
    const keys = Object.keys(localStorage)
    console.log('📁 Claves en localStorage:', keys)

    // Mostrar páginas guardadas
    const allPages = JSON.parse(localStorage.getItem('all_pages') || '[]')
    console.log('📄 Páginas guardadas:', allPages.length)

    return true
  } catch (error) {
    console.error('❌ localStorage no disponible:', error)
    return false
  }
}

// Cargar página desde base de datos con token Sanctum
const loadPage = async () => {
  console.log('=== CARGANDO PÁGINA DESDE BD ===')

  if (isEditing.value) {
    try {
      console.log('Cargando página ID:', route.params.id)

      // Verificar autenticación
      if (!authStore.token) {
        console.log('ERROR: No hay token de autenticación')
        alert('No estás autenticado. Por favor inicia sesión nuevamente.')
        window.location.href = '/login'
        resetToDefaults()
        return
      }

      console.log('Token disponible:', !!authStore.token)

      // Preparar headers con token Sanctum
      const headers = {
        'Accept': 'application/json',
        'Authorization': `Bearer ${authStore.token}`
      }

      console.log('Headers para carga:', headers)

      const response = await fetch(`/api/pages/${route.params.id}`, {
        headers: headers
      })

      console.log('Respuesta status:', response.status)

      if (response.ok) {
        const result = await response.json()
        console.log('Datos recibidos:', result)

        const pageData = result.data

        // Cargar datos del formulario
        pageForm.value = {
          title: pageData.title || '',
          slug: pageData.slug || '',
          description: pageData.meta_description || '',
          metaTitle: pageData.meta_title || '',
          metaDescription: pageData.meta_description || '',
          metaKeywords: pageData.meta_keywords || '',
          route: pageData.slug || '',
          status: pageData.status || 'draft',
          publishedAt: pageData.published_at || null
        }

        elements.value = normalizeLoadedElements(pageData.content || [])

        console.log('✅ Página cargada exitosamente')
      } else {
        const error = await response.json()
        console.log('❌ Error al cargar:', error)

        if (error.message === 'Unauthenticated') {
          alert('❌ Error de autenticación. Tu sesión ha expirado. Por favor inicia sesión nuevamente.')
          authStore.clearAuth()
          window.location.href = '/login'
        } else {
          alert('Error al cargar la página: ' + (error.message || 'No encontrada'))
        }

        // Valores por defecto
        resetToDefaults()
      }

    } catch (error) {
      console.error('❌ Error de conexión:', error)
      alert('Error de conexión al cargar la página')
      resetToDefaults()
    }
  } else {
    console.log('Nueva página - usando valores por defecto')
    resetToDefaults()
  }
}

// Función para establecer valores por defecto
const resetToDefaults = () => {
  pageForm.value = {
    title: '',
    slug: '',
    description: '',
    metaTitle: '',
    metaDescription: '',
    metaKeywords: '',
    route: '',
    status: 'draft',
    publishedAt: null
  }
  elements.value = []
}

// Lifecycle
onMounted(() => {
  fetchTemplates()
})
loadPage()
</script>

<style scoped>
.group:hover .group-hover\:opacity-100 {
  opacity: 1;
}

.opacity-0 {
  opacity: 0;
}

.transition-opacity {
  transition: opacity 0.2s ease;
}
</style>
