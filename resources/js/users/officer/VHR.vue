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
                  <div class="col-sm-4">{{ auth.fname + ' ' + auth.lname }}</div>
                  <label class="col-sm-2">Designation :</label>
                  <div class="col-sm-4">{{ auth.designation }}</div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2">Directorate :</label>
                  <div class="col-sm-4">{{ auth.directorate }}</div>
                  <label class="col-sm-2">Department :</label>
                  <div class="col-sm-4">{{ auth.department }}</div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2">Staff ID No :</label>
                  <div class="col-sm-4">{{ auth.staff_id }}</div>
                  <label class="col-sm-2">Phone No :</label>
                  <div class="col-sm-4">{{ auth.mobile_contact }}</div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2">Email Address :</label>
                  <div class="col-sm-4">{{ auth.email }}</div>
                  <label class="col-sm-2">Signature :</label>
                  <div class="col-sm-4"></div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <b-form-group label="Select only what you will need">
                      <b-form-checkbox
                        name="flavour-4a"
                        @change="data.hotel = !data.hotel"
                        inline
                      >Hotel</b-form-checkbox>
                      <b-form-checkbox
                        name="flavour-4a"
                        @change="data.vehicle = !data.vehicle"
                        inline
                      >Vehicle</b-form-checkbox>
                    </b-form-group>

                    <div class="card card-outline card-secondary" v-if="data.hotel">
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
                              <b-button @click="addRow" pill variant="primary">
                                Add row
                                <i class="fa fa-plus"></i>
                              </b-button>
                            </div>
                          </div>
                          <br />
                          <b-table-simple hover small caption-top responsive>
                            <colgroup>
                              <col />
                              <col />
                              <col />
                            </colgroup>
                            <b-thead head-variant="dark">
                              <b-tr>
                                <b-th class="text-center">Booking District</b-th>
                                <b-th class="text-center">Check-in Date</b-th>
                                <b-th class="text-center">Check-out Date</b-th>
                              </b-tr>
                            </b-thead>
                            <b-tbody>
                              <b-tr v-for="booking in bookings" :key="booking.d">
                                <b-td>
                                  <input
                                    type="text"
                                    v-model="booking.district"
                                    class="form-control"
                                  />
                                </b-td>
                                <b-td>
                                  <VueCtkDateTimePicker
                                    :position="position"
                                    v-model="booking.check_in_date"
                                    :label="label"
                                    :only-date="only_date"
                                  />
                                </b-td>
                                <b-td>
                                  <VueCtkDateTimePicker
                                    :position="position"
                                    v-model="booking.check_out_date"
                                    :label="label"
                                    :only-date="only_date"
                                  />
                                </b-td>
                              </b-tr>
                            </b-tbody>
                          </b-table-simple>

                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="exampleFormControlInput1">Purpose</label>
                                <ckeditor
                                  :editor="editor"
                                  v-model="data.purpose"
                                  :config="editorConfig"
                                ></ckeditor>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card card-outline card-secondary" v-if="data.vehicle">
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
                              <VueCtkDateTimePicker position="top" v-model="data.departure_date" />
                            </div>
                            <div class="form-group col-md-6">
                              <label>Return Date and Time</label>
                              <VueCtkDateTimePicker position="top" v-model="data.return_date" />
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label>Departure Venue</label>
                              <input
                                type="text"
                                class="form-control"
                                v-model="data.departure_venue"
                              />
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label>Reason</label>
                              <ckeditor
                                :editor="editor"
                                v-model="data.reason"
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
                                v-model="data.name_of_passengers"
                                :config="editorConfig"
                              ></ckeditor>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr />
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
      bookings: [{ district: "", check_in_date: "", check_out_date: "" }],
      spinner: false,
      only_date: true,
      date: "",
      position: "top",
      label: "Select Date",
      editor: ClassicEditor,
      date_format: "YYYY-MM-DD",
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
      data: {
        hotel: false,
        vehicle: false
      }
    };
  },
  methods: {
    addRow() {
      this.bookings.push({
        district: "",
        check_in_date: "",
        check_out_date: ""
      });
    },
    save() {
      this.spinner = true;
      this.data.bookings = this.bookings;
      this.data.request_id = this.request.id;
      api.saveVhr(this.data).then(response => {
        if (!response.success) {
          this.showToast("danger", "Error", response.data.error);
          this.spinner = false;
          return;
        }
        this.spinner = false;
        this.data = {};
        this.$parent.$emit("formSubmitted", "vhr");
      });
    },
    showToast(variant, title, body) {
      this.$bvToast.toast(body, {
        title: title,
        variant: variant,
        solid: true
      });
    },
    loadVhr() {
      if (this.request.vhr) {
        this.data = this.request.vhr;
        this.bookings = this.request.vhr.bookings;
      }
    }
  },
  mounted() {
    this.loadVhr();
  },
  computed: {
    ...mapState({
      auth: state => state.auth,
      request: state => state.request
    })
  }
};
</script>

<style>
</style>
