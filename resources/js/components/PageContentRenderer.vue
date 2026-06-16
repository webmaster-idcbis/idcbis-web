<template>
  <div v-if="elements?.length" class="page-content" :class="{ 'theme-bds': theme === 'bds' }">
    <div
      v-for="element in elements"
      :key="element.id"
      :class="element.fullBleed ? 'page-element-bleed' : 'page-element-contained'"
    >
      <component
        :is="getComponentType(element.type)"
        :element="element"
        :preview="true"
      />
    </div>
  </div>
</template>

<script setup>
import { usePageElements } from '../composables/usePageElements'

defineProps({
  elements: {
    type: Array,
    default: () => [],
  },
  theme: {
    type: String,
    default: null,
  },
})

const { getComponentType } = usePageElements()
</script>

<style scoped>
.page-content {
  font-family: var(--font-idcbis);
  background: #f5f8fa;
}

.page-element-contained {
  max-width: 80rem;
  margin-left: auto;
  margin-right: auto;
  padding: 1rem 1rem;
}

.page-element-bleed {
  width: 100%;
}

.page-content.theme-bds {
  font-family: var(--font-idcbis);
  background: #f5f7fa;
}
</style>
