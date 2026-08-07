<template>
  <div class="qs-props space-y-4">
    <p class="text-xs text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2 leading-relaxed">
      Haz clic en cualquier bloque del lienzo (líder, misión, sección…) y este panel saltará al campo correspondiente.
    </p>

    <PropertySection title="Encabezado" :open="panelsOpen.header" @update:open="panelsOpen.header = $event">
      <div data-editor-focus="hero" class="space-y-3">
      <div>
        <label class="block text-xs text-gray-600 mb-1">Etiqueta superior</label>
        <input v-model="element.heroEyebrow" type="text" placeholder="Instituto IDCBIS" class="editor-field-input">
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
        <input v-model="element.heroImage" type="text" placeholder="/img/Quienes-Somos-l-IDCBIS-2020.png" class="editor-field-input">
      </div>
      </div>
    </PropertySection>

    <PropertySection
      title="Introducción"
      :collapsible="true"
      :open="panelsOpen.intro"
      @update:open="panelsOpen.intro = $event"
    >
      <PropertyRepeater
        :items="element.intro"
        item-label="Párrafo"
        add-label="Agregar párrafo"
        :active-focus="activeFocus"
        :get-focus-id="(_, index) => buildIntroFocusAnchor(index)"
        @add="addIntro"
        @remove="removeIntro"
        @move="moveIntro"
      >
        <template #default="{ item, index }">
          <textarea
            v-model="element.intro[index]"
            rows="3"
            class="editor-field-input"
            placeholder="Texto del párrafo introductorio"
          />
        </template>
      </PropertyRepeater>
      <p v-if="!element.intro?.length" class="text-xs text-gray-500 italic">Sin párrafos de introducción.</p>
    </PropertySection>

    <PropertySection
      title="Misión, visión y propósito"
      :collapsible="true"
      :open="panelsOpen.mv"
      @update:open="panelsOpen.mv = $event"
    >
      <div data-editor-focus="mission">
        <label class="block text-xs text-gray-600 mb-1">Misión</label>
        <textarea v-model="element.mission" rows="4" class="editor-field-input" />
      </div>
      <div data-editor-focus="vision">
        <label class="block text-xs text-gray-600 mb-1">Visión 2030</label>
        <textarea v-model="element.vision" rows="4" class="editor-field-input" />
      </div>
      <div data-editor-focus="purpose">
        <label class="block text-xs text-gray-600 mb-1">Propósito superior</label>
        <textarea v-model="element.purpose" rows="2" class="editor-field-input" />
      </div>
    </PropertySection>

    <PropertySection
      title="Principios rectores"
      :collapsible="true"
      :open="panelsOpen.principles"
      @update:open="panelsOpen.principles = $event"
    >
      <PropertyRepeater
        :items="element.principles"
        item-label="Principio"
        add-label="Agregar principio"
        :active-focus="activeFocus"
        :get-focus-id="(item) => buildPrincipleFocusAnchor(item.id)"
        @add="addPrinciple"
        @remove="removePrinciple"
        @move="movePrinciple"
      >
        <template #default="{ item }">
          <div class="grid grid-cols-[3rem_1fr] gap-2">
            <input v-model="item.icon" type="text" class="editor-field-input text-center" placeholder="Emoji o ruta SVG" title="Icono">
            <input v-model="item.title" type="text" class="editor-field-input" placeholder="Nombre del principio">
          </div>
        </template>
      </PropertyRepeater>
    </PropertySection>

    <PropertySection
      title="Director"
      :collapsible="true"
      :open="panelsOpen.director"
      @update:open="panelsOpen.director = $event"
    >
      <label class="flex items-center gap-2 text-xs text-gray-700 mb-2">
        <input v-model="showDirector" type="checkbox" class="rounded">
        Mostrar bloque del director
      </label>
      <template v-if="showDirector">
        <div data-editor-focus="director" class="space-y-3">
        <input v-model="element.director.name" type="text" placeholder="Nombre completo" class="editor-field-input">
        <input v-model="element.director.role" type="text" placeholder="Cargo" class="editor-field-input">
        <input v-model="element.director.credentials" type="text" placeholder="Títulos (ej. MD. PhD.)" class="editor-field-input">
        <input v-model="element.director.email" type="email" placeholder="Correo electrónico" class="editor-field-input">
        <textarea v-model="element.director.bio" rows="4" placeholder="Biografía" class="editor-field-input" />
        <input
          v-model="element.director.image"
          type="text"
          placeholder="Foto (URL) — opcional si usas slug"
          class="editor-field-input"
        >
        <input
          v-model="element.director.photoSlug"
          type="text"
          placeholder="Slug foto: /img/equipo/{slug}.jpg"
          class="editor-field-input"
        >
        </div>
      </template>
    </PropertySection>

    <PropertySection
      title="Secciones institucionales"
      :collapsible="true"
      :open="panelsOpen.sections"
      @update:open="panelsOpen.sections = $event"
    >
      <p class="text-xs text-gray-500 leading-relaxed">
        Acordeones al final de la página: funciones, fundadores, equipo, políticas y contacto.
      </p>
      <PropertyRepeater
        :items="element.sections"
        item-label="Sección"
        add-label="Agregar sección"
        :active-focus="activeFocus"
        :get-focus-id="(section) => buildSectionFocusAnchor(section.id)"
        @add="addSection"
        @remove="removeSection"
        @move="moveSection"
      >
        <template #default="{ item: section }">
          <div class="grid grid-cols-[3rem_1fr] gap-2">
            <input v-model="section.icon" type="text" class="editor-field-input text-center" placeholder="Emoji o ruta SVG">
            <input v-model="section.title" type="text" class="editor-field-input" placeholder="Título de la sección">
          </div>
          <div>
            <label class="block text-xs text-gray-600 mb-1">Tipo de contenido</label>
            <select
              :value="section.layout"
              class="editor-field-input"
              @change="changeSectionLayout(section, $event.target.value)"
            >
              <option v-for="opt in layoutOptions" :key="opt.value" :value="opt.value">
                {{ opt.label }}
              </option>
            </select>
          </div>

          <!-- Lista / fundadores -->
          <div v-if="section.layout === 'list' || section.layout === 'founders'" class="qs-props__nested">
            <p class="text-xs font-semibold text-gray-700 mb-2">
              {{ section.layout === 'founders' ? 'Nombres' : 'Ítems de la lista' }}
            </p>
            <div v-for="(line, li) in section.items" :key="li" class="flex gap-2 items-start mb-2">
              <textarea
                v-model="section.items[li]"
                rows="2"
                class="editor-field-input flex-1"
                placeholder="Texto del ítem"
              />
              <button type="button" class="props-mini-btn props-mini-btn--danger shrink-0" @click="section.items.splice(li, 1)">✕</button>
            </div>
            <button type="button" class="editor-add-btn" @click="section.items.push('')">+ Agregar ítem</button>
          </div>

          <!-- Equipo -->
          <div v-else-if="section.layout === 'team'" class="qs-props__nested">
            <PropertyRepeater
              :items="section.members"
              item-label="Miembro"
              add-label="Agregar miembro"
              :active-focus="activeFocus"
              :get-focus-id="(member) => buildTeamFocusAnchor(member.id)"
              @add="addTeamMember(section)"
              @remove="(i) => removeTeamMember(section, i)"
              @move="(i, d) => moveTeamMember(section, i, d)"
            >
              <template #default="{ item: member }">
                <input v-model="member.name" type="text" placeholder="Nombre" class="editor-field-input">
                <input v-model="member.role" type="text" placeholder="Cargo" class="editor-field-input">
                <input v-model="member.credentials" type="text" placeholder="Títulos" class="editor-field-input">
                <input v-model="member.email" type="email" placeholder="Correo" class="editor-field-input">
                <input v-model="member.image" type="text" placeholder="Foto URL (opcional)" class="editor-field-input">
                <input v-model="member.photoSlug" type="text" placeholder="Slug foto (/img/equipo/...)" class="editor-field-input">
              </template>
            </PropertyRepeater>
          </div>

          <!-- Políticas -->
          <div v-else-if="section.layout === 'policies'" class="qs-props__nested">
            <PropertyRepeater
              :items="section.items"
              item-label="Política"
              add-label="Agregar política"
              @add="addPolicy(section)"
              @remove="(i) => removePolicy(section, i)"
              @move="(i, d) => movePolicy(section, i, d)"
            >
              <template #default="{ item: pol }">
                <div class="grid grid-cols-[3rem_1fr] gap-2">
                  <input v-model="pol.icon" type="text" class="editor-field-input text-center" placeholder="Emoji o ruta SVG">
                  <input v-model="pol.title" type="text" placeholder="Título" class="editor-field-input">
                </div>
                <input v-model="pol.description" type="text" placeholder="Descripción breve" class="editor-field-input">
                <input v-model="pol.url" type="url" placeholder="URL del documento" class="editor-field-input">
              </template>
            </PropertyRepeater>
          </div>

          <!-- Contacto -->
          <div v-else-if="section.layout === 'contact'" class="qs-props__nested">
            <PropertyRepeater
              :items="section.items"
              item-label="Bloque"
              add-label="Agregar bloque"
              @add="addContactBlock(section)"
              @remove="(i) => removeContactBlock(section, i)"
              @move="(i, d) => moveContactBlock(section, i, d)"
            >
              <template #default="{ item: block }">
                <div class="grid grid-cols-[3rem_1fr] gap-2">
                  <input v-model="block.icon" type="text" class="editor-field-input text-center" placeholder="Emoji o ruta SVG">
                  <input v-model="block.title" type="text" placeholder="Título" class="editor-field-input">
                </div>
                <textarea v-model="block.text" rows="3" placeholder="Texto (puede incluir saltos de línea)" class="editor-field-input" />
              </template>
            </PropertyRepeater>
          </div>
        </template>
      </PropertyRepeater>
    </PropertySection>
  </div>
