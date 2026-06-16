<template>
  <component
    :is="wrapperTag"
    :href="preview && element.href ? element.href : undefined"
    class="card-element"
    :class="[element.variant, { 'card-element--linked': preview && element.href }]"
    :style="cardStyles"
    @click.stop="$emit('click', element)"
  >
    <div
      v-if="element.image"
      class="card-image"
      :style="{ backgroundImage: `url(${element.image})` }"
    />
    <div class="card-body">
      <span v-if="element.icon" class="card-icon">{{ element.icon }}</span>
      <div v-if="element.tag" class="card-tag">{{ element.tag }}</div>
      <div v-if="element.title" class="card-title" :style="titleStyles">{{ element.title }}</div>
      <div v-if="element.subtitle" class="card-subtitle">{{ element.subtitle }}</div>
      <div v-if="element.content" class="card-content" :style="contentStyles">{{ element.content }}</div>
      <span v-if="element.linkLabel && preview && element.href" class="card-link-label">{{ element.linkLabel }} →</span>
    </div>
  </component>
</template>

<script setup>
import { computed } from 'vue'
import { mergeElementStyles, resolveBackgroundColor } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const wrapperTag = computed(() => (props.preview && props.element.href ? 'a' : 'div'))

const cardStyles = computed(() => mergeElementStyles(props.element, {
  display: 'flex',
  flexDirection: 'column',
  overflow: 'hidden',
  textDecoration: 'none',
  color: 'inherit',
  backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#ffffff'),
  borderRadius: props.element.borderRadius || '16px',
  border: props.element.border || '1px solid #e5e7eb',
  boxShadow: props.element.boxShadow || '0 8px 24px rgba(11, 79, 108, 0.08)',
  padding: props.element.image ? '0' : (props.element.padding || '24px'),
  width: props.element.width || '100%',
  height: props.element.height || 'auto',
  transition: 'transform 0.2s, box-shadow 0.2s',
}))

const titleStyles = computed(() => ({
  color: props.element.titleColor || '#0b4f6c',
  fontSize: props.element.titleSize || '1.25rem',
}))

const contentStyles = computed(() => ({
  color: props.element.color || '#4b5563',
  fontSize: props.element.fontSize || '0.95rem',
  textAlign: props.element.textAlign || 'left',
}))
</script>

<style scoped>
.card-element {
  cursor: pointer;
  font-family: var(--font-idcbis);
}

.card-element--linked:hover {
  transform: translateY(-4px);
  box-shadow: 0 16px 32px rgba(11, 79, 108, 0.15) !important;
}

.card-image {
  height: 160px;
  background-size: cover;
  background-position: center;
}

.card-body {
  padding: 1.25rem 1.5rem 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
  flex: 1;
}

.card-element:not(:has(.card-image)) .card-body {
  padding: 0;
}

.card-icon {
  font-size: 1.75rem;
  line-height: 1;
}

.card-tag {
  display: inline-block;
  align-self: flex-start;
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  padding: 0.25rem 0.65rem;
  border-radius: 999px;
  background: #e1f0f5;
  color: #0b4f6c;
}

.card-title {
  font-weight: 700;
  line-height: 1.25;
}

.card-subtitle {
  font-size: 0.85rem;
  color: #64748b;
  font-weight: 500;
}

.card-content {
  line-height: 1.6;
  white-space: pre-line;
  flex: 1;
}

.card-link-label {
  font-size: 0.85rem;
  font-weight: 600;
  color: #2c8c99;
  margin-top: 0.5rem;
}

.card-element.featured {
  border: 2px solid #2c8c99;
  background: linear-gradient(180deg, #f5f8fa 0%, #fff 100%);
}

.card-element.soft {
  background: #f5f8fa;
  border: none;
  box-shadow: none;
}

.card-element.feature {
  border: none;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  border-top: 5px solid #d32f2f;
  font-family: var(--font-idcbis);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}

.card-element.feature::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 5px;
  background: linear-gradient(to right, #d32f2f, #00acc1);
}

.card-element.feature {
  position: relative;
}

.card-element.feature:hover {
  transform: translateY(-15px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.card-element.feature .card-icon {
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  color: #d32f2f;
  padding-top: 1.5rem;
}

.card-element.feature .card-title {
  color: #1a237e;
  font-size: 1.5rem;
}

.card-element.type {
  border: none;
  border-radius: 20px;
  padding: 2.5rem !important;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  font-family: var(--font-idcbis);
  position: relative;
  overflow: hidden;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}

.card-element.type::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 5px;
  background: linear-gradient(to right, #d32f2f, #00acc1);
}

.card-element.type:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.card-element.type .card-title {
  color: #1a237e;
  font-size: 1.6rem;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.card-element.type .card-icon {
  font-size: 1.8rem;
  color: #d32f2f;
}

.card-element.info {
  border: none;
  border-radius: 20px;
  padding: 2.5rem !important;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  font-family: var(--font-idcbis);
}

.card-element.info .card-title {
  color: #1a237e;
  font-size: 1.8rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.card-element.info .card-content {
  color: #555;
  line-height: 1.7;
}
</style>
