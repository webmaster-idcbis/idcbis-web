import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/Page.vue'),
    meta: { homePage: true },
  },
  {
    path: '/admin',
    name: 'Admin',
    component: () => import('../views/admin/AdminLayout.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
    children: [
      {
        path: '',
        name: 'Dashboard',
        component: () => import('../views/admin/Dashboard.vue')
      },
      {
        path: 'pages',
        name: 'Pages',
        component: () => import('../views/admin/Pages.vue')
      },
      {
        path: 'pages/create',
        name: 'CreatePage',
        component: () => import('../views/admin/PageEditor.vue')
      },
      {
        path: 'pages/:id/edit',
        name: 'EditPage',
        component: () => import('../views/admin/PageEditor.vue')
      },
      {
        path: 'users',
        name: 'Users',
        component: () => import('../views/admin/Users.vue')
      },
      {
        path: 'roles',
        name: 'Roles',
        component: () => import('../views/admin/Roles.vue')
      },
      {
        path: 'permissions',
        name: 'Permissions',
        component: () => import('../views/admin/Permissions.vue')
      },
      {
        path: 'menus',
        name: 'Menus',
        component: () => import('../views/admin/Menus.vue')
      },
      {
        path: 'profile',
        name: 'Profile',
        component: () => import('../views/admin/UserProfile.vue')
      }
    ]
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/auth/Login.vue')
  },
  {
    path: '/buscar',
    name: 'Search',
    component: () => import('../views/SearchResults.vue')
  },
  {
    path: '/inicio',
    redirect: '/',
  },
  {
    path: '/:slug',
    name: 'Page',
    component: () => import('../views/Page.vue')
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();

  // If token exists but no user data, try to fetch user
  if (authStore.token && !authStore.user) {
    try {
      await authStore.fetchUser();
    } catch (error) {
      // If 401, token is invalid - redirect to login
      if (error.response?.status === 401) {
        return next('/login');
      }
      // For other errors, continue with cached roles/permissions from localStorage
    }
  }

  if (to.meta.requiresAuth && !authStore.token) {
    return next('/login');
  }

  if (to.meta.requiresAdmin && !authStore.isAdmin) {
    return next('/');
  }

  next();
});

export default router;
