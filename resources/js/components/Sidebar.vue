<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
      <img
        src="/images/logo.png"
        alt="AdminLTE Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: .8"
      />
      <span class="brand-text font-weight-light">
        <b>YOUTH</b>ALIVE
      </span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img
            v-if="auth.profile_picture"
            :src="'/storage/' + auth.profile_picture"
            class="img-circle elevation-2"
            alt="User Image"
          />
          <img
            v-else
            :src="'https://ui-avatars.com/api/?name=' + auth.fname + '+' + auth.lname"
            class="img-circle elevation-2"
            alt="User Image"
          />
        </div>
        <div class="info">
          <router-link to="/profile" class="d-block">{{ auth.fname + ' ' + auth.lname }}</router-link>
        </div>
      </div>
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <li class="nav-item">
            <router-link to="/home" class="nav-link" :class="{ 'active': isActive('/home') }">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>Dashboard</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/profile" class="nav-link" :class="{ 'active': isActive('/profile') }">
              <i class="nav-icon fa fa-user"></i>
              <p>My Profile</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="stateLoaded && auth.roles.includes('officer')">
            <router-link
              to="/requests"
              class="nav-link"
              :class="{ 'active': isActive('/requests') }"
            >
              <i class="nav-icon fa fa-hand-grab-o"></i>
              <p>
                Requests
                <i class="right fa fa-angle-left"></i>
              </p>
            </router-link>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Program</p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>HR</p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Supplies</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item" v-if="stateLoaded && auth.roles.includes('officer')">
            <router-link to="/leave" class="nav-link" :class="{ 'active': isActive('/leave') }">
              <i class="nav-icon fa fa-minus-circle"></i>
              <p>Leave</p>
            </router-link>
          </li>
          <li
            class="nav-item"
            v-if="stateLoaded && auth.roles.includes('manager') && auth.department == 'Human Resource'"
          >
            <router-link
              to="/employees"
              class="nav-link"
              :class="{ 'active': isActive('/employees') }"
            >
              <i class="nav-icon fa fa-user"></i>
              <p>Employees</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="stateLoaded && auth.roles.includes('administrator')">
            <router-link
              to="/contracts"
              class="nav-link"
              :class="{ 'active': isActive('/contracts') }"
            >
              <i class="nav-icon fa fa-user"></i>
              <p>Contract Types</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="stateLoaded && auth.roles.includes('administrator')">
            <router-link
              to="/projects"
              class="nav-link"
              :class="{ 'active': isActive('/projects') }"
            >
              <i class="nav-icon fa fa-user"></i>
              <p>Projects</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="stateLoaded && auth.roles.includes('administrator')">
            <router-link
              to="/departments"
              class="nav-link"
              :class="{ 'active': isActive('/departments') }"
            >
              <i class="nav-icon fa fa-user"></i>
              <p>Departments</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="stateLoaded && auth.roles.includes('administrator')">
            <router-link
              to="/designations"
              class="nav-link"
              :class="{ 'active': isActive('/designations') }"
            >
              <i class="nav-icon fa fa-user"></i>
              <p>Designations</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="stateLoaded && auth.roles.includes('administrator')">
            <router-link to="/assets" class="nav-link" :class="{ 'active': isActive('/assets') }">
              <i class="nav-icon fa fa-user"></i>
              <p>Assets</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="stateLoaded && auth.roles.includes('administrator')">
            <router-link to="/vendors" class="nav-link" :class="{ 'active': isActive('/vendors') }">
              <i class="nav-icon fa fa-user"></i>
              <p>Vendors</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="stateLoaded && auth.roles.includes('administrator')">
            <router-link
              to="/leavetypes"
              class="nav-link"
              :class="{ 'active': isActive('/leavetypes') }"
            >
              <i class="nav-icon fa fa-user"></i>
              <p>Leave Types</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              to="/settings"
              class="nav-link"
              :class="{ 'active': isActive('/settings') }"
            >
              <i class="nav-icon fa fa-gear"></i>
              <p>Settings</p>
            </router-link>
          </li>
          <li
            class="nav-item"
            v-if="stateLoaded && auth.roles.includes('manager') && auth.department == 'Human Resource'"
          >
            <router-link to="/reports" class="nav-link" :class="{ 'active': isActive('/reports') }">
              <i class="nav-icon fa fa-bar-chart"></i>
              <p>Reports</p>
            </router-link>
          </li>
          <li class="nav-item" v-if="stateLoaded && auth.roles.includes('administrator')">
            <a class="nav-link" @click.prevent>
              <i class="nav-icon fa fa-hand-grab-o"></i>
              <p>
                Forms
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  to="/request/activity/report"
                  class="nav-link"
                  :class="{ 'active': isActive('/request/activity/report') }"
                >
                  <i class="nav-icon fa fa-hand-grab-o"></i>
                  <p>Activity Report Form</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  to="/request/vehicle"
                  class="nav-link"
                  :class="{ 'active': isActive('/request/vehicle') }"
                >
                  <i class="nav-icon fa fa-hand-grab-o"></i>
                  <p>Vehicle Request Form</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  to="/request/hotel"
                  class="nav-link"
                  :class="{ 'active': isActive('/request/hotel') }"
                >
                  <i class="nav-icon fa fa-hand-grab-o"></i>
                  <p>Hotel Request Form</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  to="/request/concept"
                  class="nav-link"
                  :class="{ 'active': isActive('/request/concept') }"
                >
                  <i class="nav-icon fa fa-hand-grab-o"></i>
                  <p>Concept Note</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  to="/request/travel/scope"
                  class="nav-link"
                  :class="{ 'active': isActive('/request/travel/scope') }"
                >
                  <i class="nav-icon fa fa-hand-grab-o"></i>
                  <p>Travel Scope of Work</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  to="/request/travel/report"
                  class="nav-link"
                  :class="{ 'active': isActive('/request/travel/report') }"
                >
                  <i class="nav-icon fa fa-hand-grab-o"></i>
                  <p>Travel/Trip Report</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link
                  to="/request/budget"
                  class="nav-link"
                  :class="{ 'active': isActive('/request/budget') }"
                >
                  <i class="nav-icon fa fa-hand-grab-o"></i>
                  <p>Budget</p>
                </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script>
