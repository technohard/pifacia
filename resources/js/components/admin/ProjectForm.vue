<template>
    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
      <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
          <div id="kt_app_content_container" class="app-container  container-fluid ">
            <form action="" autocomplete="off">

              <input v-model="projectData.id" type="hidden" name="id" id="id">
              <input v-model="projectData.mode" type="hidden" name="mode" id="mode">

              <div class="card card-flush ">
                <div class="card-body p-5">


                  <div class="row mb-5">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Nama</label>
                        <input v-model="projectData.name"  type="text" class="form-control" id="name" name="name" placeholder="masukkan nama" :class="{ 'is-invalid': isNameInvalid }">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Vendor</label>
                        <input v-model="projectData.vendor"  type="text" class="form-control" id="vendor" name="vendor" placeholder="masukkan vendor" :class="{ 'is-invalid': isVendorInvalid }">
                      </div>
                    </div>
                  </div>

                  <div class="row mb-5">
                    <div class="col">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label fs-6 fw-bold text-gray-700">Material</label>
                                <button type="button" class="btn btn-primary btn-sm" @click="addMaterial">Tambah Material</button>
                            </div>
                            <div class="card shadow p-5">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td class="fs-6 fw-bold text-gray-700" >Nama Material</td>
                                                <td class="fs-6 fw-bold text-gray-700" >Satuan</td>
                                                <td class="fs-6 fw-bold text-gray-700">Qty</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div>Semen</div>
                                                </td>
                                                <td>
                                                    <div>Ton</div>
                                                </td>
                                                <td>
                                                    <div class="">2</div>
                                                </td>
                                                <td>


                                                    <div class="d-flex align-items-center justify-content-end">

                                                        <router-link :to="'/admin/project/material/edit/'" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3 btnEdit" >
                                                            <i class="ki-duotone ki-notepad-edit fs-3">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </router-link>

                                                        <button class="btn btn-icon btn-active-light-primary w-30px h-30px btnDelete"  data-id="" data-name="" @click="">
                                                            <i class="ki-duotone ki-trash fs-3">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                            </i>
                                                        </button>

                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                  </div>

                  <div class="row mb-5">
                    <div class="col">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label fs-6 fw-bold text-gray-700">Pekerja</label>
                                <button type="button" class="btn btn-primary btn-sm" @click="addWorker">Tambah Pekerja</button>
                            </div>
                            <div class="card shadow p-5">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td class="fs-6 fw-bold text-gray-700" >Nama Pekerja</td>
                                                <td class="fs-6 fw-bold text-gray-700">Tugas</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div>Suseno</div>
                                                </td>
                                                <td>
                                                    <div>Mengaduk Semen</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>Djoko</div>
                                                </td>
                                                <td>
                                                    <div>Pasang Plafon</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                  </div>


                </div>
                <div class="card-footer">
                  <div class="row mb-5">
                    <div class="col">
                      <button type="button" class="btn btn-primary" @click="doSimpan">Simpan</button>
                      <router-link to="/admin/project" class="btn btn-dark ms-3" >Tutup</router-link>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</template>

<script>

import { useToast } from "vue-toastification";
import projectServices from "../../services/projectServices";
import qs from 'qs';

export default {
    data() {
        return {
            isNameInvalid: false,
            isVendorInvalid: false,
            projectData: {
                id: '',
                name: '',
                vendor: '',
                mode: '',
            },
        };
    },
    setup() {
      const toast = useToast();
      return { toast }
    },
    created() {
        this.projectData.mode = this.$route.meta.mode || 'view';
        this.projectData.id = this.$route.params.id || '';
        if(this.projectData.mode=='edit'){
            this.getProjectById(this.projectData.id);
        }
    },
    methods: {
      async doSimpan() {

        this.isNameInvalid = false;
        this.isVendorInvalid = false;

        if(this.projectData.name==''){
            this.isNameInvalid = true;
            return false;
        }

        if(this.projectData.name==''){
            this.isVendorInvalid = true;
            return false;
        }

        if(this.projectData.mode=='add'){

            this.projectData.id = "";

        }

        const formData = qs.stringify(this.projectData);
        const response = await projectServices.store(formData);

        if(response.data.code==200){
            this.toast.success(response.data.message);
            if(this.projectData.mode=='add'){
                this.clearForm();
            }
        }else{
            this.toast.error(response.data.message);
        }

      },
      async getProjectById(id) {
        const response = await projectServices.getById(id);
        this.projectData = response.data.data;
        //must add mode becasue mode is missing when receiving data
        this.projectData.id = id;
        this.projectData.mode = 'edit';
      },
      clearForm(){
        this.projectData  = {
                id: '',
                name: '',
                vendor: '',
                mode: 'add',
            };
        },
    },


}
</script>
