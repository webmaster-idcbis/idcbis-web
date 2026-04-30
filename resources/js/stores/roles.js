import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useRolesStore = defineStore('roles', () => {
  const roles = ref([]);
  const permissions = ref([]);
  const currentRole = ref(null);
  const loading = ref(false);

  const fetchRoles = async () => {
    loading.value = true;
    try {
      const response = await axios.get('/api/roles');
      roles.value = response.data.data;
    } finally {
      loading.value = false;
    }
  };

  const fetchRole = async (id) => {
    loading.value = true;
    try {
      const response = await axios.get(`/api/roles/${id}`);
      currentRole.value = response.data.data;
      return currentRole.value;
    } finally {
      loading.value = false;
    }
  };

  const fetchPermissions = async () => {
    try {
      const response = await axios.get('/api/permissions');
      permissions.value = response.data.data;
    } catch (error) {
      console.error('Error fetching permissions:', error);
    }
  };

  const createRole = async (roleData) => {
    const response = await axios.post('/api/roles', roleData);
    roles.value.push(response.data.data);
    return response.data.data;
  };

  const updateRole = async (id, roleData) => {
    const response = await axios.put(`/api/roles/${id}`, roleData);
    const index = roles.value.findIndex(r => r.id === id);
    if (index !== -1) {
      roles.value[index] = response.data.data;
    }
    return response.data.data;
  };

  const deleteRole = async (id) => {
    await axios.delete(`/api/roles/${id}`);
    roles.value = roles.value.filter(r => r.id !== id);
  };

  // Grouped permissions for display
  const groupedPermissions = computed(() => {
    const grouped = {};
    permissions.value.forEach(permission => {
      const parts = permission.name.split('.');
      const module = parts[0] || 'other';
      if (!grouped[module]) {
        grouped[module] = [];
      }
      grouped[module].push(permission);
    });
    return grouped;
  });

  const getPermissionLabel = (permissionName) => {
    const labels = {
      'view': 'Ver',
      'create': 'Crear',
      'edit': 'Editar',
      'delete': 'Eliminar',
      'publish': 'Publicar'
    };
    
    const parts = permissionName.split('.');
    const action = parts[1] || parts[0];
    const module = parts[0];
    
    const moduleLabels = {
      'pages': 'Páginas',
      'users': 'Usuarios',
      'roles': 'Roles',
      'settings': 'Configuración'
    };
    
    return {
      action: labels[action] || action,
      module: moduleLabels[module] || module,
      full: `${labels[action] || action} ${moduleLabels[module] || module}`
    };
  };

  return {
    roles,
    permissions,
    currentRole,
    loading,
    groupedPermissions,
    fetchRoles,
    fetchRole,
    fetchPermissions,
    createRole,
    updateRole,
    deleteRole,
    getPermissionLabel
  };
});
