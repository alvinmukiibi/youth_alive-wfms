<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Timesheet</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Timesheet</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <ul class="nav nav-pills">
                  <li class="nav-item">
                    <a class="nav-link active" href="#mine" data-toggle="tab">My Timesheets</a>
                  </li>
                  <li
                    class="nav-item"
                    v-if="auth.user_type=='manager' || auth.user_type=='director'"
                  >
                    <a class="nav-link" href="#staff" data-toggle="tab">Staff Timesheets</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="mine">
                    <MyTimesheets></MyTimesheets>
                  </div>
                  <div class="tab-pane" id="staff">
                    <StaffTimesheets></StaffTimesheets>
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
import MyTimesheets from "./MyTimesheets";
import StaffTimesheets from "./StaffTimesheets";
import { mapState } from "vuex";
export default {
  components: {
    MyTimesheets,
    StaffTimesheets
  },
  computed: {
    ...mapState({
      auth: state => state.auth
    })
  }
};
</script>

<style lang="">
</style>
