
<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Approval Trail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Approval Trail</li>
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
              <div class="card-body">
                <h6>Upload Attachments</h6>
                <div class="form-group">
                  <!-- <b-form-file
                    multiple
                    v-model="attachments"
                    placeholder="Choose a file or drop it here..."
                    drop-placeholder="Drop file here..."
                    accept=".jpg, .png, .gif, .doc, .docx, .xls, .xlsx, .pdf, .ppt, .pptx, .jpeg, .txt"
                  ></b-form-file>-->
                  <div class="input-group">
                  <input
                    type="file"
                    @change="uploadAttachments"
                    class="form-control"
                    ref="att"
                    multiple="multiple"
                  />
                  <span class="input-group-append">
                    <button type="button" @click="saveAttachments" class="btn btn-primary btn-flat">
                      Upload
                      <span
                        v-if="spinner"
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                      ></span>
                    </button>
                  </span></div>
                </div>

                <hr />
                <div class="form-group row">
                  <label class="col-sm-2">Requestor’s Name :</label>
                  <div class="col-sm-4">{{ request.user }}</div>
                  <label class="col-sm-2">Date of Request :</label>
                  <div class="col-sm-4">{{ request.created_at }}</div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2">Activity :</label>
                  <div class="col-sm-4">{{ request.activity_type }}</div>
                  <label class="col-sm-2">Project :</label>
                  <div class="col-sm-4">{{ request.project }}</div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2">Request ID :</label>
                  <div class="col-sm-4">{{ request.identity }}</div>
                  <label class="col-sm-2">Documents Filled :</label>
                  <div class="col-sm-4">{{ request.doc_completion_status | showdocs }}</div>
                </div>
                <hr />
                <b-table-simple small caption-top responsive>
                  <colgroup>
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                  </colgroup>

                  <b-thead head-variant="dark">
                    <b-tr>
                      <b-th>Source</b-th>
                      <b-th>Status</b-th>
                      <b-th>Date</b-th>
                      <b-th>Done By</b-th>
                      <b-th colspan="3">Comments</b-th>
                    </b-tr>
                  </b-thead>
                  <b-tbody>
                    <b-tr v-if="request.trail.accountant_approval != 0">
                      <b-td>Project Accountant</b-td>
                      <b-td v-if="request.trail.accountant_approval == 1">
                        <button class="btn btn-sm btn-success">
                          <i class="fa fa-check"></i>
                        </button>
                      </b-td>
                      <b-td v-else>
                        <button class="btn btn-sm btn-danger">
                          <i class="fa fa-times"></i>
                        </button>
                      </b-td>
                      <b-td>{{ request.trail.acc_appro_date }}</b-td>
                      <b-td>{{ request.trail.accountant }}</b-td>
                      <b-td>{{ request.trail.acc_comments }}</b-td>
                    </b-tr>
                    <b-tr v-if="request.trail.level_one_approval != 0">
                      <b-td>L1</b-td>
                      <b-td v-if="request.trail.level_one_approval == 1">
                        <button class="btn btn-sm btn-success">
                          <i class="fa fa-check"></i>
                        </button>
                      </b-td>
                      <b-td v-else>
                        <button class="btn btn-sm btn-danger">
                          <i class="fa fa-times"></i>
                        </button>
                      </b-td>
                      <b-td>{{ request.trail.level_one_date }}</b-td>
                      <b-td>{{ request.trail.level_one_approver }}</b-td>
                      <b-td>{{ request.trail.level_one_comments }}</b-td>
                    </b-tr>
                    <b-tr
                      v-if="request.trail.finance_approval != 0 && request.trail.finance_approval != null"
                    >
                      <b-td>FM</b-td>
                      <b-td v-if="request.trail.finance_approval == 1">
                        <button class="btn btn-sm btn-success">
                          <i class="fa fa-check"></i>
                        </button>
                      </b-td>
                      <b-td v-else>
                        <button class="btn btn-sm btn-danger">
                          <i class="fa fa-times"></i>
                        </button>
                      </b-td>
                      <b-td>{{ request.trail.finance_approval_date }}</b-td>
                      <b-td>{{ request.trail.finance_approver }}</b-td>
                      <b-td>{{ request.trail.finance_appro_comments }}</b-td>
                    </b-tr>
                    <b-tr
                      v-if="request.trail.level_two_approval != 0 && request.trail.level_two_approval != null"
                    >
                      <b-td>L2</b-td>
                      <b-td v-if="request.trail.level_two_approval == 1">
                        <button class="btn btn-sm btn-success">
                          <i class="fa fa-check"></i>
                        </button>
                      </b-td>
                      <b-td v-else>
                        <button class="btn btn-sm btn-danger">
                          <i class="fa fa-times"></i>
                        </button>
                      </b-td>
                      <b-td>{{ request.trail.level_two_date }}</b-td>
                      <b-td>{{ request.trail.level_two_approver }}</b-td>
                      <b-td>{{ request.trail.level_two_comments }}</b-td>
                    </b-tr>
                    <b-tr
                      v-if="request.trail.level_three_approval != 0 && request.trail.level_three_approval != null"
                    >
                      <b-td>L3</b-td>
                      <b-td v-if="request.trail.level_three_approval == 1">
                        <button class="btn btn-sm btn-success">
                          <i class="fa fa-check"></i>
                        </button>
                      </b-td>
                      <b-td v-else>
                        <button class="btn btn-sm btn-danger">
                          <i class="fa fa-times"></i>
                        </button>
                      </b-td>
                      <b-td>{{ request.trail.level_three_date }}</b-td>
                      <b-td>{{ request.trail.level_three_approver }}</b-td>
                      <b-td>{{ request.trail.level_three_comments }}</b-td>
                    </b-tr>
                  </b-tbody>
                </b-table-simple>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import * as api from "../../api/api";
import { mapState, mapMutations } from "vuex";
export default {
  data() {
    return {
      spinner: false,
      attachments: new FormData()
    };
  },
  filters: {
    showdocs(value) {
      let docs = JSON.parse(value);
      let newdocs = [];
      docs.forEach(elem => {
        if (elem.status) {
          if (elem.doc == "bgt") {
            newdocs.push("TSoW Budget");
          }
          if (elem.doc == "tsw") {
            newdocs.push("Travel Scope of Work");
          }
          if (elem.doc == "vhr") {
            newdocs.push("Vehicle & Hotel Request Form");
          }
        }
      });
      return newdocs;
    }
  },
  methods: {
    uploadAttachments() {
      let files = this.$refs.att.files;
      for (let i = 0; i < files.length; i++) {
        this.attachments.append("attachments[]", files[i]);
      }
    },
    saveAttachments() {
      this.spinner = true;
      this.attachments.append("request_id", this.request.id);
      api.saveAttachments(this.attachments).then(response => {
        this.spinner = false;
      });
    }
  },
  mounted() {},
  computed: {
    ...mapState({
      request: state => state.request
    })
  }
};
</script>

<style>
</style>
