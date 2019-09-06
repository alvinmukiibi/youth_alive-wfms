<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Leaves</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">
            <button
              type="button"
              data-toggle="modal"
              data-target="#modal"
              class="btn btn-outline-primary btn-block"
            >
              <b>Ask For Leave</b>
              <i class="fa fa-plus"></i>
            </button>
          </div>
          <div class="col-md-10">
            <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title">Leaves</h3>
              </div>
              <div class="card-body"></div>
            </div>
          </div>
          <div
            class="modal fade"
            id="modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Ask For Leave</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Ask for leave</h3>
                    </div>
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="type">Leave Type</label>
                          <select name id class="form-control">
                            <option disabled value>Select Leave Type</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="type">Start Date</label>
                          <input type="date" class="form-control" />
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="type">End Date</label>
                          <input type="date" class="form-control" />
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="type">Comments...</label>
                          <textarea name id cols="3" rows="3" class="form-control"></textarea>
                        </div>
                      </div>
                    </div>
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
export default {};
</script>

<style>
</style>
