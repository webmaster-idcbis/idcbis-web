<template>
  <div class="editor-section">
    <button
      v-if="collapsible"
      type="button"
      class="editor-section__header"
      @click="open = !open"
    >
      <span class="editor-section__title">{{ title }}</span>
      <svg
        :class="['editor-section__chevron', open ? 'editor-section__chevron--open' : '']"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
      </svg>
    </button>
    <h4 v-else class="editor-section__title mb-3">{{ title }}</h4>
    <div v-show="!collapsible || open" class="space-y-3">
      <slot />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  title: { type: String, required: true },
  collapsible: { type: Boolean, default: false },
  defaultOpen: { type: Boolean, default: true },
})

const open = ref(props.defaultOpen)
</script>
