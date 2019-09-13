<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Settings</li>
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
                <h3 class="card-title">Settings</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>
                    <p-input type="checkbox">Default</p-input>
                    <!-- <p-check name="check" color="success" v-model="check">Check</p-check>Flat green skin checkbox -->
                  </label>
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
export default {
  data() {
    return {
      check: null
    };
  },
  mounted() {}
};
</script>

<style lang="css" >
@import "/node_modules/pretty-checkbox/src/pretty-checkbox.scss";
</style>
