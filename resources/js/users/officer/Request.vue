<template>
    <div>
        <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Requests</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Requests</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#requests" data-toggle="tab"> <i class="fa fa-list-alt"></i>  Requests</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#make" data-toggle="tab"> <i class="fa fa-plus-circle"></i> Make Request</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="requests">
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <ul class="nav nav-pills">
                                                    <li class="nav-item"><a @click="getMyRequests" class="nav-link active" href="#new" data-toggle="tab">Requests <span v-if="spin1"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a>  </li>
                                                    <li class="nav-item"><a class="nav-link" href="#approved" data-toggle="tab">Approval Trail</a></li>
                                                    <!-- <li class="nav-item"><a class="nav-link" href="#declined" data-toggle="tab">Declined</a></li> -->
                                                    <li @click="loadProjectRequests" v-if="auth.designation == 'Project Accountant'" class="nav-item"><a class="nav-link" href="#projectrequests" data-toggle="tab">Project Requests <span v-if="spin2"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a></li>
                                                    <li @click="loadLevel1Requests" v-if="stateLoaded && auth.roles.includes('manager')" class="nav-item"><a class="nav-link" href="#level1requests" data-toggle="tab">Supervisor Requests <span v-if="spin3"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a></li>
                                                    <li @click="loadFMRequests" v-if="stateLoaded && auth.roles.includes('manager') && auth.department == 'Finance and Operations'" class="nav-item"><a class="nav-link" href="#fmrequests" data-toggle="tab">Pending Financial Approval <span v-if="spin4"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a></li>
                                                    <li @click="loadDirectorRequests" v-if="stateLoaded && auth.roles.includes('director')"  class="nav-item"><a class="nav-link" href="#directorrequests" data-toggle="tab">Pending Director Approval <span v-if="spin5"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a></li>
                                                    <li @click="loadEDRequests" v-if="stateLoaded && auth.designation == 'Executive Director'" class="nav-item"><a class="nav-link" href="#edrequests" data-toggle="tab">Pending ED Approval <span v-if="spin6"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a></li>
                                                    <!-- <li @click="loadLevel1Requests" v-if="stateLoaded && auth.roles.includes('manager')" class="nav-item"><a class="nav-link" href="#level1requests" data-toggle="tab">Level 1 Approvals</a></li>
                                                    <li @click="loadFMRequests" v-if="stateLoaded && auth.roles.includes('manager') && auth.department == 'Finance and Operations'" class="nav-item"><a class="nav-link" href="#fmrequests" data-toggle="tab">Pending Financial Approval</a></li>
                                                    <li @click="loadDirectorRequests" v-if="stateLoaded && auth.roles.includes('director')" class="nav-item"><a class="nav-link" href="#directorrequests" data-toggle="tab">Pending Director Approval</a></li>
                                                    <li @click="loadEDRequests" v-if="stateLoaded && auth.designation == 'Executive Director'" class="nav-item"><a class="nav-link" href="#edrequests" data-toggle="tab">Pending ED Approval</a></li> -->
                                                </ul>
                                            </div>
                                              <div class="card-body">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="new">
                                                        <b-table-simple small caption-top responsive>
                                                            <colgroup>
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            </colgroup>
                                                            <b-thead head-variant="dark">
                                                            <b-tr>
                                                                <b-th>Request ID</b-th>
                                                                <b-th>Date of Request</b-th>
                                                                <b-th>Activity Type</b-th>
                                                                <b-th>Project</b-th>
                                                                <b-th>Action</b-th>
                                                            </b-tr>
                                                            </b-thead>
                                                            <b-tbody>
                                                                <b-tr v-for="req in myRequests" :key="req.id">
                                                                    <b-td><router-link to="/request/make"><span @click="loadRequest(req.id)" ><b> {{ req.identity  }}</b></span></router-link></b-td>
                                                                    <b-td>{{ req.created_at }}</b-td>
                                                                    <b-td>{{ req.activity_type }}</b-td>
                                                                    <b-td>{{ req.project }}</b-td>
                                                                    <b-td>   
                                                                       
                                                                    </b-td>
                                                                </b-tr>
                                                            </b-tbody>
                                                        </b-table-simple>
                                                    </div>
                                                      <div class="tab-pane" id="projectrequests">
                                                        <b-table-simple small caption-top responsive>
                                                            <colgroup>
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            </colgroup>
                                                            <b-thead head-variant="dark">
                                                            <b-tr>
                                                                <b-th>Request ID</b-th>
                                                                <b-th>Requested By</b-th>
                                                                <b-th>Date of Request</b-th>
                                                                <b-th>Activity Type</b-th>
                                                                <b-th>Project</b-th>
                                                                <b-th>Action</b-th>
                                                            </b-tr>
                                                            </b-thead>
                                                            <b-tbody>
                                                                <b-tr v-for="req in bucket" :key="req.id">
                                                                    <b-td><router-link to="/request/make"><span @click="loadReq(req.id)" ><b> {{ req.identity  }}</b></span></router-link></b-td>
                                                                    <b-td>{{ req.user }}</b-td>
                                                                    <b-td>{{ req.created_at }}</b-td>
                                                                    <b-td>{{ req.activity_type }}</b-td>
                                                                    <b-td>{{ req.project }}</b-td>
                                                                    <b-td>   
                                                                       
                                                                    </b-td>
                                                                </b-tr>
                                                            </b-tbody>
                                                        </b-table-simple>
                                                      </div>
                                                      <div class="tab-pane" id="level1requests">
                                                        <b-table-simple small caption-top responsive>
                                                            <colgroup>
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            </colgroup>
                                                            <b-thead head-variant="dark">
                                                            <b-tr>
                                                                <b-th>Request ID</b-th>
                                                                <b-th>Requested By</b-th>
                                                                <b-th>Date of Request</b-th>
                                                                <b-th>Activity Type</b-th>
                                                                <b-th>Project</b-th>
                                                                <b-th>Action</b-th>
                                                            </b-tr>
                                                            </b-thead>
                                                            <b-tbody>
                                                                <b-tr v-for="req in bucket" :key="req.id">
                                                                    <b-td><router-link to="/request/make"><span @click="loadReq(req.id)" ><b> {{ req.identity  }}</b></span></router-link></b-td>
                                                                    <b-td>{{ req.user }}</b-td>
                                                                    <b-td>{{ req.created_at }}</b-td>
                                                                    <b-td>{{ req.activity_type }}</b-td>
                                                                    <b-td>{{ req.project }}</b-td>
                                                                    <b-td>   
                                                                       
                                                                    </b-td>
                                                                </b-tr>
                                                            </b-tbody>
                                                        </b-table-simple>
                                                      </div>
                                                      <div class="tab-pane" id="fmrequests">
                                                        <b-table-simple small caption-top responsive>
                                                            <colgroup>
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            </colgroup>
                                                            <b-thead head-variant="dark">
                                                            <b-tr>
                                                                <b-th>Request ID</b-th>
                                                                <b-th>Requested By</b-th>
                                                                <b-th>Date of Request</b-th>
                                                                <b-th>Activity Type</b-th>
                                                                <b-th>Project</b-th>
                                                                <b-th>Action</b-th>
                                                            </b-tr>
                                                            </b-thead>
                                                            <b-tbody>
                                                                <b-tr v-for="req in bucket" :key="req.id">
                                                                    <b-td><router-link to="/request/make"><span @click="loadReq(req.id)" ><b> {{ req.identity  }}</b></span></router-link></b-td>
                                                                    <b-td>{{ req.user }}</b-td>
                                                                    <b-td>{{ req.created_at }}</b-td>
                                                                    <b-td>{{ req.activity_type }}</b-td>
                                                                    <b-td>{{ req.project }}</b-td>
                                                                    <b-td>   
                                                                       
                                                                    </b-td>
                                                                </b-tr>
                                                            </b-tbody>
                                                        </b-table-simple>
                                                      </div>
                                                      <div class="tab-pane" id="directorrequests">
                                                        <b-table-simple small caption-top responsive>
                                                            <colgroup>
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            </colgroup>
                                                            <b-thead head-variant="dark">
                                                            <b-tr>
                                                                <b-th>Request ID</b-th>
                                                                <b-th>Requested By</b-th>
                                                                <b-th>Date of Request</b-th>
                                                                <b-th>Activity Type</b-th>
                                                                <b-th>Project</b-th>
                                                                <b-th>Action</b-th>
                                                            </b-tr>
                                                            </b-thead>
                                                            <b-tbody>
                                                                <b-tr v-for="req in bucket" :key="req.id">
                                                                    <b-td><router-link to="/request/make"><span @click="loadReq(req.id)" ><b> {{ req.identity  }}</b></span></router-link></b-td>
                                                                    <b-td>{{ req.user }}</b-td>
                                                                    <b-td>{{ req.created_at }}</b-td>
                                                                    <b-td>{{ req.activity_type }}</b-td>
                                                                    <b-td>{{ req.project }}</b-td>
                                                                    <b-td>   
                                                                       
                                                                    </b-td>
                                                                </b-tr>
                                                            </b-tbody>
                                                        </b-table-simple>
                                                      </div>
                                                      <div class="tab-pane" id="edrequests">
                                                        <b-table-simple small caption-top responsive>
                                                            <colgroup>
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            <col />
                                                            </colgroup>
                                                            <b-thead head-variant="dark">
                                                            <b-tr>
                                                                <b-th>Request ID</b-th>
                                                                <b-th>Requested By</b-th>
                                                                <b-th>Date of Request</b-th>
                                                                <b-th>Activity Type</b-th>
                                                                <b-th>Project</b-th>
                                                                <b-th>Action</b-th>
                                                            </b-tr>
                                                            </b-thead>
                                                            <b-tbody>
                                                                <b-tr v-for="req in bucket" :key="req.id">
                                                                    <b-td><router-link to="/request/make"><span @click="loadReq(req.id)" ><b> {{ req.identity  }}</b></span></router-link></b-td>
                                                                    <b-td>{{ req.user }}</b-td>
                                                                    <b-td>{{ req.created_at }}</b-td>
                                                                    <b-td>{{ req.activity_type }}</b-td>
                                                                    <b-td>{{ req.project }}</b-td>
                                                                    <b-td>   
                                                                       
                                                                    </b-td>
                                                                </b-tr>
                                                            </b-tbody>
                                                        </b-table-simple>
                                                      </div>
                                                </div>
                                              </div>
                                        </div>


                                    </div>
                                    <div class="tab-pane" id="make">
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                   Please choose your request type
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                   <b-form-group >
                                                        <b-form-radio-group
                                                            id="btn-radios-1"
                                                            v-model="selected"
                                                            :options="options"
                                                            buttons
                                                            button-variant="outline-primary"
                                                            name="radio-btn-outline"
                                                        ></b-form-radio-group>
                                                    </b-form-group>
                                                   <b-form-group v-if="selected == 1" >
                                                        <b-form-radio-group
                                                            id="btn-radios-1"
                                                            v-model="activity_type"
                                                            :options="programs"
                                                            buttons
                                                            button-variant="outline-success"
                                                            name="radio-btn-outline"
                                                        ></b-form-radio-group>
                                                    </b-form-group>
                                                <div class="form-group row" v-if="activity_type != ''">
                                                    <label for="" class="col-sm-2 col-form-label">Select a Project</label>
                                                    <div class="col-md-4">
                                                        <select name="" id="" class="form-control" v-model="project_id">
                                                            <option value="Select Project" disabled>Select Project</option>
                                                            <option v-for="project in projects" :key="project.id" :value="project.id">{{ project.name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <b-form-group v-if="project_id != null" label="Please select the documents to fill" >
                                                <b-form-checkbox-group stacked id="checkbox-group-2" v-model="documents" name="flavour-2">
                                                    <b-form-checkbox size="lg" value="tsw" >Travel Scope of Work</b-form-checkbox>
                                                    <b-form-checkbox size="lg" value="vhr">Vehicle & Hotel Request Form </b-form-checkbox>
                                                    <b-form-checkbox size="lg" value="bgt">Budget</b-form-checkbox>
                                                    <b-form-checkbox size="lg" value="cpt">Concept note</b-form-checkbox>
                                                </b-form-checkbox-group>
                                            </b-form-group>

                                                <div class="form-group">
                                                   
                                                        <button class="btn btn-primary btn-flat" @click="save">
                                                            <span v-if="spinner"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                            <b>Save</b></button>

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
import * as api from '../../api/api'
import { mapState, mapMutations } from 'vuex'
export default {
    data() {
        return {
            selected: null,
            options: [
            { text: 'Programs', value: '1' },
            { text: 'Human Resource', value: '2' },
            { text: 'Supplies', value: '3' }
            ],
            checked: true,
            documents:[],
            activity_type: '',
            project_id: null,
            programs: [
                {text: 'Meeting', value: 'Meeting'},
                {text: 'Workshop', value: 'Workshop'},
                {text: 'Training', value: 'Training'},
                {text: 'Talkshow', value: 'Talkshow'},
            ],
            spinner: false,
            spin1: false,
            spin2: false,
            spin3: false,
            spin4: false,
            spin5: false,
            spin6: false,
            bucket: null,
        }
    },
    methods: {
         ...mapMutations({
             setRequest: "setRequest",
             setMyRequests: "setMyRequests",
             setErrors: "setErrors"
        }),
        save(){
            this.spinner = true;
            let doc_completion_status = []
            this.documents.forEach((arg) => {
                doc_completion_status.push({'doc' : arg, 'status' : false})
            })
            let data = {
                doc_completion_status: JSON.stringify(doc_completion_status),
                documents: JSON.stringify(this.documents),
                project_id: this.project_id,
                activity_type: this.activity_type
            }
            api.makeReq(data).then(response => {
                this.setRequest(response.data)
                this.spinner = false
                this.$router.push('/request/make')
            })
        },
        getMyRequests(){
            this.spin1 = true
            api.getMyRequests().then(response => {
                this.setMyRequests(response.data);
                this.spin1 = false
          });
        },
         loadProjectRequests(){
             this.spin2 = true
            api.getProjectRequests().then(response => {
                this.bucket = response.data
                this.spin2 = false
            })
        },
        loadLevel1Requests(){
             this.spin3 = true
            api.getLevel1Requests().then(response => {
                this.bucket = response.data
                this.spin3 = false
            })
        },
        loadFMRequests(){
             this.spin4 = true
            api.getFMRequests().then(response => {
                this.bucket = response.data
                 this.spin4 = false
            })
        },
         loadEDRequests(){
              this.spin6 = true
            api.getEDRequests().then(response => {
                this.bucket = response.data
                 this.spin6 = false
            })
        },
        loadDirectorRequests(){
             this.spin5 = true
            api.getDirectorRequests().then(response => {
                this.bucket = response.data
                 this.spin5 = true
            })
        },
        loadReq(id){
            let request = this.bucket.filter(req => req.id == id)[0]
            this.setRequest(request)
        },
        loadRequest(id){
            let request = this.myRequests.filter(req => req.id == id)[0]
            this.setRequest(request)
        },
    },
    computed: {
         ...mapState({
             auth: state => state.auth,
             myRequests: state => state.myRequests,
             projects: state => state.projects,
             vendors: state => state.vendors,
             departments: state => state.departments,
             assets: state => state.assets,
             errors: state => state.errors,
         }),
         currentDate() {
            let currentDate = new Date();
            var day = currentDate.getDate();
            var month = currentDate.getMonth() + 1;
            var year = currentDate.getFullYear();
            return {
                date: day + "/" + month + "/" + year,
            };
        },
        signature(){
            return this.auth.fname + ' ' + this.auth.lname + ', ' + this.auth.staff_id + ', ' + this.auth.designation
        },
        stateLoaded() {
            return Object.keys(this.auth).length > 0 ? true : false;
        }
    },
    mounted() {
        this.getMyRequests();
        

    },
    watch: {
        vendor_id(newVal, oldVal){
            if(newVal != undefined){
                this.vendor_location = this.vendors.filter(vendor => vendor.id == newVal)[0]['location']
            }
        },
    },
}
</script>

<style >

</style>
