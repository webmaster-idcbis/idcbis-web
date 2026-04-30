import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useUsersStore = defineStore('users', () => {
  const users = ref([]);
  const roles = ref([]);
  const currentUser = ref(null);
  const loading = ref(false);

  const fetchUsers = async () => {
    loading.value = true;
    try {
      const response = await axios.get('/api/users');
      users.value = response.data.data;
    } finally {
      loading.value = false;
    }
  };

  const fetchUser = async (id) => {
    loading.value = true;
    try {
      const response = await axios.get(`/api/users/${id}`);
      currentUser.value = response.data.data;
      return currentUser.value;
    } finally {
      loading.value = false;
    }
  };

  const fetchRoles = async () => {
    try {
      const response = await axios.get('/api/roles');
      roles.value = response.data.data;
    } catch (error) {
      console.error('Error fetching roles:', error);
      roles.value = [];
    }
  };

  const createUser = async (userData) => {
    const response = await axios.post('/api/users', userData);
    users.value.push(response.data.data);
    return response.data.data;
  };

  const updateUser = async (id, userData) => {
    const response = await axios.put(`/api/users/${id}`, userData);
    const index = users.value.findIndex(u => u.id === id);
    if (index !== -1) {
      users.value[index] = response.data.data;
    }
    return response.data.data;
  };

  const deleteUser = async (id) => {
    await axios.delete(`/api/users/${id}`);
    users.value = users.value.filter(u => u.id !== id);
  };

  const toggleUserStatus = async (id) => {
    const response = await axios.patch(`/api/users/${id}/toggle-status`);
    const index = users.value.findIndex(u => u.id === id);
    if (index !== -1) {
      users.value[index] = response.data.data;
    }
    return response.data.data;
  };

  return {
    users,
    roles,
    currentUser,
    loading,
    fetchUsers,
    fetchUser,
    fetchRoles,
    createUser,
    updateUser,
    deleteUser,
    toggleUserStatus
  };
});
