<template>
  <header class="bg-gradient-to-r from-[#005674] to-[#008996] text-white">
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

          <!-- Desktop Navigation + Search -->
          <div class="hidden md:flex items-center gap-6 flex-1 justify-end min-w-0">
            <nav class="flex items-center space-x-6 shrink-0">
              <router-link
                v-for="item in menuItems"
                :key="item.href"
                :to="item.href"
                class="text-sm font-medium hover:text-white/80 transition-colors whitespace-nowrap"
                :class="{ 'text-white/90': isActive(item.href) }"
              >
                {{ item.name }}
              </router-link>
            </nav>

            <SiteSearch class="shrink-0" />
          </div>

          <!-- Admin + mobile toggle -->
          <div class="flex items-center gap-3 shrink-0">
            <router-link
              v-if="authStore.isAuthenticated"
              to="/admin"
              class="hidden sm:inline text-sm font-medium hover:text-white/80"
            >
              Admin
            </router-link>
            <button
              v-if="authStore.isAuthenticated"
              class="hidden sm:inline text-sm font-medium hover:text-white/80"
              @click="logout"
            >
              Salir
            </button>

            <button
              class="md:hidden p-2 rounded-md hover:bg-white/10"
              :aria-expanded="mobileMenuOpen"
              aria-label="Abrir menú"
              @click="mobileMenuOpen = !mobileMenuOpen"
            >
              <Menu v-if="!mobileMenuOpen" class="h-6 w-6" />
              <X v-else class="h-6 w-6" />
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
        <router-link
          v-for="item in menuItems"
          :key="item.href"
          :to="item.href"
          class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10"
          :class="{ 'bg-white/10': isActive(item.href) }"
          @click="mobileMenuOpen = false"
        >
          {{ item.name }}
        </router-link>
        <router-link
          v-if="authStore.isAuthenticated"
          to="/admin"
          class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10"
          @click="mobileMenuOpen = false"
        >
          Admin
        </router-link>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';
import { useMenusStore } from '../../stores/menus';
import { Menu, X } from 'lucide-vue-next';
import { SITE_LOGOS } from '../../config/siteLogos';
import SiteSearch from './SiteSearch.vue';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const menusStore = useMenusStore();
const mobileMenuOpen = ref(false);
const logos = SITE_LOGOS;

const fallbackMenuItems = [
  { name: 'Inicio', href: '/' },
  { name: 'Servicios', href: '/servicios' },
  { name: 'Investigación', href: '/investigacion' },
  { name: 'El Instituto', href: '/el-instituto' },
  { name: 'Contacto', href: '/contacto' },
];

const dynamicMenuItems = ref([]);

const menuItems = computed(() => {
  if (dynamicMenuItems.value.length) {
    return dynamicMenuItems.value;
  }
  return fallbackMenuItems;
});

const isActive = (href) => {
  if (href === '/') {
    return route.path === '/';
  }
  return route.path === href || route.path.startsWith(`${href}/`);
};

const loadMenu = async () => {
  const menu = await menusStore.getPublicMenu('header');
  if (!menu?.items?.length) return;

  dynamicMenuItems.value = menu.items.map((item) => ({
    name: item.title,
    href: item.url || '/',
  }));
};

const logout = async () => {
  await authStore.logout();
  router.push('/');
};

onMounted(() => {
  loadMenu();
});
</script>