</template>

<script setup>
import { computed, onMounted, reactive, watch } from 'vue'
import PropertySection from '../fields/PropertySection.vue'
import PropertyRepeater from '../fields/PropertyRepeater.vue'
import {
  scrollToEditorFocus,
  buildIntroFocusAnchor,
  buildPrincipleFocusAnchor,
  buildSectionFocusAnchor,
  buildTeamFocusAnchor,
} from '../../../utils/editorPartFocus'
import {
  QUIENES_SOMOS_LAYOUTS,
  createPrinciple,
  createTeamMember,
  createPolicyItem,
  createContactBlock,
  createQuienesSomosSection,
  ensureQuienesSomosElement,
  onSectionLayoutChange,
} from '../../../utils/quienesSomosContent'

const props = defineProps({
  element: { type: Object, required: true },
  partFocus: { type: Object, default: null },
})

const layoutOptions = QUIENES_SOMOS_LAYOUTS
const activeFocus = computed(() => props.partFocus?.anchor || '')

const panelsOpen = reactive({
  header: true,
  intro: false,
  mv: false,
  principles: false,
  director: false,
  sections: true,
})

const applyPartFocus = (anchor) => {
  if (!anchor) return

  if (anchor === 'hero') panelsOpen.header = true
  else if (anchor.startsWith('intro:')) panelsOpen.intro = true
  else if (['mission', 'vision', 'purpose'].includes(anchor)) panelsOpen.mv = true
  else if (anchor.startsWith('principle:')) panelsOpen.principles = true
  else if (anchor === 'director') panelsOpen.director = true
  else if (anchor.startsWith('section:') || anchor.startsWith('team:')) panelsOpen.sections = true

  scrollToEditorFocus(anchor)
}

