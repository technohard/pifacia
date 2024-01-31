<template>

<nav class="bg-dark d-md-none">
      <div class="container-md">
        <div class="row align-items-center">
          <div class="col">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><span class="text-white"> Account </span></li>
              <li class="breadcrumb-item active" aria-current="page"><span class="text-white"> General </span></li>
            </ol>
          </div>
          <div class="col-auto">
            <div class="navbar-dark"><button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidenavCollapse" aria-controls="sidenavCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button></div>
          </div>
        </div>
      </div>
    </nav>
    <header class="bg-dark pt-9 pb-11 d-none d-md-block">
      <div class="container-md">
        <div class="row align-items-center">
          <div class="col">
            <h1 class="fw-bold text-white mb-2"> Account Settings </h1>
            <p class="fs-lg text-white text-opacity-75 mb-0"> Settings for <a class="text-reset" href="mailto:dhgamache@gmail.com">dhgamache@gmail.com</a></p>
          </div>
          <div class="col-auto"><button class="btn btn-sm bg-gray-300 bg-opacity-20 bg-opacity-25-hover text-white" @click="submitLogout"> Log Out </button></div>
        </div>
      </div>
    </header>
    <main class="pb-8 pb-md-11 mt-md-n6">
      <div class="container-md">
        <div class="row">
          <div class="col-12 col-md-3">
            <div class="card card-bleed border-bottom border-bottom-md-0 shadow-light-lg">
              <div class="collapse d-md-block" id="sidenavCollapse">
                <div class="card-body">
                  <h6 class="fw-bold text-uppercase mb-3"> Account </h6>
                  <ul class="card-list list text-gray-700 mb-6">
                    <li class="list-item active"><a class="list-link text-reset" href="account-general.html"> General </a></li>
                    <li class="list-item"><a class="list-link text-reset" href="account-security.html"> Security </a></li>
                    <li class="list-item"><a class="list-link text-reset" href="account-notifications.html"> Notifications </a></li>
                  </ul>
                  <h6 class="fw-bold text-uppercase mb-3"> Billing </h6>
                  <ul class="card-list list text-gray-700 mb-0">
                    <li class="list-item"><a class="list-link text-reset" href="billing-plans-and-payment.html"> Plans & Payment </a></li>
                    <li class="list-item"><a class="list-link text-reset" href="billing-users.html"> Users </a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-9">
            <div class="card card-bleed shadow-light-lg mb-6">
              <div class="card-header">
                <h4 class="mb-0"> Basic Information </h4>
              </div>
              <div class="card-body">
                <form>
                  <div class="row">
                    <div class="col-12 col-md-6">
                      <div class="form-group"><label class="form-label" for="name">Name</label>
                        <input v-model="authUserName" class="form-control" id="name" type="text" placeholder="" disabled readonly>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="form-group"><label class="form-label" for="email">Email</label>
                        <input v-model="userEmail" class="form-control" id="email" type="email" placeholder="" disabled readonly>
                      </div>
                    </div>


                  </div>
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
    </main>


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
            userFullName: '',
            userEmail: '',
        };
    },
    created() {
        const authUser = getAuthUser();
        this.authUserName = authUser.name;
        this.authUserRole = authUser.role;
        this.userEmail = authUser.email;
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
                        `${config.baseUrl}/api/member/logout`,
                        {},
                        { headers }
                    );

                }
                clearAuth();
                this.$router.push('/');

            } catch (error) {
                console.error('logout failed', error);
            }
        }
    },
}

</script>
