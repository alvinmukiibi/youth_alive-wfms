<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Activity Report Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Activity Report</li>
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
              <h4>INSTRUCTIONS:</h4>
              <hr class="my-4" />
              <ol style="text-align:justify">
                <li>The main purpose of this report is to provide key technical information about activities that have been implemented by project/field officers</li>
                <li>An activity reporting form should be filled in by implementers of all Youth Alive activities that are laid out in the detailed implementation plan.</li>
                <li>It is recommended that an activity Reporting Form be dully filled in by the person/team responsible for implementing the activity not letter than 48 hours (02 days) after the completion of the planned activity. This is to allow accurate recall of what was done.</li>
                <li>A dully filled activity report form must be submitted to the responsible officer accompanied with all primary data tools not later than 48 hours after activity implementation</li>
                <li>At the end of the month, all completed activity reports for the activities that have been implemented in that particular month will be attached to a summary Monthly reporting Form and sent to the Project Manager not letter than the later than the last day of the reporting month.</li>
                <li>A monthly report will be then written by the project manager and submitted to the MEL Manager not letter that the 05th day of the reporting month.</li>
                <li>It is recommended that this report be detailed and filled in soft copy to enable expansion of space, but delivered in hard signed copies</li>
              </ol>
            </b-jumbotron>
            <!-- <hr class="my-4" /> -->
            <div class="card card-outline card-secondary">
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleFormControlInput1">Project title and Donor</label>
                  <input type="text" class="form-control" />
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Intervention Area</label>
                  <input type="text" class="form-control" />
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">District</label>
                    <input type="text" class="form-control" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">Site of activity</label>
                    <input type="text" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Name and Nature of Activity</label>
                  <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="form-group">
                  <label
                    for="exampleFormControlInput1"
                  >Activity code and brief description of activity</label>
                  <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">Planned cost of Activity</label>
                    <input type="text" class="form-control" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">Commencement date</label>
                    <input type="text" class="form-control" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">Actual Cost of Activity</label>
                    <input type="text" class="form-control" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">Closing Date</label>
                    <input type="text" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">
                    Objectives of this particular activity
                    <small class="text-danger">
                      **
                      <i>please show linkage to work plan</i>**
                    </small>
                  </label>
                  <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">
                    Methodology of implementation and activity development
                    <small
                      class="text-danger"
                    >
                      **
                      <i>please describe how activity was implemented including materials and modes of delivery, role plays discussions etc. and attach activity work plan</i>**
                    </small>
                  </label>
                  <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">
                    Achievements
                    <small class="text-danger">
                      **
                      <i>please compare achievements against what was planned and include numbers and relevant evidence wherever applicable, summary of pre and posttests, participant’s evaluation, action plans etc.</i>**
                    </small>
                  </label>
                  <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">
                    Challenges / constraints faced
                    <small class="text-danger">
                      **
                      <i>technical and operational factors that affected what was planned and not achieved</i>
                    </small>
                  </label>
                  <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">
                    Solutions to these challenges / constraints
                    <small class="text-danger">
                      **
                      <i>please note that these could adopted to better future sessions of this activity</i>
                    </small>
                  </label>
                  <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">
                    Lessions learned and recommendations
                    <small class="text-danger">
                      **
                      <i>please include follow-up and action required</i>
                    </small>
                  </label>
                  <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">
                    Best Practices
                    <small class="text-danger">
                      **
                      <i>what worked best during activity implementation that can better other implementations</i>
                    </small>
                  </label>
                  <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">
                    Success story(`ies)
                    <small class="text-danger">
                      **
                      <i>attach written testimonies and photographs</i>
                    </small>
                  </label>
                  <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Implementing field office</label>
                  <input type="text" class="form-control" />
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Facilitator(s)</label>
                  <input type="text" class="form-control" />
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">
                    Technical / Supervisory who attended
                    <small class="text-danger">
                      **
                      <i>please include how many where invited (if any) and how many actually attended</i>
                    </small>
                  </label>
                  <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <hr />
                <b-jumbotron bg-variant="primary" text-variant="white" border-variant="dark">
                  <p>This activity report was filled in by</p>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="inputEmail4">Name</label>
                      <input type="text" class="form-control" />
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputPassword4">Staff ID</label>
                      <input type="text" class="form-control" />
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputEmail4">Position</label>
                      <input type="text" class="form-control" />
                    </div>
                    <div class="form-group col-md-3">
                      <label for="inputPassword4">Date</label>
                      <input type="text" class="form-control" />
                    </div>
                  </div>
                </b-jumbotron>
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
