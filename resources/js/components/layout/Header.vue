<template>
  <header>
    <!-- Barra institucional GOV.CO -->
    <div class="bg-white border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between min-h-8 py-0.5 gap-2">
          <a
            href="https://www.gov.co/home/"
            target="_blank"
            rel="noopener noreferrer"
            class="flex items-center shrink-0"
            :aria-label="t('header.govCoAria')"
          >
            <img
              :src="logos.govCo.src"
              :alt="logos.govCo.alt"
              :class="logos.govCo.class"
            >
          </a>

          <div class="flex items-center gap-2 min-w-0">
            <nav
              class="hidden md:flex items-center gap-4"
              :aria-label="t('header.institutionalNav')"
            >
              <router-link
                v-for="item in institutionalLinks"
                :key="item.href"
                :to="item.href"
                class="text-xs font-medium text-[#005674] hover:text-[#C4A140] transition-colors whitespace-nowrap"
                :class="{ 'underline underline-offset-4': isActive(item.href) }"
              >
                {{ item.name }}
              </router-link>
            </nav>

            <LanguageSwitcher compact />
          </div>
        </div>
      </div>
    </div>

    <div class="bg-[#005674] text-white">
    <div class="border-b border-white/20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-[72px] gap-3">
          <!-- Logo -->
          <div class="flex items-center shrink-0">
            <router-link to="/" class="flex items-center" :title="logos.header.alt">
              <img
                :src="logos.header.src"
                :alt="logos.header.alt"
                :class="logos.header.class"
              >
            </router-link>
          </div>

          <!-- Desktop Navigation + Search + Social -->
          <div class="hidden md:flex items-center gap-6 flex-1 justify-end min-w-0">
            <nav class="flex items-center space-x-6 shrink-0" :aria-label="t('header.mainNav')">
              <template v-for="item in menuItems" :key="item.href">
                <div
                  v-if="item.children?.length"
                  class="relative"
                  @mouseenter="openServicesDropdown"
                  @mouseleave="closeServicesDropdown"
                >
                  <button
                    type="button"
                    class="inline-flex items-center gap-1 text-sm font-medium hover:text-[#C4A140] transition-colors whitespace-nowrap focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C4A140] focus-visible:ring-offset-2 focus-visible:ring-offset-[#005674] rounded-sm"
                    :class="{ 'text-white/90': isServiceChildActive }"
                    :aria-expanded="servicesDropdownOpen"
                    aria-haspopup="true"
                    @focus="openServicesDropdown"
                    @click.prevent
                  >
                    {{ item.name }}
                    <ChevronDown
                      class="h-3.5 w-3.5 transition-transform duration-200"
                      :class="{ 'rotate-180': servicesDropdownOpen }"
                      aria-hidden="true"
                    />
                  </button>

                  <div
                    v-show="servicesDropdownOpen"
                    class="absolute left-1/2 top-full z-50 pt-2 -translate-x-1/2"
                    @mouseenter="openServicesDropdown"
                    @mouseleave="closeServicesDropdown"
                  >
                    <ul
                      class="min-w-[240px] rounded-lg bg-white py-2 shadow-lg ring-1 ring-black/10"
                      role="menu"
                      :aria-label="t('header.servicesMenu.label')"
                    >
                      <li v-for="child in item.children" :key="child.href" role="none">
                        <router-link
                          :to="child.href"
                          role="menuitem"
                          class="block px-4 py-2.5 text-sm font-medium text-[#005674] hover:bg-[#005674]/10 hover:text-[#003C5F] focus-visible:bg-[#005674]/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#005674] transition-colors"
                          :class="{ 'bg-[#005674]/10 text-[#003C5F]': isActive(child.href) }"
                          @click="closeServicesDropdown(true)"
                        >
                          {{ child.name }}
                        </router-link>
                      </li>
                    </ul>
                  </div>
                </div>

                <router-link
                  v-else
                  :to="item.href"
                  class="text-sm font-medium hover:text-[#C4A140] transition-colors whitespace-nowrap focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C4A140] focus-visible:ring-offset-2 focus-visible:ring-offset-[#005674] rounded-sm"
                  :class="{ 'text-white/90': isActive(item.href) }"
                >
                  {{ item.name }}
                </router-link>
              </template>
            </nav>

            <SiteSearch class="shrink-0" />

            <nav class="flex items-center gap-0.5 shrink-0" :aria-label="t('header.socialNav')">
              <a
                v-for="social in socialLinks"
                :key="social.name"
                :href="social.href"
                :aria-label="social.name"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center p-1.5 rounded-md text-white hover:text-[#C4A140] hover:bg-white/10 transition-colors"
              >
                <component :is="social.icon" class="h-4 w-4" aria-hidden="true" />
              </a>
            </nav>
          </div>

          <!-- Mobile toggle -->
          <div class="flex items-center gap-3 shrink-0 md:hidden">
            <button
              type="button"
              class="p-2 rounded-md hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C4A140]"
              :aria-expanded="mobileMenuOpen"
              :aria-label="mobileMenuOpen ? t('header.closeMenu') : t('header.openMenu')"
              @click="mobileMenuOpen = !mobileMenuOpen"
            >
              <Menu v-if="!mobileMenuOpen" class="h-6 w-6" aria-hidden="true" />
              <X v-else class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Navigation -->
    <div v-show="mobileMenuOpen" class="md:hidden bg-[#005674] border-t border-white/10">
      <div class="px-4 py-3">
        <SiteSearch compact class="max-w-none mb-3" />
      </div>
      <div class="px-4 pb-3 space-y-1">
        <template v-for="item in menuItems" :key="item.href">
          <div v-if="item.children?.length">
            <button
              type="button"
              class="flex w-full items-center justify-between gap-2 px-3 py-2.5 rounded-md text-base font-medium hover:bg-white/10 hover:text-[#C4A140] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#C4A140] min-h-11"
              :class="{ 'bg-white/10': isServiceChildActive }"
              :aria-expanded="mobileServicesOpen"
              :aria-label="t('header.servicesMenu.open')"
              @click="mobileServicesOpen = !mobileServicesOpen"
            >
              <span>{{ item.name }}</span>
              <ChevronDown
                class="h-4 w-4 shrink-0 transition-transform duration-200"
                :class="{ 'rotate-180': mobileServicesOpen }"
                aria-hidden="true"
              />
            </button>
            <div v-show="mobileServicesOpen" class="ml-3 mt-1 space-y-0.5 border-l border-white/20 pl-2">
              <router-link
                v-for="child in item.children"
                :key="child.href"
                :to="child.href"
                class="block px-3 py-2.5 rounded-md text-sm font-medium text-white/90 hover:bg-white/10 hover:text-[#C4A140] transition-colors"
                :class="{ 'bg-white/10 text-[#C4A140]': isActive(child.href) }"
                @click="mobileMenuOpen = false"
              >
                {{ child.name }}
              </router-link>
            </div>
          </div>
          <router-link
            v-else
            :to="item.href"
            class="block px-3 py-2.5 rounded-md text-base font-medium hover:bg-white/10 hover:text-[#C4A140] transition-colors"
            :class="{ 'bg-white/10': isActive(item.href) }"
            @click="mobileMenuOpen = false"
          >
            {{ item.name }}
          </router-link>
        </template>
      </div>
      <div class="px-4 pb-3 border-t border-white/10 pt-3">
        <p class="px-3 pb-1 text-xs font-semibold uppercase tracking-wider text-white/70">
          {{ t('header.institutionalNav') }}
        </p>
        <router-link
          v-for="item in institutionalLinks"
          :key="item.href"
          :to="item.href"
          class="block px-3 py-2.5 rounded-md text-base font-medium hover:bg-white/10 hover:text-[#C4A140] transition-colors"
          :class="{ 'bg-white/10': isActive(item.href) }"
          @click="mobileMenuOpen = false"
        >
          {{ item.name }}
        </router-link>
      </div>
      <nav
        class="px-4 pb-4 flex items-center gap-1 border-t border-white/10 pt-3"
        :aria-label="t('header.socialNav')"
      >
        <a
          v-for="social in socialLinks"
          :key="social.name"
          :href="social.href"
          :aria-label="social.name"
          target="_blank"
          rel="noopener noreferrer"
          class="inline-flex items-center justify-center p-2.5 rounded-md text-white hover:text-[#C4A140] hover:bg-white/10 transition-colors"
        >
          <component :is="social.icon" class="h-4 w-4" aria-hidden="true" />
        </a>
      </nav>
    </div>
    </div>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useMenusStore } from '../../stores/menus';
