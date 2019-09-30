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
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Add Leave Type</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Leave Type</label>
                  <input
                    type="text"
                    v-model="leave.type"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="e.g. Sick"
                  />
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Number of days</label>
                  <input
                    type="number"
                    v-model="leave.days"
                    min="0"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="e.g. 21"
                  />
                </div>

                <button type="button" @click="save" class="btn btn-primary btn-flat">Submit</button>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title">Leave Types</h3>
              </div>
              <div class="card-body">
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Type</th>
                      <th># Days</th>
                      <th style="width:100px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="le in leavetypes" :key="le.id">
                      <td>{{ le.type }}</td>
                      <td>{{ le.days }}</td>
                      <td>
                        <button @click="deleteType(le.id)" class="btn btn-sm btn-outline-danger">
                          <i class="fa fa-trash"></i>
                        </button>
                        <button
                          @click="setType(le.id)"
                          type="button"
                          data-toggle="modal"
                          data-target="#modal"
                          class="btn btn-sm btn-outline-primary"
                        >
                          <i class="fa fa-pencil"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div
              class="modal fade"
              id="modal"
              tabindex="-1"
              role="dialog"
              aria-labelledby="exampleModalCenterTitle"
              aria-hidden="true"
            >
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="card card-secondary card-outline">
                      <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Leave Type</label>
                          <input
                            type="text"
                            v-model="leav.type"
                            class="form-control"
                            id="exampleInputEmail1"
                            placeholder="e.g. Sick"
                          />
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Number of days</label>
                          <input
                            type="number"
                            v-model="leav.days"
                            min="0"
                            class="form-control"
                            id="exampleInputEmail1"
                            placeholder="e.g. 21"
                          />
                        </div>

                        <button
                          type="button"
                          @click="saveEdit"
                          class="btn btn-primary btn-flat"
                        >Submit</button>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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
import * as api from "./../../api/api";
import { mapState, mapMutations } from "vuex";
export default {
  data() {
    return {
      edit: false,
      name: "",
      prefix: process.env.MIX_API_URL,
      leave: {
        type: "",
        days: 0
      },
      leav: []
    };
  },
  methods: {
    ...mapMutations({
      setLeaveTypes: "setLeaveTypes"
    }),
    saveEdit() {
      if (this.leav.type == "") {
        return;
      }
      axios
        .post(
          this.prefix + `/admin/leavetypes/update/${this.leav.id}`,
          this.leav
        )
        .then(response => {
          this.showToast("success", "Notification", "Success");
          this.loadLeaveTypes();
        });
    },
    setType(id) {
      this.leav = this.leavetypes.filter(cont => cont.id == id)[0];
    },
    loadLeaveTypes() {
      api.getLeaveTypes().then(response => {
        this.setLeaveTypes(response);
      });
    },
    deleteType(id) {
      axios
        .get(this.prefix + `/admin/leavetypes/delete/${id}`)
        .then(response => {
          this.loadLeaveTypes();
          this.showToast("success", "Notification", "Success");
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
      if (this.leave.type == "") {
        return;
      }
      // if(this.leave.days == 0){
      //     return;
      // }

      api.saveLeaveType(this.leave).then(response => {
        this.showToast("success", "Notification", "Success");
        this.loadLeaveTypes();
      });
    }
  },
  computed: {
    ...mapState({
      leavetypes: state => state.leaveTypes
    })
  },
  mounted() {
    this.loadLeaveTypes();
  }
};
</script>

<style>
</style>
