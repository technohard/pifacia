<template>
    <section>
      <div style="position: relative;">
        <div style="position: absolute;top:20px;left:20px;z-index:3;">
            <div class="d-flex align-items-center">
                <router-link to="/" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
</svg>
                </router-link>

            </div>
        </div>
      </div>
      <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center gx-0 min-vh-100">
          <div class="col-12 col-md-6 col-lg-4 py-8 py-md-11">
            <h1 class="mb-3 fw-bold"> Login </h1>
            <form class="mb-6">
              <div class="form-group"><label class="form-label" for="email"> Email  </label>
                <input v-model="username" type="email" class="form-control" id="username" name="username" placeholder="nama@email.com" :class="{ 'is-invalid': isEmailEmpty || isEmailInvalid }" >
                <div class="invalid-feedback">
                    harap input email dengan benar.
                  </div>
              </div>
              <div class="form-group mb-5"><label class="form-label" for="password"> Password </label>
                <input v-model="password" type="password" class="form-control" :class="{ 'is-invalid': isPasswordEmpty }" name="password" autocomplete="off"  placeholder="Masukkan kata sandi Anda">
                <div class="invalid-feedback">
                    harap input password dengan benar.
                  </div>
              </div>
               <div class="fv-row mb-10">
                    <span v-show="showError" class="text-danger errorMsg">{{ errorMsg }}</span>
               </div>
              <button class="btn w-100 btn-primary" type="button" @click="submitLogin"> Masuk </button>
            </form>
            <!-- <p class="mb-0 fs-sm text-body-secondary"> Don't have an account yet? <a href="signup-cover.html">Sign up</a>. </p> -->
          </div>
          <div class="col-lg-7 offset-lg-1 align-self-stretch d-none d-lg-block">
            <div class="h-100 w-cover bg-cover" style="background-image: url(assets/img/covers/cover-14.jpg);"></div>
            <div class="shape shape-start shape-fluid-y text-white"><svg viewBox="0 0 100 1544" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h100v386l-50 772v386H0V0z" fill="currentColor" />
              </svg></div>
          </div>
        </div>
      </div>
    </section>
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
                const response = await axios.post(`${config.baseUrl}/api/login`,{
                    username: this.username,
                    password: this.password,
                    role: 'buyer',
                });

                if(response.data.code==200){
                    this.showError = false;
                    const authUserJson = response.data.data;
                    const authUserJsonString = JSON.stringify(authUserJson);
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('userAuth', authUserJsonString);

                    this.$router.push('/member');

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
