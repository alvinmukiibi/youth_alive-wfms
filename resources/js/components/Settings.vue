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
                <div class="row">
                  <div class="col-md-6">
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
                  <div
                    class="col-md-6"
                    v-if="auth.user_type == 'manager' && auth.department == 'Human Resource'"
                  >
                    <div class="card card-outline card-success">
                      <div class="card-header">
                        <h3 class="card-title">Dynamic Public Holidays</h3>
                      </div>
                      <div class="card-body">
                        <b-container fluid>
                          <b-row class="my-1">
                            <b-col sm="4">
                              <label for="input-default">
                                Good Friday
                                <span class="text-danger">*</span>
                              </label>
                            </b-col>
                            <b-col sm="8">
                              <b-form-input
                                v-model="systemSettings.good_friday"
                                @change="savePublicHoliday('good_friday')"
                                id="input-default"
                                type="date"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                          <b-row class="my-1">
                            <b-col sm="4">
                              <label for="input-default">
                                Easter Sunday
                                <span class="text-danger">*</span>
                              </label>
                            </b-col>
                            <b-col sm="8">
                              <b-form-input
                                v-model="systemSettings.easter_sunday"
                                @change="savePublicHoliday('easter_sunday')"
                                id="input-default"
                                type="date"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                          <b-row class="my-1">
                            <b-col sm="4">
                              <label for="input-default">
                                Easter Monday
                                <span class="text-danger">*</span>
                              </label>
                            </b-col>
                            <b-col sm="8">
                              <b-form-input
                                v-model="systemSettings.easter_monday"
                                @change="savePublicHoliday('easter_monday')"
                                id="input-default"
                                type="date"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                          <b-row class="my-1">
                            <b-col sm="4">
                              <label for="input-default">
                                Eid El Fitr
                                <span class="text-danger">*</span>
                              </label>
                            </b-col>
                            <b-col sm="8">
                              <b-form-input
                                v-model="systemSettings.eid_ul_fitr"
                                @change="savePublicHoliday('eid_ul_fitr')"
                                id="input-default"
                                type="date"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                          <b-row class="my-1">
                            <b-col sm="4">
                              <label for="input-default">
                                Eid Al Adha
                                <span class="text-danger">*</span>
                              </label>
                            </b-col>
                            <b-col sm="8">
                              <b-form-input
                                v-model="systemSettings.eid_al_adha"
                                @change="savePublicHoliday('eid_al_adha')"
                                id="input-default"
                                type="date"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                          <b-row class="my-1">
                            <b-col sm="4">
                              <label for="input-default">Miscellaneous</label>
                            </b-col>
                            <b-col sm="8">
                              <b-form-input
                                v-model="systemSettings.other_holiday"
                                @change="savePublicHoliday('other_holiday')"
                                id="input-default"
                                type="date"
                              ></b-form-input>
                            </b-col>
                          </b-row>
                        </b-container>
                      </div>
                    </div>
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
import { mapMutations, mapState } from "vuex";
import * as api from "../api/api";
export default {
  data() {
    return {};
  },
  methods: {
    ...mapMutations({
      setSettings: "setSettings",
      setSystemSettings: "setSystemSettings"
    }),
    savePublicHoliday(field) {
      let data = {
        field: field,
        value: this.systemSettings[field]
      };
      api.setHoliday(data);
    },
    toggleButton(field) {
      api.toggleButton(field).then(response => {
        this.loadSettings();
      });
    },
    loadSettings() {
      api.getSettings().then(response => {
        this.setSettings(response.data);
      });
    },
    loadSystemSettings() {
      api.getSystemSettings().then(response => {
        this.setSystemSettings(response.data);
      });
    }
  },
  computed: {
    ...mapState({
      auth: state => state.auth,
      settings: state => state.settings,
      systemSettings: state => state.systemSettings
    })
  },
  mounted() {
    this.loadSettings();
    this.loadSystemSettings();
  }
};
</script>

<style >
</style>
