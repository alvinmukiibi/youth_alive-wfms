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
                                                    <li class="nav-item"><a class="nav-link active" href="#new" data-toggle="tab">Requests</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#approved" data-toggle="tab">Approval Trail</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#declined" data-toggle="tab">Declined</a></li>
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content">
                                                    <div class="tab-pane" id="new">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID #</th>
                                                                    <th>Activity</th>
                                                                    <th>Project</th>
                                                                    <th>Vendor</th>
                                                                    <th>Dept</th>
                                                                    <th>Date of Req</th>
                                                                    <th>Target Date</th>
                                                                    <th>Assets</th>
                                                                    <th> <i class="fa fa-files-o"></i></th>
                                                                    <!-- <th >Status</th> -->
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="req in myRequests" :key="req.id">
                                                                    <td><router-link to="/view/request"><b>{{ req.identity }}</b></router-link></td>
                                                                    <td>{{ req.activity_type }}</td>
                                                                    <td>{{ req.project.name }}</td>
                                                                    <td>
                                                                        <b-button  :id="'popq' + req.id" variant="primary btn-sm"><i class="fa fa-eye"></i></b-button>
                                                                        <b-popover placement="top" :target="'popq' + req.id" triggers="hover focus">
                                                                            <template slot="title">Vendor Info</template>
                                                                            <p><b>Name: </b> {{ req.vendor.name }}</p>
                                                                            <p><b>Type: </b> {{ req.vendor.type }}</p>
                                                                            <p v-if="req.vendor.location"><b>Location: </b> {{ req.vendor.location }}</p>
                                                                            <p v-if="req.vendor.email"><b>Email: </b> {{ req.vendor.email }}</p>
                                                                            <p v-if="req.vendor.mobile"><b>Contact: </b> {{ req.vendor.mobile }}</p>
                                                                            <p v-if="req.vendor.representative"><b>Rep: </b> {{ req.vendor.representative }}</p>
                                                                        </b-popover>
                                                                    </td>
                                                                    <td>{{ req.department.acronym }}</td>
                                                                    <td>{{ req.date_of_request }}</td>
                                                                    <td>{{ req.delivery_date }}</td>
                                                                    <td> <b-button  :id="'pop' + req.id" variant="primary btn-sm"><i class="fa fa-eye"></i></b-button>
                                                                         <b-popover placement="top" :target="'pop' + req.id" triggers="hover focus">
                                                                            <template slot="title">Assets on request</template>
                                                                            <table v-if="req.assets.length > 0" class="table table-bordered" style="width:100%">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Name</th>
                                                                                        <th>Qty</th>
                                                                                        <th>Unit</th>
                                                                                        <th>Total</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr v-for="ass in req.assets" :key="ass.id">
                                                                                        <td>{{ ass.name }}</td>
                                                                                        <td>{{ ass.quantity }}</td>
                                                                                        <td>{{ ass.unit_cost }}</td>
                                                                                        <td>{{ ass.total_cost }}</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <p class="text-danger" v-else>
                                                                                None
                                                                            </p>
                                                                            <div v-if="req.trail.requestor_comments" class="callout callout-success">
                                                                                <h6>Comments</h6>
                                                                                <p>{{ req.trail.requestor_comments }}</p>
                                                                            </div>
                                                                        </b-popover>
                                                                     </td>
                                                                    <td>
                                                                        <b-button  :id="'fil' + req.id" variant="primary btn-sm"><i class="fa fa-download"></i></b-button>
                                                                         <b-popover placement="top" :target="'fil' + req.id" triggers="hover focus">
                                                                            <template slot="title">Request Attachments</template>
                                                                            <a v-for="atta in req.attachments" :key="atta.id" @click.prevent="downloadFile(atta.id)" > File <br>  </a>
                                                                         </b-popover>
                                                                    </td>
                                                                    <!-- <td>
                                                                        <button v-if="req.trail.accountant_approval == " class="btn btn-sm btn-outline-danger"><i class="fa fa-clock-o">PA</i></button>
                                                                    </td> -->
                                                                    <td>

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane active" id="approved">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID #</th>
                                                                    <th>Activity</th>
                                                                    <th>Project</th>
                                                                    <th style="width:28%">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="reqq in myRequests" :key="reqq.id">
                                                                    <td><router-link to="/view/request"><b>{{ reqq.identity }}</b></router-link></td>
                                                                    <td>{{ reqq.activity_type }}</td>
                                                                    <td>{{ reqq.project.name }}</td>
                                                                    <td>
                                                                        <button title="Approved" v-if="reqq.trail.accountant_approval == 1" class="btn btn-sm btn-success btn-flat"><i class="fa fa-check"><b>PA</b></i></button>
                                                                        <button title="Not yet approved" v-if="reqq.trail.accountant_approval == 0" class="btn btn-sm btn-outline-warning btn-flat"><i class="fa fa-clock-o"><b>PA</b></i></button>
                                                                        <button title="Declined" v-if="reqq.trail.accountant_approval == 2" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-times"><b>PA</b></i></button>

                                                                        <button title="Approved" v-if="reqq.trail.level_one_approval == 1" class="btn btn-sm btn-success btn-flat"><i class="fa fa-check"><b>SP</b></i></button>
                                                                        <button title="Not yet approved" v-if="reqq.trail.level_one_approval == 0" class="btn btn-sm btn-outline-warning btn-flat"><i class="fa fa-clock-o"><b>SP</b></i></button>
                                                                        <button title="Declined" v-if="reqq.trail.level_one_approval == 2" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-times"><b>SP</b></i></button>

                                                                        <button title="Approved" v-if="reqq.trail.finance_approval == 1" class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"><b>FM</b></i></button>
                                                                        <button title="Not yet approved" v-if="reqq.trail.finance_approval == 0" class="btn btn-sm btn-outline-warning btn-flat"><i class="fa fa-clock-o"><b>FM</b></i></button>
                                                                        <button title="Declined" v-if="reqq.trail.finance_approval == 2" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-times"><b>FM</b></i></button>

                                                                        <button title="Approved" v-if="reqq.trail.level_two_approval == 1" class="btn btn-sm btn-success btn-flat"><i class="fa fa-check"><b>2</b></i></button>
                                                                        <button title="Not yet approved" v-if="reqq.trail.level_two_approval == 0" class="btn btn-sm btn-outline-warning btn-flat"><i class="fa fa-clock-o"><b>2</b></i></button>
                                                                        <button title="Declined" v-if="reqq.trail.level_two_approval == 2" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-times"><b>2</b></i></button>

                                                                        <button title="Approved" v-if="reqq.trail.level_three_approval == 1" class="btn btn-sm btn-success btn-flat"><i class="fa fa-check"><b>3</b></i></button>
                                                                        <button title="Not yet approved" v-if="reqq.trail.level_three_approval == 0" class="btn btn-sm btn-outline-warning btn-flat"><i class="fa fa-clock-o"><b>3</b></i></button>
                                                                        <button title="Declined" v-if="reqq.trail.level_three_approval == 2" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-times"><b>3</b></i></button>




                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane" id="declined">
                                                        d
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="make">
                                        <div class="card card-primary card-outline" v-if="load == false">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    Choose Activity and Project
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 col-form-label">Activity Type</label>
                                                    <div class="col-md-8">
                                                        <select name="" id="" class="form-control" v-model="activity_type">
                                                            <option value="">Select Activity Type</option>
                                                            <option value="Meeting">Meeting</option>
                                                            <option value="Talk Show">Talk Show</option>
                                                            <option value="Workshop">Workshop</option>
                                                            <option value="Training">Training</option>
                                                            <option value="Vehicle">Vehicle</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 col-form-label">Project</label>
                                                    <div class="col-md-8">
                                                        <select name="" id="" class="form-control" v-model="project_id">
                                                            <option value="">Select Project</option>
                                                            <option v-for="project in projects" :key="project.id" :value="project.id">{{ project.name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                   <span class="text-danger">{{ message }}</span>
                                                        <button @click="loadForm" :disabled="disabled" class="btn btn-primary pull-right btn-flat">Load request Form</button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-success card-outline" v-else>
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    Make Request
                                                    <small class="text-primary">Note: Fields marked with <span class="text-danger">*</span> <b>MUST</b> be filled</small>
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="inputEmail4">Vendor's Name  <span class="text-danger">*</span> </label>
                                                        <select name="" id="" class="form-control" v-model="vendor_id"  >
                                                            <option v-for="vendor in vendors" :key="vendor.id" :value="vendor.id">{{ vendor.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Vendor Location</label>
                                                        <input type="text" readonly v-model="vendor_location" class="form-control" id="inputPassword4" >
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Date Required <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" v-model="delivery_date" id="inputPassword4" >
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="inputEmail4">Department  <span class="text-danger">*</span> </label>
                                                        <select name="" id="" class="form-control" v-model="department_id"  >
                                                            <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-8">
                                                        <label for="inputPassword4">Attachments </label>
                                                        <input type="file" @change="uploadAttachments" class="form-control" ref="att" multiple="multiple" id="inputPassword4" >
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-3">
                                                        <label for="inputEmail4"> Asset/Service Name  <span class="text-danger">*</span> </label>
                                                        <select name="" id="" class="form-control" v-model="asset_id"  >
                                                            <option v-for="ass in assets" :key="ass.id" :value="ass.id">{{ ass.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="inputPassword4">Qty <span class="text-danger">*</span></label>
                                                        <input type="number" min='0' v-model="quantity" class="form-control" id="inputPassword4" >
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="inputPassword4">Unit Cost <span class="text-danger">*</span></label>
                                                        <input type="number" min='0' v-model="unit_cost"  class="form-control" id="inputPassword4" >
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="inputPassword4">Total Cost </label>
                                                        <input type="text" readonly v-model="total_cost"  class="form-control" id="inputPassword4" >
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="inputPassword4">A little more explanation... </label>
                                                        <input type="text" v-model="comments"  class="form-control" id="inputPassword4" >
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4">Requestor's comments</label>
                                                        <textarea class="form-control" v-model="requestor_comments" cols="5" rows="2"></textarea>
                                                    </div>
                                                </div>
                                                 <div class="form-row">
                                                    <div class="form-group col-md-8">
                                                        <label for="inputEmail4">Signature </label>
                                                        <input type="text" :value="signature" readonly class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Date of Request</label>
                                                        <input type="text" readonly :value="currentDate.date" class="form-control"  multiple="multiple" id="inputPassword4" >
                                                    </div>
                                                </div>
                                                 <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <button class="btn btn-success btn-block"> <b> SCHEDULE REQUEST</b> <i class="fa fa-clock-o"></i> </button>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                      <button @click="save" class="btn btn-primary btn-block"> <b>REQUEST NOW</b> </button>
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
            vendor_location: '',
            load: false,
            message: '',
            disabled: false,
            activity_type: '',
            delivery_date: '',
            project_id: null,
            department_id: null,
            asset_id: null,
            quantity: null,
            unit_cost: null,
            total_cost: null,
            comments: null,
            requestor_comments: null,
            vendor_id: 0,
            data: new FormData,
        }
    },
    methods: {
         ...mapMutations({

        }),
        downloadFile(id){
            api.downloadFile(id).then(response => {
                console.log('file downloaded')
            })
        },
        loadForm(){
            if(this.activity_type == '' || this.project_id == null){
                this.disabled = true
                this.message = 'Please fill all fields before you load the request form'
                return;
            }
            this.load = true
        },
        uploadAttachments(){
            let files = this.$refs.att.files
            for(let i = 0; i < files.length; i++){
                this.data.append('attachments[]', files[i])
            }
        },
        save(){
            this.data.append('vendor_id', this.vendor_id)
            this.data.append('activity_type', this.activity_type)
            this.data.append('delivery_date', this.delivery_date)
            this.data.append('project_id', this.project_id)
            this.data.append('department_id', this.department_id)
            if(this.asset_id != null){
                this.data.append('asset_id', this.asset_id)
                this.data.append('quantity', this.quantity)
                this.data.append('unit_cost', this.unit_cost)
                this.data.append('comments', this.comments)
            }
            if(this.requestor_comments != null || this.requestor_comments != ''){
                this.data.append('requestor_comments', this.requestor_comments)
            }
            api.addRequest(this.data).then(response => {
                console.log(response.data);
            })
        }
    },
    computed: {
         ...mapState({
             auth: state => state.auth,
             myRequests: state => state.myRequests,
             projects: state => state.projects,
             vendors: state => state.vendors,
             departments: state => state.departments,
             assets: state => state.assets,
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
        }
    },
    mounted() {


    },
    watch: {
        activity_type(newVal, oldVal){
            if(newVal != ''){
                this.disabled = false
                this.message = ''
            }else{
                this.disabled = true
                this.message = 'Please choose an activity type'
            }
        },
        project_id(newVal, oldVal){
            if(newVal != ''){
                this.disabled = false
                this.message = ''
            }else{
                this.disabled = true
                this.message = 'Please choose a project'
            }
        },
        vendor_id(newVal, oldVal){
            if(newVal != undefined){
                this.vendor_location = this.vendors.filter(vendor => vendor.id == newVal)[0]['location']
            }
        },
        unit_cost(newVal, oldVal){
            if(this.quantity == null){
                return
            }else{
                this.total_cost = parseInt(this.quantity) * parseInt(newVal)
            }

        },

    },
}
</script>

<style >

</style>
