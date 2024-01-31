// resources/js/router.js
import { createRouter, createWebHistory } from 'vue-router';
import { getAuthUser } from './config';
import BlankLayout from './components/layouts/Blank.vue';
import DefaultLayout from './components/layouts/Default.vue';
import AdminBlankLayout from './components/admin/layouts/Blank.vue';
import AdminDefaultLayout from './components/admin/layouts/Default.vue';

import Home from './components/publics/Home.vue';
import About from './components/publics/About.vue';
import Login from './components/publics/Login.vue';

import MemberHome from './components/publics/member/MemberHome.vue';

import AdminLogin from './components/admin/Login.vue';
import AdminHome from './components/admin/Home.vue';
import AdminUser from './components/admin/UserList.vue';
import AdminUserForm from './components/admin/UserForm';
import AdminCategory from './components/admin/CategoryList.vue';
import AdminCategoryForm from './components/admin/CategoryForm';
import AdminProject from './components/admin/ProjectList.vue';
import AdminProjectTrash from './components/admin/ProjectListTrash.vue';
import AdminProjectForm from './components/admin/ProjectForm';


const routes = [
  {
    path: '/',
    component: DefaultLayout,
    children: [
      {
        path: '',
        component: Home,
      },
      {
        path: '/tentang-kami',
        component: About,
      },
      {
        path: '/member',
        component: MemberHome,
      },
    ],
  },
  {
    path: '/login',
    component: BlankLayout,
    children: [
      { path: '', component: Login },
    ],
  },
  {
    path: '/admin',
    component: AdminBlankLayout,
    children: [
      { path: '', component: AdminLogin },
    ],
  },
  {
    path: '/admin/home',
    component: AdminDefaultLayout,
    children: [
      { path: '', component: AdminHome, meta: { requiresAdmin: true, title: 'Dashboard', mode: 'view', },  },
    ],
  },
  {
    path: '/admin/user',
    component: AdminDefaultLayout,
    children: [
      { path: '',name: 'userViewRoute', component: AdminUser, meta: { requiresAdmin: true, title: 'Daftar User', mode: 'view', },  },
      { path: 'add',name: 'userAddRoute', component: AdminUserForm, meta: { requiresAdmin: true, title: 'Form Tambah User', mode: 'add', },  },
      { path: 'edit/:id',name: 'userEditRoute', component: AdminUserForm, props: true, meta: { requiresAdmin: true, title: 'Form Edit User', mode: 'edit', },  },
    ],
  },
  {
    path: '/admin/category',
    component: AdminDefaultLayout,
    children: [
      { path: '', component: AdminCategory, meta: { requiresAdmin: true, title: 'Daftar Kategori', mode: 'view', },  },
      { path: 'add',name: 'categoryAddRoute', component: AdminCategoryForm, meta: { requiresAdmin: true, title: 'Form Tambah Kategori', mode: 'add', },  },
      { path: 'edit/:id',name: 'categoryEditRoute', component: AdminCategoryForm, props: true, meta: { requiresAdmin: true, title: 'Form Edit Kategori', mode: 'edit', },  },
    ],
  },
  {
    path: '/admin/project',
    component: AdminDefaultLayout,
    children: [
      { path: '', component: AdminProject, meta: { requiresAdmin: true, title: 'Daftar Project', mode: 'view', },  },
      { path: 'trash', component: AdminProjectTrash, meta: { requiresAdmin: true, title: 'Daftar Project Terhapus', mode: 'view', },  },
      { path: 'add',name: 'projectAddRoute', component: AdminProjectForm, meta: { requiresAdmin: true, title: 'Form Tambah Proyek', mode: 'add', },  },
      { path: 'edit/:id',name: 'projectEditRoute', component: AdminProjectForm, props: true, meta: { requiresAdmin: true, title: 'Form Edit Proyek', mode: 'edit', },  },
      { path: 'show/:id',name: 'projectShowRoute', component: AdminProjectForm, props: true, meta: { requiresAdmin: true, title: 'Form View Proyek', mode: 'view', },  },
    ],
  },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation Guard
router.beforeEach((to, from, next) => {

    const authUser = getAuthUser();
    document.title = to.meta.title || 'Default Title';
    document.mode = to.meta.mode || 'add';

    // Check if the route requires admin role
    if (to.meta.requiresAdmin) {
      // Check if the user has the admin role
      if (authUser && (authUser.role === 'admin' || authUser.role === 'staf' )) {
        // User has admin role, proceed to the route
        next();
      } else {
        // User does not have admin role, redirect to /admin
        next('/admin');
      }
    } else if (to.meta.requiresMember) {
      // Check if the route requires member role
      if (authUser && authUser.role === 'buyer') {
        // User has member role, proceed to the route
        next();
      } else {
        // User does not have member role, redirect to /login or another route
        next('/login');
      }
    } else {
      // Route does not require admin or member role, proceed
      next();
    }
  });

export default router;
