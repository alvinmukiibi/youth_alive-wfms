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
    return {};
  },
  methods: {
    ...mapMutations({
      setAuthUser: "setAuthUser",
      setDepartments: "setDepartments",
      setDesignations: "setDesignations",
      setContracts: "setContracts",
      setRoles: "setRoles",
      setProjects: "setProjects",
      setLeaveTypes: "setLeaveTypes",
      setAssets: "setAssets",
      setVendors: "setVendors",
      setUsers: "setUsers",
      setMyRequests: "setMyRequests"
    }),
    logout() {
      api.logout().then(response => {
        document.location.href = "/login";
      });
    },
    getAuthUser() {
      api.getAuthUser().then(response => {
        this.setAuthUser(response.data);
        if (
          response.data.roles.includes("manager") ||
          response.data.roles.includes("administrator")
        ) {
          api.getDepartments().then(response => {
            this.setDepartments(response.data);
          });
          api.getDesignations().then(response => {
            this.setDesignations(response.data);
          });
          api.getUsers().then(response => {
            this.setUsers(response.data);
          });
          api.getContracts().then(response => {
            this.setContracts(response.data);
          });
          api.getRoles().then(response => {
            this.setRoles(response.data);
          });
          api.getProjects().then(response => {
            this.setProjects(response.data);
          });
          api.getLeaveTypes().then(response => {
            this.setLeaveTypes(response);
          });
          api.getAssets().then(response => {
            this.setAssets(response);
          });
          api.getVendors().then(response => {
            this.setVendors(response);
          });
          api.getMyRequests().then(response => {
            this.setMyRequests(response.data);
          });
        }
        if (
          response.data.roles.includes("officer") &&
          response.data.roles.length == 1
        ) {
          api.getProjects().then(response => {
            this.setProjects(response.data);
          });
          api.getVendors().then(response => {
            this.setVendors(response);
          });
          api.getDepartments().then(response => {
            this.setDepartments(response.data);
          });
          api.getAssets().then(response => {
            this.setAssets(response);
          });
          api.getMyRequests().then(response => {
            this.setMyRequests(response.data);
          });
          api.getLeaveTypes().then(response => {
            this.setLeaveTypes(response);
          });
        }
        if (response.data.roles.includes("director")) {
          api.getProjects().then(response => {
            this.setProjects(response.data);
          });
          api.getVendors().then(response => {
            this.setVendors(response);
          });
          api.getDepartments().then(response => {
            this.setDepartments(response.data);
          });
          api.getAssets().then(response => {
            this.setAssets(response);
          });
          api.getMyRequests().then(response => {
            this.setMyRequests(response.data);
          });
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
  created() {
    this.getAuthUser();
  }
};
</script>

<style type="css">
</style>
