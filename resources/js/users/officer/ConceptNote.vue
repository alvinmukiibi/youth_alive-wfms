<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Concept Note</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Concept Note</li>
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
              <div class="card-header">
                <h3 class="card-title">Concept Note</h3>
              </div>
              <div class="card-body">
                <b-table-simple hover small caption-top responsive>
                  <caption>TRAINING/WORKSHOP CONCEPT NOTE</caption>
                  <colgroup>
                    <col />
                    <col />
                    <col />
                  </colgroup>
                  <b-tbody>
                    <b-tr>
                      <b-th rowspan="5">Section A</b-th>
                      <b-th variant="secondary" class="text-right">Activity</b-th>
                      <b-td>
                        <input type="text" class="form-control" />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-right">Date of Activity</b-th>
                      <b-td>
                        <VueCtkDateTimePicker
                          position="bottom"
                          :only-date="only_date"
                          label="Select Date"
                          v-model="date"
                        />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-right">Activity Location</b-th>
                      <b-td>
                        <input
                          type="text"
                          v-model="location"
                          ref="autocomplete"
                          @focus="value = ''"
                          class="form-control"
                        />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-right">Result Area</b-th>
                      <b-td>
                        <input type="text" class="form-control" />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-right">Intermediate Result Area</b-th>
                      <b-td>
                        <input type="text" class="form-control" />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="primary" class="text-center" colspan="3">Activity Description</b-th>
                    </b-tr>
                    <b-tr>
                      <b-th rowspan="3">Section B</b-th>
                      <b-td colspan="2">
                          <textarea v-model="editorData" class="form-control"></textarea>
                        <!-- <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor> -->
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-td colspan="2" class="text-right" variant="secondary">Total Budget</b-td>
                    </b-tr>
                    <b-tr>
                      <b-td colspan="2" class="text-right">
                        <input type="text" class="form-control" />
                      </b-td>
                    </b-tr>
                  </b-tbody>
                </b-table-simple>
                <b-table-simple hover small caption-top responsive>
                  <colgroup>
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                  </colgroup>
                  <b-tbody>
                    <b-tr>
                      <b-th rowspan="2">Section C</b-th>
                      <b-th
                        variant="secondary"
                        class="text-center"
                        rowspan="2"
                      >Expected Number of Participants</b-th>
                      <b-th variant="secondary" class="text-center">Male</b-th>
                      <b-th variant="secondary" class="text-center">Female</b-th>
                      <b-th variant="secondary" class="text-center">Total</b-th>
                    </b-tr>
                    <b-tr>
                      <b-td class="text-center">
                        <input type="text" class="form-control" />
                      </b-td>
                      <b-td class="text-center">
                        <input type="text" class="form-control" />
                      </b-td>
                      <b-td class="text-center">
                        <input type="text" class="form-control" />
                      </b-td>
                    </b-tr>
                  </b-tbody>
                </b-table-simple>
                <b-table-simple hover small caption-top responsive>
                  <colgroup>
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                  </colgroup>
                  <b-thead>
                    <b-tr>
                      <b-th colspan="8" class="text-center" variant="primary">Section D</b-th>
                    </b-tr>
                    <b-tr>
                      <b-th colspan="8" variant="dark" class="text-center">Project Activity Budget</b-th>
                    </b-tr>
                    <b-tr>
                      <b-th class="text-center">
                        <button @click="addRow()" class="btn-sm btn-primary">
                          <i class="fa fa-plus"></i>
                          <b></b>
                        </button>
                      </b-th>
                      <b-th variant="dark" class="text-center">Code</b-th>
                      <b-th variant="dark" class="text-center">Item</b-th>
                      <b-th variant="dark" class="text-center">Unit of measure</b-th>
                      <b-th variant="dark" class="text-center">Unit Cost</b-th>
                      <b-th variant="dark" class="text-center">Qty/No</b-th>
                      <b-th variant="dark" class="text-center">No. days</b-th>
                      <b-th variant="dark" class="text-center">Total</b-th>
                    </b-tr>
                  </b-thead>
                  <b-tbody>
                    <b-tr class="text-center">
                      <b-td></b-td>
                      <b-td>1</b-td>
                      <b-td>
                        <input type="text" class="form-control" />
                      </b-td>
                      <b-td>
                        <input type="text" class="form-control" />
                      </b-td>
                      <b-td>
                        <input type="text" class="form-control" />
                      </b-td>
                      <b-td>
                        <input type="text" class="form-control" />
                      </b-td>
                      <b-td>
                        <input type="text" class="form-control" />
                      </b-td>
                      <b-td>
                        <input type="text" class="form-control" />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-td></b-td>
                      <b-th colspan="6" class="text-left">Grand Total</b-th>
                      <b-td class="text-center">3,000,00</b-td>
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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  data() {
    return {
      only_date: true,
      date: "",
      autocomplete: "",
      location: "",
      editor: ClassicEditor,
      editorData: "<p>Content of the editor.</p>",
      editorConfig: {
        // The configuration of the editor.
      }
    };
  },
  methods: {
    addRow() {}
  },
  mounted() {
    this.autocomplete = new google.maps.places.Autocomplete(
      this.$refs.autocomplete,
      { types: ["geocode"] }
    );
    this.autocomplete.addListener("place_changed", () => {
      let place = this.autocomplete.getPlace();
      if (place != undefined) {
        let ac = place.address_components;
        let towns =
          ac[0]["short_name"] +
          ", " +
          ac[1]["short_name"] +
          ", " +
          ac[2]["short_name"];
        this.location = towns;
      }
    });
  },
  computed: {}
};
</script>

<style>
</style>
