<template>
    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
      <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
          <div id="kt_app_content_container" class="app-container  container-fluid ">
            <form action="" autocomplete="off">

              <input v-model="categoryData.id" type="hidden" name="id" id="id">
              <input v-model="categoryData.mode" type="hidden" name="mode" id="mode">

              <div class="card card-flush ">
                <div class="card-body p-5">


                  <div class="row mb-5">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Nama</label>
                        <input v-model="categoryData.name"  type="text" class="form-control" id="name" name="name" placeholder="masukkan nama" :class="{ 'is-invalid': isNameInvalid }">
                      </div>
                    </div>

                  </div>

                </div>
                <div class="card-footer">
                  <div class="row mb-5">
                    <div class="col">
                      <button type="button" class="btn btn-primary" @click="doSimpan">Simpan</button>
                      <router-link to="/admin/category" class="btn btn-dark ms-3" >Tutup</router-link>
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
import categoryServices from "../../services/categoryServices";
import qs from 'qs';

export default {
    data() {
        return {
            isNameInvalid: false,
            categoryData: {
                id: '',
                name: '',
                mode: '',
            },
        };
    },
    setup() {
      const toast = useToast();
      return { toast }
    },
    created() {
        this.categoryData.mode = this.$route.meta.mode || 'view';
        this.categoryData.id = this.$route.params.id || '';
        if(this.categoryData.mode=='edit'){
            this.getCategoryById(this.categoryData.id);
        }
    },
    methods: {
      async doSimpan() {

        this.isNameInvalid = false;


        if(this.categoryData.name==''){
            this.isNameInvalid = true;
            return false;
        }

        if(this.categoryData.mode=='add'){

            this.categoryData.id = "";

        }

        const formData = qs.stringify(this.categoryData);
        const response = await categoryServices.store(formData);

        if(response.data.code==200){
            this.toast.success(response.data.message);
            if(this.categoryData.mode=='add'){
                this.clearForm();
            }
        }else{
            this.toast.error(response.data.message);
        }

      },
      async getCategoryById(id) {
        const response = await categoryServices.getById(id);
        this.categoryData = response.data.data;
        //must add mode becasue mode is missing when receiving data
        this.categoryData.id = id;
        this.categoryData.mode = 'edit';
      },
      clearForm(){
        this.categoryData  = {
                id: '',
                name: '',
                mode: 'add',
            };
        },
    },


}
</script>
