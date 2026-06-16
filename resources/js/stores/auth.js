import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('user') || 'null'));
  const token = ref(localStorage.getItem('token'));
  const permissions = ref(JSON.parse(localStorage.getItem('permissions') || '[]'));
  const roles = ref(JSON.parse(localStorage.getItem('roles') || '[]'));

  // Configure axios header on init if token exists
  if (token.value) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
  }

  const isAuthenticated = computed(() => !!token.value);
  const isAdmin = computed(() => roles.value.includes('admin'));
  const isEditor = computed(() => roles.value.includes('editor') || roles.value.includes('admin'));

  const setAuth = (userData, authToken) => {
    user.value = userData;
    token.value = authToken;
    roles.value = userData.roles || [];
    permissions.value = userData.permissions || [];
    localStorage.setItem('token', authToken);
    localStorage.setItem('user', JSON.stringify(userData));
    localStorage.setItem('roles', JSON.stringify(userData.roles || []));
    localStorage.setItem('permissions', JSON.stringify(userData.permissions || []));
    axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;
  };

  const clearAuth = () => {
    user.value = null;
    token.value = null;
    roles.value = [];
    permissions.value = [];
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    localStorage.removeItem('roles');
    localStorage.removeItem('permissions');
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
      localStorage.setItem('user', JSON.stringify(response.data));
      localStorage.setItem('roles', JSON.stringify(response.data.roles || []));
      localStorage.setItem('permissions', JSON.stringify(response.data.permissions || []));
    } catch (error) {
      // Only clear auth if token is invalid (401), not for network/server errors
      if (error.response?.status === 401) {
        clearAuth();
      }
      throw error;
    }
  };

  const hasPermission = (permission) => {
    return permissions.value.includes(permission) || isAdmin.value;
  };

  const updateUser = (newUserData) => {
    user.value = { ...user.value, ...newUserData };
    localStorage.setItem('user', JSON.stringify(user.value));
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
    clearAuth,
    updateUser
  };
});
