<template>
  <div class="space-y-3">
    <p class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2">
      Haz clic en el encabezado o en una tarjeta del equipo en el lienzo para editarla aquí.
    </p>

    <div data-editor-focus="team:header" :class="{ 'ring-2 ring-[#0B4F6C] rounded-lg p-2': activeFocus === 'team:header' }" class="space-y-2">
      <input v-model="element.sectionTitle" type="text" placeholder="Título de la sección" class="editor-field-input">
      <input v-model="element.sectionIcon" type="text" placeholder="Emoji (👥)" class="editor-field-input">
    </div>

    <div
      v-for="(member, i) in element.members"
      :key="member.id || i"
      :data-editor-focus="buildTeamFocusAnchor(member.id || `index-${i}`)"
      class="border rounded p-3 space-y-2 bg-gray-50"
      :class="{ 'ring-2 ring-[#0B4F6C]': activeFocus === buildTeamFocusAnchor(member.id || `index-${i}`) }"
    >
      <div class="flex justify-between items-center">
        <span class="text-xs font-medium">{{ member.name || `Miembro ${i + 1}` }}</span>
        <button type="button" class="text-xs text-red-600" @click="element.members.splice(i, 1)">Quitar</button>
      </div>
      <input v-model="member.name" type="text" placeholder="Nombre" class="editor-field-input">
      <input v-model="member.role" type="text" placeholder="Cargo" class="editor-field-input">
      <input v-model="member.credentials" type="text" placeholder="Credenciales" class="editor-field-input">
      <input v-model="member.email" type="text" placeholder="Correo" class="editor-field-input">
      <input v-model="member.photoSlug" type="text" placeholder="Slug foto (ej. ana-maria-perdomo)" class="editor-field-input">
      <input v-model="member.image" type="text" placeholder="URL imagen (opcional)" class="editor-field-input">
    </div>

    <button type="button" class="w-full py-2 text-sm border border-dashed rounded hover:bg-gray-50" @click="addMember">
      + Agregar miembro
    </button>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue'
import { generateId } from '../../../utils/pageElementFactory'
import { scrollToEditorFocus, buildTeamFocusAnchor } from '../../../utils/editorPartFocus'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const activeFocus = computed(() => props.partFocus?.anchor || '')

watch(() => props.partFocus?.anchor, (anchor) => {
  if (anchor) scrollToEditorFocus(anchor)
}, { immediate: true })

const addMember = () => {
  if (!props.element.members) props.element.members = []
  props.element.members.push({
    id: generateId(),
    name: '',
    role: '',
    email: '',
    credentials: '',
    photoSlug: '',
    image: '',
  })
}
</script>

<style scoped>
.editor-field-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; }
</style>
