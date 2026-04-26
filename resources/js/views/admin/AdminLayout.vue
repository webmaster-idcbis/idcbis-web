<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Admin Sidebar -->
    <aside 
      :class="[
        'fixed top-0 left-0 z-40 h-screen transition-transform bg-[#003C5F]',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
        'w-64'
      ]"
    >
      <div class="h-full px-3 py-4 overflow-y-auto">
        <div class="flex items-center justify-between mb-6 px-2">
          <span class="text-xl font-bold text-white">IDCBIS Admin</span>
          <button @click="sidebarOpen = false" class="md:hidden text-white">
            <X class="w-6 h-6" />
          </button>
        </div>
        
        <ul class="space-y-2">
          <li>
            <router-link 
              to="/admin"
              class="flex items-center p-2 text-white rounded-lg hover:bg-white/10"
              :class="{ 'bg-white/20': $route.path === '/admin' }"
            >
              <LayoutDashboard class="w-5 h-5 mr-3" />
              <span>Dashboard</span>
            </router-link>
          </li>
          <li>
            <router-link 
              to="/admin/pages"
              class="flex items-center p-2 text-white rounded-lg hover:bg-white/10"
              :class="{ 'bg-white/20': $route.path.startsWith('/admin/pages') }"
            >
              <FileText class="w-5 h-5 mr-3" />
              <span>Páginas</span>
            </router-link>
          </li>
          <li v-if="authStore.hasPermission('users.view')">
            <router-link 
              to="/admin/users"
              class="flex items-center p-2 text-white rounded-lg hover:bg-white/10"
              :class="{ 'bg-white/20': $route.path.startsWith('/admin/users') }"
            >
              <Users class="w-5 h-5 mr-3" />
              <span>Usuarios</span>
            </router-link>
          </li>
          <li v-if="authStore.hasPermission('roles.view')">
            <router-link 
              to="/admin/roles"
              class="flex items-center p-2 text-white rounded-lg hover:bg-white/10"
              :class="{ 'bg-white/20': $route.path.startsWith('/admin/roles') }"
            >
              <Shield class="w-5 h-5 mr-3" />
              <span>Roles</span>
            </router-link>
          </li>
          <li v-if="authStore.hasPermission('permissions.view')">
            <router-link 
              to="/admin/permissions"
              class="flex items-center p-2 text-white rounded-lg hover:bg-white/10"
              :class="{ 'bg-white/20': $route.path.startsWith('/admin/permissions') }"
            >
              <Key class="w-5 h-5 mr-3" />
              <span>Permisos</span>
            </router-link>
          </li>
        </ul>
        
        <div class="absolute bottom-4 left-3 right-3">
          <button 
            @click="logout"
            class="flex items-center w-full p-2 text-white rounded-lg hover:bg-white/10"
          >
            <LogOut class="w-5 h-5 mr-3" />
            <span>Cerrar sesión</span>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="md:ml-64 min-h-screen">
      <!-- Top Navigation -->
      <nav class="bg-white border-b border-gray-200 px-4 py-3">
        <div class="flex items-center justify-between">
          <button 
            @click="sidebarOpen = true"
            class="md:hidden p-2 rounded-lg hover:bg-gray-100"
          >
            <Menu class="w-6 h-6" />
          </button>
          
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
  X 
} from 'lucide-vue-next';

const router = useRouter();
const authStore = useAuthStore();
const sidebarOpen = ref(false);

const logout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>
