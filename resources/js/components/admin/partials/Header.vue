<template>
    <div id="kt_app_header" class="app-header ">
      <div class="app-container  container-fluid d-flex align-items-stretch justify-content-between " id="kt_app_header_container">
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
          <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
            <i class="ki-duotone ki-abstract-14 fs-1">
              <span class="path1"></span>
              <span class="path2"></span>
            </i>
          </div>
        </div>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
          <a href="/good/index.html" class="d-lg-none">
            <img alt="Logo" src="/good/assets/media/logos/default.svg" class="h-25px" />
          </a>
        </div>
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
          <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}" class="page-title d-flex flex-column justify-content-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0"> {{ pageTitle }} </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
              <li class="breadcrumb-item text-muted">
                <a href="/good/index.html" class="breadcrumb-link text-muted text-hover-primary"> {{pageTitle}} </a>
              </li>
              <!-- <li class="breadcrumb-item">
                <span class="bullet bg-gray-300 w-5px h-2px"></span>
              </li>
              <li class="breadcrumb-item text-muted"> User Management </li> -->
            </ul>
          </div>
        </div>
      </div>
    </div>
  </template>
 <script>
export default {
    computed: {
     pageTitle() {
        return this.$route.meta.title || 'Dashboard';
     },
   },
    data(){
        return {
        };
    },
}
 </script>
