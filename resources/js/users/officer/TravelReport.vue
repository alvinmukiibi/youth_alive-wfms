<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Trip/Travel Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Trip/Travel Report</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <b-jumbotron bg-variant="primary" text-variant="white" border-variant="dark">
              <h4>TRAVEL/TRIP REPORT</h4>
              <p>A travel/trip report is required for all YA travels. Staff travelling to carry out the same activity should complete one (joint) trip report. The travel/trip report should be submitted to the Supervisor for review and approval prior to the reimbursement of travel receipts.</p>
            </b-jumbotron>
            <hr />
            <div class="card card-outline card-primary">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleFormControlInput1">Name of the Traveller(s)</label>
                      <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Place/Venue</label>
                        <input type="text" class="form-control" id="inputEmail4" />
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputPassword4">Date</label>
                        <input type="text" class="form-control" id="inputPassword4" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlInput1">Project</label>
                      <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlInput1">Other participants involved</label>
                      <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlInput1">Travel Objectives and deliverables</label>
                      <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlInput1">
                        Accomplishments
                        <small class="text-danger">
                          <i>state which objectives identified above was met; and clearly indicates all other accomplishments of the trip</i>
                        </small>
                      </label>
                      <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlInput1">
                        Issues raised, constraints and other matters arising
                        <small
                          class="text-danger"
                        >
                          <i>state issues or concerns arising from the trip, constraints in achieving stated objectives, and any other matters arising</i>
                        </small>
                      </label>
                      <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlInput1">Conclusions and recommendations</label>
                      <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                    </div>
                    <b-table-simple hover small caption-top responsive>
                      <caption>ACTION PLAN</caption>
                      <colgroup>
                        <col />
                        <col />
                        <col />
                      </colgroup>
                      <b-thead>
                        <tr>
                          <b-th colspan="3" class="text-center" variant="dark">ACTION PLAN</b-th>
                        </tr>
                        <tr>
                          <b-th variant="secondary" class="text-left">ACTION</b-th>
                          <b-th variant="secondary" class="text-left">RESPONSIBLE PARTY</b-th>
                          <b-th variant="secondary" class="text-left">COMPLETION DATE</b-th>
                        </tr>
                      </b-thead>
                      <b-tbody>
                        <b-td>
                          <input type="text" class="form-control" />
                        </b-td>
                        <b-td>
                          <input type="text" class="form-control" />
                        </b-td>
                        <b-td>
                          <input type="text" class="form-control" />
                        </b-td>
                      </b-tbody>
                    </b-table-simple>
                    <b-jumbotron bg-variant="primary" text-variant="white" border-variant="dark">
                      <p>Compiled By</p>
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="inputEmail4">Name</label>
                          <input type="text" class="form-control" />
                        </div>
                        <div class="form-group col-md-3">
                          <label for="inputPassword4">Designation</label>
                          <input type="text" class="form-control" />
                        </div>
                        <div class="form-group col-md-3">
                          <label for="inputEmail4">Date</label>
                          <input type="text" class="form-control" />
                        </div>
                        <div class="form-group col-md-3">
                          <label for="inputPassword4">Signature</label>
                          <input type="text" class="form-control" />
                        </div>
                      </div>
                    </b-jumbotron>
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
import * as api from "../../api/api";
import { mapState, mapMutations } from "vuex";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  data() {
    return {
      editor: ClassicEditor,
      editorData: "<p>Content of the editor.</p>",
      editorConfig: {
        // The configuration of the editor.
      }
    };
  },
  methods: {},
  mounted() {},
  computed: {}
};
</script>

<style>
</style>
