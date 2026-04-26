import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null);
  const token = ref(localStorage.getItem('token'));
  const permissions = ref([]);
  const roles = ref([]);

  const isAuthenticated = computed(() => !!token.value);
  const isAdmin = computed(() => roles.value.includes('admin'));
  const isEditor = computed(() => roles.value.includes('editor') || roles.value.includes('admin'));

  const setAuth = (userData, authToken) => {
    user.value = userData;
    token.value = authToken;
    roles.value = userData.roles || [];
    permissions.value = userData.permissions || [];
    localStorage.setItem('token', authToken);
    axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;
  };

  const clearAuth = () => {
    user.value = null;
    token.value = null;
    roles.value = [];
    permissions.value = [];
    localStorage.removeItem('token');
    delete axios.defaults.headers.common['Authorization'];
  };

  const login = async (credentials) => {
    const response = await axios.post('/api/login', credentials);
    setAuth(response.data.user, response.data.token);
    return response.data;
  };

  const logout = async () => {
    try {
      await axios.post('/api/logout');
    } finally {
      clearAuth();
    }
  };

  const fetchUser = async () => {
    if (!token.value) return;
    try {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
      const response = await axios.get('/api/user');
      user.value = response.data;
      roles.value = response.data.roles || [];
      permissions.value = response.data.permissions || [];
    } catch (error) {
      clearAuth();
    }
  };

  const hasPermission = (permission) => {
    return permissions.value.includes(permission) || isAdmin.value;
  };

  return {
    user,
    token,
    permissions,
    roles,
    isAuthenticated,
    isAdmin,
    isEditor,
    login,
    logout,
    fetchUser,
    hasPermission,
    clearAuth
  };
});
