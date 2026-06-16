<template>
  <component
    :is="wrapperTag"
    :href="linkHref"
    :target="linkTarget"
    :rel="linkTarget === '_blank' ? 'noopener noreferrer' : undefined"
    :type="wrapperTag === 'button' ? 'button' : undefined"
    :class="['button-element', element.className, { 'button-element--link': isLink }]"
    :style="buttonStyles"
    @click="onClick"
  >
    <i v-if="element.icon && element.iconPosition === 'left'" :class="element.icon" :style="iconStyles" />
    <span>{{ element.content || 'Botón' }}</span>
    <i v-if="element.icon && element.iconPosition === 'right'" :class="element.icon" :style="iconStyles" />
  </component>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

const emit = defineEmits(['click'])

const hrefValue = computed(() => (props.element.href || '').trim())

const isLink = computed(() => props.preview && !!hrefValue.value)

const wrapperTag = computed(() => (isLink.value ? 'a' : 'button'))

const linkHref = computed(() => (isLink.value ? hrefValue.value : undefined))

const linkTarget = computed(() => {
  if (!isLink.value) return undefined
  if (props.element.openInNewTab) return '_blank'
  if (/^https?:\/\//i.test(hrefValue.value)) return '_blank'
  return undefined
})

const buttonStyles = computed(() => mergeElementStyles(props.element, {
  display: props.element.display || 'inline-block',
  width: props.element.width || 'auto',
  cursor: 'pointer',
  border: props.element.border || 'none',
  textDecoration: 'none',
  textAlign: 'center',
}))

const iconStyles = computed(() => ({
  fontSize: props.element.iconSize || '14px',
  color: props.element.iconColor || props.element.color || '#ffffff',
}))

const onClick = (event) => {
  if (!props.preview) {
    event.preventDefault()
    event.stopPropagation()
    emit('click', props.element)
  }
}
</script>

<style scoped>
.button-element {
  cursor: pointer;
  white-space: nowrap;
  font-family: inherit;
}

.button-element--link {
  text-decoration: none;
}

.button-element:hover:not(:disabled) {
  filter: brightness(0.95);
  transform: translateY(-1px);
}

.button-element:active:not(:disabled) {
  transform: translateY(0);
}

.button-element:focus {
  outline: 2px solid #005674;
  outline-offset: 2px;
}

.button-element:disabled {
  cursor: not-allowed;
  opacity: 0.6;
}
</style>
