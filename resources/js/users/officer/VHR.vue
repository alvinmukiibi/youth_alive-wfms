<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vehicle and Hotel Request Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Vehicle and Hotel Request Form</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="callout callout-warning">
              <h4>
                <i class="fa fa-info">&nbsp; Complete form in its entirety</i>
              </h4>
            </div>
            <div class="card card-outline card-primary">
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2">Requestor’s Name :</label>
                  <div class="col-sm-4">fdgxdfg</div>
                  <label class="col-sm-2">Designation :</label>
                  <div class="col-sm-4">xfgxdfg</div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2">Directorate :</label>
                  <div class="col-sm-4">fdgxdfg</div>
                  <label class="col-sm-2">Department :</label>
                  <div class="col-sm-4">xfgxdfg</div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2">Staff ID No :</label>
                  <div class="col-sm-4">fdgxdfg</div>
                  <label class="col-sm-2">Phone No :</label>
                  <div class="col-sm-4">xfgxdfg</div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2">Email Address :</label>
                  <div class="col-sm-4">fdgxdfg</div>
                  <label class="col-sm-2">Signature :</label>
                  <div class="col-sm-4"></div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <b-form-group label="Select only what you will need">
                      <b-form-checkbox name="flavour-4a" @change="hotel = !hotel" inline>Hotel</b-form-checkbox>
                      <b-form-checkbox name="flavour-4a" @change="vehicle = !vehicle" inline>Vehicle</b-form-checkbox>
                    </b-form-group>

                    <div class="card card-outline card-secondary" v-if="hotel">
                      <div class="card-header">
                        <h3 class="card-title">
                          <b>HOTEL</b>
                          <small class="text-danger">
                            <i>to be completed only when the traveler needs accomodation</i>
                          </small>
                        </h3>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12">
                              <b-button pill variant="primary">
                                Add row
                                <i class="fa fa-plus"></i>
                              </b-button>
                            </div>
                          </div>
                          <br />
                          <div class="form-row">
                            <div class="form-group col-md-4">
                              <label>Booking District</label>
                              <input type="text" class="form-control" />
                            </div>
                            <div class="form-group col-md-4">
                              <label>Check-in Date</label>
                              <VueCtkDateTimePicker position="top" v-model="date" :only-date="only_date" />
                            </div>
                            <div class="form-group col-md-4">
                              <label>Check-out Date</label>
                              <VueCtkDateTimePicker position="top" v-model="date" :only_date="only_date" />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="exampleFormControlInput1">Purpose</label>
                                <ckeditor
                                  :editor="editor"
                                  v-model="editorData"
                                  :config="editorConfig"
                                ></ckeditor>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card card-outline card-secondary" v-if="vehicle">
                      <div class="card-header">
                        <h3 class="card-title">
                          <b>VEHICLE</b>
                          <small class="text-danger">
                            <i>to be completed only when the traveler needs a vehicle</i>
                          </small>
                        </h3>
                        <div class="card-body">
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label>Departure Date and Time</label>
                              <VueCtkDateTimePicker position="top" v-model="date" />
                            </div>
                            <div class="form-group col-md-6">
                              <label>Return Date and Time</label>
                              <VueCtkDateTimePicker position="top" v-model="date" />
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label>Departure Venue</label>
                              <input type="text" class="form-control" />
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label>Reason</label>
                              <ckeditor
                                :editor="editor"
                                v-model="editorData"
                                :config="editorConfig"
                              ></ckeditor>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label>
                                Name of Passengers
                                <small class="text-danger">
                                  <i>you may list the people</i>
                                </small>
                              </label>
                              <ckeditor
                                :editor="editor"
                                v-model="editorData"
                                :config="editorConfig"
                              ></ckeditor>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr />
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
      only_date: true,
      date: "",
      hotel: false,
      vehicle: false,
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
