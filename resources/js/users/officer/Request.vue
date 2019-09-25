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
                                                   
                                                        <button class="btn btn-primary pull-right" @click="save">
                                                            <span v-if="spinner"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                            Save</button>

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
            let data = {
                documents: JSON.stringify(this.documents),
                project_id: this.project_id,
                activity_type: this.activity_type
            }
            api.makeReq(data).then(response => {
                this.setRequest(response.data)
                this.spinner = false
                this.$router.push('/request/make')
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
