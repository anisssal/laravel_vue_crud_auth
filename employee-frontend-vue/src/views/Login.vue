<template>


  <br>
  <br>

  <div class="cotainer justify-content-center">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <div class="alert alert-danger" role="alert" v-if="errorMessage">
              {{errorMessage}}
            </div>
            <form @submit.prevent="login">
              <div class="form-group row mb-4">
                <label for="email_address" class="col-md-4 col-form-label text-md-right">Email</label>
                <div class="col-md-6">
                  <input type="text" id="email_address" class="form-control"
                         :class="{ 'is-invalid': validationErrorMessage.email }"
                         name="email-address" v-model="user.email" required autofocus>
                  <div class="invalid-feedback" v-if="validationErrorMessage.email">
                    {{ validationErrorMessage.email[0] }}
                  </div>
                </div>
              </div>

              <div class="form-group row mb-4">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                <div class="col-md-6">
                  <input type="password" id="password" class="form-control" name="password" required v-model="user.password">
                </div>
              </div>


              <div class="col-md-6 offset-md-4 text-center ">
                <button type="submit" class="btn btn-primary px-5 me-1" >
                  Login
                </button>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


</template>

<script>
import auth from "../auth";
export default {
  emits : ['user_success_login'],
  data() {
    return {
      user : {
        email: '',
        password : '',
      },
      errorMessage : '',
      validationErrorMessage : '',
    }
  },
  methods: {
    login() {
      console.log("tes2");
      this.axios.post('/api/login', this.user).then((response) => {
        if (!response.data.success) {
          return;
        }
        console.log(response.data.access_token);
        localStorage.setItem('id_token', response.data.access_token);
        this.$emit('user_success_login', response.data.data);
        this.$router.push({
          name: 'employee.index'
        })
      }).catch((error) => {
        console.log(error);

        if (error.response.status===422){
          this.validationErrorMessage = error.response.data.errors
          this.errorMessage = error.response.data.message
        }

      });
    }

  },
}

</script>