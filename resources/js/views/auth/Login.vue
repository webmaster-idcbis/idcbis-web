<template>
  <div class="min-h-screen bg-gradient-to-br from-[#005674] to-[#008996] flex items-center justify-center p-4">
    <div class="w-full max-w-md">
      <!-- Logo -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-white">IDCBIS</h1>
        <p class="text-white/80 text-sm mt-2">Panel de Administración</p>
      </div>
      
      <!-- Login Form -->
      <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6 text-center">
          Iniciar Sesión
        </h2>
        
        <form @submit.prevent="handleLogin" class="space-y-5">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Correo electrónico
            </label>
            <div class="relative">
              <Mail class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
              <input 
                v-model="form.email"
                type="email" 
                required
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] focus:border-transparent"
                placeholder="admin@idcbis.org.co"
              >
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Contraseña
            </label>
            <div class="relative">
              <Lock class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
              <input 
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                required
                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#005674] focus:border-transparent"
                placeholder="••••••••"
              >
              <button 
                type="button"
                @click="showPassword = !showPassword"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
              >
                <Eye v-if="!showPassword" class="w-5 h-5" />
                <EyeOff v-else class="w-5 h-5" />
              </button>
            </div>
          </div>
          
          <div class="flex items-center justify-between">
            <label class="flex items-center">
              <input 
                v-model="form.remember"
                type="checkbox" 
                class="w-4 h-4 text-[#005674] border-gray-300 rounded focus:ring-[#005674]"
              >
              <span class="ml-2 text-sm text-gray-600">Recordarme</span>
            </label>
            <a href="#" class="text-sm text-[#005674] hover:text-[#003C5F]">
              ¿Olvidaste tu contraseña?
            </a>
          </div>
          
          <button 
            type="submit"
            :disabled="loading"
            class="w-full py-3 bg-[#005674] text-white font-semibold rounded-lg hover:bg-[#003C5F] disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            <span v-if="!loading">Ingresar</span>
            <span v-else class="flex items-center justify-center">
              <Loader class="w-5 h-5 animate-spin mr-2" />
              Ingresando...
            </span>
          </button>
        </form>
        
        <p v-if="error" class="mt-4 text-center text-red-600 text-sm">
          {{ error }}
        </p>
      </div>
      
      <!-- Back to site -->
      <div class="text-center mt-6">
        <router-link to="/" class="text-white/80 hover:text-white text-sm">
          ← Volver al sitio web
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';
import { Mail, Lock, Eye, EyeOff, Loader } from 'lucide-vue-next';

const router = useRouter();
const authStore = useAuthStore();

const form = ref({
  email: '',
  password: '',
  remember: false
});

const showPassword = ref(false);
const loading = ref(false);
const error = ref('');

const handleLogin = async () => {
  loading.value = true;
  error.value = '';
  
  try {
    await authStore.login({
      email: form.value.email,
      password: form.value.password
    });
    router.push('/admin');
  } catch (err) {
    error.value = err.response?.data?.message || 'Credenciales inválidas';
  } finally {
    loading.value = false;
  }
};
</script>
