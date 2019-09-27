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
                    <ckeditor :editor="editor" v-model="data.travellers" :config="editorConfig"></ckeditor>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Project</label>
                    <input type="text" readonly v-model="request.project" class="form-control" />
                  </div>
                  <div class="form-group col-md-6">
                    <label>Date</label>
                    <VueCtkDateTimePicker
                      :position="position"
                      :label="label"
                      :format="date_format"
                      :only-date="only_date"
                      v-model="data.date_of_activity"
                    />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Destinations</label>
                    <input type="text" v-model="data.destination" class="form-control" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label>Departure Point</label>
                    <input type="text" v-model="data.departure_point" class="form-control" />
                  </div>
                  <div class="form-group col-md-4">
                    <label>Departure Date</label>

                    <VueCtkDateTimePicker
                      :position="position"
                      :label="label"
                      :format="date_format"
                      :only-date="only_date"
                      v-model="data.departure_date"
                    />
                  </div>
                  <div class="form-group col-md-4">
                    <label>Return Date</label>

                    <VueCtkDateTimePicker
                      :position="position"
                      :label="label"
                      :format="date_format"
                      :only-date="only_date"
                      v-model="data.return_date"
                    />
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Travel Objectives</label>
                    <ckeditor :editor="editor" v-model="data.objectives" :config="editorConfig"></ckeditor>
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
                    <ckeditor :editor="editor" v-model="data.activities" :config="editorConfig"></ckeditor>
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
                    <ckeditor
                      :editor="editor"
                      v-model="data.key_people_to_be_met"
                      :config="editorConfig"
                    ></ckeditor>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Expected Deliverables</label>
                    <ckeditor
                      :editor="editor"
                      v-model="data.expected_deliverables"
                      :config="editorConfig"
                    ></ckeditor>
                  </div>
                </div>
                <button @click="save" class="btn btn-primary btn-flat pull-right">
                  <i class="fa fa-save"></i> Provisional Save
                  <span
                    v-if="spinner"
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                  ></span>
                </button>
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
      spinner: false,
      date: "",
      only_date: true,
      position: "top",
      date_format: "YYYY-MM-DD",
      label: "Select Date",
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
      },
      data: {}
    };
  },
  methods: {
    save() {
      this.spinner = true;
      this.data.request_id = this.request.id;
      api.saveTSoW(this.data).then(response => {
        if (response.success) {
          this.spinner = false;
          this.data = {};
          this.$parent.$emit("formSubmitted", "tsw");
        }
      });
    },
    loadTsow() {
      if (this.request.tsow) {
        this.data = this.request.tsow;
      }
    }
  },
  mounted() {
    this.loadTsow();
  },
  computed: {
    ...mapState({
      request: state => state.request
    })
  }
};
</script>

<style>
</style>
