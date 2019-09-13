<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Settings</li>
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
                <h3 class="card-title">Settings</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <b-form-checkbox
                    v-model="settings.receive_login_notifications"
                    name="check-button"
                    switch
                    size="lg"
                    @change="toggleButton('receive_login_notifications')"
                  >Receive Login Notifications</b-form-checkbox>
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
import { mapMutations, mapState } from "vuex";
import * as api from "../api/api";
export default {
  data() {
    return {};
  },
  methods: {
    ...mapMutations({
      setSettings: "setSettings"
    }),
    toggleButton(field) {
      api.toggleButton(field).then(response => {
        this.loadSettings();
      });
    },
    loadSettings() {
      api.getSettings().then(response => {
        this.setSettings(response.data);
      });
    }
  },
  computed: {
    ...mapState({
      settings: state => state.settings
    })
  },
  mounted() {
    this.loadSettings();
  }
};
</script>

<style >
</style>
