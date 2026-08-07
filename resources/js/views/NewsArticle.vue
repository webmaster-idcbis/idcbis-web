<template>
  <MainLayout>
    <div v-if="loading" class="flex justify-center items-center min-h-[400px]">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#005674]" />
    </div>

    <article v-else-if="post" class="news-article">
      <header class="news-article__hero" :style="heroStyle">
        <div class="news-article__hero-inner">
          <router-link to="/noticias" class="news-article__back">
            <ArrowLeft class="w-4 h-4" aria-hidden="true" />
            {{ t('news.backToNews') }}
          </router-link>
          <span class="news-article__category">{{ post.categoryLabel }}</span>
          <h1>{{ post.title }}</h1>
          <div class="news-article__meta">
            <time v-if="post.publishedAt" :datetime="post.publishedAtIso">{{ post.publishedAt }}</time>
          </div>
        </div>
      </header>

      <div class="news-article__body">
        <div class="news-article__container">
          <p v-if="post.excerpt" class="news-article__excerpt">{{ post.excerpt }}</p>
          <div class="news-article__content" v-html="post.content" />
        </div>
      </div>

      <NewsRelatedCarousel
        :items="related"
        :title="t('news.related')"
      />
    </article>

    <div v-else class="max-w-3xl mx-auto px-4 py-16 text-center">
      <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ t('news.notFound') }}</h1>
      <p class="text-gray-600 mb-6">{{ t('news.notFoundHint') }}</p>
      <router-link to="/noticias" class="text-[#005674] hover:underline">{{ t('news.viewAll') }}</router-link>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { ArrowLeft } from 'lucide-vue-next'
import MainLayout from '../components/layout/MainLayout.vue'
import NewsRelatedCarousel from '../components/news/NewsRelatedCarousel.vue'
import { usePostsStore } from '../stores/posts'
import { scrollToTop } from '../utils/scrollToTop'
import { useI18n } from '../i18n'

const route = useRoute()
const postsStore = usePostsStore()
const { t } = useI18n()

const post = ref(null)
const related = ref([])
const loading = ref(true)

const heroStyle = computed(() => {
  if (!post.value?.image) {
    return { background: 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)' }
  }
  return {
    backgroundImage: `linear-gradient(rgba(11, 79, 108, 0.88), rgba(44, 140, 153, 0.82)), url(${post.value.image})`,
    backgroundSize: 'cover',
    backgroundPosition: 'center',
  }
})

const loadArticle = async () => {
  loading.value = true
  post.value = null
  related.value = []
  scrollToTop()

  try {
    const response = await postsStore.fetchPostBySlug(route.params.slug)
    post.value = response.data
    related.value = response.related || []
    document.title = `${post.value.metaTitle || post.value.title} | IDCBIS`
  } catch {
    post.value = null
  } finally {
    loading.value = false
  }
}

onMounted(loadArticle)
watch(() => route.params.slug, loadArticle)
</script>

<style scoped>
.news-article {
  font-family: var(--font-idcbis);
  color: #1e293b;
}

.news-article__hero {
  padding: 2.5rem 1.5rem 3rem;
  color: #fff;
}

.news-article__hero-inner {
  max-width: 800px;
  margin: 0 auto;
}

.news-article__back {
  display: flex;
  width: fit-content;
  align-items: center;
  gap: 0.35rem;
  color: rgba(255, 255, 255, 0.9);
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
}

.news-article__back:hover {
  color: #fff;
}

.news-article__category {
  display: inline-block;
  padding: 0.3rem 0.75rem;
  border-radius: 9999px;
  background: rgba(255, 255, 255, 0.15);
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.03em;
  margin-bottom: 0.75rem;
}

.news-article__hero h1 {
  font-size: clamp(1.75rem, 4vw, 2.75rem);
  font-weight: 800;
  line-height: 1.15;
  margin: 0 0 0.75rem;
}

.news-article__meta {
  font-size: 0.9375rem;
  opacity: 0.9;
}

.news-article__body {
  background: #fff;
  padding: 2.5rem 1.5rem 3rem;
}

.news-article__container {
  max-width: 760px;
  margin: 0 auto;
}

.news-article__excerpt {
  font-size: 1.125rem;
  line-height: 1.65;
  color: #475569;
  margin: 0 0 1.5rem;
  font-weight: 600;
}

.news-article__content :deep(p) {
  margin: 0 0 1rem;
  line-height: 1.75;
  font-size: 1.0625rem;
}

.news-article__content :deep(ul),
.news-article__content :deep(ol) {
  margin: 0 0 1rem 1.25rem;
  line-height: 1.75;
}

.news-article__content :deep(a) {
  color: #0b4f6c;
  text-decoration: underline;
}

.news-article__content :deep(.news-content-figure) {
  margin: 1.75rem 0;
}

.news-article__content :deep(.news-content-figure img) {
  width: 100%;
  height: auto;
  border-radius: 0.875rem;
  display: block;
  box-shadow: 0 8px 24px rgba(11, 79, 108, 0.1);
}

.news-article__content :deep(.news-content-cta) {
  margin: 2rem 0;
  text-align: center;
}

.news-article__content :deep(.news-content-cta__btn) {
  display: inline-block;
  min-height: 44px;
  padding: 0.8rem 1.75rem;
  border-radius: 9999px;
  background: linear-gradient(135deg, #0b4f6c, #2c8c99);
  color: #fff !important;
  font-weight: 700;
  font-size: 0.9375rem;
  text-decoration: none !important;
  transition: transform 0.2s, box-shadow 0.2s;
}

.news-article__content :deep(.news-content-cta__btn:hover) {
  transform: translateY(-1px);
  box-shadow: 0 8px 20px rgba(11, 79, 108, 0.25);
}
</style>
