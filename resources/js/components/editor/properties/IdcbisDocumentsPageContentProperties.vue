<template>
  <div class="docs-props space-y-4">
    <PropertySection title="Encabezado">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Etiqueta superior</label>
        <input v-model="element.eyebrow" type="text" placeholder="Transparencia" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Título</label>
        <input v-model="element.heroTitle" type="text" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Subtítulo</label>
        <input v-model="element.heroSubtitle" type="text" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Imagen de fondo (URL)</label>
        <input v-model="element.heroImage" type="text" placeholder="/img/banner.png" class="editor-field-input">
      </div>
      <div>
        <label class="block text-xs text-gray-600 mb-1">Texto introductorio</label>
        <textarea v-model="element.intro" rows="2" class="editor-field-input" />
      </div>
    </PropertySection>

    <PropertySection title="Presentación" :collapsible="true" :default-open="false">
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Navegación lateral</label>
          <select v-model="element.layout" class="editor-field-input">
            <option value="sidebar">Barra lateral</option>
            <option value="tabs">Pestañas superiores</option>
          </select>
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Columnas de documentos</label>
          <select v-model.number="element.documentColumns" class="editor-field-input">
            <option :value="1">1 columna</option>
            <option :value="2">2 columnas</option>
          </select>
        </div>
      </div>
      <label class="flex items-center gap-2 text-xs text-gray-700">
        <input v-model="element.showSearch" type="checkbox" class="rounded">
        Mostrar buscador
      </label>
      <p class="text-xs text-gray-500 leading-relaxed">
        Cada <strong>sección</strong> puede ser un año (2026), un período
        («Estados financieros a Diciembre de 2025») o cualquier título que necesites.
      </p>
    </PropertySection>

    <PropertySection title="Secciones y documentos" :collapsible="true">
      <PropertyRepeater
        :items="element.groups"
        item-label="Sección"
        add-label="Agregar sección"
        @add="addGroup"
        @remove="removeGroup"
        @move="moveGroup"
      >
        <template #default="{ item: group, index: groupIndex }">
          <div>
            <label class="block text-xs text-gray-600 mb-1">Título de la sección</label>
            <input
              v-model="group.label"
              type="text"
              placeholder="Ej. 2026 o Estados financieros a Marzo de 2025"
              class="editor-field-input"
            >
          </div>

          <div class="docs-props__docs">
            <p class="text-xs font-semibold text-gray-700 mb-2">Documentos</p>
            <PropertyRepeater
              :items="group.documents"
              item-label="Documento"
              add-label="Agregar documento"
              @add="addDocument(group)"
              @remove="(i) => removeDocument(group, i)"
              @move="(i, d) => moveDocument(group, i, d)"
            >
              <template #default="{ item: doc }">
                <input
                  v-model="doc.title"
                  type="text"
                  placeholder="Título del documento"
                  class="editor-field-input"
                >
                <input
                  v-model="doc.publishedAt"
                  type="text"
                  placeholder="Fecha publicación (ej. 06 de Marzo 2026)"
                  class="editor-field-input"
                >
                <input
                  v-model="doc.url"
                  type="url"
                  placeholder="URL del PDF o enlace"
                  class="editor-field-input"
                >
              </template>
            </PropertyRepeater>
          </div>

          <p v-if="!group.documents?.length" class="text-xs text-gray-400 italic">
            Sección {{ groupIndex + 1 }} sin documentos.
          </p>
        </template>
      </PropertyRepeater>

      <p v-if="!element.groups?.length" class="text-xs text-gray-500 italic">
        No hay secciones. Agrega la primera con el botón de abajo.
      </p>
    </PropertySection>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import PropertySection from '../fields/PropertySection.vue'
import PropertyRepeater from '../fields/PropertyRepeater.vue'
import {
  normalizeDocumentGroups,
  createDocumentGroup,
  createDocumentItem,
} from '../../../utils/documentPageGroups'

const props = defineProps({ element: { type: Object, required: true } })

const ensureGroupsArray = () => {
  if (props.element.groups?.length) return

  if (props.element.yearGroups?.length) {
    props.element.groups = props.element.yearGroups.map((g) => ({
      id: g.id,
      label: g.label || g.year || 'Sin título',
      documents: g.documents || [],
    }))
    return
  }

  if (!props.element.groups) {
    props.element.groups = []
  }
}

onMounted(() => {
  ensureGroupsArray()
  props.element.groups.forEach((group) => {
    if (!group.id) group.id = createDocumentGroup().id
    if (!group.label) group.label = group.year || 'Nueva sección'
    if (!group.documents) group.documents = []
    group.documents.forEach((doc) => {
      if (!doc.id) doc.id = createDocumentItem().id
    })
  })
})

const addGroup = () => {
  ensureGroupsArray()
  const isYearStyle = props.element.groups.every((g) => /^\d{4}$/.test(String(g.label || '').trim()))
  let label = 'Nueva sección'
  if (isYearStyle && props.element.groups.length) {
    const years = props.element.groups.map((g) => parseInt(g.label, 10)).filter(Boolean)
    label = years.length ? String(Math.max(...years) + 1) : String(new Date().getFullYear())
  }
  props.element.groups.push(createDocumentGroup(label))
}

const removeGroup = (index) => props.element.groups.splice(index, 1)

const moveGroup = (index, direction) => {
  const list = props.element.groups
  const newIndex = index + direction
  if (newIndex < 0 || newIndex >= list.length) return
  const [item] = list.splice(index, 1)
  list.splice(newIndex, 0, item)
}

const addDocument = (group) => () => {
  if (!group.documents) group.documents = []
  group.documents.push(createDocumentItem())
}

const removeDocument = (group, index) => group.documents.splice(index, 1)

const moveDocument = (group, index, direction) => {
  const list = group.documents
  const newIndex = index + direction
  if (newIndex < 0 || newIndex >= list.length) return
  const [item] = list.splice(index, 1)
  list.splice(newIndex, 0, item)
}
</script>

<style scoped>
.docs-props__docs {
  margin-top: 0.5rem;
  padding: 0.75rem;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
}
</style>
