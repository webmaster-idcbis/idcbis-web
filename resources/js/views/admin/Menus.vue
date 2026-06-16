<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-[#e6edf3]">Gestión de Menús</h1>
      <button
        v-if="authStore.hasPermission('menus.create')"
        @click="openModal()"
        class="px-4 py-2 bg-[#005674] dark:bg-[#58a6ff] text-white rounded-lg hover:bg-[#003C5F] dark:hover:bg-[#79c0ff] transition-colors flex items-center gap-2"
      >
        <Plus class="w-5 h-5" />
        Nuevo Menú
      </button>
    </div>

    <!-- Menus List -->
    <div class="space-y-4">
      <div
        v-for="menu in menusStore.menus"
        :key="menu.id"
        class="bg-white dark:bg-[#161b22] rounded-lg shadow-sm dark:shadow-none dark:border dark:border-[#30363d] p-4"
      >
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
              <MenuIcon class="w-5 h-5 text-[#005674] dark:text-[#58a6ff]" />
              <h3 class="font-semibold text-gray-900 dark:text-[#e6edf3]">{{ menu.name }}</h3>
            </div>
            <span
              :class="[
                'px-2 py-1 rounded-full text-xs font-medium',
                menu.location === 'header' 
                  ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400'
                  : 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400'
              ]"
            >
              {{ menu.location === 'header' ? 'Menú Superior' : 'Menú Footer' }}
            </span>
            <span
              :class="[
                'px-2 py-1 rounded-full text-xs font-medium',
                menu.is_active
                  ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400'
                  : 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-400'
              ]"
            >
              {{ menu.is_active ? 'Activo' : 'Inactivo' }}
            </span>
          </div>
          
          <div class="flex items-center gap-2">
            <button
              @click="openModal(menu)"
              class="p-2 text-[#005674] dark:text-[#58a6ff] hover:bg-[#005674]/10 dark:hover:bg-[#58a6ff]/10 rounded"
              title="Editar"
            >
              <Pencil class="w-4 h-4" />
            </button>
            <button
              v-if="authStore.hasPermission('menus.delete')"
              @click="confirmDelete(menu)"
              class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded"
              title="Eliminar"
            >
              <Trash2 class="w-4 h-4" />
            </button>
          </div>
        </div>

        <!-- Menu Items Preview -->
        <div class="mt-4 pl-4 border-l-2 border-gray-200 dark:border-[#30363d]">
          <p class="text-xs text-gray-500 dark:text-[#8b949e] mb-2">Items del menú ({{ menu.items?.length || 0 }}):</p>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="(item, index) in menu.items?.slice(0, 5)"
              :key="index"
              class="text-xs px-2 py-1 bg-gray-100 dark:bg-[#21262d] text-gray-700 dark:text-[#8b949e] rounded"
            >
              {{ item.title }}
            </span>
            <span
              v-if="(menu.items?.length || 0) > 5"
              class="text-xs px-2 py-1 bg-gray-100 dark:bg-[#21262d] text-gray-500 dark:text-[#8b949e] rounded"
            >
              +{{ menu.items.length - 5 }} más
            </span>
          </div>
        </div>
      </div>
    </div>

    <div v-if="menusStore.menus.length === 0" class="text-center py-12 text-gray-500 dark:text-[#8b949e]">
      <MenuIcon class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-[#30363d]" />
      <p>No hay menús creados</p>
      <p class="text-sm">Haz clic en "Nuevo Menú" para crear uno</p>
    </div>

    <!-- Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 overflow-y-auto"
    >
      <div class="flex min-h-screen items-center justify-center p-4">
        <div 
          class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"
          @click="closeModal"
        ></div>
        
        <div class="relative bg-white dark:bg-[#161b22] rounded-xl shadow-2xl w-full max-w-2xl mx-auto overflow-hidden">
          <!-- Header -->
          <div class="bg-gradient-to-r from-[#005674] to-[#003C5F] px-6 py-4">
            <div class="flex items-center justify-between">
              <h2 class="text-xl font-bold text-white">
                {{ editingMenu ? 'Editar Menú' : 'Nuevo Menú' }}
              </h2>
              <button @click="closeModal" class="text-white/80 hover:text-white">
                <X class="w-6 h-6" />
              </button>
            </div>
          </div>
          
          <!-- Content -->
          <form @submit.prevent="saveMenu" class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
            <!-- Name -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-[#8b949e] mb-1">
                Nombre del Menú <span class="text-red-500">*</span>
              </label>
              <input
                v-model="menuForm.name"
                type="text"
                required
                placeholder="Ej: Menú Principal"
                class="w-full px-3 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
              >
            </div>

            <!-- Location -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-[#8b949e] mb-1">
                Ubicación <span class="text-red-500">*</span>
              </label>
              <select
                v-model="menuForm.location"
                required
                class="w-full px-3 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
              >
                <option value="header">Menú Superior (Header)</option>
                <option value="footer">Menú Footer</option>
              </select>
            </div>

            <!-- Status -->
            <div class="flex items-center gap-2">
              <input
                v-model="menuForm.is_active"
                type="checkbox"
                id="is_active"
                class="w-4 h-4 text-[#005674] dark:text-[#58a6ff] rounded focus:ring-[#005674] dark:focus:ring-[#58a6ff] border-gray-300 dark:border-[#30363d]"
              >
              <label for="is_active" class="text-sm text-gray-700 dark:text-[#8b949e]">
                Menú activo
              </label>
            </div>

            <!-- Menu Items -->
            <div>
              <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-semibold text-gray-700 dark:text-[#8b949e]">
                  Items del Menú
                </label>
                <button
                  type="button"
                  @click="addItem"
                  class="text-xs px-3 py-1.5 bg-[#005674]/10 dark:bg-[#58a6ff]/20 text-[#005674] dark:text-[#58a6ff] rounded-full hover:bg-[#005674]/20 dark:hover:bg-[#58a6ff]/30 transition-colors"
                >
                  <Plus class="w-3 h-3 inline mr-1" />
                  Agregar Item
                </button>
              </div>

              <div class="space-y-2">
                <div
                  v-for="(item, index) in menuForm.items"
                  :key="index"
                  class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-[#21262d] rounded-lg"
                >
                  <div class="flex-1 grid grid-cols-12 gap-2">
                    <div class="col-span-4">
                      <input
                        v-model="item.title"
                        type="text"
                        placeholder="Título"
                        required
                        class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-[#30363d] rounded focus:ring-1 focus:ring-[#005674] dark:focus:ring-[#58a6ff] bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
                      >
                    </div>
                    <div class="col-span-3">
                      <select
                        v-model="item.type"
                        class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-[#30363d] rounded focus:ring-1 focus:ring-[#005674] dark:focus:ring-[#58a6ff] bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
                      >
                        <option value="page">Página</option>
                        <option value="url">URL Externa</option>
                      </select>
                    </div>
                    <div class="col-span-4">
                      <select
                        v-if="item.type === 'page'"
                        v-model="item.page_id"
                        class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-[#30363d] rounded focus:ring-1 focus:ring-[#005674] dark:focus:ring-[#58a6ff] bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
                      >
                        <option value="">Seleccionar página</option>
                        <option
                          v-for="page in menusStore.availablePages"
                          :key="page.id"
                          :value="page.id"
                        >
                          {{ page.title }}
                        </option>
                      </select>
                      <input
                        v-else
                        v-model="item.url"
                        type="url"
                        placeholder="https://ejemplo.com"
                        class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-[#30363d] rounded focus:ring-1 focus:ring-[#005674] dark:focus:ring-[#58a6ff] bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
                      >
                    </div>
                    <div class="col-span-1">
                      <select
                        v-model="item.target"
                        class="w-full px-1 py-1.5 text-xs border border-gray-300 dark:border-[#30363d] rounded focus:ring-1 focus:ring-[#005674] dark:focus:ring-[#58a6ff] bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
                        title="Target"
                      >
                        <option value="_self">Mismo</option>
                        <option value="_blank">Nueva</option>
                      </select>
                    </div>
                  </div>
                  <button
                    type="button"
                    @click="removeItem(index)"
                    class="p-1 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded"
                  >
                    <X class="w-4 h-4" />
                  </button>
                </div>
              </div>

              <div v-if="menuForm.items.length === 0" class="text-center py-4 text-gray-500 dark:text-[#8b949e] text-sm">
                No hay items. Haz clic en "Agregar Item" para crear uno.
              </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-[#30363d]">
              <button
                type="button"
                @click="closeModal"
                class="px-4 py-2 text-gray-700 dark:text-[#8b949e] hover:bg-gray-100 dark:hover:bg-[#21262d] rounded-lg transition-colors"
              >
                Cancelar
              </button>
              <button
                type="submit"
                :disabled="saving || menuForm.items.length === 0"
                class="px-4 py-2 bg-[#005674] dark:bg-[#58a6ff] text-white rounded-lg hover:bg-[#003C5F] dark:hover:bg-[#79c0ff] disabled:opacity-50 flex items-center gap-2 transition-colors"
              >
                <Save v-if="!saving" class="w-4 h-4" />
                <Loader2 v-else class="w-4 h-4 animate-spin" />
                {{ saving ? 'Guardando...' : 'Guardar' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../../stores/auth';
import { useMenusStore } from '../../stores/menus';
import { 
  Plus, 
  Pencil, 
  Trash2, 
  X, 
  Save, 
  Loader2,
  Menu as MenuIcon
} from 'lucide-vue-next';

const authStore = useAuthStore();
const menusStore = useMenusStore();

const showModal = ref(false);
const saving = ref(false);
const editingMenu = ref(null);

const menuForm = ref({
  name: '',
  location: 'header',
  is_active: true,
  items: []
});

const defaultItem = {
  title: '',
  type: 'page',
  page_id: '',
  url: '',
  target: '_self',
  order: 0
};

onMounted(async () => {
  await menusStore.fetchMenus();
  await menusStore.fetchAvailablePages();
});

const openModal = (menu = null) => {
  if (menu) {
    editingMenu.value = menu;
    menuForm.value = {
      name: menu.name,
      location: menu.location,
      is_active: menu.is_active,
      items: [...menu.items]
    };
  } else {
    editingMenu.value = null;
    menuForm.value = {
      name: '',
      location: 'header',
      is_active: true,
      items: [{ ...defaultItem }]
    };
  }
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  editingMenu.value = null;
};

const addItem = () => {
  menuForm.value.items.push({
    ...defaultItem,
    order: menuForm.value.items.length
  });
};

const removeItem = (index) => {
  menuForm.value.items.splice(index, 1);
  // Reordenar
  menuForm.value.items.forEach((item, i) => {
    item.order = i;
  });
};

const saveMenu = async () => {
  if (menuForm.value.items.length === 0) {
    alert('Debes agregar al menos un item al menú');
    return;
  }

  // Procesar items para enviar la URL correcta
  const items = menuForm.value.items.map(item => {
    if (item.type === 'page') {
      const page = menusStore.availablePages.find(p => p.id === item.page_id);
      return {
        ...item,
        url: page ? `/${page.slug}` : '#'
      };
    }
    return item;
  });

  const data = {
    ...menuForm.value,
    items
  };

  saving.value = true;
  try {
    if (editingMenu.value) {
      await menusStore.updateMenu(editingMenu.value.id, data);
    } else {
      await menusStore.createMenu(data);
    }
    closeModal();
  } catch (err) {
    console.error('Error al guardar menú:', err);
  } finally {
    saving.value = false;
  }
};

const confirmDelete = async (menu) => {
  if (confirm(`¿Estás seguro de eliminar el menú "${menu.name}"?`)) {
    try {
      await menusStore.deleteMenu(menu.id);
    } catch (err) {
      console.error('Error al eliminar menú:', err);
    }
  }
};
</script>