import * as api from "../api/api.js";
import { mapState, mapMutations } from "vuex";
export default {
  data() {
    return {
      n: 0,
      n1: 0,
      n2: 0,
      n3: 0
    };
  },
  methods: {
    ...mapMutations({
      setUsersCount: "setUsersCount"
    }),
    // n3(approval1, approval2){
    //     return this.myRequests.filter(req => {
    //         if(req.trail[approval1] == 1 && req.trail[approval2] == 1){
    //             return req
    //         }
    //     }).length
    // },
    // n1(approval1, approval2, approval3){
    //     return this.myRequests.filter(req => {
    //         if(req.trail[approval1] == 1 && req.trail[approval2] == 1 && req.trail[approval3] == 0){
    //             return req
    //         }
    //     }).length
    // },
    // n2(approval, approval1){
    //     return this.myRequests.filter(req => {
    //         if(req.trail[approval] == 1 && req.trail[approval1] == 0){
    //             return req
    //         }
    //     }).length
    // },
    isActive(route) {
      if (this.$route.path == route) {
        return true;
      }
      return false;
    },
    countEmployees() {
      api.countUsers().then(response => {
        this.setUsersCount(response);
      });
    }
  },
  mounted() {
    this.countEmployees();
  },
  computed: {
    ...mapState({
      auth: state => state.auth,
      myRequests: state => state.myRequests
    }),
    stateLoaded() {
      return Object.keys(this.auth).length > 0 ? true : false;
    }
    // n(){
    //     return this.myRequests.filter(req => {
    //         if(req.trail['accountant_approval'] == 0){
    //             return req
    //         }
    //     }).length
    // },
  }
};
</script>

<style scoped>
</style>
