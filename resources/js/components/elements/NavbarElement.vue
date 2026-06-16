<template>
  <nav
    class="navbar-element"
    :style="navbarStyles"
    @click.stop="$emit('click', element)"
  >
    <div class="navbar-brand">
      {{ element.brand || 'Mi sitio' }}
    </div>
    <ul class="navbar-menu">
      <li
        v-for="(link, index) in links"
        :key="`${link.href}-${index}`"
        class="navbar-item"
      >
        <a
          :href="preview && link.href ? link.href : '#'"
          class="navbar-link"
          @click="onLinkClick"
        >
          {{ link.text }}
        </a>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { computed } from 'vue'
import { resolveBackgroundColor } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const links = computed(() => props.element.links || [])

const navbarStyles = computed(() => ({
  backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#343a40'),
  color: props.element.color || '#ffffff',
  padding: props.element.padding || '8px 16px',
  borderRadius: '0',
  marginBottom: '16px',
  display: 'flex',
  justifyContent: 'space-between',
  alignItems: 'center',
  boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
}))

const onLinkClick = (event) => {
  if (!props.preview) {
    event.preventDefault()
    event.stopPropagation()
  }
}
</script>

<style scoped>
.navbar-element {
  cursor: pointer;
  transition: all 0.2s ease;
}

.navbar-element:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.navbar-brand {
  font-size: 1.25rem;
  font-weight: 700;
  color: inherit;
}

.navbar-menu {
  display: flex;
  list-style: none;
  margin: 0;
  padding: 0;
  gap: 24px;
}

.navbar-item {
  margin: 0;
  padding: 0;
}

.navbar-link {
  color: inherit;
  text-decoration: none;
  font-weight: 500;
  padding: 8px 12px;
  border-radius: 6px;
  transition: background-color 0.2s ease;
}

.navbar-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
}
</style>
