<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img
                    v-if="auth.profile_picture"
                    :src="'/storage/' + auth.profile_picture"
                    class="profile-user-img img-fluid img-circle"
                    alt="User Image"
                  />
                  <img
                    v-else
                    :src="'https://ui-avatars.com/api/?name=' + auth.fname + '+' + auth.lname"
                    class="img-circle elevation-2"
                    alt="User Image"
                  />
                  <!-- <img
                    class="profile-user-img img-fluid img-circle"
                    :src="'storage/' + auth.profile_picture"
                    alt="User profile picture"
                  />-->
                </div>

                <h3 class="profile-username text-center">{{ auth.fname + ' ' + auth.lname }}</h3>

                <p class="text-muted text-center">{{ auth.designation }}</p>

                <!-- <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>-->
                <form>
                  <div class="custom-file">
                    <input
                      type="file"
                      ref="dp"
                      @change="uploadDp"
                      class="custom-file-input is-valid"
                      id="validatedCustomFile"
                      required
                    />
                    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                    <div class="valid-feedback">Upload Profile Picture!!</div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Employment Details</h3>
              </div>
              <div class="card-body">
                <b-table stacked :fields="fields" :items="profile"></b-table>
                <!-- <div class="form-group row">
                  <label for="Deparmtent" class="col-sm-2 col-form-label">Staff ID</label>
                  <div class="col-md-10">
                    <input type="text" readonly :value="auth.staff_id" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="Deparmtent" class="col-sm-2 col-form-label">Directorate</label>
                  <div class="col-md-10">
                    <input type="text" readonly :value="auth.directorate" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="Deparmtent" class="col-sm-2 col-form-label">Department</label>
                  <div class="col-md-10">
                    <input type="text" readonly :value="auth.department" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="Designation" class="col-sm-2 col-form-label">Designation</label>
                  <div class="col-md-10">
                    <input type="text" readonly :value="auth.designation" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="contract" class="col-sm-2 col-form-label">Contract Type</label>
                  <div class="col-md-10">
                    <input type="text" readonly :value="auth.contract" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="station" class="col-sm-2 col-form-label">Duty Station</label>
                  <div class="col-md-10">
                    <input type="text" readonly :value="auth.duty_station" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="station" class="col-sm-2 col-form-label">Availability</label>
                  <div class="col-md-10">
                    <span v-if="auth.availability_status">
                      <b class="text-success">ON DUTY</b>
                    </span>
                    <span v-else>
                      <b class="text-danger">ON LEAVE</b>
                    </span>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="station" class="col-sm-2 col-form-label">System Roles</label>
                  <div class="col-md-10">
                    [
                    <span v-for="role in auth.roles" :key="role">{{ role }},</span> ]
                  </div>
                </div>
                <div class="form-group row">
                  <label for="station" class="col-sm-4 col-form-label">Projects Attached To</label>
                  <div class="col-md-8">
                    [
                    <span v-for="project in auth.projects" :key="project">{{ project }},</span> ]
                  </div>
                </div>-->
              </div>
              <!-- <div class="card-header">
                <h3 class="card-title">Contact Details</h3>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label for class="col-sm-3 col-form-label">Work Contact</label>
                  <div class="col-md-3">
                    <input type="text" readonly :value="auth.work_contact" class="form-control" />
                  </div>
                  <label for="Phone Number" class="col-sm-3 col-form-label">Mobile Contact</label>
                  <div class="col-md-3">
                    <input type="text" readonly :value="auth.mobile_contact" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-sm-3 col-form-label">Email Address</label>
                  <div class="col-md-9">
                    <input type="text" readonly :value="auth.email" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for class="col-sm-3 col-form-label">Address</label>
                  <div class="col-md-9">
                    <input type="text" readonly :value="auth.address" class="form-control" />
                  </div>
                </div>
              </div>-->
              <!-- <div class="card-header">
                <h3 class="card-title">Other Information [Editable]</h3>
              </div>-->
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="inputEmail4">Username</label>
                    <input type="text" class="form-control" v-model="auth.user_name" />
                  </div>
                  <div class="form-group col-md-4">
                    <label for="inputPassword4">Password</label>
                    <input
                      type="password"
                      class="form-control"
                      v-model="auth.password"
                      id="inputPassword4"
                      min="8"
                      placeholder="Password"
                    />
                  </div>
                </div>
                <!-- <div class="row" v-if="errors.length > 0">
                  <div class="col-md-12">
                    <p class="text-danger pull-left">{{ errors }}</p>
                  </div>
                </div>-->
                <div class="row">
                  <div class="col-md-6">
                    <button @click="save" class="btn btn-primary" type="button">
                      <span
                        v-if="spinner"
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                      ></span>
                      Save Profile
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>


<script>
import * as api from "../api/api";
import { mapState, mapMutations } from "vuex";
export default {
  data() {
    return {
      spinner: false,
      profile: [],
      fields: [
        { key: "staff_id", label: "Staff ID" },
        { key: "fname", label: "First Name" },
        { key: "lname", label: "Other Names" },
        { key: "directorate", label: "Directorate" },
        { key: "department", label: "Department" },
        { key: "designation", label: "Designation" },
        { key: "contract", label: "Contract Type" },
        { key: "duty_station", label: "Duty Station" },
        { key: "email", label: "Email Address" },
        { key: "work_contact", label: "Work Contact" },
        { key: "mobile_contact", label: "Mobile Contact" },
        { key: "roles", label: "System Roles" },
        { key: "projects", label: "Projects Attached To" }
      ]
    };
  },
  methods: {
    ...mapMutations({
      //   setErrors: "setErrors",
      setAuthUser: "setAuthUser"
    }),
    uploadDp() {
      let dp = this.$refs.dp.files[0];
      let data = new FormData();
      data.append("profile_picture", dp);
      api.saveDp(data, this.auth.id).then(response => {
        if (!response.success) {
          //   this.setErrors(response.data.error);
          this.showToast("danger", "Error", response.data.error);
          //   this.spinner = false;
          return;
        }
        // this.setErrors([]);
        this.loadAuthUser();
        this.showToast(
          "success",
          "Notification",
          "Profile picture saved successfully"
        );
        // this.spinner = false;
      });
    },
    loadAuthUser() {
      api.getAuthUser().then(response => {
        this.setAuthUser(response.data);
      });
    },
    showToast(variant, title, body) {
      this.$bvToast.toast(body, {
        title: title,
        variant: variant,
        solid: true
      });
    },
    save() {
      this.spinner = true;
      let data = {
        user_name: this.auth.user_name,
        password: this.auth.password
      };
      api.saveProfile(data).then(response => {
        if (!response.success) {
          //   this.setErrors(response.data.error);
          this.showToast("danger", "Error", response.data.error);
          this.spinner = false;
          return;
        }
        // this.setErrors([]);
        this.spinner = false;
        this.showToast("success", "Notification", "Profile saved successfully");
      });
    }
  },
  mounted() {
    api.getAuthUser().then(response => {
      this.profile = [response.data];
    });
  },
  computed: {
    ...mapState({
      auth: state => state.auth
      //   errors: state => state.errors
    })
  }
};
</script>

<style>
</style>