import { Menu, X, Facebook, Instagram, Linkedin, ChevronDown } from 'lucide-vue-next';
import { SITE_LOGOS, INSTITUTIONAL_LOGOS } from '../../config/siteLogos';
import { HOME_SERVICES, isServicesMenuItem } from '../../config/homeServices';
import { useI18n } from '../../i18n';
import { localizeLabel } from '../../utils/localizeContent';
import SiteSearch from './SiteSearch.vue';
import LanguageSwitcher from './LanguageSwitcher.vue';
import XLogoIcon from '../icons/XLogoIcon.vue';

const route = useRoute();
const menusStore = useMenusStore();
const { t, locale } = useI18n();
const mobileMenuOpen = ref(false);
const mobileServicesOpen = ref(false);
const servicesDropdownOpen = ref(false);
let closeDropdownTimer = null;

const logos = {
  ...SITE_LOGOS,
  govCo: INSTITUTIONAL_LOGOS.govCo,
};

const institutionalLinks = computed(() => [
  { name: t('header.institutionalLinks.news'), href: '/noticias' },
  { name: t('header.institutionalLinks.userCare'), href: '/atencion-a-usuarios' },
  { name: t('header.institutionalLinks.participa'), href: '/participa' },
  { name: t('header.institutionalLinks.transparency'), href: '/transparencia' },
]);

