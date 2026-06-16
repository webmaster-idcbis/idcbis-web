<template>
  <MainLayout>
    <div v-if="loading" class="flex justify-center items-center min-h-[400px]">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#005674]"></div>
    </div>

    <div v-else-if="page" class="bg-white">
      <component
        v-for="(section, index) in (page.sections || [])"
        :key="`section-${index}`"
        :is="getSectionComponent(section.type)"
        :section="section"
      />

      <PageContentRenderer
        v-if="hasElementContent"
        :elements="pageContent"
        :theme="pageTheme"
      />

      <div
        v-if="!hasSections && !hasElementContent"
        class="max-w-7xl mx-auto px-4 py-12"
      >
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ page.title }}</h1>
        <p class="text-gray-600">Esta página está en construcción.</p>
      </div>
    </div>

    <div v-else class="max-w-7xl mx-auto px-4 py-12 text-center">
      <h1 class="text-2xl font-bold text-gray-900 mb-4">Página no encontrada</h1>
      <p class="text-gray-600">La página que buscas no existe o ha sido eliminada.</p>
      <router-link to="/" class="mt-4 inline-block text-[#005674] hover:underline">
        Volver al inicio
      </router-link>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch, markRaw } from 'vue';
import { useRoute } from 'vue-router';
import { useCmsStore } from '../stores/cms';
import MainLayout from '../components/layout/MainLayout.vue';
import PageContentRenderer from '../components/PageContentRenderer.vue';

import HeroSection from '../components/sections/HeroSection.vue';
import TextSection from '../components/sections/TextSection.vue';
import CardsSection from '../components/sections/CardsSection.vue';
import ImageSection from '../components/sections/ImageSection.vue';
import GallerySection from '../components/sections/GallerySection.vue';
import ButtonSection from '../components/sections/ButtonSection.vue';
import FeaturesSection from '../components/sections/FeaturesSection.vue';
import StatsSection from '../components/sections/StatsSection.vue';
import TeamSection from '../components/sections/TeamSection.vue';
import ContactSection from '../components/sections/ContactSection.vue';
import HTMLSection from '../components/sections/HTMLSection.vue';
import VideoSection from '../components/sections/VideoSection.vue';
import FAQSection from '../components/sections/FAQSection.vue';
import TestimonialsSection from '../components/sections/TestimonialsSection.vue';
import DividerSection from '../components/sections/DividerSection.vue';
import SpacerSection from '../components/sections/SpacerSection.vue';
import IconsRowSection from '../components/sections/IconsRowSection.vue';
import BubblesSection from '../components/sections/BubblesSection.vue';
import HeroSliderSection from '../components/sections/HeroSliderSection.vue';
import ProcessSection from '../components/sections/ProcessSection.vue';
import NewsletterSection from '../components/sections/NewsletterSection.vue';

const route = useRoute();
const cmsStore = useCmsStore();
const loading = ref(true);
const page = ref(null);

const sectionComponents = {
  hero: markRaw(HeroSection),
  text: markRaw(TextSection),
  cards: markRaw(CardsSection),
  image: markRaw(ImageSection),
  gallery: markRaw(GallerySection),
  button: markRaw(ButtonSection),
  features: markRaw(FeaturesSection),
  stats: markRaw(StatsSection),
  team: markRaw(TeamSection),
  contact: markRaw(ContactSection),
  html: markRaw(HTMLSection),
  video: markRaw(VideoSection),
  faq: markRaw(FAQSection),
  testimonials: markRaw(TestimonialsSection),
  divider: markRaw(DividerSection),
  spacer: markRaw(SpacerSection),
  iconsrow: markRaw(IconsRowSection),
  bubbles: markRaw(BubblesSection),
  heroslider: markRaw(HeroSliderSection),
  process: markRaw(ProcessSection),
  newsletter: markRaw(NewsletterSection),
};

const getSectionComponent = (type) => sectionComponents[type] || 'div';

const pageContent = computed(() => {
  const content = page.value?.content;
  return Array.isArray(content) ? content : [];
});

const hasSections = computed(() => {
  const sections = page.value?.sections;
  return Array.isArray(sections) && sections.length > 0;
});

const hasElementContent = computed(() => pageContent.value.length > 0);

const pageTheme = computed(() => {
  const slug = page.value?.slug || '';
  if (slug === 'banco-de-sangre') return 'bds';
  return page.value?.theme || null;
});

const loadPage = async () => {
  loading.value = true;
  const slug = route.params.slug || 'inicio';
  try {
    page.value = await cmsStore.fetchPageBySlug(slug);
  } catch (error) {
    page.value = null;
  } finally {
    loading.value = false;
  }
};

onMounted(loadPage);
watch(() => route.params.slug, loadPage);
</script>
