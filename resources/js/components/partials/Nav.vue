<template>
        <nav class="navbar navbar-expand-lg bg-white">
      <div class="container">
      <a class="navbar-brand" href="/" style="font-weight:bolder;">
        Projectku
      </a><button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarCollapse"><button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"><i class="fe fe-x"></i></button>
          <ul class="navbar-nav ms-auto">

            <li class="nav-item dropdown">
                <router-link to="/" class="nav-link">Home</router-link>
            </li>
            <li class="nav-item dropdown">
                <router-link to="/tentang-kami" class="nav-link">Tentang Kami</router-link>
            </li>

          </ul>
          <!-- <a class="navbar-btn btn btn-sm btn-primary lift ms-auto" href="/login" > Login </a> -->
          <router-link to="/login" class="navbar-btn btn btn-sm btn-primary lift ms-auto">Login</router-link>
        </div>
      </div>
    </nav>
</template>
<script>

</script>
