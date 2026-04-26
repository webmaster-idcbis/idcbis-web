<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Gestión de Permisos</h1>
      <button
        v-if="authStore.hasPermission('permissions.create')"
        @click="openModal()"
        class="px-4 py-2 bg-[#005674] text-white rounded-lg hover:bg-[#003C5F] transition-colors flex items-center gap-2"
      >
        <Plus class="w-5 h-5" />
        Nuevo Permiso
      </button>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
          <input
            v-model="search"
            type="text"
            placeholder="Buscar permisos..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] focus:border-transparent"
          >
        </div>
        <select
          v-model="moduleFilter"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674]"
        >
          <option value="">Todos los módulos</option>
          <option v-for="module in permissionsStore.modules" :key="module" :value="module">
            {{ permissionsStore.getModuleLabel(module) }}
          </option>
        </select>
      </div>
    </div>

    <!-- Permissions Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="w-full text-sm text-left">
        <thead class="text-xs text-gray-500 uppercase bg-gray-50">
          <tr>
            <th class="px-6 py-3">Nombre</th>
            <th class="px-6 py-3">Módulo</th>
            <th class="px-6 py-3">Acción</th>
            <th class="px-6 py-3">Roles</th>
            <th class="px-6 py-3">Creado</th>
            <th class="px-6 py-3 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="permission in filteredPermissions" :key="permission.id" class="border-b hover:bg-gray-50">
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                  <Key class="w-5 h-5 text-blue-600" />
                </div>
                <div>
                  <p class="font-medium text-gray-900 font-mono text-sm">{{ permission.name }}</p>
                  <p class="text-xs text-gray-500">{{ permission.guard_name }}</p>
                </div>
              </div>
            </td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700 capitalize">
                <component :is="getModuleIcon(permission.module)" class="w-3 h-3 mr-1" />
                {{ permissionsStore.getModuleLabel(permission.module) }}
              </span>
            </td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 capitalize">
                {{ permissionsStore.getActionLabel(permission.action) }}
              </span>
            </td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                <Shield class="w-3 h-3" />
                {{ permission.roles_count || 0 }} rol{{ permission.roles_count !== 1 ? 'es' : '' }}
              </span>
            </td>
            <td class="px-6 py-4">{{ formatDate(permission.created_at) }}</td>
            <td class="px-6 py-4 text-right">
              <div class="flex items-center justify-end gap-2">
                <button
                  v-if="authStore.hasPermission('permissions.edit')"
                  @click="openModal(permission)"
                  class="p-2 text-[#005674] hover:bg-[#005674]/10 rounded"
                  title="Editar"
                >
                  <Pencil class="w-4 h-4" />
                </button>
                <button
                  v-if="authStore.hasPermission('permissions.delete')"
                  @click="confirmDelete(permission)"
                  class="p-2 text-red-600 hover:bg-red-50 rounded"
                  :disabled="permission.roles_count > 0 || isCriticalPermission(permission.name)"
                  :class="{ 'opacity-50 cursor-not-allowed': permission.roles_count > 0 || isCriticalPermission(permission.name) }"
                  :title="getDeleteTooltip(permission)"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="filteredPermissions.length === 0" class="text-center py-12 text-gray-500">
        <Key class="w-12 h-12 mx-auto mb-3 text-gray-300" />
        <p>No se encontraron permisos</p>
      </div>
    </div>

    <!-- Permissions by Module Cards -->
    <div class="mt-8">
      <h2 class="text-lg font-bold text-gray-900 mb-4">Permisos por Módulo</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div
          v-for="(perms, module) in permissionsStore.permissionsByModule"
          :key="module"
          class="bg-white rounded-lg shadow p-4 border border-gray-200"
        >
          <div class="flex items-center gap-2 mb-3">
            <component :is="getModuleIcon(module)" class="w-5 h-5 text-[#005674]" />
            <h3 class="font-semibold text-gray-800 capitalize">{{ permissionsStore.getModuleLabel(module) }}</h3>
            <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full">
              {{ perms.length }}
            </span>
          </div>
          <div class="flex flex-wrap gap-1">
            <span
              v-for="perm in perms.slice(0, 5)"
              :key="perm.id"
              class="text-xs px-2 py-1 bg-blue-50 text-blue-700 rounded"
            >
              {{ permissionsStore.getActionLabel(perm.action) }}
            </span>
            <span
              v-if="perms.length > 5"
              class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded"
            >
              +{{ perms.length - 5 }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
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
          <div class="flex min-h-screen items-center justify-center p-2 sm:p-4">
            <div
              class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
              @click="closeModal"
            ></div>

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
                class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all"
              >
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <Key class="w-6 h-6 text-white" />
                      </div>
                      <div>
                        <h2 id="modal-title" class="text-xl font-bold text-white">
                          {{ editingPermission ? 'Editar Permiso' : 'Nuevo Permiso' }}
                        </h2>
                        <p class="text-sm text-white/70">
                          {{ editingPermission ? 'Modifica el permiso existente' : 'Crea un nuevo permiso para el sistema' }}
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
                  <form @submit.prevent="savePermission" class="p-6 space-y-5">
                    <!-- Nombre del Permiso -->
                    <div>
                      <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre del Permiso <span class="text-red-500">*</span>
                      </label>
                      <input
                        v-model="permissionForm.name"
                        type="text"
                        required
                        placeholder="Ej: pages.create, users.edit, roles.delete"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-mono text-sm"
                        :disabled="editingPermission && isCriticalPermission(permissionForm.name)"
                      >
                      <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                        <Info class="w-3 h-3" />
                        Formato: modulo.accion (ej: pages.view, users.create)
                      </p>
                      <p v-if="editingPermission && isCriticalPermission(permissionForm.name)" class="text-xs text-amber-600 mt-1 flex items-center gap-1">
                        <AlertTriangle class="w-3 h-3" />
                        Permiso crítico - no se puede modificar el nombre
                      </p>
                    </div>

                    <!-- Guard -->
                    <div>
                      <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Guard
                      </label>
                      <select
                        v-model="permissionForm.guard_name"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                      >
                        <option value="web">web</option>
                        <option value="api">api</option>
                      </select>
                      <p class="text-xs text-gray-500 mt-1">Normalmente "web" para aplicaciones web</p>
                    </div>

                    <!-- Preview -->
                    <div v-if="permissionForm.name" class="bg-blue-50 rounded-xl p-4">
                      <p class="text-sm font-medium text-blue-900 mb-1">Vista previa:</p>
                      <div class="flex items-center gap-2">
                        <span class="text-sm text-blue-700">
                          {{ permissionsStore.getPermissionFullLabel(permissionForm.name) }}
                        </span>
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
                        :disabled="saving || !permissionForm.name.trim()"
                        class="w-full sm:flex-1 px-4 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center justify-center gap-2"
                      >
                        <span v-if="saving" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        {{ saving ? 'Guardando...' : (editingPermission ? 'Actualizar Permiso' : 'Crear Permiso') }}
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
  Plus, Pencil, Trash2, X, Key, Shield, Info, AlertTriangle,
  FileText, User, ShieldCheck, Settings, Lock
} from 'lucide-vue-next';
import { usePermissionsStore } from '../../stores/permissions';
import { useAuthStore } from '../../stores/auth';

