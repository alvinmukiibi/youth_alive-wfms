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
                                      Here
                                    </div>
                                    <div class="tab-pane" id="make">
                                        <div class="card card-primary card-outline" v-if="load == false">
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
                                                    <b-form-checkbox size="lg" value="acc">Vehicle & Hotel Request Form </b-form-checkbox>
                                                    <b-form-checkbox size="lg" value="bgt">Budget</b-form-checkbox>
                                                    <b-form-checkbox size="lg" value="cpt">Concept note</b-form-checkbox>
                                                </b-form-checkbox-group>
                                            </b-form-group>

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
                                                        <label for="inputPassword4">Delivery Date <span class="text-danger">*</span></label>
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
                                                <div class="row" v-if="errors.length > 0">
                                                    <div class="col-md-12">
                                                        <p class="text-danger pull-left">{{ errors }}</p>
                                                    </div>
                                                </div>
                                                 <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <button class="btn btn-success btn-block"> <b> SCHEDULE REQUEST</b> <i class="fa fa-clock-o"></i> </button>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <button @click="save" class="btn btn-primary btn-block" type="button">
                                                            <span v-if="loading == true" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        <b>REQUEST NOW</b>
                                                        </button>

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
            selected: null,
            options: [
            { text: 'Programs', value: '1' },
            { text: 'Human Resource', value: '2' },
            { text: 'Supplies', value: '3' }
            ],
            checked: true,
            documents:[],
            programs: [
                {text: 'Meeting', value: 'Meeting'},
                {text: 'Workshop', value: 'Wofrkshop'},
                {text: 'Training', value: 'Training'},
                {text: 'Talkshow', value: 'Talkshow'},
            ],
            bag: {
                request_id: null,
                field: null,
                comments: null,
            },
            loading: false,
            edRequests: [],
            directorRequests: [],
            fMRequests: [],
            pendingRequests: [],
            level1Requests: [],
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
             setRequest: "setRequest",
             setMyRequests: "setMyRequests",
             setErrors: "setErrors"
        }),
        setDataBag(id, type){
            this.bag.request_id = id
            this.bag.field = type
        },
        approveLevel1Request(req){
            api.giveLevel1Approval(req).then(response => {
                this.loadLevel1Requests();
            })
        },
        approveDirectorRequest(req){
            api.giveDirectorApproval(req).then(response => {
                this.loadDirectorRequests();
            })
        },
        approveEDRequest(req){
            api.giveEDApproval(req).then(response => {
                this.loadEDRequests();
            })
        },
        approveFMRequest(req){
            api.givefMApproval(req).then(response => {
                this.loadFMRequests();
            })
        },
        approveProjectrequest(req){
            api.giveAccountantApproval(req).then(response => {
                this.loadProjectRequests();
            })
        },
        declineProjectrequest(){
            console.log(this.bag)
            api.declineRequest(this.bag).then(response => {
                $('#exampleModal').modal('toggle');
                // let trail = response.data
                // this.updateRequest()
                // if(auth.designation == 'Project Accountant' ){
                //     this.loadProjectRequests();
                // }
                // if(auth.roles.includes('manager') ){
                //     this.loadProjectRequests();
                // }

            })
        },
        loadEDRequests(){
            api.getEDRequests().then(response => {
                this.edRequests = response.data
            })
        },
        loadDirectorRequests(){
            api.getDirectorRequests().then(response => {
                this.directorRequests = response.data
            })
        },
        loadLevel1Requests(){
            api.getLevel1Requests().then(response => {
                this.level1Requests = response.data
            })
        },
        loadFMRequests(){
            api.getFMRequests().then(response => {
                this.fMRequests = response.data
            })
        },
        loadProjectRequests(){
            api.getProjectRequests().then(response => {
                this.pendingRequests = response.data
            })
        },
        loadRequest(id){
            let request = this.myRequests.filter(req => req.id == id)[0]
            this.setRequest(request)
        },
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
            this.loading = true
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
                if(!response.success){
                    this.setErrors(response.data.error)
                    this.loading = false;
                    return;
                }
                this.setErrors([])
                api.getMyRequests().then(response => {
                        this.setMyRequests(response.data)
                        this.loading = false;
                        this.$router.push('/requests')
                    })
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
