<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Budget</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Budget</li>
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
                <h3 class="card-title">TSoW Budget</h3>
              </div>
              <div class="card-body">
                <b-table-simple hover small caption-top responsive>
                  <caption>TSoW Budget</caption>
                  <caption v-if="data.id"><a class="btn btn-sm btn-primary" :href="`budget/${data.id}/print`"  >PRINT</a></caption>
                  <colgroup>
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                  </colgroup>
                  <b-tbody>
                    <b-tr>
                      <b-th variant="secondary" class="text-right">Activity</b-th>
                      <b-td colspan="6">
                        <input type="text" v-model="data.activity" class="form-control" />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-right">Activity Date</b-th>
                      <b-td colspan="6">
                        <VueCtkDateTimePicker
                          :position="position"
                          :label="label"
                          :format="date_format"
                          :only-date="only_date"
                          v-model="data.date"
                        />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-right">Destination</b-th>
                      <b-td colspan="6">
                        <input type="text" class="form-control" v-model="data.destination" />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-right">Purpose</b-th>
                      <b-td colspan="6">
                          <textarea v-model="data.purpose" class="form-control"></textarea>
                        <!-- <ckeditor :editor="editor" v-model="data.purpose" :config="editorConfig"></ckeditor> -->
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th>
                        <button @click="addRow" class="btn-sm btn-primary">
                          <i class="fa fa-plus"></i>
                          <b></b>
                        </button>
                      </b-th>
                      <b-th colspan="6"></b-th>
                    </b-tr>
                    <b-tr>
                      <b-th variant="primary" class="text-center">No</b-th>
                      <b-th variant="primary" colspan="2" class="text-center">Item</b-th>
                      <b-th variant="primary" class="text-center">Units</b-th>
                      <b-th variant="primary" class="text-center">Frequency</b-th>
                      <b-th variant="primary" class="text-center">Unit Cost</b-th>
                      <b-th variant="primary" class="text-center">Subtotal</b-th>
                    </b-tr>
                    <b-tr v-for="item in items" :key="item.m">
                      <b-th class="text-center">
                        <input type="number" min="0" v-model="item.no" class="form-control" />
                      </b-th>
                      <b-th class="text-center" colspan="2">
                        <input type="text" v-model="item.item" class="form-control" />
                      </b-th>
                      <b-th class="text-center">
                        <input
                          type="number"
                          min="0"
                          @change="calculateSubTotal(item)"
                          v-model="item.units"
                          class="form-control"
                        />
                      </b-th>
                      <b-th class="text-center">
                        <input
                          type="number"
                          min="0"
                          @change="calculateSubTotal(item)"
                          v-model="item.frequency"
                          class="form-control"
                        />
                      </b-th>
                      <b-th class="text-center">
                        <input
                          type="number"
                          min="0"
                          @change="calculateSubTotal(item)"
                          v-model="item.unit_cost"
                          class="form-control"
                        />
                      </b-th>
                      <b-th class="text-center">
                        <input
                          type="number"
                          min="0"
                          readonly
                          v-model="item.sub_total"
                          class="form-control"
                        />
                      </b-th>
                    </b-tr>
                    <b-tr>
                      <b-td colspan="6" class="text-center">Total</b-td>
                      <b-td>
                        <input type="text" readonly v-model="total" class="form-control" />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-center">Comment</b-th>
                      <b-td colspan="6">
                          <textarea v-model="data.comments" class="form-control"></textarea>
                        <!-- <ckeditor :editor="editor" v-model="data.comments" :config="editorConfig"></ckeditor> -->
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th>
                        <button @click="addContactRow" class="btn-sm btn-primary">
                          <i class="fa fa-plus"></i>
                          <b></b>
                        </button>
                      </b-th>
                      <b-th colspan="6" variant="primary" class="text-center">Telephone Contacts</b-th>
                    </b-tr>
                    <b-tr>
                      <b-td colspan="3" variant="dark" class="text-center">Name</b-td>
                      <b-td colspan="1" variant="dark" class="text-center">Contact</b-td>
                      <b-td colspan="2" variant="dark" class="text-center">Position</b-td>
                      <b-td colspan="1" variant="dark" class="text-center">Amount</b-td>
                    </b-tr>
                    <b-tr v-for="cont in contacts" :key="cont.m">
                      <b-td colspan="3" class="text-center">
                        <input type="text" v-model="cont.name" class="form-control" />
                      </b-td>
                      <b-td colspan="1" class="text-center">
                        <input type="text" v-model="cont.contact" class="form-control" />
                      </b-td>
                      <b-td colspan="2" class="text-center">
                        <input type="text" v-model="cont.position" class="form-control" />
                      </b-td>
                      <b-td colspan="1" class="text-center">
                        <input type="text" v-model="cont.amount" class="form-control" />
                      </b-td>
                    </b-tr>
                  </b-tbody>
                </b-table-simple>
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
                <!-- <b-jumbotron bg-variant="primary" text-variant="white" border-variant="dark">
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
                </b-jumbotron>-->
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
      contacts: [{ name: "", contact: "", position: "", amount: 0 }],
      items: [
        {
          no: "",
          item: "",
          units: "",
          frequency: "",
          unit_cost: "",
          sub_total: 0
        }
      ],
      my_subtotal: 0,
      total: 0,
      spinner: false,
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
      this.data.items = this.items;
      this.data.contacts = this.contacts;
      this.data.request_id = this.request.id;
      this.data.total = this.total;
      api.saveBudget(this.data).then(response => {
        if (!response.success) {
          this.showToast("danger", "Error", response.data.error);
          this.spinner = false;
          return;
        }
        this.spinner = false;
        this.data = {};
        this.items = [];
        this.contacts = [];
        this.$router.push('/request/trail')
        // this.$parent.$emit("formSubmitted", "bgt");
      });
    },
    showToast(variant, title, body) {
      this.$bvToast.toast(body, {
        title: title,
        variant: variant,
        solid: true
      });
    },
    addRow() {
      this.items.push({
        no: "",
        item: "",
        units: "",
        frequency: "",
        unit_cost: "",
        sub_total: 0
      });
    },
    addContactRow() {
      this.contacts.push({ name: "", contact: "", position: "", amount: 0 });
    },
    calculateSubTotal(item) {
      let total =
        parseFloat(item.units) *
        parseFloat(item.frequency) *
        parseFloat(item.unit_cost);
      if (!isNaN(total)) {
        item.sub_total = total.toFixed(2);
      }
      this.calculateTotal();
    },
    calculateTotal() {
      var subtotal, total;
      subtotal = this.items.reduce(function(sum, item) {
        var subTotal = parseFloat(item.sub_total);
        if (!isNaN(subTotal)) {
          return sum + subTotal;
        }
      }, 0);

      this.my_subtotal = subtotal.toFixed(2);

      total = subtotal;
      total = parseFloat(total);
      if (!isNaN(total)) {
        this.total = total.toFixed(2);
      } else {
        this.total = "0.00";
      }
    },
    loadBgt() {
      if (this.request.bgt) {
        this.data = this.request.bgt;
        this.items = this.request.bgt.items;
        this.contacts = this.request.bgt.contacts;
        this.total = this.request.bgt.total;
      }
    }
  },
  mounted() {
    this.loadBgt();
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
