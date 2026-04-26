<template>
  <MainLayout>
    <div v-if="loading" class="flex justify-center items-center min-h-[400px]">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#005674]"></div>
    </div>
    
    <div v-else-if="page" class="bg-white">
      <!-- Render sections dynamically -->
      <component
        v-for="(section, index) in page.sections"
        :key="index"
        :is="getSectionComponent(section.type)"
        :section="section"
      />
      
      <!-- Fallback content if no sections -->
      <div v-if="!page.sections || page.sections.length === 0" class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ page.title }}</h1>
        <div v-if="page.content" class="prose max-w-none" v-html="page.content"></div>
        <p v-else class="text-gray-600">Esta página está en construcción.</p>
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
import { ref, onMounted, watch, markRaw } from 'vue';
import { useRoute } from 'vue-router';
import { useCmsStore } from '../stores/cms';
import MainLayout from '../components/layout/MainLayout.vue';

// Import section components
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
};

const getSectionComponent = (type) => {
  return sectionComponents[type] || 'div';
};

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
