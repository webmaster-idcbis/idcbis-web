<template>
  <footer class="bg-[#003C5F] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">
        <div>
          <router-link to="/" class="inline-block rounded-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#D9B85A]">
            <img
              :src="siteLogos.footer.src"
              :alt="siteLogos.footer.alt"
              :class="siteLogos.footer.class"
            >
          </router-link>
          <p class="mt-4 text-sm leading-relaxed text-white/90 max-w-xs">
            {{ t('footer.tagline') }}
          </p>
          <p class="mt-3 text-sm font-semibold text-[#C4A140]">
            {{ t('footer.minciencias') }}
          </p>
        </div>

        <nav :aria-label="t('footer.quickLinks')">
          <h2 class="text-[#C4A140] font-semibold text-sm uppercase tracking-wider mb-4">
            {{ t('footer.quickLinks') }}
          </h2>
          <ul class="space-y-2">
            <li v-for="item in quickLinks" :key="item.href">
              <router-link
                :to="item.href"
                class="text-sm text-white hover:text-[#D9B85A] rounded-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#D9B85A]"
              >
                {{ item.name }}
              </router-link>
            </li>
          </ul>
        </nav>

        <div>
          <h2 class="text-[#C4A140] font-semibold text-sm uppercase tracking-wider mb-4">
            {{ t('footer.contactUs') }}
          </h2>
          <ul class="space-y-3 text-sm text-white">
            <li>
              <span class="block text-white/85">{{ t('footer.addressLabel') }}</span>
              {{ t('footer.addressValue') }}
            </li>
            <li>
              <span class="block text-white/85">{{ t('footer.phoneLabel') }}</span>
              <a
                href="tel:+5713649620"
                class="hover:text-[#D9B85A] rounded-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#D9B85A]"
              >
                {{ t('footer.phoneValue') }}
              </a>
            </li>
            <li>
              <span class="block text-white/85">{{ t('footer.emailLabel') }}</span>
              <a
                href="mailto:contacto@idcbis.org.co"
                class="hover:text-[#D9B85A] break-all rounded-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#D9B85A]"
              >
                contacto@idcbis.org.co
              </a>
            </li>
            <li>
              <span class="block text-white/85">{{ t('footer.hoursLabel') }}</span>
              {{ t('footer.hoursValue') }}
            </li>
          </ul>
        </div>

        <div>
          <h2 class="text-[#C4A140] font-semibold text-sm uppercase tracking-wider mb-4">
            {{ t('footer.socialTitle') }}
          </h2>
          <ul class="flex flex-wrap gap-2">
            <li v-for="social in socialLinks" :key="social.href">
              <a
                :href="social.href"
                :aria-label="social.name"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center min-h-11 min-w-11 rounded-md text-white hover:text-[#D9B85A] hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#D9B85A]"
              >
                <component :is="social.icon" class="h-5 w-5" aria-hidden="true" />
              </a>
            </li>
          </ul>
          <ul class="mt-6 flex flex-col items-start gap-4">
            <li>
              <img
                :src="institutional.ministerioSalud.src"
                alt="Ministerio de Salud y Protección Social"
                class="w-full max-w-[200px] h-auto object-contain"
              >
            </li>
            <li>
              <img
                :src="institutional.idcbisInstitute.src"
                alt="Instituto Nacional de Salud"
                class="w-[110px] h-[90px] object-contain"
              >
            </li>
          </ul>
        </div>
      </div>

      <!--
        Logos pedidos (Alcaldía, Secretaría de Salud, CAT, Bogotá) no están en el proyecto.
        Cuando existan los archivos, agregarlos a partnerLogos para mostrarlos en escala de grises.
      -->
      <ul v-if="partnerLogos.length" class="mt-10 pt-8 border-t border-white/10 flex flex-wrap items-center gap-4">
        <li v-for="logo in partnerLogos" :key="logo.src">
          <img :src="logo.src" :alt="logo.alt" class="footer-partner">
        </li>
      </ul>
    </div>

    <div class="border-t border-white/10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-white/80">{{ t('footer.copyright') }}</p>
        <nav :aria-label="t('footer.legalNav')" class="flex flex-wrap gap-x-5 gap-y-2">
          <router-link
            v-for="item in legalLinks"
            :key="item.href"
            :to="item.href"
            class="text-sm text-[#C4A140] hover:text-[#D9B85A] rounded-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#D9B85A]"
          >
            {{ item.name }}
          </router-link>
        </nav>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue'
import { Facebook, Instagram, Linkedin } from 'lucide-vue-next'
import XLogoIcon from '../icons/XLogoIcon.vue'
import { INSTITUTIONAL_LOGOS, SITE_LOGOS } from '../../config/siteLogos'
import { useI18n } from '../../i18n'

const { t } = useI18n()
const siteLogos = SITE_LOGOS
const institutional = INSTITUTIONAL_LOGOS

const quickLinks = computed(() => [
  { name: t('footer.links.donate'), href: '/banco-de-sangre' },
  { name: t('footer.links.darcelulas'), href: '/darcelulas' },
  { name: t('footer.links.services'), href: '/#servicios' },
  { name: t('footer.links.research'), href: '/investigacion' },
  { name: t('footer.links.news'), href: '/noticias' },
  { name: t('footer.links.contact'), href: '/contacto' },
])

const socialLinks = computed(() => [
  { name: t('header.social.instagram'), href: 'https://www.instagram.com/idcbis/', icon: Instagram },
  { name: t('header.social.facebook'), href: 'https://www.facebook.com/IDCBIS/', icon: Facebook },
  { name: t('header.social.x'), href: 'https://x.com/IDCBIS', icon: XLogoIcon },
  { name: t('header.social.linkedin'), href: 'https://www.linkedin.com/company/instituto-distrtial-de-ciencia-biotecnolog%C3%ADa-e-innovaci%C3%B3n-en-salud-idcbis/', icon: Linkedin },
])

const legalLinks = computed(() => [
  { name: t('footer.privacy'), href: '/privacidad' },
  { name: t('footer.terms'), href: '/terminos-y-condiciones' },
  { name: t('footer.sitemap'), href: '/mapa-del-sitio' },
])

const partnerLogos = []
</script>

<style scoped>
.footer-partner {
  height: 3rem;
  width: auto;
  max-width: 8.5rem;
  object-fit: contain;
  background: #ffffff;
  border-radius: 0.375rem;
  padding: 0.35rem 0.5rem;
  filter: grayscale(1);
  transition: filter 0.2s ease;
}

.footer-partner:hover {
  filter: none;
}

@media (prefers-reduced-motion: reduce) {
  .footer-partner {
    transition: none;
  }
}
</style>
