<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Travel Scope of Work</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Travel Scope of Work</li>
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
              <h4>TRAVEL SCOPE OF WORK</h4>
              <p>A Travel Scope of Work (SoW) is required for all YA relatad travels. Staff travelling to carry out the same activity should complete one (joint) SoW. The SoW should be submitted to the Supervisor for review and approval prior to the travel and a copy attached to any advance request related to the trip</p>
            </b-jumbotron>
            <hr />
            <div class="card card-outline card-primary">
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Name of Traveller(s)</label>
                    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Project</label>
                    <input type="text" class="form-control" />
                  </div>
                  <div class="form-group col-md-6">
                    <label>Date</label>
                    <input type="text" class="form-control" />
                    <!-- <VueCtkDateTimePicker position="top" v-model="date" /> -->
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Destinations</label>
                    <input type="text" class="form-control" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label>Departure Point</label>
                    <input type="text" class="form-control" />
                  </div>
                  <div class="form-group col-md-4">
                    <label>Departure Date</label>

                    <VueCtkDateTimePicker
                      :position="position"
                      :label="label"
                      :format="date_format"
                      :only-date="only_date"
                      v-model="date"
                    />
                  </div>
                  <div class="form-group col-md-4">
                    <label>Return Date</label>

                    <VueCtkDateTimePicker
                      :position="position"
                      :label="label"
                      :format="date_format"
                      :only-date="only_date"
                      v-model="date"
                    />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Travel Objectives</label>
                    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>
                      Activities
                      <small class="text-danger">
                        <i>state which activities will contribute to the achievement of the identified trip objectives above</i>
                      </small>
                    </label>
                    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>
                      Key people to be met
                      <small class="text-danger">
                        <i>State the key people/individuals who you will engage or interact with to achieve the stated trip objectives</i>
                      </small>
                    </label>
                    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Expected Deliverables</label>
                    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                  </div>
                </div>
                <b-jumbotron bg-variant="primary" text-variant="white" border-variant="dark">
                  <p>Compiled By</p>
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
      date: "",
      only_date: true,
      position: "top",
      date_format: "YYYY-MM-DD",
      label: "Select Date",
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
