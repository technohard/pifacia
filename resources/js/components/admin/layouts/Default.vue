<template>
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
      <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">

        <Header/>

        <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">

            <Sidebar/>

            <router-view />


        </div>
      </div>
    </div>

    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
      <i class="ki-duotone ki-arrow-up">
        <span class="path1"></span>
        <span class="path2"></span>
      </i>
    </div>

</template>
<script>
import Header from '../partials/Header.vue';
import Sidebar from '../partials/Sidebar.vue';
export default {
    components: {
        Header,
        Sidebar,
    },
};
</script>

