<template>
    <div class="container w-100 h-100">
        <div class="d-flex justify-content-center align-items-center w-100 h-100">
            <div class="card shadow">
                <div class="card-body">

              <form class="col-md-4" style="width:340px;"  >
                <div class="text-center mb-1">
                    <a href="/" style="color:#4e74ed;font-weight: 800;font-size:36px;" >
                        Projectku
                    </a>
                </div>
                <div class="text-center mb-5">
                  <h1 class="text-gray-900 mb-3 fw-bold"> Admin Login </h1>
                </div>
                <div class="fv-row mb-5">
                  <label class="form-label fs-6 fw-bold text-gray-900">Email</label>
                  <input v-model="username" class="form-control form-control-lg form-control-solid enail" :class="{ 'is-invalid': isEmailEmpty || isEmailInvalid }" type="text" name="username" autocomplete="off" />
                  <div class="invalid-feedback">
                    harap input email dengan benar.
                  </div>
                </div>
                <div class="fv-row mb-3">
                  <div class="d-flex flex-stack mb-2">
                    <label class="form-label fw-bold text-gray-900 fs-6 mb-0">Password</label>
                  </div>
                  <input v-model="password" class="form-control form-control-lg form-control-solid password"  :class="{ 'is-invalid': isPasswordEmpty }" type="password" name="password" autocomplete="off" />
                  <div class="invalid-feedback">
                    harap input password dengan benar.
                  </div>
                </div>
                <div class="fv-row mb-10">
                    <span v-show="showError" class="text-danger errorMsg">{{ errorMsg }}</span>
                </div>
                <div class="text-center">
                  <button type="button" id="kt_sign_in_submit" @click="submitLogin" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label"> Masuk </span>
                    <span class="indicator-progress"> Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                  </button>

                </div>
            </form>

                </div>
            </div>


        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { config, isValidEmail } from '../../config';

export default {
    data(){
        return {
            username: '',
            password: '',
            errorMsg: '',
            showError: false,
            isEmailEmpty: false,
            isEmailInvalid: false,
            isPasswordEmpty: false,
        };
    },
    methods: {
        async submitLogin() {

            this.isEmailEmpty = false;
            this.isEmailInvalid = false;
            this.isPasswordEmpty = false;
            this.showError = false;

            if(!this.username.trim()){
                this.isEmailInvalid = true;
                return;
            }

            if (!isValidEmail(this.username)) {
                this.isEmailInvalid = true;
                return;
            }

            if (!this.password.trim()) {
                this.isPasswordEmpty = true;
                return;
            }

            try {
                const response = await axios.post(`${config.baseUrl}/api/admin/login`,{
                    username: this.username,
                    password: this.password,
                    role: 'admin',
                });

                if(response.data.code==200){
                    this.showError = false;
                    const authUserJson = response.data.data;
                    const authUserJsonString = JSON.stringify(authUserJson);
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('userAuth', authUserJsonString);

                    this.$router.push('/admin/home');

                }else{



                }

            } catch (error) {

                this.errorMsg = error.response.data.message;
                this.showError = true;

                //console.error('Login failed', error.response);
            }

        },

    },
}
</script>