const socialLinks = computed(() => [
  {
    name: t('header.social.facebook'),
    href: 'https://www.facebook.com/IDCBIS/',
    icon: Facebook,
  },
  {
    name: t('header.social.instagram'),
    href: 'https://www.instagram.com/idcbis/',
    icon: Instagram,
  },
  {
    name: t('header.social.x'),
    href: 'https://x.com/IDCBIS',
    icon: XLogoIcon,
  },
  {
    name: t('header.social.linkedin'),
    href: 'https://www.linkedin.com/company/instituto-distrtial-de-ciencia-biotecnolog%C3%ADa-e-innovaci%C3%B3n-en-salud-idcbis/',
    icon: Linkedin,
  },
]);

const serviceChildren = computed(() =>
  HOME_SERVICES.map((service) => ({
    name: t(service.titleKey),
    href: service.href,
  })),
);

const fallbackMenuItems = computed(() => [
  { name: t('header.fallbackMenu.home'), href: '/' },
  { name: t('header.fallbackMenu.about'), href: '/quienes-somos' },
  {
    name: t('header.fallbackMenu.services'),
    href: '/servicios',
    children: serviceChildren.value,
  },
  { name: t('header.fallbackMenu.research'), href: '/investigacion' },
  { name: t('header.fallbackMenu.contact'), href: '/contacto' },
]);

const dynamicMenuItems = ref([]);

const menuItems = computed(() => {
  const base = dynamicMenuItems.value.length
    ? dynamicMenuItems.value.map((item) => ({
        ...item,
        name: localizeLabel(item.name, locale.value),
      }))
    : fallbackMenuItems.value;

  return base.map((item) => {
    if (!isServicesMenuItem(item)) return item;
    return {
      ...item,
      children: item.children?.length ? item.children : serviceChildren.value,
    };
  });
});

const isActive = (href) => {
  if (href === '/') {
    return route.path === '/';
  }
  return route.path === href || route.path.startsWith(`${href}/`);
};

const isServiceChildActive = computed(() =>
  HOME_SERVICES.some((service) => isActive(service.href)),
);

const openServicesDropdown = () => {
  if (closeDropdownTimer) {
    clearTimeout(closeDropdownTimer);
    closeDropdownTimer = null;
  }
  servicesDropdownOpen.value = true;
};

const closeServicesDropdown = (immediate = false) => {
  if (closeDropdownTimer) {
    clearTimeout(closeDropdownTimer);
    closeDropdownTimer = null;
  }
  if (immediate === true) {
    servicesDropdownOpen.value = false;
    return;
  }
  closeDropdownTimer = setTimeout(() => {
    servicesDropdownOpen.value = false;
    closeDropdownTimer = null;
  }, 120);
};

const onDocumentKeydown = (event) => {
  if (event.key === 'Escape') {
    servicesDropdownOpen.value = false;
    mobileServicesOpen.value = false;
  }
};

const loadMenu = async () => {
  const menu = await menusStore.getPublicMenu('header');
  if (!menu?.items?.length) return;

  dynamicMenuItems.value = menu.items.map((item) => ({
    name: item.title,
    href: item.url || '/',
    children: Array.isArray(item.children)
      ? item.children.map((child) => ({
          name: child.title,
          href: child.url || '/',
        }))
      : undefined,
  }));
};

watch(
  () => route.fullPath,
  () => {
    servicesDropdownOpen.value = false;
    mobileMenuOpen.value = false;
  },
);

onMounted(() => {
  loadMenu();
  document.addEventListener('keydown', onDocumentKeydown);
});

onUnmounted(() => {
  document.removeEventListener('keydown', onDocumentKeydown);
  if (closeDropdownTimer) clearTimeout(closeDropdownTimer);
});
</script>
