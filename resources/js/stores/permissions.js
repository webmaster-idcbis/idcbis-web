import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const usePermissionsStore = defineStore('permissions', () => {
  const permissions = ref([]);
  const groupedPermissions = ref({});
  const modules = ref([]);
  const currentPermission = ref(null);
  const loading = ref(false);

  const fetchPermissions = async () => {
    loading.value = true;
    try {
      const response = await axios.get('/api/permissions');
      permissions.value = response.data.data;
    } finally {
      loading.value = false;
    }
  };

  const fetchPermission = async (id) => {
    loading.value = true;
    try {
      const response = await axios.get(`/api/permissions/${id}`);
      currentPermission.value = response.data.data;
      return currentPermission.value;
    } finally {
      loading.value = false;
    }
  };

  const fetchGrouped = async () => {
    try {
      const response = await axios.get('/api/permissions-grouped');
      groupedPermissions.value = response.data.data;
    } catch (error) {
      console.error('Error fetching grouped permissions:', error);
    }
  };

  const fetchModules = async () => {
    try {
      const response = await axios.get('/api/permission-modules');
      modules.value = response.data.data;
    } catch (error) {
      console.error('Error fetching modules:', error);
    }
  };

  const createPermission = async (permissionData) => {
    const response = await axios.post('/api/permissions', permissionData);
    permissions.value.push(response.data.data);
    return response.data.data;
  };

  const updatePermission = async (id, permissionData) => {
    const response = await axios.put(`/api/permissions/${id}`, permissionData);
    const index = permissions.value.findIndex(p => p.id === id);
    if (index !== -1) {
      permissions.value[index] = response.data.data;
    }
    return response.data.data;
  };

  const deletePermission = async (id) => {
    await axios.delete(`/api/permissions/${id}`);
    permissions.value = permissions.value.filter(p => p.id !== id);
  };

  // Grouped by module for display
  const permissionsByModule = computed(() => {
    const grouped = {};
    permissions.value.forEach(perm => {
      if (!grouped[perm.module]) {
        grouped[perm.module] = [];
      }
      grouped[perm.module].push(perm);
    });
    return grouped;
  });

  // Helper functions for labels
  const getModuleLabel = (module) => {
    const labels = {
      'pages': 'Páginas',
      'users': 'Usuarios',
      'roles': 'Roles',
      'permissions': 'Permisos',
      'settings': 'Configuración'
    };
    return labels[module] || module;
  };

  const getActionLabel = (action) => {
    const labels = {
      'view': 'Ver',
      'create': 'Crear',
      'edit': 'Editar',
      'delete': 'Eliminar',
      'publish': 'Publicar'
    };
    return labels[action] || action;
  };

  const getPermissionFullLabel = (permissionName) => {
    const parts = permissionName.split('.');
    const module = parts[0] || 'other';
    const action = parts[1] || parts[0];
    return `${getActionLabel(action)} ${getModuleLabel(module)}`;
  };

  return {
    permissions,
    groupedPermissions,
    modules,
    currentPermission,
    loading,
    permissionsByModule,
    fetchPermissions,
    fetchPermission,
    fetchGrouped,
    fetchModules,
    createPermission,
    updatePermission,
    deletePermission,
    getModuleLabel,
    getActionLabel,
    getPermissionFullLabel
  };
});
