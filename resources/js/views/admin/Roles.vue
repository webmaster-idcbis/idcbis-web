<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Gestión de Roles</h1>
      <button
        v-if="authStore.hasPermission('roles.create')"
        @click="openModal()"
        class="px-4 py-2 bg-[#005674] text-white rounded-lg hover:bg-[#003C5F] transition-colors flex items-center gap-2"
      >
        <Plus class="w-5 h-5" />
        Nuevo Rol
      </button>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
          <input
            v-model="search"
            type="text"
            placeholder="Buscar roles..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] focus:border-transparent"
          >
        </div>
      </div>
    </div>

    <!-- Roles Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="w-full text-sm text-left">
        <thead class="text-xs text-gray-500 uppercase bg-gray-50">
          <tr>
            <th class="px-6 py-3">Nombre</th>
            <th class="px-6 py-3">Permisos</th>
            <th class="px-6 py-3">Usuarios</th>
            <th class="px-6 py-3">Creado</th>
            <th class="px-6 py-3 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="role in filteredRoles" :key="role.id" class="border-b hover:bg-gray-50">
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#005674]/10 flex items-center justify-center">
                  <Shield class="w-5 h-5 text-[#005674]" />
                </div>
                <div>
                  <p class="font-medium text-gray-900 capitalize">{{ role.name }}</p>
                  <p class="text-xs text-gray-500">{{ role.guard_name }}</p>
                </div>
              </div>
            </td>
            <td class="px-6 py-4">
              <div class="flex flex-wrap gap-1">
                <span
                  v-for="permission in role.permissions.slice(0, 3)"
                  :key="permission.id"
                  class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700"
                >
                  {{ getPermissionShortLabel(permission.name) }}
                </span>
                <span
                  v-if="role.permissions.length > 3"
                  class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600"
                >
                  +{{ role.permissions.length - 3 }}
                </span>
                <span
                  v-if="role.permissions.length === 0"
                  class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500"
                >
                  Sin permisos
                </span>
              </div>
            </td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                <Users class="w-3 h-3" />
                {{ role.users_count || 0 }} usuario{{ role.users_count !== 1 ? 's' : '' }}
              </span>
            </td>
            <td class="px-6 py-4">{{ formatDate(role.created_at) }}</td>
            <td class="px-6 py-4 text-right">
              <div class="flex items-center justify-end gap-2">
                <button
                  v-if="authStore.hasPermission('roles.edit')"
                  @click="openModal(role)"
                  class="p-2 text-[#005674] hover:bg-[#005674]/10 rounded"
                  title="Editar"
                >
                  <Pencil class="w-4 h-4" />
                </button>
                <button
                  v-if="authStore.hasPermission('roles.delete')"
                  @click="confirmDelete(role)"
                  class="p-2 text-red-600 hover:bg-red-50 rounded"
                  :disabled="role.name === 'admin' || role.users_count > 0"
                  :class="{ 'opacity-50 cursor-not-allowed': role.name === 'admin' || role.users_count > 0 }"
                  :title="role.name === 'admin' ? 'No se puede eliminar el rol admin' : role.users_count > 0 ? 'Tiene usuarios asignados' : 'Eliminar'"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="filteredRoles.length === 0" class="text-center py-12 text-gray-500">
        <Shield class="w-12 h-12 mx-auto mb-3 text-gray-300" />
        <p>No se encontraron roles</p>
      </div>
    </div>

    <!-- Modal Mejorado -->
    <Teleport to="body">
      <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="showModal"
          class="fixed inset-0 z-50 overflow-y-auto"
          aria-labelledby="modal-title"
          role="dialog"
          aria-modal="true"
        >
          <!-- Backdrop with blur -->
          <div class="flex min-h-screen items-center justify-center p-2 sm:p-4">
            <div
              class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
              @click="closeModal"
            ></div>

            <!-- Modal Panel -->
            <Transition
              enter-active-class="transition duration-300 ease-out"
              enter-from-class="opacity-0 scale-95 translate-y-4"
              enter-to-class="opacity-100 scale-100 translate-y-0"
              leave-active-class="transition duration-200 ease-in"
              leave-from-class="opacity-100 scale-100 translate-y-0"
              leave-to-class="opacity-0 scale-95 translate-y-4"
            >
              <div
                v-if="showModal"
                class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-auto overflow-hidden transform transition-all"
              >
                <!-- Header Mejorado -->
                <div class="bg-gradient-to-r from-[#005674] via-[#004a5f] to-[#003C5F] px-6 py-5">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <Shield class="w-6 h-6 text-white" />
                      </div>
                      <div>
                        <h2 id="modal-title" class="text-xl font-bold text-white">
                          {{ editingRole ? 'Editar Rol' : 'Nuevo Rol' }}
                        </h2>
                        <p class="text-sm text-white/70">
                          {{ editingRole ? 'Modifica los permisos del rol' : 'Crea un nuevo rol con permisos específicos' }}
                        </p>
                      </div>
                    </div>
                    <button
                      @click="closeModal"
                      class="text-white/70 hover:text-white hover:bg-white/20 rounded-lg p-2 transition-all"
                    >
                      <X class="w-6 h-6" />
                    </button>
                  </div>
                </div>

                <!-- Content -->
                <div class="max-h-[calc(100vh-280px)] overflow-y-auto">
                  <form @submit.prevent="saveRole" class="p-6 space-y-6">
                    <!-- Nombre del Rol -->
                    <div class="bg-gray-50 rounded-xl p-4">
                      <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre del Rol <span class="text-red-500">*</span>
                      </label>
                      <input
                        v-model="roleForm.name"
                        type="text"
                        required
                        placeholder="Ej: editor, moderador, analista"
                        class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] focus:border-[#005674] transition-colors"
                      >
                      <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                        <Info class="w-3 h-3" />
                        Use nombres descriptivos en minúsculas sin espacios
                      </p>
                    </div>

                    <!-- Permisos por Categoría -->
                    <div>
                      <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-semibold text-gray-700">
                          Permisos asignados
                        </label>
                        <div class="flex gap-2">
                          <button
                            type="button"
                            @click="selectAllPermissions"
                            class="text-xs px-3 py-1.5 bg-[#005674]/10 text-[#005674] rounded-full hover:bg-[#005674]/20 transition-colors font-medium"
                          >
                            Seleccionar todos
                          </button>
                          <button
                            type="button"
                            @click="deselectAllPermissions"
                            class="text-xs px-3 py-1.5 bg-gray-100 text-gray-600 rounded-full hover:bg-gray-200 transition-colors font-medium"
                          >
                            Deseleccionar
                          </button>
                        </div>
                      </div>

                      <div class="space-y-4">
                        <div
                          v-for="(perms, module) in rolesStore.groupedPermissions"
                          :key="module"
                          class="border border-gray-200 rounded-xl overflow-hidden"
                        >
                          <!-- Module Header -->
                          <button
                            type="button"
                            @click="toggleModule(module)"
                            class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors"
                          >
                            <div class="flex items-center gap-3">
                              <component :is="getModuleIcon(module)" class="w-5 h-5 text-[#005674]" />
                              <span class="font-semibold text-gray-800 capitalize">{{ getModuleLabel(module) }}</span>
                              <span class="text-xs px-2 py-0.5 bg-[#005674]/10 text-[#005674] rounded-full">
                                {{ roleForm.permissions.filter(p => perms.some(perm => perm.name === p)).length }}/{{ perms.length }}
                              </span>
                            </div>
                            <ChevronDown
                              class="w-5 h-5 text-gray-400 transition-transform"
                              :class="{ 'rotate-180': expandedModules.includes(module) }"
                            />
                          </button>

                          <!-- Module Permissions -->
                          <Transition
                            enter-active-class="transition duration-200 ease-out"
                            enter-from-class="opacity-0 -translate-y-2"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition duration-150 ease-in"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 -translate-y-2"
                          >
                            <div
                              v-show="expandedModules.includes(module)"
                              class="p-4 bg-white"
                            >
                              <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <label
                                  v-for="permission in perms"
                                  :key="permission.id"
                                  class="flex items-start gap-3 p-3 rounded-lg border-2 cursor-pointer transition-all"
                                  :class="roleForm.permissions.includes(permission.name)
                                    ? 'border-[#005674] bg-[#005674]/5'
                                    : 'border-gray-200 hover:border-gray-300 bg-white'
                                  "
                                >
                                  <div class="relative flex items-center">
                                    <input
                                      type="checkbox"
                                      :value="permission.name"
                                      v-model="roleForm.permissions"
                                      class="peer sr-only"
                                    >
                                    <div class="w-5 h-5 border-2 border-gray-300 rounded transition-all peer-checked:border-[#005674] peer-checked:bg-[#005674]">
                                      <Check class="w-3 h-3 text-white absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 peer-checked:opacity-100" />
                                    </div>
                                  </div>
                                  <div class="flex-1">
                                    <span class="text-sm font-medium text-gray-700 block">
                                      {{ rolesStore.getPermissionLabel(permission.name).action }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                      {{ permission.name }}
                                    </span>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </Transition>
                        </div>
                      </div>

                      <div v-if="Object.keys(rolesStore.groupedPermissions).length === 0" class="text-center py-8 bg-gray-50 rounded-xl">
                        <Loader2 class="w-8 h-8 mx-auto mb-2 text-gray-400 animate-spin" />
                        <p class="text-sm text-gray-500">Cargando permisos...</p>
                      </div>
                    </div>

                    <!-- Summary -->
                    <div class="bg-[#005674]/5 rounded-xl p-4">
                      <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                          <CheckCircle2 class="w-5 h-5 text-[#005674]" />
                          <span class="text-sm font-medium text-gray-700">
                            {{ roleForm.permissions.length }} permiso{{ roleForm.permissions.length !== 1 ? 's' : '' }} seleccionado{{ roleForm.permissions.length !== 1 ? 's' : '' }}
                          </span>
                        </div>
                        <button
                          v-if="roleForm.permissions.length > 0"
                          type="button"
                          @click="roleForm.permissions = []"
                          class="text-xs text-red-600 hover:text-red-700 font-medium"
                        >
                          Limpiar
                        </button>
                      </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col-reverse sm:flex-row gap-3 pt-4 border-t">
                      <button
                        type="button"
                        @click="closeModal"
                        class="w-full sm:flex-1 px-4 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors"
                      >
                        Cancelar
                      </button>
                      <button
                        type="submit"
                        :disabled="saving || !roleForm.name.trim()"
                        class="w-full sm:flex-1 px-4 py-3 bg-[#005674] text-white font-medium rounded-lg hover:bg-[#003C5F] disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center justify-center gap-2"
                      >
                        <span v-if="saving" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        {{ saving ? 'Guardando...' : (editingRole ? 'Actualizar Rol' : 'Crear Rol') }}
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </Transition>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, reactive } from 'vue';
import {
  Plus, Pencil, Trash2, X, Shield, Users, Info,
  Check, ChevronDown, CheckCircle2, Loader2,
  FileText, User, ShieldCheck, Settings
} from 'lucide-vue-next';
import { useRolesStore } from '../../stores/roles';
import { useAuthStore } from '../../stores/auth';

const rolesStore = useRolesStore();
const authStore = useAuthStore();
const search = ref('');
const showModal = ref(false);
const editingRole = ref(null);
const saving = ref(false);
const expandedModules = ref([]);

const roleForm = reactive({
  name: '',
  permissions: []
});

const moduleIcons = {
  pages: FileText,
  users: User,
  roles: ShieldCheck,
  settings: Settings
};

const moduleLabels = {
  pages: 'Páginas',
  users: 'Usuarios',
  roles: 'Roles y Permisos',
  settings: 'Configuración'
};

const filteredRoles = computed(() => {
  let roles = rolesStore.roles;

  if (search.value) {
    const searchLower = search.value.toLowerCase();
    roles = roles.filter(r =>
      r.name.toLowerCase().includes(searchLower)
    );
  }

  return roles;
});

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-CO', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const getPermissionShortLabel = (permissionName) => {
  const labels = {
    'pages.view': 'Ver Pág.',
    'pages.create': 'Crear Pág.',
    'pages.edit': 'Editar Pág.',
    'pages.delete': 'Eliminar Pág.',
    'pages.publish': 'Publicar Pág.',
    'users.view': 'Ver Usr.',
    'users.create': 'Crear Usr.',
    'users.edit': 'Editar Usr.',
    'users.delete': 'Eliminar Usr.',
    'roles.view': 'Ver Rol',
    'roles.create': 'Crear Rol',
    'roles.edit': 'Editar Rol',
    'roles.delete': 'Eliminar Rol',
    'settings.view': 'Ver Conf.',
    'settings.edit': 'Editar Conf.'
  };
  return labels[permissionName] || permissionName;
};

