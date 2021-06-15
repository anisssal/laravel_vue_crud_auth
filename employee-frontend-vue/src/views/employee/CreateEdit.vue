<template>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-8">
        <router-link :to="{
          name : 'employee.index'
        }" class="btn btn-outline-primary shadow ">
          Back
        </router-link>

        <div class="card shadow my-4">

          <div class="card-header">
            <h3>{{ isUpdate ? 'Update' : 'Create' }} Employee Data</h3>
          </div>
          <div class="card-body">
            <div class="alert alert-danger" role="alert" v-if="errorMessage">
              {{ errorMessage }}
            </div>
            <div class="mb-3">
              <form @submit.prevent="onSubmit">
                <div class="m-3">
                  <label for="first_name" class="form-label">First Name*</label>
                  <input type="text" class="form-control" id="first_name" name="first_name"
                         :class="{ 'is-invalid': validationErrorMessage.first_name }"
                         v-model="employee.first_name">
                  <div class="invalid-feedback" v-if="validationErrorMessage.first_name">
                    {{ validationErrorMessage.first_name[0] }}
                  </div>
                </div>

                <div class="m-3">
                  <label for="last_name" class="form-label">Last Name*</label>
                  <input type="text"
                         :class="{ 'is-invalid': validationErrorMessage.last_name }"
                         class="form-control" id="last_name" name="last_name" v-model="employee.last_name">
                  <div class="invalid-feedback" v-if="validationErrorMessage.last_name">
                    {{ validationErrorMessage.last_name[0] }}
                  </div>
                </div>
                <div class="m-3">
                  <label for="email" class="form-label">Email*</label>
                  <input type="text" class="form-control"
                         :class="{ 'is-invalid': validationErrorMessage.email }"
                         id="email" name="email" v-model="employee.email">
                  <div class="invalid-feedback" v-if="validationErrorMessage.email">
                    {{ validationErrorMessage.email[0] }}
                  </div>
                </div>
                <div class="m-3">
                  <label for="phone_number" class="form-label">Phone Number*</label>
                  <input type="text" class="form-control" id="phone_number"
                         :class="{ 'is-invalid': validationErrorMessage.phone_number }"
                         v-model="employee.phone_number" placeholder="628XXXX">
                  <div class="invalid-feedback" v-if="validationErrorMessage.phone_number">
                    {{ validationErrorMessage.phone_number[0] }}
                  </div>
                </div>
                <div class="m-3">
                  <label for="department_name" class="form-label">Department Name*</label>
                  <select id="department_name" class="form-select"
                          :class="{ 'is-invalid': validationErrorMessage.department_name }"
                          v-model="employee.department_name">
                    <option value="IT">IT</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Finance">Finance</option>
                    <option value="HR Dept">HR Dept</option>
                  </select>
                  <div class="invalid-feedback" v-if="validationErrorMessage.department_name">
                    {{ validationErrorMessage.department_name[0] }}
                  </div>
                </div>

                <div class="m-3">
                  <label for="start_date" class="form-label">Start Date*</label>
                  <input type="text" class="form-control"
                         :class="{ 'is-invalid': validationErrorMessage.start_date }"
                         id="start_date" name="start_date" v-model="employee.start_date" placeholder="yyyy-mm-dd">
                  <div class="invalid-feedback" v-if="validationErrorMessage.start_date">
                    {{ validationErrorMessage.start_date[0] }}
                  </div>
                </div>
                <div class="m-3">
                  <label for="end_date" class="form-label">End Date</label>
                  <input type="text" class="form-control"
                         :class="{ 'is-invalid': validationErrorMessage.end_date }"
                         id="end_date" name="start_date" v-model="employee.end_date" placeholder="yyyy-mm-dd">
                  <div class="invalid-feedback" v-if="validationErrorMessage.end_date">
                    {{ validationErrorMessage.end_date[0] }}
                  </div>
                  <br>
                  *required
                </div>

                <div class="text-center">
                  <button class="btn btn-primary shadow mt-4 align-self-center">Save</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      employee: {},
      validationErrorMessage: '',
      errorMessage: '',
      isUpdate: false

    }
  },
  methods: {
    onSubmit() {
      if (!this.isUpdate) {
        this.axios.post('api/employee', this.employee)
            .then((result) => {
              if (!result.data.success) {
                this.errorMessage = result.data.message;
                return;
              }
              // this.flash('Data Updated', 'success');
              this.routeToIndex()
            }).catch((error) => {
          let response = error.response;
          if (response.status === 422) {
            this.validationErrorMessage = response.data.data;
            this.errorMessage = response.data.message;
            window.scroll(0,0)
          }
        });
        return
      }
      const id = this.$route.params.id;
      this.axios.put(`api/employee/${id}`, this.employee)
          .then((result) => {

            if (!result.data.success) {
              this.errorMessage = result.data.message;
              return;
            }
            this.routeToIndex()
          }).catch((error) => {
        let response = error.response;
        console.log("==== param ====")
        console.log(response)

        if (response.status === 422) {
          this.validationErrorMessage = response.data.data;
          this.errorMessage = response.data.message;
          window.scroll(0,0)
        }
      })

    },
    routeToIndex() {
      this.$router.push({name: 'employee.index'});
    },
    async getEmployee(id) {
      this.axios.get(`api/employee/${id}`)
          .then((result) => {

            console.log(result.data);

            if (result.data.success) {
              this.employee = result.data.data;
            }
          }).catch((error) => {
        console.log(error);
        if (error.response.status === 404) {
          this.routeToIndex()
        }
      })
    }
  },
  beforeMount() {
    console.log("==== param ====")
    console.log(this.$route.params);
    console.log("==== param ====")
    if (this.$route.params == null || this.$route.params.id == null) {
      return;
    }
    this.isUpdate = true;
  },
  mounted() {
    if (this.isUpdate) {
      this.getEmployee(this.$route.params.id);
    }
  }

}
</script>