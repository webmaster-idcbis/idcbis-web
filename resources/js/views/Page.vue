<template>
  <MainLayout>
    <div v-if="loading" class="flex justify-center items-center min-h-[400px]">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#005674]"></div>
    </div>

    <div v-else-if="displayPage" class="bg-white">
      <component
        v-for="(section, index) in (displayPage.sections || [])"
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
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ displayPage.title }}</h1>
        <p class="text-gray-600">{{ t('common.underConstruction') }}</p>
      </div>
    </div>

    <div v-else class="max-w-7xl mx-auto px-4 py-12 text-center">
      <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ t('common.pageNotFound') }}</h1>
      <p class="text-gray-600">{{ t('common.pageNotFoundHint') }}</p>
      <router-link to="/" class="mt-4 inline-block text-[#005674] hover:underline">
        {{ t('common.backHome') }}
      </router-link>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch, markRaw, nextTick } from 'vue';
import { useRoute } from 'vue-router';
import { useCmsStore } from '../stores/cms';
import { scrollToTop } from '../utils/scrollToTop';
import { useI18n } from '../i18n';
import { localizePage } from '../utils/localizeContent';
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
const { t, locale } = useI18n();
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

// Instantáneo: usa translations guardadas / overlays, sin llamar APIs al navegar.
const displayPage = computed(() => {
  if (!page.value) {
    return null;
  }
  return localizePage(page.value, locale.value);
});

const pageContent = computed(() => {
  const content = displayPage.value?.content;
  return Array.isArray(content) ? content : [];
});

const hasSections = computed(() => {
  const sections = displayPage.value?.sections;
  return Array.isArray(sections) && sections.length > 0;
});

const hasElementContent = computed(() => pageContent.value.length > 0);

const pageTheme = computed(() => {
  const slug = displayPage.value?.slug || '';
  if (slug === 'banco-de-sangre') return 'bds';
  return displayPage.value?.theme || null;
});

const loadPage = async () => {
  loading.value = true;
  page.value = null;
  scrollToTop();

  const slug = route.params.slug || 'inicio';
  try {
    page.value = await cmsStore.fetchPageBySlug(slug);
  } catch (error) {
    page.value = null;
  } finally {
    loading.value = false;
    await nextTick();
    scrollToTop();
  }
};

onMounted(loadPage);
watch(() => route.fullPath, loadPage);
</script>
