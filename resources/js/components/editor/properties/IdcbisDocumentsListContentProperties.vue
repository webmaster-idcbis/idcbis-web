<template>
  <div class="docs-list-props space-y-4">
    <p class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2">
      Haz clic en una sección o documento del lienzo para editarlo aquí. El encabezado e intro se editan en sus bloques separados.
    </p>

    <PropertySection title="Presentación" :collapsible="true" :default-open="true">
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Navegación</label>
          <select v-model="element.layout" class="editor-field-input">
            <option value="sidebar">Barra lateral</option>
            <option value="tabs">Pestañas superiores</option>
          </select>
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Columnas</label>
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
    </PropertySection>

    <PropertySection title="Secciones y documentos" :collapsible="true">
      <PropertyRepeater
        :items="element.groups"
        item-label="Sección"
        add-label="Agregar sección"
        :active-focus="activeFocus"
        :get-focus-id="(group) => buildDocumentGroupFocusAnchor(group.id)"
        @add="addGroup"
        @remove="removeGroup"
        @move="moveGroup"
      >
        <template #default="{ item: group }">
          <div :data-editor-focus="buildDocumentGroupFocusAnchor(group.id)">
            <label class="block text-xs text-gray-600 mb-1">Título de la sección</label>
            <input v-model="group.label" type="text" class="editor-field-input">

            <div class="docs-list-props__docs mt-3">
              <PropertyRepeater
                :items="group.documents"
                item-label="Documento"
                add-label="Agregar documento"
                :active-focus="activeFocus"
                :get-focus-id="(doc) => buildDocumentItemFocusAnchor(doc.id)"
                @add="addDocument(group)"
                @remove="(i) => removeDocument(group, i)"
                @move="(i, d) => moveDocument(group, i, d)"
              >
                <template #default="{ item: doc }">
                  <div :data-editor-focus="buildDocumentItemFocusAnchor(doc.id)" class="space-y-2">
                    <input v-model="doc.title" type="text" placeholder="Título del documento" class="editor-field-input">
                    <input v-model="doc.publishedAt" type="text" placeholder="Fecha de publicación" class="editor-field-input">
                    <input v-model="doc.url" type="text" placeholder="URL del documento" class="editor-field-input">
                  </div>
                </template>
              </PropertyRepeater>
            </div>
          </div>
        </template>
      </PropertyRepeater>
    </PropertySection>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue'
import PropertySection from '../fields/PropertySection.vue'
import PropertyRepeater from '../fields/PropertyRepeater.vue'
import { createDocumentGroup, createDocumentItem } from '../../../utils/documentPageGroups'
import { scrollToEditorFocus, buildDocumentGroupFocusAnchor, buildDocumentItemFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const activeFocus = computed(() => props.partFocus?.anchor || '')

watch(() => props.partFocus?.anchor, (anchor) => {
  if (anchor) scrollToEditorFocus(anchor)
}, { immediate: true })

const addGroup = () => {
  if (!props.element.groups) props.element.groups = []
  props.element.groups.push(createDocumentGroup())
}

const removeGroup = (i) => props.element.groups.splice(i, 1)

const moveGroup = (i, d) => {
  const list = props.element.groups
  const next = i + d
  if (next < 0 || next >= list.length) return
  const [item] = list.splice(i, 1)
  list.splice(next, 0, item)
}

const addDocument = (group) => () => {
  if (!group.documents) group.documents = []
  group.documents.push(createDocumentItem())
}

const removeDocument = (group, i) => group.documents.splice(i, 1)

const moveDocument = (group, i, d) => {
  const list = group.documents
  const next = i + d
  if (next < 0 || next >= list.length) return
  const [item] = list.splice(i, 1)
  list.splice(next, 0, item)
}
</script>

<style scoped>
.docs-list-props__docs {
  padding: 0.75rem;
  background: #f9fafb;
  border-radius: 0.5rem;
  border: 1px solid #e5e7eb;
}
</style>
