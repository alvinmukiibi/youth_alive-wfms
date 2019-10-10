<template>
  <nav class="main-header navbar navbar-expand bg-primary navbar-light border-bottom">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#">
          <i class="fa fa-bars"></i>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/home" class="nav-link">
          Home
          <i class="fa fa-home"></i>
        </a>
      </li>
      <li
        class="nav-item d-none d-sm-inline-block"
        v-if="stateLoaded && auth.roles.includes('officer')"
      >
        <router-link to="leave" class="nav-link">
          Ask for Leave
          <i class="fa fa-sign-out"></i>
        </router-link>
      </li>
      <li
        class="nav-item d-none d-sm-inline-block"
        v-if="stateLoaded && auth.roles.includes('officer')"
      >
        <router-link to="/requests" class="nav-link">
          Make a Request
          <i class="fa fa-hand-grab-o"></i>
        </router-link>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" @click.prevent href="#">
          <i class="fa fa-user"></i>
          <b>{{ auth.designation }}</b>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" @click.prevent="logout" href="#">
          <i class="fa fa-sign-out"></i>
          <span
            v-if="spinner"
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
          ></span>
          <b>Logout</b>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
import { mapState, mapMutations } from "vuex";
import * as api from "../api/api.js";
export default {
  data() {
    return {
      spinner: false
    };
  },
  methods: {
    ...mapMutations({
      setAuthUser: "setAuthUser",
      setDepartments: "setDepartments",
      setDirectorates: "setDirectorates",
      setDesignations: "setDesignations",
      setContracts: "setContracts",
      setRoles: "setRoles",
      setProjects: "setProjects",
      setLeaveTypes: "setLeaveTypes",
      setAssets: "setAssets",
      setVendors: "setVendors",
      setUsers: "setUsers",
      setMyRequests: "setMyRequests",
      setErrors: "setErrors"
    }),
    logout() {
      this.spinner = true;
      window.localStorage.clear();
      api
        .logout()
        .then(response => {
          this.spinner = false;
          this.setErrors([]);
          document.location.href = "/login";
        })
        .catch(error => {
          this.spinner = false;
          this.setErrors([]);
          document.location.href = "/login";
        });
    },
    showToast(variant, title, body) {
      this.$bvToast.toast(body, {
        title: title,
        variant: variant,
        solid: true
      });
    },
    getAuthUser() {
      api.getAuthUser().then(response => {
        this.setAuthUser(response.data);
      });
    },
    checkUnreadMessage() {
      api.checkUnreadMessage().then(response => {
        if (response.data.count > 0) {
          this.showToast(
            "warning",
            "Notification",
            "You have " + response.data.count + " unread messages"
          );
        }
      });
    }
  },
  computed: {
    ...mapState({
      auth: state => state.auth
    }),
    stateLoaded() {
      return Object.keys(this.auth).length > 0 ? true : false;
    }
  },
  mounted() {
    this.checkUnreadMessage();
    this.getAuthUser();
  }
};
</script>

<style type="css">
</style>
