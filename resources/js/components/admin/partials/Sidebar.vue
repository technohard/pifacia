<template>
    <div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
            <div class="app-sidebar-logo d-none d-lg-flex flex-stack flex-shrink-0 px-8" id="kt_app_sidebar_logo">
                <router-link to="/admin/home" >
                    <span style="font-size:24px;font-weight: 800;color:#4e74ed;">Projectku Admin</span>
                </router-link>
              <div class="ms-5"></div>
            </div>
            <div class="separator d-none d-lg-block"></div>
            <div class="separator"></div>

            <div class="app-sidebar-user d-flex flex-stack pt-5 px-8">
              <div class="d-flex me-5">
                <div class="me-5">

                    <div class="symbol symbol-40px cursor-pointer" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
                        <img src="/good/assets/media/avatars/300-1.jpg" alt="" />
                    </div>

                </div>
                <div class="me-2">
                  <a href="#" class="app-sidebar-username text-gray-800 text-hover-primary fs-6 fw-semibold lh-0">{{ authUserName }}</a>
                  <span class="app-sidebar-deckription text-gray-500 fw-semibold d-block fs-8">{{ authUserRole }}</span>
                </div>
              </div>

            </div>

            <div class="app-sidebar-menu  hover-scroll-y my-5 my-lg-5 mx-3" id="kt_app_sidebar_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_toolbar, #kt_app_sidebar_footer" data-kt-scroll-offset="0">
              <div class="
                menu
                menu-column
                menu-sub-indention
                menu-active-bg
                fw-semibold" id="#kt_sidebar_menu" data-kt-menu="true">
                <div class="menu-item pt-1">
                  <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">MENU</span>
                  </div>
                </div>
                <div class="menu-item">

                    <router-link to="/admin/home" class="menu-link" :class="{ 'active': $route.path === '/admin/home' }">
                        <span class="menu-icon">
                      <i class="ki-duotone ki-setting                        ">
                        <span class="path1"></span>
                        <span class="path2"></span>
                      </i>
                    </span>
                    <span class="menu-title">Dashboard</span>

                    </router-link>


                </div>
                <div class="menu-item" :class="{ 'd-none': authUserRole === 'staf' }" >
                    <router-link to="/admin/user" class="menu-link" :class="{ 'active': ($route.path === '/admin/user' || $route.path === '/admin/user/add' || $route.path.includes('/admin/user/edit')  ) }">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-setting                        ">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                    <span class="menu-title">User</span>
                    </router-link>
                </div>
                <div class="menu-item">
                    <router-link to="/admin/category" class="menu-link" :class="{ 'active': ($route.path === '/admin/category' || $route.path === '/admin/category/add' || $route.path.includes('/admin/category/edit') ) }">
                    <span class="menu-icon">
                      <i class="ki-duotone ki-setting                        ">
                        <span class="path1"></span>
                        <span class="path2"></span>
                      </i>
                    </span>
                    <span class="menu-title">Category</span>
                    </router-link>
                </div>
                <div class="menu-item">
                    <router-link to="/admin/project" class="menu-link" :class="{ 'active': ($route.path === '/admin/project' || $route.path === '/admin/project/add' || $route.path.includes('/admin/project/edit') || $route.path.includes('/admin/project/trash') ) }">
                    <span class="menu-icon">
                      <i class="ki-duotone ki-setting                        ">
                        <span class="path1"></span>
                        <span class="path2"></span>
                      </i>
                    </span>
                    <span class="menu-title">Project</span>
                    </router-link>
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="javascript:void(0);" @click="submitLogout" >
                    <span class="menu-icon">
                      <i class="ki-duotone ki-setting                        ">
                        <span class="path1"></span>
                        <span class="path2"></span>
                      </i>
                    </span>
                    <span class="menu-title">Logout</span>
                  </a>
                </div>

              </div>
            </div>

          </div>
</template>

<script>
import axios from 'axios';
import { config, getAuthUser, getAuthToken, clearAuth } from '../../../config';

export default {
    data() {
        return {
            isActiveClass: false,
            authUserName: '',
            authUserRole: '',
        };
    },
    created() {
        const authUser = getAuthUser();
        this.authUserName = authUser.name;
        this.authUserRole = authUser.role;
    },
    methods: {
        async submitLogout() {
            try {
                const authUser = getAuthUser();
                if(authUser){
                    const authToken = getAuthToken();
                    const headers = {
                        Authorization: `Bearer ${authToken}`,
                    };
                    const response = await axios.post(
                        `${config.baseUrl}/api/admin/logout`,
                        {},
                        { headers }
                    );

                }
                clearAuth();
                this.$router.push('/admin');

            } catch (error) {
                console.error('logout failed', error);
            }
        }
    },
}

</script>