watch(() => props.partFocus?.anchor, (anchor) => {
  if (anchor) applyPartFocus(anchor)
}, { immediate: true })

const showDirector = computed({
  get: () => props.element.director != null,
  set: (value) => {
    if (value) {
      props.element.director = props.element.director || createTeamMember({
        name: 'Nombre del director',
        role: 'Director',
        bio: '',
      })
    } else {
      props.element.director = null
    }
  },
})

onMounted(() => {
  ensureQuienesSomosElement(props.element)
})

const moveArrayItem = (arr, index, delta) => {
  const next = index + delta
  if (next < 0 || next >= arr.length) return
  const [item] = arr.splice(index, 1)
  arr.splice(next, 0, item)
}

const addIntro = () => {
  if (!props.element.intro) props.element.intro = []
  props.element.intro.push('')
}
const removeIntro = (i) => props.element.intro.splice(i, 1)
const moveIntro = (i, d) => moveArrayItem(props.element.intro, i, d)

const addPrinciple = () => {
  if (!props.element.principles) props.element.principles = []
  props.element.principles.push(createPrinciple())
}
const removePrinciple = (i) => props.element.principles.splice(i, 1)
const movePrinciple = (i, d) => moveArrayItem(props.element.principles, i, d)

const addSection = () => {
  if (!props.element.sections) props.element.sections = []
  props.element.sections.push(createQuienesSomosSection('list'))
}
const removeSection = (i) => props.element.sections.splice(i, 1)
const moveSection = (i, d) => moveArrayItem(props.element.sections, i, d)

const changeSectionLayout = (section, layout) => {
  if (section.layout === layout) return
  onSectionLayoutChange(section, layout)
}

const addTeamMember = (section) => () => {
  if (!section.members) section.members = []
  section.members.push(createTeamMember())
}
const removeTeamMember = (section, i) => section.members.splice(i, 1)
const moveTeamMember = (section, i, d) => moveArrayItem(section.members, i, d)

const addPolicy = (section) => () => {
  if (!section.items) section.items = []
  section.items.push(createPolicyItem())
}
const removePolicy = (section, i) => section.items.splice(i, 1)
const movePolicy = (section, i, d) => moveArrayItem(section.items, i, d)

const addContactBlock = (section) => () => {
  if (!section.items) section.items = []
  section.items.push(createContactBlock())
}
const removeContactBlock = (section, i) => section.items.splice(i, 1)
const moveContactBlock = (section, i, d) => moveArrayItem(section.items, i, d)
</script>

<style scoped>
.qs-props__nested {
  margin-top: 0.5rem;
  padding: 0.75rem;
  background: #f9fafb;
  border-radius: 0.5rem;
  border: 1px solid #e5e7eb;
}

.props-mini-btn {
  padding: 0.125rem 0.375rem;
  font-size: 0.6875rem;
  border: 1px solid #d1d5db;
  border-radius: 0.25rem;
  background: #fff;
  color: #dc2626;
  border-color: #fecaca;
  line-height: 1.2;
}
</style>
