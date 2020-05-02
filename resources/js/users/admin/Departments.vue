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
          <div class="col-md-2">
            <button
              type="button"
              data-toggle="modal"
              data-target="#modal"
              class="btn btn-outline-primary btn-block"
            >
              <b>Add Department</b>
            </button>
          </div>
          <div class="col-md-10">
            <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title">Departments</h3>
              </div>
              <div class="card-body">
                <b-table-simple hover small caption-top responsive>
                  <colgroup>
                    <col />
                    <col />
                    <col />
                    <col style="width:100px" />
                  </colgroup>
                  <b-thead head-variant="dark">
                    <b-tr>
                      <b-th>Name</b-th>
                      <b-th>Directorate</b-th>
                      <b-th>Acronym</b-th>
                      <b-th>Action</b-th>
                    </b-tr>
                  </b-thead>
                  <b-tbody>
                    <b-tr v-for="dept in departments" :key="dept.id">
                      <b-td>{{ dept.name }}</b-td>
                      <b-td>{{ dept.directorate }}</b-td>
                      <b-td>{{ dept.acronym }}</b-td>
                      <b-td>
                        <!-- <button @click="deleteDept(dept.id)" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button> -->
                        <button
                          v-if="dept.id !== 4 && dept.id !== 5 && dept.id !== 1 "
                          @click="setDept(dept.id)"
                          type="button"
                          data-toggle="modal"
                          data-target="#editModal"
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
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Department</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Add Department</h3>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for class="col-form-label">
                          Parent Directorate
                          <span class="text-danger">*</span>
                        </label>
                        <select v-model="department.directorate_id" class="form-control">
                          <option disabled>Select Directorate</option>
                          <option v-for="dir in directorates" :value="dir.id" :key="dir.id" >{{ dir.name }}</option\>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for class="col-form-label">
                          Department Name
                          <span class="text-danger">*</span>
                        </label>
                        <input type="text" v-model="department.name" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for class="col-form-label">Department Role</label>
                        <textarea
                          name
                          id
                          cols="5"
                          rows="3"
                          v-model="department.role"
                          class="form-control"
                        ></textarea>
                      </div>
                      <div class="form-group">
                        <label for class="col-form-label">Acronym</label>
                        <input type="text" v-model="department.acronym" class="form-control" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" @click="save" class="btn btn-primary">
                    Save Department
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div
            class="modal fade"
            id="editModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Edit Department</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Edit Department</h3>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for class="col-form-label">
                          Parent Directorate
                          <span class="text-danger">*</span>
                        </label>
                        <select v-model="dept.directorate_id" class="form-control">
                          <option disabled>Select Directorate</option>
                          <option v-for="dir in directorates" :value="dir.id" :key="dir.id" >{{ dir.name }}</option\>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for class="col-form-label">
                          Department Name
                          <span class="text-danger">*</span>
                        </label>
                        <input type="text" v-model="dept.name" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for class="col-form-label">Department Role</label>
                        <textarea
                          name
                          id
                          cols="5"
                          rows="3"
                          v-model="dept.role"
                          class="form-control"
                        ></textarea>
                      </div>
                      <div class="form-group">
                        <label for class="col-form-label">Acronym</label>
                        <input type="text" v-model="dept.acronym" class="form-control" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" @click="saveEdit" class="btn btn-primary">Save changes</button>
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
      department: {},
      dept: []
    };
  },
  methods: {
    ...mapMutations({
      setDepartments: "setDepartments"
    }),
    saveEdit() {
      if (this.dept.name == "") {
        return;
      }
      if (this.dept.acronym == "") {
        return;
      }
      axios
        .post(this.prefix + `/departments/update/${this.dept.id}`, this.dept)
        .then(response => {
          this.loadDepartments();
          this.showToast("success", "Notification", "success");
        });
    },
    setDept(id) {
      this.dept = this.departments.filter(dept => dept.id == id)[0];
    },
    loadDepartments() {
      api.getDepartments().then(response => {
        this.setDepartments(response.data);
      });
    },
    showToast(variant, title, body) {
      this.$bvToast.toast(body, {
        title: title,
        variant: variant,
        solid: true
      });
    },
    deleteDept(id) {
      axios.get(this.prefix + `/departments/delete/${id}`).then(response => {
        this.showToast("success", "Notification", "success");
        this.loadDepartments();
      });
    },
    save() {
      if (this.department.name == "") {
        return;
      }
      if (this.department.acronym == "") {
        return;
      }
      if (this.department.directorate_id == "") {
        return;
      }
      axios
        .post(this.prefix + "/departments", this.department)
        .then(response => {
          this.loadDepartments();
          this.showToast("success", "Notification", "success");
        });
    }
  },
  computed: {
    ...mapState({
      departments: state => state.departments,
      directorates: state => state.directorates,
      users: state => state.users
    })
  },
  mounted() {
    this.loadDepartments();
  }
};
</script>

<style>
</style>
