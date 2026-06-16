<template>
  <div class="min-h-screen bg-gray-100 dark:bg-[#0f1419]">
    <!-- Admin Sidebar - Premium Dark Theme -->
    <aside 
      :class="[
        'fixed top-0 left-0 z-40 h-screen transition-all duration-300 ease-in-out',
        'bg-[#003C5F] dark:bg-[#161b22]',
        'dark:border-r dark:border-[#30363d]',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
        sidebarCollapsed ? 'md:w-16' : 'md:w-52',
        'w-64'
      ]"
    >
      <div class="h-full px-2 py-2 flex flex-col">
        <!-- Logo Section -->
        <div class="flex items-center justify-between mb-4 px-2">
          <!-- Logo expandido -->
          <div v-if="!sidebarCollapsed" class="flex items-center gap-2 px-1">
            <img
              :src="siteLogos.admin.src"
              :alt="siteLogos.admin.alt"
              :class="siteLogos.admin.class"
            >
          </div>
          <!-- Botón toggle en sidebar (solo visible cuando colapsado) -->
          <button 
            v-if="sidebarCollapsed"
            @click="sidebarCollapsed = !sidebarCollapsed" 
            class="hidden md:flex items-center justify-center w-10 h-10 rounded-lg text-white hover:bg-white/10 transition-colors mx-auto"
            title="Expandir menú"
          >
            <PanelRightClose class="w-5 h-5" />
          </button>
          <!-- Botón cerrar en móvil -->
          <button @click="sidebarOpen = false" class="md:hidden text-white ml-auto">
            <X class="w-6 h-6" />
          </button>
        </div>
        
        <ul class="space-y-2">
          <li>
            <router-link 
              to="/admin"
              class="flex items-center p-1.5 text-white rounded-lg hover:bg-white/10 group relative text-sm"
              :class="{ 
                'bg-white/20': $route.path === '/admin',
                'justify-center': sidebarCollapsed
              }"
            >
              <LayoutDashboard class="w-4 h-4" :class="sidebarCollapsed ? '' : 'mr-2'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300 text-xs">Dashboard</span>
              <!-- Tooltip para modo colapsado -->
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Dashboard
              </span>
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/pages"
              class="flex items-center p-1.5 text-white rounded-lg hover:bg-white/10 group relative text-sm"
              :class="{ 
                'bg-white/20': $route.path.startsWith('/admin/pages'),
                'justify-center': sidebarCollapsed
              }"
            >
              <FileText class="w-4 h-4" :class="sidebarCollapsed ? '' : 'mr-2'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300 text-xs">Páginas</span>
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Páginas
              </span>
            </router-link>
          </li>
          <li v-if="authStore.hasPermission('users.view')">
            <router-link 
              to="/admin/users"
              class="flex items-center p-1.5 text-white rounded-lg hover:bg-white/10 group relative text-sm"
              :class="{ 
                'bg-white/20': $route.path.startsWith('/admin/users'),
                'justify-center': sidebarCollapsed
              }"
            >
              <Users class="w-4 h-4" :class="sidebarCollapsed ? '' : 'mr-2'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300 text-xs">Usuarios</span>
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Usuarios
              </span>
            </router-link>
          </li>
          <li v-if="authStore.hasPermission('roles.view')">
            <router-link 
              to="/admin/roles"
              class="flex items-center p-1.5 text-white rounded-lg hover:bg-white/10 group relative text-sm"
              :class="{ 
                'bg-white/20': $route.path.startsWith('/admin/roles'),
                'justify-center': sidebarCollapsed
              }"
            >
              <Shield class="w-4 h-4" :class="sidebarCollapsed ? '' : 'mr-2'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300 text-xs">Roles</span>
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Roles
              </span>
            </router-link>
          </li>
          <li v-if="authStore.hasPermission('permissions.view')">
            <router-link 
              to="/admin/permissions"
              class="flex items-center p-1.5 text-white rounded-lg hover:bg-white/10 group relative text-sm"
              :class="{ 
                'bg-white/20': $route.path.startsWith('/admin/permissions'),
                'justify-center': sidebarCollapsed
              }"
            >
              <Key class="w-4 h-4" :class="sidebarCollapsed ? '' : 'mr-2'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300 text-xs">Permisos</span>
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Permisos
              </span>
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/menus"
              class="flex items-center p-1.5 text-white rounded-lg hover:bg-white/10 group relative text-sm"
              :class="{ 
                'bg-white/20': $route.path.startsWith('/admin/menus'),
                'justify-center': sidebarCollapsed
              }"
            >
              <MenuIcon class="w-4 h-4" :class="sidebarCollapsed ? '' : 'mr-2'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300 text-xs">Menús</span>
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Menús
              </span>
            </router-link>
          </li>
          <li class="border-t border-white/20 pt-2 mt-2">
            <router-link 
              to="/admin/profile"
              class="flex items-center p-1.5 text-white rounded-lg hover:bg-white/10 group relative text-sm"
              :class="{ 
                'bg-white/20': $route.path === '/admin/profile',
                'justify-center': sidebarCollapsed
              }"
            >
              <UserCircle class="w-4 h-4" :class="sidebarCollapsed ? '' : 'mr-2'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300 text-xs">Mi Perfil</span>
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Mi Perfil
              </span>
            </router-link>
          </li>
        </ul>
        
        <div class="absolute bottom-3 left-2 right-2">
          <button 
            @click="logout"
            class="flex items-center w-full p-1.5 text-white rounded-lg hover:bg-white/10 transition-colors text-xs"
            :class="sidebarCollapsed ? 'justify-center' : ''"
          >
            <LogOut class="w-4 h-4" :class="sidebarCollapsed ? '' : 'mr-2'" />
            <span v-if="!sidebarCollapsed">Cerrar Sesión</span>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div 
      class="min-h-screen transition-all duration-300 ease-in-out"
      :class="sidebarCollapsed ? 'md:ml-16' : 'md:ml-52'"
    >
      <!-- Top Navigation - Premium Dark Theme -->
      <nav class="bg-white dark:bg-[#161b22] border-b border-gray-200 dark:border-[#30363d] px-3 py-2">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <!-- Botón para móvil -->
            <button 
              @click="sidebarOpen = true"
              class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#21262d]"
            >
              <Menu class="w-6 h-6 text-gray-600 dark:text-[#8b949e]" />
            </button>
            <!-- Logo pequeño cuando sidebar está colapsado -->
            <div v-if="sidebarCollapsed" class="hidden md:flex items-center">
              <img
                :src="siteLogos.adminCompact.src"
                :alt="siteLogos.adminCompact.alt"
                :class="siteLogos.adminCompact.class"
                class="cursor-pointer"
                @click="sidebarCollapsed = false"
                title="Haz clic para expandir el menú"
              >
            </div>
            <!-- Botón colapsar (solo visible cuando sidebar está expandido) -->
            <button 
              v-if="!sidebarCollapsed"
              @click="sidebarCollapsed = true"
              class="hidden md:flex items-center gap-1 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-[#21262d] text-gray-600 dark:text-[#8b949e] transition-colors text-xs"
              title="Colapsar menú"
            >
              <PanelLeftClose class="w-4 h-4" />
              <span class="font-medium">Colapsar</span>
            </button>
          </div>
          
          <div class="flex items-center gap-2">
            <!-- Toggle Tema Oscuro - Premium -->
            <button
              @click="preferencesStore.toggleTheme"
              class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-[#21262d] text-gray-600 dark:text-[#8b949e] transition-colors"
              :title="preferencesStore.isDarkMode ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'"
            >
              <Sun v-if="preferencesStore.isDarkMode" class="w-4 h-4 text-[#58a6ff]" />
              <Moon v-else class="w-4 h-4" />
            </button>
            
            <!-- Separador -->
            <div class="h-5 w-px bg-gray-300 dark:bg-[#30363d]"></div>
            
            <!-- Usuario -->
            <router-link 
              to="/admin/profile"
              class="flex items-center gap-2 hover:bg-gray-100 dark:hover:bg-[#21262d] rounded-lg px-2 py-1 transition-colors"
            >
              <span class="text-xs text-gray-600 dark:text-[#e6edf3] hidden sm:block">
                {{ authStore.user?.name }}
              </span>
              <div class="w-7 h-7 bg-[#005674] dark:bg-[#58a6ff] rounded-full flex items-center justify-center text-white text-xs font-medium">
                {{ authStore.user?.name?.charAt(0) }}
              </div>
            </router-link>
          </div>
        </div>
      </nav>

      <!-- Page Content - Premium Dark Theme -->
      <main class="p-3 dark:text-[#e6edf3]">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';
import { usePreferencesStore } from '../../stores/preferences';
import { SITE_LOGOS } from '../../config/siteLogos';
import {
  LayoutDashboard, 
  FileText, 
  Users, 
  Shield, 
  Key,
  LogOut, 
  Menu,
  X,
  PanelLeftClose,
  PanelRightClose,
  Globe,
  UserCircle,
  Sun,
  Moon,
  MenuIcon
} from 'lucide-vue-next';

const router = useRouter();
const authStore = useAuthStore();
const preferencesStore = usePreferencesStore();
const sidebarOpen = ref(false);
const sidebarCollapsed = ref(true);
const showLanguageMenu = ref(false);
const siteLogos = SITE_LOGOS;

const availableLanguages = [
  { code: 'es', name: 'Español', flag: '🇪🇸' },
  { code: 'en', name: 'English', flag: '🇺🇸' },
];

const changeLanguage = (code) => {
  preferencesStore.setLanguage(code);
  showLanguageMenu.value = false;
};

const logout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>
