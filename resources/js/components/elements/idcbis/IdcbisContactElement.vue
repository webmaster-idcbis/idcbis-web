<template>
  <section class="idcbis-contact" @click.stop="$emit('click', element)">
    <div class="idcbis-contact__grid">
      <div
        v-for="(item, index) in items"
        :key="item.id || index"
        class="idcbis-contact__item"
      >
        <h4>{{ item.icon ? `${item.icon} ` : '' }}{{ item.title }}</h4>
        <component
          :is="item.link && preview ? 'a' : 'p'"
          :href="item.link && preview ? item.link : undefined"
        >
          {{ item.text }}
        </component>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  element: { type: Object, required: true },
  preview: { type: Boolean, default: false },
})

defineEmits(['click'])

const items = computed(() => props.element.items || [])
</script>

<style scoped>
.idcbis-contact {
  background: #0b4f6c;
  padding: 4rem 2rem;
  color: white;
  cursor: pointer;
  font-family: var(--font-idcbis);
}

.idcbis-contact__grid {
  max-width: 1400px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.25rem;
  text-align: center;
}

.idcbis-contact__item {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  padding: 2rem;
  border-radius: 40px 10px 40px 10px;
}

.idcbis-contact__item h4 {
  font-size: 1.8rem;
  margin-bottom: 1rem;
  color: #ffd166;
}

.idcbis-contact__item p,
.idcbis-contact__item a {
  color: white;
  text-decoration: none;
  font-size: 1.1rem;
  margin: 0;
}

@media (max-width: 900px) {
  .idcbis-contact__grid {
    grid-template-columns: 1fr;
  }
}
</style>
