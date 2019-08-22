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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>200</h3>
                            <p>Profile</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <router-link to="/profile" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>5</h3>
                            <p>Requests</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-hand-grab-o"></i>
                        </div>
                        <router-link to="/requests" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>2</h3>
                            <p>Leave</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-minus-circle"></i>
                        </div>
                        <router-link to="/leave" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>

</template>

<script>
export default {

}
</script>

<style>

</style>
