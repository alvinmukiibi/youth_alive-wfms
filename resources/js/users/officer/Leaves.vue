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
              <li class="breadcrumb-item active">Leaves</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">
            <!-- data-backdrop="false"
            data-dismiss="modal"-->
            <button
              type="button"
              data-toggle="modal"
              data-target="#modal"
              class="btn btn-outline-primary btn-block"
            >
              <b>Ask For Leave</b>
              <i class="fa fa-plus"></i>
            </button>
          </div>
          <div class="col-md-10">
            <div class="card card-success card-outline">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item">
                    <a class="nav-link active" href="#myleaves" data-toggle="tab">
                      <i class="fa fa-list-alt"></i> My Leaves
                    </a>
                  </li>
                  <li v-if="auth.user_type == 'manager'" class="nav-item">
                    <a
                      @click="loadPendingLeaves"
                      class="nav-link"
                      href="#pendingapprovals"
                      data-toggle="tab"
                    >
                      <i class="fa fa-circle-o"></i> Pending Approvals
                      <span
                        v-if="spinner"
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                      ></span>
                    </a>
                  </li>
                  <li v-if="auth.user_type == 'director'" class="nav-item">
                    <a
                      @click="loadPendingLeaves"
                      class="nav-link"
                      href="#pendingapprovalsdirector"
                      data-toggle="tab"
                    >
                      <i class="fa fa-circle-o"></i> Pending Approvals
                      <span
                        v-if="spinner"
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                      ></span>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="myleaves">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Date of Request</th>
                          <th>Type</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Duration</th>
                          <th>Comments</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="le in myLeaves" :key="le.id">
                          <td>{{ le.request_date }}</td>
                          <td>{{ le.leave_type }}</td>
                          <td>{{ le.leave_first_day }}</td>
                          <td>{{ le.leave_last_day }}</td>
                          <td>{{ le.duration_of_leave }}</td>
                          <td>
                            <b-button :id="'pock' + le.id" variant="primary btn-sm">
                              <i class="fa fa-eye"></i>
                            </b-button>
                            <b-popover
                              placement="top"
                              :target="'pock' + le.id"
                              triggers="hover focus"
                            >
                              <template slot="title">Comments</template>
                              <p>{{ le.comments }}</p>
                            </b-popover>
                          </td>
                          <td>
                            <button
                              v-if="le.status < 3"
                              title="Not yet approved"
                              class="btn btn-sm btn-warning"
                            >
                              <b>P</b>
                            </button>
                            <button
                              v-if="le.status == 3"
                              title="Approved"
                              class="btn btn-sm btn-success"
                            >
                              <b>
                                <i class="fa fa-check"></i>
                              </b>
                            </button>
                            <button
                              v-if="le.status == 5"
                              title="Leave was taken and is past"
                              class="btn btn-sm btn-secondary"
                            >
                              <b>G</b>
                            </button>
                            <button
                              v-if="le.status == 4"
                              title="Leave was denied"
                              class="btn btn-sm btn-danger"
                            >
                              <b>D</b>
                            </button>
                            <button
                              v-if="le.status == 6"
                              title="You cancelled this leave"
                              class="btn btn-sm btn-dark"
                            >
                              <b>C</b>
                            </button>
                          </td>
                          <td>
                            <button
                              v-if="le.status < 3"
                              @click="cancel(le.id)"
                              title="Cancel Request"
                              class="btn btn-sm btn-danger"
                            >
                              <b>
                                <i class="fa fa-times"></i>
                              </b>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="pendingapprovals">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Date Made</th>
                          <th>Staff</th>
                          <th>Type</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Duration</th>
                          <th></th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="lea in pendingLeaves" :key="lea.id">
                          <td>{{ lea.request_date }}</td>
                          <td>{{ lea.user }}</td>
                          <td>{{ lea.leave_type }}</td>
                          <td>{{ lea.leave_first_day }}</td>
                          <td>{{ lea.leave_last_day }}</td>
                          <td>{{ lea.duration_of_leave + ' days' }}</td>
                          <td>
                            <b-button :id="'pocke' + lea.id" variant="primary btn-sm">
                              <i class="fa fa-eye"></i>
                            </b-button>
                            <b-popover
                              placement="top"
                              :target="'pocke' + lea.id"
                              triggers="hover focus"
                            >
                              <template slot="title">Comments</template>
                              <p>{{ lea.comments }}</p>
                            </b-popover>
                          </td>
                          <td>
                            <button
                              v-if="auth.department != 'Human Resource' && lea.status == 0"
                              title="Not yet approved"
                              class="btn btn-sm btn-warning"
                            >
                              <b>P</b>
                            </button>
                            <button
                              v-if="auth.department == 'Human Resource' && (lea.status == 0 || lea.status == 1)"
                              title="Not yet approved"
                              class="btn btn-sm btn-warning"
                            >
                              <b>P</b>
                            </button>
                            <button
                              v-if="auth.department != 'Human Resource' && (lea.status == 1 || lea.status == 2 || lea.status == 3)"
                              title="Approved"
                              class="btn btn-sm btn-success"
                            >
                              <b>
                                <i class="fa fa-check"></i>
                              </b>
                            </button>
                            <button
                              v-if="auth.department == 'Human Resource' && (lea.status == 2 || lea.status == 3)"
                              title="Approved"
                              class="btn btn-sm btn-success"
                            >
                              <b>
                                <i class="fa fa-check"></i>
                              </b>
                            </button>
                            <b-button
                              v-if="lea.status == 4"
                              :id="'pockex' + lea.id"
                              title="Leave was denied"
                              variant="btn btn-sm btn-danger"
                            >
                              <b>D</b>
                            </b-button>
                            <b-popover
                              placement="top"
                              :target="'pockex' + lea.id"
                              triggers="hover focus"
                            >
                              <template slot="title">Reason given</template>
                              <p>{{ lea.reason }}</p>
                            </b-popover>
                          </td>
                          <td>
                            <button
                              v-if="auth.department != 'Human Resource' && lea.status == 0"
                              @click="setLeave(lea.id)"
                              data-toggle="modal"
                              data-target="#declineModal"
                              title="Decline Request"
                              class="btn btn-sm btn-danger"
                            >
                              <b>
                                <i class="fa fa-times"></i>
                              </b>
                            </button>
                            <button
                              v-if="auth.department == 'Human Resource' && (lea.status == 0 || lea.status == 1)"
                              @click="setLeave(lea.id)"
                              data-toggle="modal"
                              data-target="#declineModal"
                              title="Decline Request"
                              class="btn btn-sm btn-danger"
                            >
                              <b>
                                <i class="fa fa-times"></i>
                              </b>
                            </button>
                            <button
                              v-if="auth.department != 'Human Resource' && lea.status == 0"
                              @click="approve(lea.id)"
                              title="Approve Request"
                              class="btn btn-sm btn-success"
                            >
                              <b>
                                <i class="fa fa-check"></i>
                              </b>
                            </button>
                            <button
                              v-if="auth.department == 'Human Resource' && (lea.status == 0 || lea.status == 1)"
                              @click="approve(lea.id)"
                              title="Approve Request"
                              class="btn btn-sm btn-success"
                            >
                              <b>
                                <i class="fa fa-check"></i>
                              </b>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="pendingapprovalsdirector">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Date Made</th>
                          <th>Staff</th>
                          <th>Type</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Duration</th>
                          <th></th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="lea in pendingLeaves" :key="lea.id">
                          <td>{{ lea.request_date }}</td>
                          <td>{{ lea.user }}</td>
                          <td>{{ lea.leave_type }}</td>
                          <td>{{ lea.leave_first_day }}</td>
                          <td>{{ lea.leave_last_day }}</td>
                          <td>{{ lea.duration_of_leave + ' days' }}</td>
                          <td>
                            <b-button :id="'pockee' + lea.id" variant="primary btn-sm">
                              <i class="fa fa-eye"></i>
                            </b-button>
                            <b-popover
                              placement="top"
                              :target="'pockee' + lea.id"
                              triggers="hover focus"
                            >
                              <template slot="title">Comments</template>
                              <p>{{ lea.comments }}</p>
                            </b-popover>
                          </td>
                          <td>
                            <button
                              v-if="lea.user_type == 'officer' && lea.status == 2"
                              title="Not yet approved"
                              class="btn btn-sm btn-warning"
                            >
                              <b>P</b>
                            </button>
                            <button
                              v-if="lea.user_type == 'manager' && lea.status == 0"
                              title="Not yet approved"
                              class="btn btn-sm btn-warning"
                            >
                              <b>P</b>
                            </button>
                            <button
                              v-if="lea.user_type == 'officer' && lea.status == 3"
                              title="Approved"
                              class="btn btn-sm btn-success"
                            >
                              <b>
                                <i class="fa fa-check"></i>
                              </b>
                            </button>
                            <button
                              v-if="lea.user_type == 'manager' && lea.status == 1"
                              title="Approved"
                              class="btn btn-sm btn-success"
                            >
                              <b>
                                <i class="fa fa-check"></i>
                              </b>
                            </button>
                            <b-button
                              v-if="lea.status == 4"
                              :id="'pockex' + lea.id"
                              title="Leave was denied"
                              variant="btn btn-sm btn-danger"
                            >
                              <b>D</b>
                            </b-button>
                            <b-popover
                              placement="top"
                              :target="'pockex' + lea.id"
                              triggers="hover focus"
                            >
                              <template slot="title">Reason given</template>
                              <p>{{ lea.reason }}</p>
                            </b-popover>
                          </td>
                          <td>
                            <button
                              v-if="lea.user_type == 'officer' && lea.status == 2"
                              @click="setLeave(lea.id)"
                              data-toggle="modal"
                              data-target="#declineModal"
                              title="Decline Request"
                              class="btn btn-sm btn-danger"
                            >
                              <b>
                                <i class="fa fa-times"></i>
                              </b>
                            </button>
                            <button
                              v-if="lea.user_type == 'manager' && lea.status == 0"
                              @click="setLeave(lea.id)"
                              data-toggle="modal"
                              data-target="#declineModal"
                              title="Decline Request"
                              class="btn btn-sm btn-danger"
                            >
                              <b>
                                <i class="fa fa-times"></i>
                              </b>
                            </button>
                            <button
                              v-if="lea.user_type == 'officer' && lea.status == 2"
                              @click="approve(lea.id)"
                              title="Approve Request"
                              class="btn btn-sm btn-success"
                            >
                              <b>
                                <i class="fa fa-check"></i>
                              </b>
                            </button>
                            <button
                              v-if="lea.user_type == 'manager' && lea.status == 0"
                              @click="approve(lea.id)"
                              title="Approve Request"
                              class="btn btn-sm btn-success"
                            >
                              <b>
                                <i class="fa fa-check"></i>
                              </b>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
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
                  <h5 class="modal-title" id="exampleModalLongTitle">Ask For Leave</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Ask for leave</h3>
                    </div>
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="type">Leave Type</label>
                          <select v-model="leave.leave_type_id" id class="form-control">
                            <option disabled value>Select Leave Type</option>
                            <option
                              v-for="leaveType in leaveTypes"
                              :key="leaveType.id"
                              :value="leaveType.id"
                            >{{ leaveType.type }}</option>
                          </select>
                        </div>
                      </div>
                      <!-- <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="type">Max Days</label>
                          <input readonly v-model="max_days" class="form-control" />
                        </div>
                      </div>-->
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="type">Start Date</label>
                          <input v-model="leave.from" type="date" class="form-control" />
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="type">End Date</label>
                          <input v-model="leave.to" type="date" class="form-control" />
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="type">Comments...</label>
                          <textarea
                            v-model="leave.comments"
                            name
                            id
                            cols="3"
                            rows="3"
                            class="form-control"
                          ></textarea>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-12" v-if="errors.length > 0">
                          <p class="text-danger pull-left">{{ errors }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button @click="save" class="btn btn-primary btn-flat">
                    <span
                      v-if="loading == true"
                      class="spinner-border spinner-border-sm"
                      role="status"
                      aria-hidden="true"
                    ></span>
                    <b>REQUEST</b>
                    <i class="fa fa-save"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div
            class="modal fade"
            id="declineModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Reason</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Give Reason</h3>
                    </div>
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="type">Reason</label>
                          <textarea
                            v-model="dec.reason"
                            name
                            id
                            cols="3"
                            rows="3"
                            class="form-control"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button @click="decline" class="btn btn-primary btn-flat">
                    <b>CONTINUE</b>
                  </button>
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
import { mapState, mapMutations } from "vuex";
import * as api from "../../api/api";
export default {
  data() {
    return {
      spinner: false,
      dec: {
        id: null,
        reason: null
      },
      leave: {
        leave_type_id: null,
        from: null,
        to: null,
        comments: null
      },
      max_days: null,
      loading: false,
      myLeaves: [],
      pendingLeaves: []
    };
  },
  methods: {
    ...mapMutations({
      setErrors: "setErrors",
      setMyLeaves: "setMyLeaves"
    }),
    setLeave(id) {
      this.dec.id = id;
    },
    approve(id) {
      api.approveLeave(id).then(response => {
        this.loadPendingLeaves();
      });
    },
    decline() {
      api.declineLeave(this.dec).then(response => {
        $(".modal").modal("hide");
        this.loadPendingLeaves();
      });
    },
    loadPendingLeaves() {
      this.spinner = true;
      api.getPendingLeaves().then(response => {
        this.pendingLeaves = response.data;
        this.spinner = false;
      });
    },
    cancel(id) {
      api.cancelLeave(id).then(response => {
        this.loadMyLeaves();
      });
    },
    loadMyLeaves() {
      api.getMyLeaves().then(response => {
        this.myLeaves = response.data;
      });
    },
    save() {
      this.loading = true;
      api.askForLeave(this.leave).then(response => {
        if (!response.success) {
          this.setErrors(response.data.error);
          this.loading = false;
          return;
        }
        this.setErrors([]);
        this.loading = false;
        // this.leave.leave_type_id = null
        // this.leave.from = null
        // this.leave.to = null
        // this.leave.comments = null
        $(".modal").modal("hide");
        this.loadMyLeaves();
      });
    }
    // setMaxDays() {
    //   if (this.leave.leave_type_id != null) {
    //     this.max_days = this.leaveTypes.filter(
    //       lt => lt.id == this.leave.leave_type_id
    //     )[0]["days"];
    //   }
    // }
  },
  mounted() {
    this.loadMyLeaves();
  },
  computed: {
    ...mapState({
      auth: state => state.auth,
      leaveTypes: state => state.leaveTypes,
      errors: state => state.errors
    })
  }
};
</script>

<style>
</style>
