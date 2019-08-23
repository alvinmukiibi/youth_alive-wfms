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
              <li class="breadcrumb-item active">Employees</li>
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
                                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab"> <i class="fa fa-list-alt"></i>  List of Employees</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab"> <i class="fa fa-plus-circle"></i> Add Employee</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <table

                                            class="table table-striped table-bordered table-hover"

                                        >
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Designation</th>
                                                    <th>Dept</th>
                                                    <th>Contract</th>
                                                    <th>Station</th>
                                                    <th>Contact</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="user in users" :key="user.id">
                                                    <td> <router-link to="/view/employee"><span @click="setEmployee(user.id)" ><b> {{ user.fname + ' ' + user.lname  }}</b></span></router-link></td>
                                                    <td>{{ user.email }}</td>
                                                    <td>{{ user.designation }}</td>
                                                    <td>{{ user.department_acronym }}</td>
                                                    <td>{{ user.contract }}</td>
                                                    <td>{{ user.duty_station }}</td>
                                                    <td>{{ user.mobile_contact }}</td>
                                                    <td>
                                                        <!-- <router-link to="/view/employee" class="btn btn-sm btn-primary"> <span @click="setEmployee(user.id)"><i  class="fa fa-pencil"></i></span>  </router-link> -->
                                                        <a @click="deactivate(user.id)" title="Deactivate" v-if="user.activity_status"  :class="{'disabled': user.id == auth.id}" to="/deactivate" class="btn btn-sm btn-danger"> <i class="fa fa-times text-white"></i> </a>
                                                        <a @click="activate(user.id)" title="Activate" v-else to="/activate" class="btn btn-sm btn-success"> <i class="fa fa-check text-white"></i> </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="timeline">
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    Enter Employee Information
                                                    <small class="text-primary">Note: Fields marked with <span class="text-danger">*</span> <b>MUST</b> be filled</small>
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="inputEmail4">First Name <span class="text-danger">*</span> </label>
                                                        <input type="text" v-model="user.fname" class="form-control" id="inputEmail4" placeholder="First Name">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Last Name <span class="text-danger">*</span></label>
                                                        <input type="text" v-model="user.lname" class="form-control" id="inputPassword4" placeholder="Last Name">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Email Address <span class="text-danger">*</span></label>
                                                        <input type="email" v-model="user.email" class="form-control" id="inputPassword4" placeholder="Email address">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="inputEmail4">Mobile Contact <span class="text-danger">*</span></label>
                                                        <input type="text" v-model="user.mobile_contact" class="form-control" id="inputEmail4" placeholder="Mobile">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Work Contact</label>
                                                        <input type="text" v-model="user.work_contact" class="form-control" id="inputPassword4" placeholder="Work">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Home Contact</label>
                                                        <input type="email" v-model="user.home_contact" class="form-control" id="inputPassword4" placeholder="Home">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="">Address <span class="text-danger">*</span></label>
                                                        <textarea name="" v-model="user.address" id="" cols="5" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="inputEmail4">Department <span class="text-danger">*</span></label>
                                                        <select v-model="user.department_id" name="" id="" class="form-control">
                                                            <option disabled >Select Department</option>
                                                            <option v-for="dept in departments" :value="dept.id" :key="dept.id"> {{ dept.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Designation <span class="text-danger">*</span></label>
                                                        <select v-model="user.designation_id" name="" id="" class="form-control">
                                                            <option disabled >Select Designation</option>
                                                            <option v-for="desi in designations" :value="desi.id" :key="desi.id"> {{ desi.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Contract Type <span class="text-danger">*</span></label>
                                                        <select v-model="user.contract_id" name="" id="" class="form-control">
                                                            <option >Select Contract Type</option>
                                                            <option v-for="cont in contracts" :value="cont.id" :key="cont.id"> {{ cont.name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="inputEmail4">Duty Station <span class="text-danger">*</span></label>
                                                        <input type="text" v-model="user.duty_station" class="form-control" id="inputEmail4" placeholder="Duty Station">
                                                    </div>
                                                    <div class="form-group col-md-8">
                                                        <label for="">Bio Data Form Copy</label>
                                                         <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" ref="biodata" @change="uploadFile" class="custom-file-input" id="exampleInputFile">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                        <div class="col-md-12" v-if="errors.length > 0">
                                                            <p class="text-danger pull-left">{{ errors }}</p>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <button @click="save" class="btn btn-primary pull-right btn-block"> <b> <i class="fa fa-plus"></i> ADD USER</b> </button>
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
            spinner: false,
            user: {
                biodata: '',
                fname: '',
                lname: '',
                email: '',
                mobile_contact: '',
                work_contact: '',
                home_contact: '',
                department_id: '',
                designation_id: '',
                contract_id: '',
                address: '',
                duty_station: '',
            },
            data: new FormData
        }
    },
    methods: {
        ...mapMutations({
            setUsers: 'setUsers',
            setCurrentEmployee: 'setCurrentEmployee',
            setErrors: 'setErrors'
        }),
        uploadFile(){
            this.user.biodata = this.$refs.biodata.files[0]
        },
        save(){
            this.data.append('biodata', this.user.biodata);
            this.data.append('fname', this.user.fname)
            this.data.append('lname', this.user.lname)
            this.data.append('email', this.user.email)
            this.data.append('mobile_contact', this.user.mobile_contact)
            this.data.append('work_contact', this.user.work_contact)
            this.data.append('home_contact', this.user.home_contact)
            this.data.append('address', this.user.address)
            this.data.append('department_id', this.user.department_id)
            this.data.append('designation_id', this.user.designation_id)
            this.data.append('contract_id', this.user.contract_id)
            this.data.append('duty_station', this.user.duty_station)
            api.addUser(this.data).then(response => {
                if(!response.success){
                    this.setErrors(response.data.error)
                    this.spinner = false
                    return;
                }
                this.setErrors([])
                this.spinner = false;
            })

        },
        setEmployee(id){
            let user = this.users.filter(user => user.id == id)[0]
            this.setCurrentEmployee(user)
        },
        activate(id){
            api.activateUser(id).then(response => {
                this.loadUsers()
            })
        },
        deactivate(id){
            api.deactivateUser(id).then(response => {
                this.loadUsers()
            })
        },
        loadUsers(){
            api.getUsers().then(response => {
                this.setUsers(response.data)
            })
        }
    },
    computed: {
        ...mapState({
            auth: state => state.auth,
            users: state => state.users,
            departments: state => state.departments,
            designations: state => state.designations,
            contracts: state => state.contracts,
            errors: state => state.errors,
        })
    },
    created() {
        this.loadUsers();
    },
}
</script>

<style >
    .disabled {
        pointer-events: none;
        cursor: default;
    }
</style>
