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
              <li class="breadcrumb-item active">Mailbox</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card-outline card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  My Mailbox
                  <button class="btn btn-sm btn-outline-primary">
                    Send
                    <i class="fa fa-paper-plane"></i>
                  </button>
                </h3>
              </div>
              <div class="card-body"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card-outline card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Chat</h3>
              </div>
              <div class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import * as api from "../api/api";
import { mapMutations, mapState } from "vuex";
export default {
  data() {
    return {};
  },
  methods: {
    ...mapMutations({
      setUsers: "setUsers"
    }),
    loadChats() {
      api.getChats();
    },
    loadUsers() {
      api.getUsers().then(response => {
        this.setUsers(response.data);
      });
    }
  },
  computed: {
    ...mapState({
      auth: state => state.auth
    })
  },
  mounted() {
    this.loadUsers();
    this.loadChats();
  }
};
</script>

<style >
</style>
