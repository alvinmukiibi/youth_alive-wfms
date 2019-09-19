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
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-4"></div>
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
export default {
  data() {
    return {};
  },
  methods: {},
  mounted() {},
  computed: {}
};
</script>

<style>
</style>
