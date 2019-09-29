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
                                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab" @click="loadUsers"> <i class="fa fa-list-alt"></i>  List of Employees  <span v-if="usersPresent"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> </a></li>
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
                                                    <th>Station</th>
                                                    <th>Contact</th>
                                                    <th>DP</th>
                                                    <th style="width:100px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="user in users" :key="user.id">
                                                    <td> <router-link to="/view/employee"><span :class="available(user.availability_status)" @click="setEmployee(user.id)" ><b> {{ user.fname + ' ' + user.lname  }}</b></span></router-link></td>
                                                    <td>{{ user.email }}</td>
                                                    <td>{{ user.designation }}</td>
                                                    <td>{{ user.department_acronym }}</td>

                                                    <td>{{ user.duty_station }}</td>
                                                    <td>{{ user.mobile_contact }}</td>
                                                    <td>
                                                        <img
                                                            v-if="user.profile_picture"
                                                            :src="'/storage/' + user.profile_picture"
                                                            class="profile-user-img img-fluid img-circle"
                                                            alt="User Image"
                                                        />
                                                        <img
                                                            v-else
                                                            :src="'https://ui-avatars.com/api/?name=' + user.fname + '+' + user.lname"
                                                            class="img-circle elevation-2"
                                                            alt="User Image"
                                                        />
                                                        <!-- <img class="profile-user-img img-fluid img-circle"
                                                            :src="'/storage/' + user.profile_picture"
                                                            alt="User profile picture"> -->
                                                    </td>
                                                    <td>
                                                        <button type="button" data-toggle="modal" @click="setEmployee(user.id)" data-target="#rolesModal" class="btn btn-sm btn-primary" title="Roles and Projects"> <i  class="fa fa-tasks"></i>  </button>
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
                                                        <label for="inputEmail4">Staff ID </label>
                                                        <input type="text" v-model="user.staff_id" class="form-control" id="inputEmail4" placeholder="Company Staff ID">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputEmail4">First Name <span class="text-danger">*</span> </label>
                                                        <input type="text" v-model="user.fname" class="form-control" id="inputEmail4" placeholder="First Name">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Last Name <span class="text-danger">*</span></label>
                                                        <input type="text" v-model="user.lname" class="form-control" id="inputPassword4" placeholder="Last Name">
                                                    </div>

                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Email Address <span class="text-danger">*</span></label>
                                                        <input type="email" v-model="user.email" class="form-control" id="inputPassword4" placeholder="Email address">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputEmail4">Mobile Contact <span class="text-danger">*</span></label>
                                                        <input type="text" v-model="user.mobile_contact" class="form-control" id="inputEmail4" placeholder="Mobile">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Work Contact</label>
                                                        <input type="text" v-model="user.work_contact" class="form-control" id="inputPassword4" placeholder="Work">
                                                    </div>

                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="">Address <span class="text-danger">*</span></label>
                                                        <!-- <input type="text"  @focus="value = ''" v-model="user.address" class="form-control" id="autocomplete-input" placeholder="Work"> -->
                                                        <textarea ref="autocomplete" @focus="value = ''" name="" v-model="user.address" id="" cols="5" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-row">

                                                    <div class="form-group col-md-3">
                                                         <label for="inputEmail4">User is Director</label>
                                                        <b-form-checkbox
                                                        id="checkbox-1"
                                                        @change="userNotDirector = !userNotDirector"
                                                        name="checkbox-1"
                                                        >
                                                        </b-form-checkbox>
                                                    </div>
                                                    <div class="form-group col-md-3" v-if="userNotDirector">
                                                        <label for="inputEmail4">Department <span class="text-danger">*</span></label>
                                                        <select v-model="user.department_id" name="" id="" class="form-control">
                                                            <option disabled value=""  >Select Department</option>
                                                            <option v-for="dept in departments" :value="dept.id" :key="dept.id"> {{ dept.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3" v-else>
                                                        <label for="inputEmail4">Directorate <span class="text-danger">*</span></label>
                                                        <select v-model="user.directorate_id" name="" id="" class="form-control">
                                                            <option disabled value=""  >Select Directorate</option>
                                                            <option v-for="dir in directorates" :value="dir.id" :key="dir.id"> {{ dir.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="inputPassword4">Designation <span class="text-danger">*</span></label>
                                                        <select v-model="user.designation_id" name="" id="" class="form-control">
                                                            <option disabled value=""  >Select Designation</option>
                                                            <option v-for="desi in designations" :value="desi.id" :key="desi.id"> {{ desi.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="inputPassword4">Contract Type <span class="text-danger">*</span></label>
                                                        <select v-model="user.contract_id" name="" id="" class="form-control">
                                                            <option disabled value="" >Select Contract Type</option>
                                                            <option v-for="cont in contracts" :value="cont.id" :key="cont.id"> {{ cont.name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-8">
                                                        <label for="inputEmail4">Duty Station <span class="text-danger">*</span></label>
                                                        <input type="text" ref="autocompleted" @focus="value = ''" v-model="user.duty_station" class="form-control" id="inputEmail4" placeholder="Duty Station">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="">Bio Data Form Copy</label>
                                                         <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" ref="biodata" @change="uploadFile" class="custom-file-input" id="exampleInputFile">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                        </div>
                                                        <!-- <div class="upload-btn-wrapper">
                                                            <button class="btnw">Upload a file</button>
                                                            <input type="file" name="myfile" />
                                                        </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                        <div class="col-md-12" v-if="errors.length > 0">
                                                            <p class="text-danger pull-left">{{ errors }}</p>
                                                        </div>
                                                        
                                                        <div class="form-group col-md-6">
                                                            <button @click="save" class="btn btn-primary pull-right btn-block" type="button">
                                                                <span v-if="spinner"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                <b> <i class="fa fa-plus"></i> ADD USER</b>
                                                            </button>
                                                           
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="rolesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Roles and Projects</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card card-primary card-outline">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        Manage <b> {{ employee.fname + ' ' + employee.lname + '`s'  }}</b> roles
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <p>{{ employee.fname + '`s' }} current roles <b> [<span v-for="ro in employee.roles" :key="ro">{{ ro + ', ' }}</span> ]</b>  </p>
                                                    <div class="input-group">
                                                        <select name="" id="" v-model="user_role" class="form-control">
                                                            <option disabled value="Select role">Select Role</option>
                                                            <option v-for="role in raw_roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                                                        </select>
                                                        <span class="input-group-append">
                                                            <button type="button" @click="addRoleToUser(employee.id)" class="btn btn-success btn-flat"> <i class="fa fa-plus"></i> </button>
                                                        </span>
                                                        <span class="input-group-append">
                                                            <button type="button" @click="removeRoleFromUser(employee.id)" class="btn btn-danger btn-flat"> <i class="fa fa-minus-circle"></i> </button>
                                                        </span>
                                                        </div>
                                                        <br>

                                                </div>
                                            </div>
                                            <div class="card card-success card-outline">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        Manage <b> {{ employee.fname + ' ' + employee.lname + '`s'  }}</b> projects
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <p>{{ employee.fname + '`s' }} current projects <b> [<span v-for="ro in employee.projects" :key="ro">{{ ro + ', ' }}</span> ]</b>  </p>
                                                    <div class="input-group">
                                                        <select name="" id="" v-model="user_project" class="form-control">
                                                            <option disabled value="Select role">Select Project</option>
                                                            <option v-for="proj in raw_projects" :key="proj.id" :value="proj.id">{{ proj.name }}</option>
                                                        </select>
                                                        <span class="input-group-append">
                                                            <button type="button" @click="addProjectToUser(employee.id)" class="btn btn-success btn-flat"> <i class="fa fa-plus"></i> </button>
                                                        </span>
                                                        <span class="input-group-append">
                                                            <button type="button" @click="removeProjectFromUser(employee.id)" class="btn btn-danger btn-flat"> <i class="fa fa-minus-circle"></i> </button>
                                                        </span>
                                                        </div>
                                                        <br>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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
            userNotDirector: true,
            autocomplete: '',
            spinner: false,
            usersPresent: false,
            user: {
                biodata: '',
                fname: '',
                lname: '',
                email: '',
                mobile_contact: '',
                work_contact: '',
                staff_id: '',
                department_id: '',
                designation_id: '',
                directorate_id: '',
                contract_id: '',
                address: '',
                duty_station: '',
            },
            data: new FormData,
            user_role: '',
            user_project: '',
        }
    },
    methods: {
        ...mapMutations({
            setUsers: 'setUsers',
            setCurrentEmployee: 'setCurrentEmployee',
            setErrors: 'setErrors'
        }),
        available(bool){
            if(bool){
                return 'text-success'
            }else{
                return 'text-danger'
            }
        },
        removeRoleFromUser(user_id){
            let data = {
                user_id: user_id,
                role_id: this.user_role
            }
            api.detachRole(data).then(response => {
                this.loadUsers()
                this.setEmployee(user_id)
                this.showToast('primary', 'Notification', response.message)
                
            })
        },
        showToast(variant, title, body){
             this.$bvToast.toast(body, {
                title: title,
                variant: variant,
                solid: true
        })
    },
        removeProjectFromUser(user_id){
            let data = {
                user_id: user_id,
                project_id: this.user_project
            }
            api.detachProject(data).then(response => {
                this.loadUsers()
                this.setEmployee(user_id)
                this.showToast('primary', 'Notification', response.message)
            })
        },
        addRoleToUser(user_id){
            let data = {
                user_id: user_id,
                role_id: this.user_role
            }
            api.attachRole(data).then(response => {
                this.loadUsers()
                this.setEmployee(user_id)
                this.showToast('primary', 'Notification', response.message)
            })
        },
        addProjectToUser(user_id){
            let data = {
                user_id: user_id,
                project_id: this.user_project
            }
            api.attachProject(data).then(response => {
                this.loadUsers()
                this.setEmployee(user_id)
                this.showToast('primary', 'Notification', response.message)
            })
        },
        uploadFile(){
            this.user.biodata = this.$refs.biodata.files[0]
        },
        save(){
            if(this.userNotDirector){
                this.user.directorate_id == null
            }else{
                this.user.department_id == null
            }
            this.spinner = true;
            this.setErrors([])
            this.data.append('biodata', this.user.biodata);
            this.data.append('fname', this.user.fname)
            this.data.append('lname', this.user.lname)
            this.data.append('email', this.user.email)
            this.data.append('mobile_contact', this.user.mobile_contact)
            this.data.append('work_contact', this.user.work_contact)
            this.data.append('staff_id', this.user.staff_id)
            this.data.append('address', this.user.address)
            this.data.append('department_id', this.userNotDirector ? this.user.department_id: null)
            this.data.append('directorate_id', this.userNotDirector ? null : this.user.directorate_id)
            this.data.append('designation_id', this.user.designation_id)
            this.data.append('contract_id', this.user.contract_id)
            this.data.append('duty_station', this.user.duty_station)
            api.addUser(this.data).then(response => {
                if(!response.success){
                    this.setErrors(response.data.error)
                    this.spinner = false
                    this.showToast('danger', 'Error', response.data.error)
                    return;
                }
                this.setErrors([])
                this.spinner = false;
                this.loadUsers();
                this.user = {}
                this.showToast('success', 'Notification', response.message)
                this.$router.push('/employees#activity')
                // window.location.href = '/employees'
            })

        },
        setEmployee(id){
            let user = this.users.filter(user => user.id == id)[0]
            this.setCurrentEmployee(user)
        },
        activate(id){
            api.activateUser(id).then(response => {
                this.loadUsers()
                this.showToast('success', 'Notification', response.message)
            })
        },
        deactivate(id){
            api.deactivateUser(id).then(response => {
                this.loadUsers()
                this.showToast('success', 'Notification', response.message)
            })
        },
        loadUsers(){
            this.usersPresent = true
            api.getUsers().then(response => {
                this.setUsers(response.data)
                this.usersPresent = false
            })
        }
    },
    
    computed: {
        ...mapState({
            auth: state => state.auth,
            users: state => state.users,
            departments: state => state.departments,
            directorates: state => state.directorates,
            designations: state => state.designations,
            contracts: state => state.contracts,
            errors: state => state.errors,
            raw_roles: state => state.roles,
            raw_projects: state => state.projects,
            employee: state => state.employee
        }),
      
    },
    mounted() {
        this.autocomplete = new google.maps.places.Autocomplete((this.$refs.autocomplete),{types: ['geocode']});
        this.autocomplete.addListener('place_changed', () => {
            let place = this.autocomplete.getPlace();
            if(place != undefined){
                let ac = place.address_components;
                let towns = ac[0]['short_name'] + ', ' + ac[1]['short_name'] + ', ' + ac[2]['short_name']
                this.user.address = towns
            }
        });
        this.autocompleted = new google.maps.places.Autocomplete((this.$refs.autocompleted),{types: ['geocode']});
        this.autocompleted.addListener('place_changed', () => {
            let place = this.autocompleted.getPlace();
            if(place != undefined){
                let ac = place.address_components;
                let town = ac[0]['short_name'] + ', ' + ac[1]['short_name'] + ', ' + ac[2]['short_name']
                this.user.duty_station = town
            }
        });
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
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .btnw {
        border: 2px solid gray;
        color: gray;
        background-color: white;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 20px;
        font-weight: bold;
    }
    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
</style>
