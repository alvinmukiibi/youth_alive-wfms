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
              <li class="breadcrumb-item active">Employee</li>
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
                    class="profile-user-img img-fluid img-circle"
                    :src="'/storage/' + employee.profile_picture"
                    alt="User profile picture"
                  />
                </div>

                <h3 class="profile-username text-center">{{ employee.fname + ' ' + employee.lname }}</h3>

                <p class="text-muted text-center">{{ employee.designation }}</p>

                <!-- <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b>
                    <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b>
                    <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b>
                    <a class="float-right">13,287</a>
                  </li>
                </ul>-->

                <router-link to="/employees" class="btn btn-primary btn-block btn-flat btn-outline">
                  <b>
                    <i class="fa fa-backward"></i> Back
                  </b>
                </router-link>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  Employment Details
                  <small
                    class="text-primary"
                  >** To edit, please click in the field and type **</small>
                </h3>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label for="Deparmtent" class="col-sm-2 col-form-label">Staff ID</label>
                  <div class="col-md-10">
                    <input type="text" readonly :value="employee.staff_id" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="Deparmtent" class="col-sm-2 col-form-label">Department</label>
                  <div class="col-md-10">
                    <input
                      type="text"
                      v-if="!dropDown"
                      @click="dropDown = true"
                      :value="employee.department"
                      class="form-control"
                    />
                    <select v-model="user.department_id" v-else name id class="form-control">
                      <option disabled>Select Department</option>
                      <option
                        v-for="dept in departments"
                        :value="dept.id"
                        :key="dept.id"
                      >{{ dept.name }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="Designation" class="col-sm-2 col-form-label">Designation</label>
                  <div class="col-md-10">
                    <input
                      type="text"
                      v-if="!dropDown2"
                      @click="dropDown2 = true"
                      :value="employee.designation"
                      class="form-control"
                    />
                    <select v-model="user.designation_id" v-else name id class="form-control">
                      <option disabled>Select Designation</option>
                      <option
                        v-for="desi in designations"
                        :value="desi.id"
                        :key="desi.id"
                      >{{ desi.name }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="contract" class="col-sm-2 col-form-label">Contract Type</label>
                  <div class="col-md-10">
                    <input
                      type="text"
                      v-if="!dropDown3"
                      @click="dropDown3 = true"
                      :value="employee.contract"
                      class="form-control"
                    />
                    <select v-model="user.contract_id" v-else name id class="form-control">
                      <option disabled>Select Contract Type</option>
                      <option
                        v-for="cont in contracts"
                        :value="cont.id"
                        :key="cont.id"
                      >{{ cont.name }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="station" class="col-sm-2 col-form-label">Duty Station</label>
                  <div class="col-md-10">
                    <input type="text" v-model="employee.duty_station" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="station" class="col-sm-2 col-form-label">Availability</label>
                  <div class="col-md-10">
                    <span v-if="employee.availability_status">
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
                    <span v-for="role in employee.roles" :key="role">{{ role }},</span> ]
                  </div>
                </div>
                <div class="form-group row">
                  <label for="station" class="col-sm-4 col-form-label">Projects Attached To</label>
                  <div class="col-md-8">
                    [
                    <span v-for="project in employee.projects" :key="project">{{ project }},</span> ]
                  </div>
                </div>
              </div>
              <div class="card-header">
                <h3 class="card-title">Contact Details</h3>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label for class="col-sm-3 col-form-label">Work Contact</label>
                  <div class="col-md-3">
                    <input type="text" v-model="employee.work_contact" class="form-control" />
                  </div>
                  <label for="Phone Number" class="col-sm-3 col-form-label">Mobile Contact</label>
                  <div class="col-md-3">
                    <input type="text" v-model="employee.mobile_contact" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-sm-3 col-form-label">Email Address</label>
                  <div class="col-md-9">
                    <input type="text" v-model="employee.email" class="form-control" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for class="col-sm-3 col-form-label">Address</label>
                  <div class="col-md-9">
                    <input type="text" v-model="employee.address" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row" v-if="errors.length > 0">
                  <div class="col-md-12">
                    <p class="text-danger pull-left">{{ errors }}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button @click="save" class="btn btn-primary btn-block" type="button">
                      <span
                        v-if="spinner"
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                      ></span>
                      <b>Save Profile</b>
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
import * as api from "../../api/api";
import { mapState, mapMutations } from "vuex";
export default {
  data() {
    return {
      dropDown: false,
      dropDown2: false,
      dropDown3: false,
      spinner: false,
      user: {
        department_id: "",
        designation_id: "",
        contract_id: ""
      }
    };
  },
  methods: {
    ...mapMutations({
      setErrors: "setErrors",
      setCurrentEmployee: "setCurrentEmployee"
    }),
    save() {
      this.spinner = true;
      let id = this.employee.id;
      let data = {
        department_id: this.user.department_id,
        designation_id: this.user.designation_id,
        contract_id: this.user.contract_id,
        duty_station: this.employee.duty_station,
        email: this.employee.email,
        work_contact: this.employee.work_contact,
        mobile_contact: this.employee.mobile_contact,
        address: this.employee.address
      };
      api.saveUserEdit(data, id).then(response => {
        if (!response.success) {
          this.setErrors(response.data.error);
          this.spinner = false;
          return;
        }
        this.setErrors([]);
        this.spinner = false;
        this.setCurrentEmployee(response.data);
      });
    }
  },
  computed: {
    ...mapState({
      employee: state => state.employee,
      departments: state => state.departments,
      designations: state => state.designations,
      contracts: state => state.contracts,
      errors: state => state.errors
    })
  }
};
</script>

<style>
</style>
