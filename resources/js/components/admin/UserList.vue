<template>
    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
      <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
          <div id="kt_app_content_container" class="app-container  container-fluid ">

            <div class="card card-flush ">
              <div class="card-header mt-6">
                <div class="card-title">
                  <div class="d-flex align-items-center position-relative my-1 me-5">

                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                      <span class="path1"></span>
                      <span class="path2"></span>
                    </i>
                    <input v-model="keywords" @keyup.enter="doSearch" type="text" data-kt-permissions-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari ..." />

                  </div>
                </div>
                <div class="card-toolbar">

                    <router-link to="/admin/user/add" class="btn btn-light-primary" >

                        <i class="ki-duotone ki-plus-square fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i> Tambah

                    </router-link>

                </div>
              </div>
              <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">User</th>
                        <th class="min-w-125px">Email</th>
                        <th class="min-w-250px">Role</th>
                        <th class="min-w-125px">Tgl.Dibuat</th>
                        <th class="text-end min-w-100px">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600 listData">

                        <tr v-for="row in userData" :key="row.id">
                        <td>
                            <div class="d-flex flex-column">
                                <div>{{ row.name }}</div>
                            </div>
                        </td>
                        <td> {{ row.email }} </td>
                        <td>
                            <div class="badge badge-light-primary fs-7 m-1">{{ row.role }}</div>
                        </td>
                        <td> <span class="small">{{ row.formattedCreatedAt }}</span>  </td>
                        <td class="text-end">

                            <router-link :to="'/admin/user/edit/' + row.id" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3 btnEdit" >
                                <i class="ki-duotone ki-notepad-edit fs-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </router-link>

                            <button class="btn btn-icon btn-active-light-primary w-30px h-30px btnDelete"  data-id="{{ row.id }}" data-name="{{ row.name }}" @click="showDeleteModal(row)">
                            <i class="ki-duotone ki-trash fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                            </button>

                        </td>
                        </tr>


                    </tbody>
                    <tfoot>
                        <div class="d-flex mt-5">
                            <button class="btn btn-sm btn-primary" @click="goPrev">Prev</button>
                            <button class="btn btn-sm btn-primary ms-2" @click="goNext">Next</button>
                        </div>
                    </tfoot>
                    </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Modal confirm delete -->
    <ModalConfirm v-if="modalConfirm" @close="modalConfirm = false" >
        <div class="d-flex flex-column">
            <div class="mb-5">Apakah akan menghapus data <strong>{{ userNameDelete }}</strong> ini ? </div>
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-sm btn-primary" @click="doDelete(userIdDelete)">Hapus</button>
                <button class="btn btn-sm btn-secondary ms-2" @click="modalConfirm = false">Tutup</button>
            </div>
        </div>
    </ModalConfirm>


</template>
<script>

import qs from 'qs';
import { useToast } from "vue-toastification";
import ModalConfirm from '../partials/ModalConfirm.vue';
import userServices from '../../services/userServices';

export default {
  components: {
    ModalConfirm,
  },
  data() {
    return {
      userData: [],
      page: 1,
      limit: 5,
      pageTotal: 0,
      keywords: '',
      modalConfirm: false,
      deleteConfirmText: 'tesss',
      userNameDelete: '',
      userIdDelete: '',
    };
  },
  setup() {
      const toast = useToast();
      return { toast }
    },
  created() {
    this.page = 1;
    this.pageCount = 1;

    this.limit = 5;
    //this.loadUserData(this.page, this.limit, this.keywords);
    const res =  this.loadUserData(this.pageCount, this.limit, this.keywords);
    res.then((data) => {
        this.pageTotal = data.pageTotal;
    });
  },
  methods: {
    async loadUserData(page, limit, keywords) {

        try {

            const res = await userServices.getAll(page, limit, keywords);
            this.userData = res.data;
            this.pageTotal = res.pageTotal;
            return res;

        } catch (error){

            console.log(error.response);

        }

    },
    async doSearch() {
        const res = await this.loadUserData(this.pageCount, this.limit, this.keywords);
    },
    goPrev: async function () {

        if (this.pageCount > 0) {
            this.pageCount--;
            const res = await this.loadUserData(this.pageCount, this.limit, this.keywords);
        }
    },
    goNext: async function () {
        this.pageCount++;
        if (this.pageCount <= this.pageTotal) {
            const res = await this.loadUserData(this.pageCount, this.limit, this.keywords);
        }
    },
    showDeleteModal(payload) {
        this.modalConfirm = !this.modalConfirm;
        this.userNameDelete = payload.name;
        this.userIdDelete = payload.id;
    },
    async doDelete(id){

        const formData = qs.stringify({id:id});

        try {

            const res = await userServices.delete(formData);

            if(res.code==200){
                this.toast.success(res.message);
                this.loadUserData(this.pageCount, this.limit, this.keywords);
            }else{
                this.toast.error(res.message);
            }

            this.modalConfirm = !this.modalConfirm;

        } catch (error){
            //this.toast.error(res.message);
            console.log(error);

        }



    },

  },
};
</script>
