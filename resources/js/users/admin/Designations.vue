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
                <h3 class="card-title">Add Designation</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Designation</label>
                  <div class="input-group">
                    <input type="text" v-model="name" class="form-control" />
                    <span class="input-group-append">
                      <button type="button" @click="save" class="btn btn-primary btn-flat">Submit</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title">Designation</h3>
              </div>
              <div class="card-body">
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Designation</th>
                      <th style="width:100px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="type in designations" :key="type.id">
                      <td>{{ type.name }}</td>
                      <td>
                        <button @click="deleteDesi(type.id)" class="btn btn-sm btn-outline-danger">
                          <i class="fa fa-trash"></i>
                        </button>
                        <button
                          @click="setDesi(type.id)"
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
                        <div class="input-group">
                          <input type="text" v-model="designation.name" class="form-control" />
                          <span class="input-group-append">
                            <button
                              type="button"
                              @click="saveEdit"
                              class="btn btn-primary btn-flat"
                            >
                              Save
                              <i class="fa fa-save"></i>
                            </button>
                          </span>
                        </div>
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
      designation: []
    };
  },
  methods: {
    ...mapMutations({
      setDesignations: "setDesignations"
    }),
    saveEdit() {
      if (this.designation.name == "") {
        return;
      }
      axios
        .post(this.prefix + `/designations/update/${this.designation.id}`, {
          name: this.designation.name
        })
        .then(response => {
          this.loadDesignations();
        });
    },
    setDesi(id) {
      this.designation = this.designations.filter(cont => cont.id == id)[0];
    },
    loadDesignations() {
      api.getDesignations().then(response => {
        this.setDesignations(response.data);
      });
    },
    deleteDesi(id) {
      axios.get(this.prefix + `/designations/delete/${id}`).then(response => {
        this.loadDesignations();
      });
    },
    save() {
      if (this.name == "") {
        return;
      }
      let data = {
        name: this.name
      };
      api.saveDesignation(data).then(response => {
        this.loadDesignations();
      });
    }
  },
  computed: {
    ...mapState({
      designations: state => state.designations
    })
  },
  mounted() {}
};
</script>

<style>
</style>
