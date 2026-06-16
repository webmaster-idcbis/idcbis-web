<template>
  <div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-8 text-gray-900 dark:text-[#e6edf3]">
      Perfil de Usuario
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Datos Básicos -->
      <div class="bg-white dark:bg-[#161b22] rounded-xl shadow-sm dark:shadow-none dark:border dark:border-[#30363d] p-6">
        <h2 class="text-lg font-semibold mb-6 text-gray-900 dark:text-[#e6edf3] flex items-center gap-2">
          <User class="w-5 h-5 text-[#005674] dark:text-[#58a6ff]" />
          Datos Básicos
        </h2>

        <form @submit.prevent="saveProfile" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-[#8b949e] mb-1">
              Nombre
            </label>
            <input
              v-model="profileForm.name"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
              required
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-[#8b949e] mb-1">
              Email
            </label>
            <input
              v-model="profileForm.email"
              type="email"
              class="w-full px-3 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
              required
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-[#8b949e] mb-1">
              Teléfono
            </label>
            <input
              v-model="profileForm.phone"
              type="tel"
              class="w-full px-3 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-[#8b949e] mb-1">
              Cargo / Rol
            </label>
            <input
              v-model="profileForm.position"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
            >
          </div>

          <div class="pt-4">
            <button
              type="submit"
              :disabled="saving"
              class="w-full px-4 py-2 bg-[#005674] text-white rounded-lg hover:bg-[#003C5F] disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
              <Save v-if="!saving" class="w-4 h-4" />
              <Loader2 v-else class="w-4 h-4 animate-spin" />
              {{ saving ? 'Guardando...' : 'Guardar Cambios' }}
            </button>
          </div>
        </form>
      </div>

      <!-- Preferencias -->
      <div class="space-y-6">
        <!-- Idioma - OCULTO temporalmente -->
        <!--
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-semibold mb-6 text-gray-900 flex items-center gap-2">
            <Globe class="w-5 h-5 text-[#005674]" />
            Idioma
          </h2>

          <div class="space-y-3">
            <label
              v-for="lang in availableLanguages"
              :key="lang.code"
              class="flex items-center gap-3 p-3 rounded-lg border-2 cursor-pointer transition-all"
              :class="preferencesStore.currentLanguage === lang.code 
                ? 'border-[#005674] bg-[#005674]/10' 
                : 'border-gray-200 hover:border-gray-300'"
            >
              <input
                type="radio"
                :value="lang.code"
                v-model="selectedLanguage"
                @change="changeLanguage"
                class="sr-only"
              >
              <span class="text-2xl">{{ lang.flag }}</span>
              <div class="flex-1">
                <p class="font-medium text-gray-900">{{ lang.name }}</p>
                <p class="text-sm text-gray-500">{{ lang.nativeName }}</p>
              </div>
              <Check v-if="preferencesStore.currentLanguage === lang.code" class="w-5 h-5 text-[#005674]" />
            </label>
          </div>
          
          <p class="mt-4 text-sm text-gray-500 bg-yellow-50 p-3 rounded-lg border border-yellow-200">
            <strong>Nota:</strong> La traducción completa estará disponible próximamente. 
            Actualmente solo se guarda la preferencia de idioma.
          </p>
        </div>
        -->

        <!-- Cambiar Contraseña -->
        <div class="bg-white dark:bg-[#161b22] rounded-xl shadow-sm dark:shadow-none dark:border dark:border-[#30363d] p-6">
          <h2 class="text-lg font-semibold mb-6 text-gray-900 dark:text-[#e6edf3] flex items-center gap-2">
            <Lock class="w-5 h-5 text-[#005674] dark:text-[#58a6ff]" />
            Seguridad
          </h2>

          <form @submit.prevent="changePassword" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-[#8b949e] mb-1">
                Contraseña Actual
              </label>
              <input
                v-model="passwordForm.current"
                type="password"
                class="w-full px-3 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
                required
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-[#8b949e] mb-1">
                Nueva Contraseña
              </label>
              <input
                v-model="passwordForm.new"
                type="password"
                class="w-full px-3 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
                required
                minlength="8"
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-[#8b949e] mb-1">
                Confirmar Nueva Contraseña
              </label>
              <input
                v-model="passwordForm.confirm"
                type="password"
                class="w-full px-3 py-2 border border-gray-300 dark:border-[#30363d] rounded-lg focus:ring-2 focus:ring-[#005674] dark:focus:ring-[#58a6ff] focus:border-transparent bg-white dark:bg-[#0f1419] text-gray-900 dark:text-[#e6edf3]"
                required
              >
            </div>

            <button
              type="submit"
              :disabled="changingPassword"
              class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
              <Loader2 v-if="changingPassword" class="w-4 h-4 animate-spin" />
              {{ changingPassword ? 'Cambiando...' : 'Cambiar Contraseña' }}
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Toast de notificación -->
    <Transition
      enter-active-class="transform ease-out duration-300 transition"
      enter-from-class="translate-y-2 opacity-0"
      enter-to-class="translate-y-0 opacity-100"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="notification.show"
        class="fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 z-50"
        :class="notification.type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'"
      >
        <Check v-if="notification.type === 'success'" class="w-5 h-5" />
        <X v-else class="w-5 h-5" />
        {{ notification.message }}
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../../stores/auth';
import { usePreferencesStore } from '../../stores/preferences';
import axios from 'axios';
import {
  User,
  Save,
  Loader2,
  Globe,
  Check,
  X,
  Lock
} from 'lucide-vue-next';

const authStore = useAuthStore();
const preferencesStore = usePreferencesStore();

// Formularios
const profileForm = ref({
  name: '',
  email: '',
  phone: '',
  position: ''
});

const passwordForm = ref({
  current: '',
  new: '',
  confirm: ''
});

const selectedLanguage = ref(preferencesStore.currentLanguage);

const availableLanguages = [
  { code: 'es', name: 'Español', nativeName: 'Español', flag: '🇪🇸' },
  { code: 'en', name: 'English', nativeName: 'English', flag: '🇺🇸' },
];

// Estados
const saving = ref(false);
const changingPassword = ref(false);
const notification = ref({
  show: false,
  type: 'success',
  message: ''
});

// Cargar datos del usuario
onMounted(() => {
  const user = authStore.user;
  if (user) {
    profileForm.value = {
      name: user.name || '',
      email: user.email || '',
      phone: user.phone || '',
      position: user.position || ''
    };
  }
});

// Guardar perfil
const saveProfile = async () => {
  saving.value = true;
  try {
    const response = await axios.put('/api/user/profile', profileForm.value);
    authStore.updateUser(response.data.data);
    showNotification('success', 'Perfil actualizado correctamente');
  } catch (error) {
    showNotification('error', error.response?.data?.message || 'Error al actualizar perfil');
  } finally {
    saving.value = false;
  }
};

// Cambiar idioma
const changeLanguage = () => {
  preferencesStore.setLanguage(selectedLanguage.value);
  showNotification('success', `Idioma cambiado a ${availableLanguages.find(l => l.code === selectedLanguage.value)?.name}`);
};

// Cambiar contraseña
const changePassword = async () => {
  if (passwordForm.value.new !== passwordForm.value.confirm) {
    showNotification('error', 'Las contraseñas no coinciden');
    return;
  }

  if (passwordForm.value.new.length < 8) {
    showNotification('error', 'La contraseña debe tener al menos 8 caracteres');
    return;
  }

  changingPassword.value = true;
  try {
    await axios.put('/api/user/password', {
      current_password: passwordForm.value.current,
      new_password: passwordForm.value.new
    });
    showNotification('success', 'Contraseña actualizada correctamente');
    passwordForm.value = { current: '', new: '', confirm: '' };
  } catch (error) {
    showNotification('error', error.response?.data?.message || 'Error al cambiar contraseña');
  } finally {
    changingPassword.value = false;
  }
};

// Mostrar notificación
const showNotification = (type, message) => {
  notification.value = { show: true, type, message };
  setTimeout(() => {
    notification.value.show = false;
  }, 3000);
};
</script>
