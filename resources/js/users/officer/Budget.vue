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
                        <input type="text" class="form-control" />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-right">Activity Date</b-th>
                      <b-td colspan="6">
                        <input type="text" class="form-control" />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-right">Destination</b-th>
                      <b-td colspan="6">
                        <input type="text" class="form-control" />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-right">Purpose</b-th>
                      <b-td colspan="6">
                        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th>
                        <button class="btn-sm btn-primary">
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
                    <b-tr>
                      <b-th class="text-center">1</b-th>
                      <b-th class="text-center" colspan="2">Dinner</b-th>
                      <b-th class="text-center">2</b-th>
                      <b-th class="text-center">2</b-th>
                      <b-th class="text-center">32000</b-th>
                      <b-th class="text-center">128000</b-th>
                    </b-tr>
                    <b-tr>
                      <b-td colspan="6" class="text-center">Total</b-td>
                      <b-td>272000</b-td>
                    </b-tr>
                    <b-tr>
                      <b-th variant="secondary" class="text-center">Comment</b-th>
                      <b-td colspan="6">
                        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th colspan="7" variant="primary" class="text-center">Telephone Contacts</b-th>
                    </b-tr>
                    <b-tr>
                      <b-td colspan="3" variant="dark" class="text-center">Name</b-td>
                      <b-td colspan="1" variant="dark" class="text-center">Contact</b-td>
                      <b-td colspan="2" variant="dark" class="text-center">Position</b-td>
                      <b-td colspan="1" variant="dark" class="text-center">Amount</b-td>
                    </b-tr>
                    <b-tr>
                      <b-td colspan="3" class="text-center">Bukenya Francis</b-td>
                      <b-td colspan="1" class="text-center">0747465685</b-td>
                      <b-td colspan="2" class="text-center">MEL Manager</b-td>
                      <b-td colspan="1" class="text-center">136000</b-td>
                    </b-tr>
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
