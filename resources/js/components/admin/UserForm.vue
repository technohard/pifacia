<template>
    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
      <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
          <div id="kt_app_content_container" class="app-container  container-fluid ">
            <form action="" autocomplete="off">

              <input v-model="userData.id" type="hidden" name="id" id="id">
              <input v-model="userData.mode" type="hidden" name="mode" id="mode">

              <div class="card card-flush ">
                <div class="card-body p-5">
                  <div class="row mb-5">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Role</label>
                        <select v-model="userData.role" name="role" id="role" class="form-control" :class="{ 'is-invalid': isRoleInvalid }" >
                            <option value="">- Pilih role user -</option>
                            <option value="buyer">Buyer</option>
                            <option value="staf">Staf</option>
                            <option value="admin">Admin</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-5">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Nama</label>
                        <input v-model="userData.name"  type="text" class="form-control" id="name" name="name" placeholder="masukkan nama" :class="{ 'is-invalid': isNameInvalid }">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Username</label>
                        <input  v-model="userData.username" type="text" class="form-control" id="username" name="username" placeholder="masukkan username" autocomplete="new" :class="{ 'is-invalid': isUsernameInvalid }" >
                      </div>
                    </div>
                  </div>
                  <div class="row mb-5">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Email</label>
                        <input  v-model="userData.email" type="text" class="form-control" id="email" name="email" placeholder="masukkan email" autocomplete="off" :class="{ 'is-invalid': isEmailInvalid }" >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Password</label>
                        <input v-model="userData.password" type="password" class="form-control" id="password" name="password" placeholder="masukkan password" autocomplete="off" :class="{ 'is-invalid': isPasswordInvalid }" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row mb-5">
                    <div class="col">
                      <button type="button" class="btn btn-primary" @click="doSimpan">Simpan</button>
                      <router-link to="/admin/user" class="btn btn-dark ms-3" >Tutup</router-link>
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

import { isValidEmail } from '../../config';
import { useToast } from "vue-toastification";
import userServices from "../../services/userServices";
import qs from 'qs';

export default {
    data() {
        return {
            isRoleInvalid: false,
            isNameInvalid: false,
            isUsernameInvalid: false,
            isEmailInvalid: false,
            isPasswordInvalid: false,
            userData: {
                id: '',
                role: '',
                name: '',
                username: '',
                email: '',
                password: '',
                mode: '',
            },
        };
    },
    setup() {
      const toast = useToast();
      return { toast }
    },
    created() {
        this.userData.mode = this.$route.meta.mode || 'view';
        this.userData.id = this.$route.params.id || '';
        if(this.userData.mode=='edit'){
            this.getUserById(this.userData.id);
        }
    },
    methods: {
      async doSimpan() {

        this.isRoleInvalid = false;
        this.isNameInvalid = false;
        this.isUsernameInvalid = false;
        this.isEmailInvalid = false;
        this.isPasswordInvalid = false;

        if(this.userData.role==''){
            this.isRoleInvalid = true;
            return false;
        }

        if(this.userData.name==''){
            this.isNameInvalid = true;
            return false;
        }
        if(this.userData.username==''){
            this.isUsernameInvalid = true;
            return false;
        }
        if(this.userData.email=='' || !isValidEmail(this.userData.email)){
            this.isEmailInvalid = true;
            return false;
        }

        if(this.userData.mode=='add'){

            if(this.userData.password==''){
                this.isPasswordInvalid = true;
                return false;
            }

            this.userData.id = "";

        }

        const formData = qs.stringify(this.userData);
        const response = await userServices.store(formData);

        if(response.data.code==200){
            this.toast.success(response.data.message);
            if(this.userData.mode=='add'){
                this.clearForm();
            }
        }else{
            this.toast.error(response.data.message);
        }

      },
      async getUserById(id) {
        const response = await userServices.getById(id);
        this.userData = response.data.data;
        //must add mode becasue mode is missing when receiving data
        this.userData.id = id;
        this.userData.mode = 'edit';
      },
      clearForm(){
        this.userData  = {
                id: '',
                role: '',
                name: '',
                username: '',
                email: '',
                password: '',
                mode: 'add',
            };
        },
    },


}
</script>
