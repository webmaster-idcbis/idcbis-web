<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Admin Sidebar -->
    <aside 
      :class="[
        'fixed top-0 left-0 z-40 h-screen transition-all duration-300 ease-in-out bg-[#003C5F]',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
        sidebarCollapsed ? 'md:w-20' : 'md:w-64',
        'w-64'
      ]"
    >
      <div class="h-full px-3 py-3 flex flex-col">
        <!-- Logo Section -->
        <div class="flex items-center justify-between mb-6 px-2">
          <!-- Logo expandido -->
          <div v-if="!sidebarCollapsed" class="flex items-center gap-2">
            <img 
              :src="'/images/logo/logo-IDCBIS.jpg'" 
              alt="IDCBIS Logo" 
              class="h-10 w-auto"
              onerror="this.style.display='none'"
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
              class="flex items-center p-2 text-white rounded-lg hover:bg-white/10 group relative"
              :class="{ 
                'bg-white/20': $route.path === '/admin',
                'justify-center': sidebarCollapsed
              }"
            >
              <LayoutDashboard class="w-5 h-5" :class="sidebarCollapsed ? '' : 'mr-3'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300">Dashboard</span>
              <!-- Tooltip para modo colapsado -->
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Dashboard
              </span>
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/pages"
              class="flex items-center p-2 text-white rounded-lg hover:bg-white/10 group relative"
              :class="{ 
                'bg-white/20': $route.path.startsWith('/admin/pages'),
                'justify-center': sidebarCollapsed
              }"
            >
              <FileText class="w-5 h-5" :class="sidebarCollapsed ? '' : 'mr-3'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300">Páginas</span>
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Páginas
              </span>
            </router-link>
          </li>
          <li v-if="authStore.hasPermission('users.view')">
            <router-link 
              to="/admin/users"
              class="flex items-center p-2 text-white rounded-lg hover:bg-white/10 group relative"
              :class="{ 
                'bg-white/20': $route.path.startsWith('/admin/users'),
                'justify-center': sidebarCollapsed
              }"
            >
              <Users class="w-5 h-5" :class="sidebarCollapsed ? '' : 'mr-3'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300">Usuarios</span>
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Usuarios
              </span>
            </router-link>
          </li>
          <li v-if="authStore.hasPermission('roles.view')">
            <router-link 
              to="/admin/roles"
              class="flex items-center p-2 text-white rounded-lg hover:bg-white/10 group relative"
              :class="{ 
                'bg-white/20': $route.path.startsWith('/admin/roles'),
                'justify-center': sidebarCollapsed
              }"
            >
              <Shield class="w-5 h-5" :class="sidebarCollapsed ? '' : 'mr-3'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300">Roles</span>
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Roles
              </span>
            </router-link>
          </li>
          <li v-if="authStore.hasPermission('permissions.view')">
            <router-link 
              to="/admin/permissions"
              class="flex items-center p-2 text-white rounded-lg hover:bg-white/10 group relative"
              :class="{ 
                'bg-white/20': $route.path.startsWith('/admin/permissions'),
                'justify-center': sidebarCollapsed
              }"
            >
              <Key class="w-5 h-5" :class="sidebarCollapsed ? '' : 'mr-3'" />
              <span v-if="!sidebarCollapsed" class="transition-opacity duration-300">Permisos</span>
              <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
                Permisos
              </span>
            </router-link>
          </li>
        </ul>
        
        <div class="absolute bottom-4 left-3 right-3">
          <button 
            @click="logout"
            class="flex items-center w-full p-2 text-white rounded-lg hover:bg-white/10 group relative"
            :class="{ 'justify-center': sidebarCollapsed }"
          >
            <LogOut class="w-5 h-5" :class="sidebarCollapsed ? '' : 'mr-3'" />
            <span v-if="!sidebarCollapsed" class="transition-opacity duration-300">Cerrar sesión</span>
            <span v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">
              Cerrar sesión
            </span>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div 
      class="min-h-screen transition-all duration-300 ease-in-out"
      :class="sidebarCollapsed ? 'md:ml-20' : 'md:ml-64'"
    >
      <!-- Top Navigation -->
      <nav class="bg-white border-b border-gray-200 px-4 py-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <!-- Botón para móvil -->
            <button 
              @click="sidebarOpen = true"
              class="md:hidden p-2 rounded-lg hover:bg-gray-100"
            >
              <Menu class="w-6 h-6" />
            </button>
            <!-- Logo pequeño cuando sidebar está colapsado -->
            <div v-if="sidebarCollapsed" class="hidden md:flex items-center">
              <img 
                :src="'/images/logo/logo-IDCBIS.jpg'" 
                alt="IDCBIS" 
                class="h-8 w-auto cursor-pointer"
                @click="sidebarCollapsed = false"
                title="Haz clic para expandir el menú"
                onerror="this.style.display='none'"
              >
            </div>
            <!-- Botón colapsar (solo visible cuando sidebar está expandido) -->
            <button 
              v-if="!sidebarCollapsed"
              @click="sidebarCollapsed = true"
              class="hidden md:flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 text-gray-600 transition-colors"
              title="Colapsar menú"
            >
              <PanelLeftClose class="w-5 h-5" />
              <span class="text-sm font-medium">Colapsar</span>
            </button>
          </div>
          
          <div class="flex items-center gap-4">
            <span class="text-sm text-gray-600">
              {{ authStore.user?.name }}
            </span>
            <div class="w-8 h-8 bg-[#005674] rounded-full flex items-center justify-center text-white text-sm font-medium">
              {{ authStore.user?.name?.charAt(0) }}
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Content -->
      <main class="p-4">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';
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
  PanelRightClose
} from 'lucide-vue-next';

const router = useRouter();
const authStore = useAuthStore();
const sidebarOpen = ref(false);
const sidebarCollapsed = ref(false);

const logout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>
