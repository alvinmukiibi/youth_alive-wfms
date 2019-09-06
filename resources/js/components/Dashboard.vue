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
                            <h3>My Profile</h3>
                            <p>{{ auth.designation }}</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <router-link to="/profile" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6" v-if="stateLoaded && auth.roles.includes('officer')">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ Object.keys(myRequests).length }}</h3>
                            <p>Requests</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-hand-grab-o"></i>
                        </div>
                        <router-link to="/requests" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6" v-if="stateLoaded && auth.roles.includes('officer')">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>2</h3>
                            <p>Leaves</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-minus-circle"></i>
                        </div>
                        <router-link to="/leave" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6" v-if="stateLoaded && auth.roles.includes('manager') && auth.department == 'Human Resource'">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3> {{ Object.keys(users).length }}</h3>
                            <p>Manage Employees</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <router-link to="/employees" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6" v-if="stateLoaded && auth.roles.includes('administrator')">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ Object.keys(departments).length }}</h3>
                            <p>Manage departments</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <router-link to="/departments" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6" v-if="stateLoaded && auth.roles.includes('administrator')">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ Object.keys(projects).length }}</h3>
                            <p>Manage projects</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <router-link to="/projects" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6" v-if="stateLoaded && auth.roles.includes('administrator')">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ Object.keys(vendors).length }}</h3>
                            <p>Manage vendors</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <router-link to="/vendors" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6" v-if="stateLoaded && auth.roles.includes('administrator')">
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ Object.keys(assets).length }}</h3>
                            <p>Assets</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <router-link to="/assets" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6" v-if="stateLoaded && auth.roles.includes('administrator')">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ Object.keys(leaveTypes).length }}</h3>
                            <p>Leave Types</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <router-link to="/leavetypes" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
                <div class="col-lg-3 col-6" v-if="stateLoaded && auth.roles.includes('administrator')">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ Object.keys(designations).length }}</h3>
                            <p>Designations</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <router-link to="/designations" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>

</template>

<script>
import * as api from '../api/api'
import { mapState, mapMutations } from 'vuex'
export default {
    data() {
        return {

        }
    },
    computed: {
        ...mapState({
            auth: state => state.auth,
            departments: state => state.departments,
            projects: state => state.projects,
            users: state => state.users,
            assets: state => state.assets,
            vendors: state => state.vendors,
            leaveTypes: state => state.leaveTypes,
            designations: state => state.designations,
            myRequests: state => state.myRequests,
        }),
        stateLoaded (){
            return Object.keys(this.auth).length > 0 ? true : false;
        }
    },
}
</script>

<style>

</style>
