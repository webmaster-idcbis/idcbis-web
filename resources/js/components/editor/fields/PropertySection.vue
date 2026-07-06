<template>
  <div class="editor-section">
    <button
      v-if="collapsible"
      type="button"
      class="editor-section__header"
      :aria-expanded="isOpen"
      @click="isOpen = !isOpen"
    >
      <span class="editor-section__title">{{ title }}</span>
      <svg
        class="editor-section__chevron"
        :class="{ 'editor-section__chevron--open': isOpen }"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        aria-hidden="true"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
      </svg>
    </button>
    <h4 v-else class="editor-section__title editor-section__title--static">{{ title }}</h4>
    <div v-show="!collapsible || isOpen" class="editor-section__body">
      <slot />
    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue'

const props = defineProps({
  title: { type: String, required: true },
  collapsible: { type: Boolean, default: false },
  defaultOpen: { type: Boolean, default: true },
  /** Control externo (para abrir al enfocar desde el lienzo) */
  open: { type: Boolean, default: undefined },
})

const emit = defineEmits(['update:open'])

const internalOpen = ref(props.defaultOpen)

watch(() => props.defaultOpen, (value) => {
  if (props.open === undefined) {
    internalOpen.value = value
  }
})

const isOpen = computed({
  get: () => (props.open !== undefined ? props.open : internalOpen.value),
  set: (value) => {
    if (props.open !== undefined) {
      emit('update:open', value)
    } else {
      internalOpen.value = value
    }
  },
})
</script>

<style scoped>
.editor-section {
  padding-bottom: 0.75rem;
  border-bottom: 1px solid #e5e7eb;
}

.editor-section:last-child {
  border-bottom: none;
  padding-bottom: 0;
}

.editor-section__header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.5rem;
  width: 100%;
  margin: 0;
  padding: 0.25rem 0;
  border: none;
  background: transparent;
  cursor: pointer;
  text-align: left;
}

.editor-section__title {
  font-size: 0.8125rem;
  font-weight: 600;
  color: #374151;
  line-height: 1.3;
}

.editor-section__title--static {
  margin: 0 0 0.75rem;
}

.editor-section__chevron {
  width: 0.875rem;
  height: 0.875rem;
  min-width: 0.875rem;
  flex-shrink: 0;
  color: #9ca3af;
  transition: transform 0.15s ease;
}

.editor-section__chevron--open {
  transform: rotate(90deg);
}

.editor-section__body {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  padding-top: 0.5rem;
}
</style>
