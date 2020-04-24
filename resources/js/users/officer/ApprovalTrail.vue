
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
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Add Comments</label>
                    <textarea class="form-control" v-model="new_note" cols="5" rows="3"></textarea>
                    <!-- <ckeditor :editor="editor" :config="editorConfig"></ckeditor> -->
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-4">
                    <button @click="saveNotes" class="btn btn-primary btn-flat">
                      Save Comment
                      <span
                        v-if="spin2"
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                      ></span>
                    </button>
                  </div>
                </div>
                <div class="card card-success card-line">
                  <div class="card-body">
                    <b-list-group>
                      <b-list-group-item v-for="not in request.notes" :key="not.id">
                        {{ not.note }}
                        <small class="text-secondary">{{ not.user }}</small>
                        <small class="text-secondary">{{ not.date_made }}</small>
                      </b-list-group-item>
                    </b-list-group>
                    <a style="font-weight:500">
                      <br />
                    </a>
                  </div>
                </div>

                <hr />
                <h6>Upload Attachments</h6>
                <div class="form-group">
                  <div class="input-group">
                    <input
                      type="file"
                      @change="uploadAttachments"
                      class="form-control"
                      ref="att"
                      multiple="multiple"
                    />
                    <span class="input-group-append">
                      <button
                        type="button"
                        @click="saveAttachments"
                        class="btn btn-primary btn-flat"
                      >
                        Upload
                        <span
                          v-if="spinner"
                          class="spinner-border spinner-border-sm"
                          role="status"
                          aria-hidden="true"
                        ></span>
                      </button>
                    </span>
                  </div>
                </div>
                <div class="card card-success card-line">
                  <div class="card-body">
                    <b-list-group>
                      <b-list-group-item
                        :href="'/storage/attachments/' + attach"
                        v-for="attach in request.attachments"
                        :key="attach"
                      >{{ attach }}</b-list-group-item>
                    </b-list-group>
                    <a style="font-weight:500">
                      <br />
                    </a>
                  </div>
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
                <button @click="downloadPage('tabl')" class="btn-sm btn btn-primary">
                  <i class="fa fa-print"></i> Print
                  <span
                    v-if="spin1"
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                  ></span>
                </button>
                <div ref="tabl">
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
                        <!-- <b-th>Source</b-th> -->
                        <b-th>Status</b-th>
                        <b-th>Date</b-th>
                        <b-th>Done By</b-th>
                        <b-th colspan="3">Comments</b-th>
                      </b-tr>
                    </b-thead>
                    <b-tbody>
                      <b-tr v-if="request.trail.accountant_approval != 0">
                        <!-- <b-td>Project Accountant</b-td> -->
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
                        <!-- <b-td>Supervisor</b-td> -->
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
                        <!-- <b-td>Finance Manager</b-td> -->
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
                        <!-- <b-td>Line Director</b-td> -->
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
                        <!-- <b-td>Executive Director</b-td> -->
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
      </div>
    </section>
  </div>
</template>

<script>
import * as api from "../../api/api";
import { mapState, mapMutations } from "vuex";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  data() {
    return {
      new_note: "",
      spinner: false,
      attachments: new FormData(),
      spin1: false,
      spin2: false,
      editor: ClassicEditor,
      editorConfig: {
        toolbar: [
          "heading",
          "|",
          "bold",
          "italic",
          "bulletedList",
          "numberedList",
          "blockQuote"
        ],
        heading: {
          options: [
            {
              model: "paragraph",
              title: "Paragraph",
              class: "ck-heading_paragraph"
            },
            {
              model: "heading1",
              view: "h1",
              title: "Heading 1",
              class: "ck-heading_heading1"
            },
            {
              model: "heading2",
              view: "h2",
              title: "Heading 2",
              class: "ck-heading_heading2"
            }
          ]
        }
      }
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
    ...mapMutations({
      setRequestAttachments: "setRequestAttachments",
      setRequestNotes: "setRequestNotes"
    }),
    saveNotes() {
      this.spin2 = true;
      let data = {
        request_id: this.request.id,
        notes: this.new_note
      };
      api.saveNotes(data).then(response => {
        this.getRequestNotes(this.request.id);
        this.spin2 = false;
        this.showToast("success", "Notification", response.message);
      });
    },
    downloadFile(id) {
      api.downloadAttachment(id).then(response => {
        console.log(response);
      });
    },
    downloadPage(page) {
      this.spin1 = true;
      var name = "";
      const doc = new jsPDF();
      var canvasElement = document.createElement("canvas");
      html2canvas(this.$refs[page], { canvas: canvasElement }).then(function(
        canvas
      ) {
        const img = canvas.toDataURL("image/jpeg", 0.8);
        doc.addImage(img, "JPEG", 20, 20);
        name = "Downloadable.pdf";
        doc.save(name);
      });
      this.spin1 = false;
    },
    showToast(variant, title, body) {
      this.$bvToast.toast(body, {
        title: title,
        variant: variant,
        solid: true
      });
    },
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
        this.getRequestAttachments(this.request.id);
        this.showToast(
          "success",
          "Notification",
          "Attachments saved successfully"
        );
        this.spinner = false;
      });
    },
    getRequestAttachments(id) {
      api.getRequestAttachments(id).then(response => {
        this.setRequestAttachments(response.data);
      });
    },
    getRequestNotes(id) {
      api.getRequestNotes(id).then(response => {
        this.setRequestNotes(response.data);
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
