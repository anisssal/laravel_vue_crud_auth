<template>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand">Simple Laravel Vue</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
              aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class=" nav-item ">
            <router-link :to="{ name: 'home' }" class="nav-link">Home</router-link>
          </li>
          <li class=" nav-item ">
            <router-link v-if="this.auth.authenticated" :to="{ name: 'employee.index' }" class="nav-link">Employee</router-link>
          </li>
          <!--          <li class="pull-right nav-item" v-if="!auth.user.authenticated">-->
          <!--            <router-link :to="{ name: 'register' }">Register</router-link>-->
          <!--          </li>-->

        </ul>
        <a v-if="auth.profile" class="me-5 navbar-text">Hallo, {{ this.auth.profile.name }}</a>
        <a id="text-button" v-if="this.auth.authenticated" @click.prevent="logOut" class="nav-link navbar-text">Log out</a>
        <router-link v-if="!this.auth.authenticated" class="nav-link navbar-text" :to="{ name: 'login' }" >Log in</router-link>
      </div>
    </div>
  </nav>

  <router-view @user_success_login="userLogged"></router-view>
</template>

<script>
import auth from "./auth";

export default {
  data() {

    return {
      auth: {
        authenticated: false,
        profile: null
      },
    }
  },
  methods: {
    async checkUserLogin() {
      let token = localStorage.getItem('id_token');
      if (token !== null) {
        this.axios.get(
            'api/user', {
              headers: {"Authorization": "Bearer " + token}
            }
        ).then(response => {
          this.auth.authenticated = true
          this.auth.profile = response.data.data
        }).catch((error) => {
          console.log(error)
        })
      }
    },
    userLogged($user_profile) {
      this.auth.authenticated = true;
      this.auth.profile = $user_profile;
      this.axios.defaults.headers = {
        'Authorization': `Bearer ${localStorage.getItem('id_token')}`
      }
      console.log($user_profile);
    },
    logOut() {
      console.log("tes")
      this.auth.authenticated = false;
      this.auth.profile = null;
      localStorage.setItem('id_token', null);
      this.$router.push('home')
    }

  },
  mounted() {
    this.$nextTick(async () => {
      await auth.check(this)
      console.log("=======")
      console.log(this.auth.profile)
    })
  }

}

</script>
<style>
  #text-button{
    cursor: pointer;
  }

</style>
