<template>
  <header class="bg-gradient-to-r from-[#005674] to-[#008996] text-white">
    <!-- Top bar -->
    <div class="border-b border-white/20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <div class="flex items-center">
            <router-link to="/" class="flex items-center gap-3">
              <div class="flex flex-col">
                <span class="text-2xl font-bold tracking-tight">IDCBIS</span>
                <span class="text-[10px] uppercase tracking-wider text-white/80">
                  Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud
                </span>
              </div>
            </router-link>
          </div>

          <!-- Desktop Navigation -->
          <nav class="hidden md:flex items-center space-x-8">
            <router-link 
              v-for="item in menuItems" 
              :key="item.name"
              :to="item.href"
              class="text-sm font-medium hover:text-white/80 transition-colors"
              :class="{ 'text-white/90': $route.path === item.href }"
            >
              {{ item.name }}
            </router-link>
          </nav>

          <!-- Admin link (if authenticated) -->
          <div class="flex items-center gap-4">
            <router-link 
              v-if="authStore.isAuthenticated"
              to="/admin"
              class="text-sm font-medium hover:text-white/80"
            >
              Admin
            </router-link>
            <button
              v-if="authStore.isAuthenticated"
              @click="logout"
              class="text-sm font-medium hover:text-white/80"
            >
              Salir
            </button>
            
            <!-- Mobile menu button -->
            <button 
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="md:hidden p-2 rounded-md hover:bg-white/10"
            >
              <Menu v-if="!mobileMenuOpen" class="h-6 w-6" />
              <X v-else class="h-6 w-6" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Navigation -->
    <div v-show="mobileMenuOpen" class="md:hidden bg-[#005674]">
      <div class="px-4 py-2 space-y-1">
        <router-link
          v-for="item in menuItems"
          :key="item.name"
          :to="item.href"
          class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10"
          :class="{ 'bg-white/10': $route.path === item.href }"
          @click="mobileMenuOpen = false"
        >
          {{ item.name }}
        </router-link>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '../../stores/auth';
import { Menu, X } from 'lucide-vue-next';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const mobileMenuOpen = ref(false);

const menuItems = [
  { name: 'Inicio', href: '/' },
  { name: 'Servicios', href: '/servicios' },
  { name: 'Investigación', href: '/investigacion' },
  { name: 'El Instituto', href: '/el-instituto' },
  { name: 'Contacto', href: '/contacto' },
];

const logout = async () => {
  await authStore.logout();
  router.push('/');
};
</script>
