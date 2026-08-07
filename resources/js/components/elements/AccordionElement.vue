<template>
  <section class="accordion-block" :style="sectionStyles" @click.stop="$emit('click', element)">
    <div class="accordion-block__container">
      <div v-if="element.title || element.subtitle" class="section-header">
        <h2 v-if="element.title" class="section-title" :style="titleColor">{{ element.title }}</h2>
        <p v-if="element.subtitle" class="section-subtitle" :style="subtitleColor">{{ element.subtitle }}</p>
      </div>
      <div class="accordion-list">
        <div
          v-for="(item, index) in items"
          :key="item.id || index"
          class="faq-item"
          :class="{ active: openIndex === index }"
        >
          <button
            type="button"
            class="faq-question"
            :aria-expanded="openIndex === index ? 'true' : 'false'"
            @click.stop="toggle(index)"
          >
            <span>{{ item.question }}</span>
            <span class="faq-chevron">▼</span>
          </button>
          <div class="faq-answer">
            <p v-if="item.answer" class="faq-answer__text">{{ item.answer }}</p>
            <img
              v-if="item.image"
              :src="item.image"
              :alt="item.imageAlt || item.question"
              class="faq-answer__image"
              @error="($event) => { $event.target.style.display = 'none' }"
            />
            <div v-if="item.links?.length" class="faq-links">
              <a
                v-for="(link, li) in item.links"
                :key="link.id || li"
                :href="preview ? (link.url || '#') : '#'"
                :target="preview && link.url?.startsWith('http') ? '_blank' : undefined"
                rel="noopener"
                class="faq-link"
                @click.stop="!preview && $event.preventDefault()"
              >
                <strong>{{ link.label }}</strong>
                <span v-if="link.description">{{ link.description }}</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref } from 'vue'
import { resolveBackgroundColor } from '../../composables/useElementStyles'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const openIndex = ref(props.preview ? 0 : -1)

const items = computed(() => props.element.items || [])

const sectionStyles = computed(() => ({
  backgroundColor: resolveBackgroundColor(props.element.backgroundColor, '#eceff1'),
  borderRadius: props.element.borderRadius || '30px',
  padding: props.element.padding || '5rem 2rem',
  margin: props.element.margin || '2rem auto',
  maxWidth: props.element.maxWidth || '1200px',
}))

const titleColor = computed(() => ({
  color: props.element.titleColor || '#1a237e',
}))

const subtitleColor = computed(() => ({
  color: props.element.subtitleColor || '#607d8b',
}))

const toggle = (index) => {
  openIndex.value = openIndex.value === index ? -1 : index
}
</script>

<style scoped>
.accordion-block {
  font-family: var(--font-idcbis);
  cursor: pointer;
}

.accordion-block__container {
  max-width: 900px;
  margin: 0 auto;
}

.section-header {
  text-align: center;
  margin-bottom: 3rem;
}

.section-title {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  position: relative;
  display: inline-block;
}

.section-title::after {
  content: '';
  position: absolute;
  width: 120px;
  height: 5px;
  background: linear-gradient(to right, #0b4f6c, #2c8c99);
  bottom: -15px;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 5px;
}

.section-subtitle {
  font-size: 1.2rem;
  max-width: 700px;
  margin: 2rem auto 0;
}

.accordion-list {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.faq-item {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  transition: box-shadow 0.3s ease;
}

.faq-question {
  width: 100%;
  padding: 1.5rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  cursor: pointer;
  font-weight: 600;
  font-size: 1.1rem;
  color: #1a237e;
  background: none;
  border: none;
  text-align: left;
  font-family: inherit;
}

.faq-chevron {
  color: #2c8c99;
  font-size: 0.75rem;
  transition: transform 0.3s ease;
  flex-shrink: 0;
}

.faq-item.active .faq-chevron {
  transform: rotate(180deg);
}

.faq-answer {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.5s ease, padding 0.5s ease;
}

.faq-item.active .faq-answer {
  max-height: 20000px;
  padding: 0 2rem 2rem;
}

.faq-answer p {
  margin: 0;
  color: #555;
  line-height: 1.65;
  white-space: pre-line;
}

.faq-answer__image {
  display: block;
  width: 100%;
  max-width: 100%;
  height: auto;
  margin: 1.25rem 0;
  border-radius: 12px;
}

.faq-links {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.faq-answer p + .faq-links,
.faq-answer__image + .faq-links {
  margin-top: 1.25rem;
}

.faq-link {
  display: block;
  padding: 1rem 1.25rem;
  background: #f0f5f8;
  border-left: 4px solid #2c8c99;
  border-radius: 8px;
  text-decoration: none;
  transition: background 0.2s ease, transform 0.2s ease;
}

.faq-link:hover,
.faq-link:focus-visible {
  background: #e1f0f5;
  transform: translateX(4px);
}

.faq-link:focus-visible {
  outline: 2px solid #005674;
  outline-offset: 2px;
}

.faq-link strong {
  display: block;
  color: #0b4f6c;
  font-size: 1rem;
}

.faq-link span {
  display: block;
  margin-top: 0.25rem;
  color: #555;
  font-size: 0.9rem;
  line-height: 1.5;
}
</style>
