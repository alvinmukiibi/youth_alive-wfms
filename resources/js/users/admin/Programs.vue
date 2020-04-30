<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Programs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Programs</li>
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
                <h3 class="card-title">Add Program</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Program</label>
                  <div class="input-group">
                    <input type="text" v-model="text" class="form-control" />
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
                <h3 class="card-title">Program</h3>
              </div>
              <div class="card-body">
                <b-table-simple hover small caption-top responsive>
                  <colgroup>
                    <col />
                    <col style="width:100px" />
                  </colgroup>
                  <b-thead head-variant="dark">
                    <b-tr>
                      <b-th>Program</b-th>

                      <b-th>Action</b-th>
                    </b-tr>
                  </b-thead>
                  <b-tbody>
                    <b-tr v-for="type in programs" :key="type.id">
                      <b-td>{{ type.text }}</b-td>
                      <b-td>
                        <button @click="deleteProg(type.id)" class="btn btn-sm btn-outline-danger">
                          <i class="fa fa-trash"></i>
                        </button>
                        <button
                          @click="setProg(type.id)"
                          type="button"
                          data-toggle="modal"
                          data-target="#modal"
                          class="btn btn-sm btn-outline-primary"
                        >
                          <i class="fa fa-pencil"></i>
                        </button>
                      </b-td>
                    </b-tr>
                  </b-tbody>
                </b-table-simple>
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
                          <input type="text" v-model="program.text" class="form-control" />
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
      text: "",
      prefix: process.env.MIX_API_URL,
      program: []
    };
  },
  methods: {
    ...mapMutations({
      setPrograms: "setPrograms"
    }),
    saveEdit() {
      if (this.program.text == "") {
        return;
      }
      axios
        .post(this.prefix + `/programs/update/${this.program.id}`, {
          text: this.program.text
        })
        .then(response => {
          this.loadPrograms();
          this.showToast("success", "Notification", "success");
        });
    },
    setProg(id) {
      this.program = this.programs.filter(cont => cont.id == id)[0];
    },
    loadPrograms() {
      api.getPrograms().then(response => {
        this.setPrograms(response.data);
      });
    },
    showToast(variant, title, body) {
      this.$bvToast.toast(body, {
        title: title,
        variant: variant,
        solid: true
      });
    },
    deleteProg(id) {
      axios.get(this.prefix + `/programs/delete/${id}`).then(response => {
        this.loadPrograms();
        this.showToast("success", "Notification", "success");
      });
    },
    save() {
      if (this.text == "") {
        return;
      }
      let data = {
        text: this.text
      };
      api.saveProgram(data).then(response => {
        this.loadPrograms();
        this.showToast("success", "Notification", "success");
      });
    }
  },
  computed: {
    ...mapState({
      programs: state => state.programs
    })
  },
  mounted() {
    this.loadPrograms();
  }
};
</script>

<style>
</style>