const permissionsStore = usePermissionsStore();
const authStore = useAuthStore();

const search = ref('');
const moduleFilter = ref('');
const showModal = ref(false);
const editingPermission = ref(null);
const saving = ref(false);

const permissionForm = reactive({
  name: '',
  guard_name: 'web'
});

const moduleIcons = {
  pages: FileText,
  users: User,
  roles: ShieldCheck,
  permissions: Lock,
  settings: Settings
};

const criticalPermissions = [
  'roles.view', 'roles.create', 'roles.edit', 'roles.delete',
  'users.view', 'users.create', 'users.edit', 'users.delete',
  'permissions.view', 'permissions.create', 'permissions.edit', 'permissions.delete'
];

const filteredPermissions = computed(() => {
  let perms = permissionsStore.permissions;

  if (search.value) {
    const searchLower = search.value.toLowerCase();
    perms = perms.filter(p =>
      p.name.toLowerCase().includes(searchLower) ||
      p.module.toLowerCase().includes(searchLower) ||
      p.action.toLowerCase().includes(searchLower)
    );
  }

  if (moduleFilter.value) {
    perms = perms.filter(p => p.module === moduleFilter.value);
  }

  return perms;
});

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-CO', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const getModuleIcon = (module) => {
  return moduleIcons[module] || Lock;
};

const isCriticalPermission = (name) => {
  return criticalPermissions.includes(name);
};

const getDeleteTooltip = (permission) => {
  if (isCriticalPermission(permission.name)) {
    return 'Permiso crítico del sistema - no se puede eliminar';
  }
  if (permission.roles_count > 0) {
    return 'Tiene roles asignados - no se puede eliminar';
  }
  return 'Eliminar';
};

const openModal = (permission = null) => {
  editingPermission.value = permission;
  if (permission) {
    permissionForm.name = permission.name;
    permissionForm.guard_name = permission.guard_name;
  } else {
    permissionForm.name = '';
    permissionForm.guard_name = 'web';
  }
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  editingPermission.value = null;
  permissionForm.name = '';
  permissionForm.guard_name = 'web';
};

const savePermission = async () => {
  saving.value = true;
  try {
    if (editingPermission.value) {
      await permissionsStore.updatePermission(editingPermission.value.id, { ...permissionForm });
    } else {
      await permissionsStore.createPermission({ ...permissionForm });
    }
    closeModal();
    await permissionsStore.fetchPermissions();
    await permissionsStore.fetchModules();
  } catch (error) {
    alert('Error al guardar: ' + (error.response?.data?.message || error.message));
  } finally {
    saving.value = false;
  }
};

const confirmDelete = (permission) => {
  if (isCriticalPermission(permission.name)) {
    alert('No se puede eliminar este permiso crítico del sistema');
    return;
  }
  if (permission.roles_count > 0) {
    alert('No se puede eliminar el permiso porque está asignado a roles');
    return;
  }
  if (!confirm(`¿Estás seguro de eliminar el permiso "${permission.name}"?`)) return;
  permissionsStore.deletePermission(permission.id).catch(error => {
    alert('Error al eliminar: ' + (error.response?.data?.message || error.message));
  });
};

onMounted(async () => {
  await permissionsStore.fetchPermissions();
  await permissionsStore.fetchModules();
});
</script>