const getModuleIcon = (module) => {
  return moduleIcons[module] || Shield;
};

const getModuleLabel = (module) => {
  return moduleLabels[module] || module;
};

const toggleModule = (module) => {
  if (expandedModules.value.includes(module)) {
    expandedModules.value = expandedModules.value.filter(m => m !== module);
  } else {
    expandedModules.value.push(module);
  }
};

const selectAllPermissions = () => {
  const allPerms = [];
  Object.values(rolesStore.groupedPermissions).forEach(perms => {
    perms.forEach(p => allPerms.push(p.name));
  });
  roleForm.permissions = allPerms;
};

const deselectAllPermissions = () => {
  roleForm.permissions = [];
};

const openModal = (role = null) => {
  editingRole.value = role;
  if (role) {
    roleForm.name = role.name;
    roleForm.permissions = role.permissions.map(p => p.name);
  } else {
    roleForm.name = '';
    roleForm.permissions = [];
  }
  // Expand all modules by default when opening modal
  expandedModules.value = Object.keys(rolesStore.groupedPermissions);
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  editingRole.value = null;
  roleForm.name = '';
  roleForm.permissions = [];
};

const saveRole = async () => {
  saving.value = true;
  try {
    if (editingRole.value) {
      await rolesStore.updateRole(editingRole.value.id, { ...roleForm });
    } else {
      await rolesStore.createRole({ ...roleForm });
    }
    closeModal();
    await rolesStore.fetchRoles();
  } catch (error) {
    alert('Error al guardar: ' + (error.response?.data?.message || error.message));
  } finally {
    saving.value = false;
  }
};

const confirmDelete = (role) => {
  if (role.name === 'admin') {
    alert('No se puede eliminar el rol de administrador');
    return;
  }
  if (role.users_count > 0) {
    alert('No se puede eliminar el rol porque tiene usuarios asignados');
    return;
  }
  if (!confirm(`¿Estás seguro de eliminar el rol "${role.name}"?`)) return;
  rolesStore.deleteRole(role.id).catch(error => {
    alert('Error al eliminar: ' + (error.response?.data?.message || error.message));
  });
};

onMounted(async () => {
  await rolesStore.fetchRoles();
  await rolesStore.fetchPermissions();
});
</script>
