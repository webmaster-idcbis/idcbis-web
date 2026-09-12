import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from '../i18n'
import { useCmsStore } from '../stores/cms'
import { usePostsStore } from '../stores/posts'
import { localizePage } from '../utils/localizeContent'
import { getPageTranslationOverlay } from '../i18n/pageOverlays'
import {
  findSitemapItemBySlug,
  findSitemapPath,
  isSitemapPublished,
  sitemapItemUrl,
} from '../config/siteSitemap'

const SLUG_I18N_KEYS = {
  noticias: 'header.institutionalLinks.news',
  'atencion-a-usuarios': 'header.institutionalLinks.userCare',
  participa: 'header.institutionalLinks.participa',
  transparencia: 'header.institutionalLinks.transparency',
  'quienes-somos': 'header.fallbackMenu.about',
  servicios: 'header.fallbackMenu.services',
  investigacion: 'header.fallbackMenu.research',
  contacto: 'header.fallbackMenu.contact',
  'mapa-del-sitio': 'footer.sitemap',
  'estados-financieros': 'footer.publicLinks.financial',
  'ejecucion-presupuestal': 'footer.publicLinks.budget',
  'plan-anticorrupcion': 'footer.publicLinks.anticorrupcion',
  'programa-transparencia-etica-publica': 'footer.publicLinks.ptep',
  'contratacion-bienes-servicios': 'footer.publicLinks.contracting',
  'rendicion-de-cuentas': 'footer.publicLinks.accountability',
  'publicaciones-cientificas': 'footer.learnLinks.publications',
  'trabaje-con-nosotros': 'footer.learnLinks.jobs',
  'apoyo-financiero': 'footer.learnLinks.funding',
  'informacion-a-proveedores': 'footer.learnLinks.suppliers',
}

function cleanCmsTitle(title) {
  return String(title || '')
    .replace(/\s*\|\s*IDCBIS\s*$/i, '')
    .trim()
}

function humanizeSlug(slug) {
  return String(slug || '')
    .split('-')
    .filter(Boolean)
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ')
}

export function useBreadcrumbs() {
  const route = useRoute()
  const { t, locale } = useI18n()
  const cmsStore = useCmsStore()
  const postsStore = usePostsStore()

  const visible = computed(() => {
    if (route.meta.homePage || route.name === 'Home' || route.path === '/') {
      return false
    }
    return true
  })

  const labelForSlug = (slug, fallbackTitle = '') => {
    const i18nKey = SLUG_I18N_KEYS[slug]
    if (i18nKey) {
      const translated = t(i18nKey)
      if (translated && translated !== i18nKey) {
        return translated
      }
    }

    const overlay = getPageTranslationOverlay(slug, locale.value)
    if (overlay?.title) {
      return cleanCmsTitle(overlay.title)
    }

    const sitemapItem = findSitemapItemBySlug(slug)
    if (sitemapItem?.title) {
      return sitemapItem.title
    }

    if (cmsStore.currentPage?.slug === slug) {
      const localized = localizePage(cmsStore.currentPage, locale.value)
      const cleaned = cleanCmsTitle(localized?.title)
      if (cleaned) {
        return cleaned
      }
    }

    if (fallbackTitle) {
      return cleanCmsTitle(fallbackTitle)
    }

    return humanizeSlug(slug)
  }

  const items = computed(() => {
    if (!visible.value) {
      return []
    }

    const home = {
      label: t('header.fallbackMenu.home'),
      to: '/',
      current: false,
    }

    if (route.name === 'Search') {
      return [
        home,
        { label: t('breadcrumbs.search'), to: '/buscar', current: true },
      ]
    }

    if (route.name === 'NewsArticle') {
      const post = postsStore.currentPost
      const postMatches = Boolean(post && post.slug === route.params.slug)
      const crumbs = [
        home,
        {
          label: labelForSlug('noticias'),
          to: '/noticias',
          current: !postMatches,
        },
      ]

      if (postMatches && post.title) {
        crumbs.push({
          label: post.title,
          to: `/noticias/${post.slug}`,
          current: true,
        })
      }

      return crumbs
    }

    const slug = typeof route.params.slug === 'string' ? route.params.slug : ''
    if (!slug) {
      return [home]
    }

    const path = findSitemapPath(slug)
    const crumbs = [home]

    path.slice(0, -1).forEach((item) => {
      if (!isSitemapPublished(item.slug)) {
        return
      }
      crumbs.push({
        label: labelForSlug(item.slug, item.title),
        to: sitemapItemUrl(item.slug),
        current: false,
      })
    })

    const currentFromPath = path[path.length - 1]
    crumbs.push({
      label: labelForSlug(slug, currentFromPath?.title),
      to: sitemapItemUrl(slug),
      current: true,
    })

    return crumbs
  })

  return { visible, items }
}
