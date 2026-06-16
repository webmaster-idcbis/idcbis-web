<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-[#e6edf3]">Gestión de Usuarios</h1>
      <button
        v-if="authStore.hasPermission('users.create')"
        @click="openModal()"
        class="px-4 py-2 bg-[#005674] dark:bg-[#58a6ff] text-white rounded-lg hover:bg-[#003C5F] dark:hover:bg-[#79c0ff] transition-colors flex items-center gap-2"
      >
        <Plus class="w-5 h-5" />
        Nuevo Usuario
      </button>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d] p-4 mb-6">
      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
          <input 
            v-model="search"
            type="text" 
            placeholder="Buscar usuarios..."
            class="w-full px-4 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
          >
        </div>
        <select 
          v-model="roleFilter"
          class="px-4 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
        >
          <option value="">Todos los roles</option>
          <option v-for="role in usersStore.roles" :key="role.name" :value="role.name">
            {{ role.name }}
          </option>
        </select>
      </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d] overflow-hidden">
      <table class="w-full text-sm text-left">
        <thead class="text-xs text-gray-500 dark:text-[#8b949e] uppercase bg-gray-50 dark:bg-[#21262d]">
          <tr>
            <th class="px-6 py-3">Nombre</th>
            <th class="px-6 py-3">Email</th>
            <th class="px-6 py-3">Roles</th>
            <th class="px-6 py-3">Estado</th>
            <th class="px-6 py-3">Creado</th>
            <th class="px-6 py-3 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in filteredUsers" :key="user.id" class="border-b border-gray-200 dark:border-[#30363d] hover:bg-gray-50 dark:hover:bg-[#21262d]">
            <td class="px-6 py-4 font-medium text-gray-900 dark:text-[#e6edf3]">{{ user.name }}</td>
            <td class="px-6 py-4 text-gray-500 dark:text-[#8b949e]">{{ user.email }}</td>
            <td class="px-6 py-4">
              <span 
                v-for="role in user.roles" 
                :key="role.id"
                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-[#005674]/10 dark:bg-[#58a6ff]/20 text-[#005674] dark:text-[#58a6ff] mr-1"
              >
                {{ role.name }}
              </span>
            </td>
            <td class="px-6 py-4">
              <span :class="[
                'px-2 py-1 rounded-full text-xs font-medium',
                user.is_active !== false ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400'
              ]">
                {{ user.is_active !== false ? 'Activo' : 'Inactivo' }}
              </span>
            </td>
            <td class="px-6 py-4 text-gray-500 dark:text-[#8b949e]">{{ formatDate(user.created_at) }}</td>
            <td class="px-6 py-4 text-right">
              <div class="flex items-center justify-end gap-2">
                <button
                  v-if="authStore.hasPermission('users.edit')"
                  @click="openModal(user)"
                  class="p-2 text-[#005674] dark:text-[#58a6ff] hover:bg-[#005674]/10 dark:hover:bg-[#58a6ff]/10 rounded"
                  title="Editar"
                >
                  <Pencil class="w-4 h-4" />
                </button>
                <button
                  v-if="authStore.hasPermission('users.delete')"
                  @click="confirmDelete(user)"
                  class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded"
                  title="Eliminar"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      
      <div v-if="filteredUsers.length === 0" class="text-center py-12 text-gray-500 dark:text-[#8b949e]">
        No se encontraron usuarios
      </div>
    </div>

    <!-- Modal -->
    <div 
      v-if="showModal" 
      class="fixed inset-0 z-50 overflow-y-auto"
      aria-labelledby="modal-title"
      role="dialog"
      aria-modal="true"
    >
      <!-- Backdrop -->
      <div class="flex min-h-screen items-center justify-center p-2 sm:p-4">
        <div 
          class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
          @click="closeModal"
        ></div>
        
        <!-- Modal Panel -->
        <div class="relative bg-white dark:bg-[#161b22] rounded-xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all">
          <!-- Header -->
          <div class="bg-gradient-to-r from-[#005674] to-[#003C5F] px-4 py-4 sm:px-6 sm:py-5">
            <div class="flex items-center justify-between">
              <h2 id="modal-title" class="text-lg sm:text-xl font-bold text-white">
                {{ editingUser ? 'Editar Usuario' : 'Nuevo Usuario' }}
              </h2>
              <button 
                @click="closeModal" 
                class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-1 transition-colors"
              >
                <X class="w-5 h-5 sm:w-6 sm:h-6" />
              </button>
            </div>
          </div>
          
          <!-- Content -->
          <div class="max-h-[calc(100vh-250px)] overflow-y-auto">
            <form @submit.prevent="saveUser" class="p-4 sm:p-6 space-y-4 sm:space-y-5">
              <!-- Nombre -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-[#8b949e] mb-1.5">
                  Nombre <span class="text-red-500">*</span>
                </label>
                <input 
                  v-model="userForm.name"
                  type="text"
                  required
                  placeholder="Ingrese el nombre completo"
                  class="w-full px-3 py-2.5 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3] transition-colors text-sm sm:text-base"
                >
              </div>
              
              <!-- Email -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-[#8b949e] mb-1.5">
                  Email <span class="text-red-500">*</span>
                </label>
                <input 
                  v-model="userForm.email"
                  type="email"
                  required
                  placeholder="usuario@ejemplo.com"
                  class="w-full px-3 py-2.5 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3] transition-colors text-sm sm:text-base"
                >
              </div>
              
              <!-- Contraseña -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-[#8b949e] mb-1.5">
                  {{ editingUser ? 'Nueva Contraseña' : 'Contraseña' }}
                  <span v-if="!editingUser" class="text-red-500">*</span>
                  <span v-else class="text-gray-400 dark:text-[#8b949e] font-normal">(opcional)</span>
                </label>
                <input 
                  v-model="userForm.password"
                  type="password"
                  :required="!editingUser"
                  minlength="8"
                  :placeholder="editingUser ? 'Dejar en blanco para no cambiar' : 'Mínimo 8 caracteres'"
                  class="w-full px-3 py-2.5 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3] transition-colors text-sm sm:text-base"
                >
                <p v-if="!editingUser" class="text-xs text-gray-500 dark:text-[#8b949e] mt-1">Mínimo 8 caracteres</p>
              </div>
              
              <!-- Roles -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-[#8b949e] mb-1.5">Roles</label>
                <div class="border border-gray-300 dark:border-[#30363d] rounded-lg p-2 sm:p-3 bg-white dark:bg-[#0f1419]">
                  <div v-if="usersStore.roles.length === 0" class="text-sm text-gray-500 py-2">
                    No hay roles creados.
                    <router-link to="/admin/roles" class="text-[#005674] hover:underline">Cree roles primero</router-link>.
                  </div>
                  <div v-else class="max-h-32 overflow-y-auto space-y-1">
                    <label
                      v-for="role in usersStore.roles"
                      :key="role.name"
                      class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer"
                    >
                      <input
                        type="checkbox"
                        :value="role.name"
                        v-model="userForm.roles"
                        class="w-4 h-4 text-[#005674] border-gray-300 rounded focus:ring-[#005674]"
                      >
                      <span class="text-sm text-gray-700 capitalize">{{ role.name }}</span>
                    </label>
                  </div>
                </div>
                <p v-if="usersStore.roles.length > 0" class="text-xs text-gray-500 mt-1">Seleccione uno o más roles</p>
              </div>
              
              <!-- Estado Activo -->
              <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg">
                <div class="relative inline-block w-11 h-6">
                  <input 
                    v-model="userForm.is_active"
                    type="checkbox"
                    id="is_active"
                    class="sr-only peer"
                  >
                  <label 
                    for="is_active"
                    class="inline-flex items-center justify-between w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-[#005674] rounded-full cursor-pointer peer-checked:bg-[#005674] peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"
                  ></label>
                </div>
                <label for="is_active" class="text-sm font-medium text-gray-700 cursor-pointer select-none">
                  Usuario activo
                </label>
              </div>
              
              <!-- Botones -->
              <div class="flex flex-col-reverse sm:flex-row gap-3 pt-4 border-t">
                <button 
                  type="button"
                  @click="closeModal"
                  class="w-full sm:flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors"
                >
                  Cancelar
                </button>
                <button 
                  type="submit"
                  :disabled="saving"
                  class="w-full sm:flex-1 px-4 py-2.5 bg-[#005674] text-white font-medium rounded-lg hover:bg-[#003C5F] disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center justify-center gap-2"
                >
                  <span v-if="saving" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                  {{ saving ? 'Guardando...' : (editingUser ? 'Actualizar Usuario' : 'Crear Usuario') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, reactive } from 'vue';
import { Plus, Pencil, Trash2, X } from 'lucide-vue-next';
import { useUsersStore } from '../../stores/users';
import { useAuthStore } from '../../stores/auth';

const usersStore = useUsersStore();
const authStore = useAuthStore();
const search = ref('');
const roleFilter = ref('');
const showModal = ref(false);
const editingUser = ref(null);
const saving = ref(false);

const userForm = reactive({
  name: '',
  email: '',
  password: '',
  roles: [],
  is_active: true
});

const filteredUsers = computed(() => {
  let users = usersStore.users;
  
  if (search.value) {
    const searchLower = search.value.toLowerCase();
    users = users.filter(u => 
      u.name.toLowerCase().includes(searchLower) ||
      u.email.toLowerCase().includes(searchLower)
    );
  }
  
  if (roleFilter.value) {
    users = users.filter(u => 
      u.roles.some(r => r.name === roleFilter.value)
    );
  }
  
  return users;
});

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-CO', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const openModal = (user = null) => {
  editingUser.value = user;
  if (user) {
    userForm.name = user.name;
    userForm.email = user.email;
    userForm.password = '';
    userForm.roles = user.roles.map(r => r.name);
    userForm.is_active = user.is_active !== false;
  } else {
    userForm.name = '';
    userForm.email = '';
    userForm.password = '';
    userForm.roles = [];
    userForm.is_active = true;
  }
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  editingUser.value = null;
};

const saveUser = async () => {
  saving.value = true;
  try {
    if (editingUser.value) {
      const data = { ...userForm };
      if (!data.password) delete data.password;
      await usersStore.updateUser(editingUser.value.id, data);
    } else {
      await usersStore.createUser({ ...userForm });
    }
    closeModal();
    await usersStore.fetchUsers();
  } catch (error) {
    alert('Error al guardar: ' + (error.response?.data?.message || error.message));
  } finally {
    saving.value = false;
  }
};

const confirmDelete = (user) => {
  if (!confirm(`¿Estás seguro de eliminar a ${user.name}?`)) return;
  usersStore.deleteUser(user.id).catch(error => {
    alert('Error al eliminar: ' + (error.response?.data?.message || error.message));
  });
};

onMounted(async () => {
  await usersStore.fetchUsers();
  await usersStore.fetchRoles();
});
</script>
