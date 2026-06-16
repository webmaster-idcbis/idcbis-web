<template>
  <div class="space-y-3">
    <div v-if="!collapsed">
      <input
        v-model="search"
        type="search"
        placeholder="Buscar elemento..."
        class="editor-field-input text-sm"
        data-cy="palette-search"
      >
    </div>

    <section v-for="category in filteredCategories" :key="category.id">
      <button
        v-if="!collapsed"
        type="button"
        class="flex items-center justify-between w-full text-left mb-1.5"
        @click="toggleCategory(category.id)"
      >
        <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">
          {{ category.label }}
        </span>
        <svg
          :class="['w-3 h-3 text-gray-400 transition-transform', isOpen(category.id) ? 'rotate-90' : '']"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
      </button>
      <h4
        v-else
        class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-1.5 sr-only"
      >
        {{ category.label }}
      </h4>

      <div v-show="collapsed || isOpen(category.id)" :class="collapsed ? 'space-y-2' : 'space-y-1'">
        <div
          v-for="item in category.items"
          :key="item.type"
          draggable="true"
          :title="collapsed ? item.label : item.description"
          :data-cy="`palette-item-${item.type}`"
          class="cursor-move hover:bg-gray-100 border border-gray-200 rounded transition-colors bg-gray-50"
          :class="collapsed
            ? 'p-2 flex items-center justify-center'
            : 'p-2.5 flex items-center gap-3'"
          @dragstart="$emit('drag-start', $event, item.type)"
        >
          <span
            :class="['shrink-0 font-semibold', collapsed ? 'text-lg' : 'text-base w-6 text-center', item.iconClass]"
          >
            {{ item.icon }}
          </span>
          <div v-if="!collapsed" class="min-w-0">
            <span class="block text-sm font-medium text-gray-800">{{ item.label }}</span>
            <span class="block text-[11px] text-gray-500 truncate">{{ item.description }}</span>
          </div>
        </div>
      </div>
    </section>

    <p v-if="!collapsed && filteredCategories.length === 0" class="text-xs text-gray-500 text-center py-4">
      No hay elementos que coincidan con «{{ search }}»
    </p>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { paletteCategories } from '../../config/pageElementPalette'

defineProps({
  collapsed: { type: Boolean, default: false },
})

defineEmits(['drag-start'])

const search = ref('')
const openCategories = ref(Object.fromEntries(paletteCategories.map((c) => [c.id, true])))

const toggleCategory = (id) => {
  openCategories.value[id] = !openCategories.value[id]
}

const isOpen = (id) => openCategories.value[id] !== false

const filteredCategories = computed(() => {
  const q = search.value.trim().toLowerCase()
  if (!q) return paletteCategories

  return paletteCategories
    .map((category) => ({
      ...category,
      items: category.items.filter(
        (item) =>
          item.label.toLowerCase().includes(q)
          || item.description.toLowerCase().includes(q)
          || item.type.toLowerCase().includes(q)
      ),
    }))
    .filter((category) => category.items.length > 0)
})
</script>
