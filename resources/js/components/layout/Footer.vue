<template>
  <footer class="bg-[#003C5F] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

        <div>
          <h3 class="text-[#C4A140] font-semibold text-sm uppercase tracking-wider mb-4">
            {{ t('footer.publicInfo') }}
          </h3>
          <ul class="space-y-2">
            <li v-for="item in infoPublica" :key="item.href">
              <router-link
                :to="item.href"
                class="text-sm text-white hover:text-[#C4A140] transition-colors"
              >
                {{ item.name }}
              </router-link>
            </li>
          </ul>
        </div>

        <div>
          <h3 class="text-[#C4A140] font-semibold text-sm uppercase tracking-wider mb-4">
            {{ t('footer.learnMore') }}
          </h3>
          <ul class="space-y-2">
            <li v-for="item in informate" :key="item.href">
              <router-link
                :to="item.href"
                class="text-sm text-white hover:text-[#C4A140] transition-colors"
              >
                {{ item.name }}
              </router-link>
            </li>
          </ul>
        </div>

        <!-- Logos institucionales -->
        <div class="flex flex-col gap-5 items-start">
          <router-link to="/" class="block">
            <img
              :src="siteLogos.footer.src"
              :alt="siteLogos.footer.alt"
              :class="siteLogos.footer.class"
            >
          </router-link>
          <img
            :src="institutional.idcbisInstitute.src"
            :alt="institutional.idcbisInstitute.alt"
            :class="institutional.idcbisInstitute.class"
          >
          <img
            :src="institutional.colombia.src"
            :alt="institutional.colombia.alt"
            :class="institutional.colombia.class"
          >
          <img
            :src="institutional.ministerioSalud.src"
            :alt="institutional.ministerioSalud.alt"
            :class="institutional.ministerioSalud.class"
          >
        </div>

        <div>
          <h3 class="text-[#C4A140] font-semibold text-sm uppercase tracking-wider mb-4">
            {{ t('footer.contactUs') }}
          </h3>
          <div class="space-y-3 text-sm text-white">
            <p>{{ t('footer.address') }}</p>
            <p>{{ t('footer.tower') }}</p>
            <p>{{ t('footer.phone') }}</p>
            <p>{{ t('footer.email') }}</p>
          </div>
          <router-link
            to="/contacto"
            class="inline-block mt-4 text-sm text-[#C4A140] hover:text-[#D9B85A]"
          >
            {{ t('footer.contactForm') }}
          </router-link>
        </div>
      </div>
    </div>

    <div class="border-t border-white/10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
          <p class="text-sm text-white text-center md:text-left">
            {{ t('footer.copyright') }}
          </p>
          <div class="flex items-center gap-6">
            <router-link to="/mapa-del-sitio" class="text-sm text-[#C4A140] hover:text-[#D9B85A]">
              {{ t('footer.sitemap') }}
            </router-link>
            <router-link to="/contacto" class="text-sm text-[#C4A140] hover:text-[#D9B85A]">
              {{ t('footer.contactUs') }}
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue';
import { SITE_LOGOS, INSTITUTIONAL_LOGOS } from '../../config/siteLogos';
import { useI18n } from '../../i18n';

const { t } = useI18n();
const siteLogos = SITE_LOGOS;
const institutional = INSTITUTIONAL_LOGOS;

const infoPublica = computed(() => [
  { name: t('footer.publicLinks.ptep'), href: '/programa-transparencia-etica-publica' },
  { name: t('footer.publicLinks.anticorrupcion'), href: '/plan-anticorrupcion' },
  { name: t('footer.publicLinks.financial'), href: '/estados-financieros' },
  { name: t('footer.publicLinks.budget'), href: '/ejecucion-presupuestal' },
  { name: t('footer.publicLinks.contracting'), href: '/contratacion-bienes-servicios' },
  { name: t('footer.publicLinks.accountability'), href: '/rendicion-de-cuentas' },
  { name: t('footer.publicLinks.transparency'), href: '/transparencia' },
  { name: t('footer.publicLinks.sitemap'), href: '/mapa-del-sitio' },
]);

const informate = computed(() => [
  { name: t('footer.learnLinks.jobs'), href: '/trabaje-con-nosotros' },
  { name: t('footer.learnLinks.funding'), href: '/apoyo-financiero' },
  { name: t('footer.learnLinks.news'), href: '/noticias' },
  { name: t('footer.learnLinks.publications'), href: '/publicaciones-cientificas' },
  { name: t('footer.learnLinks.userCare'), href: '/atencion-a-usuarios' },
  { name: t('footer.learnLinks.suppliers'), href: '/informacion-a-proveedores' },
  { name: t('footer.learnLinks.contact'), href: '/contacto' },
]);
</script>
