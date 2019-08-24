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
                    <div class="col-md-2">
                        <button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-primary btn-block"><b>Add Project</b> <i class="fa fa-plus"></i> </button>
                    </div>
                    <div class="col-md-10">
                    <div class="card card-success card-outline" >
                        <div class="card-header">
                            <h3 class="card-title">Projects</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Supervisor</th>
                                        <th style="width:100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="project in projects" :key="project.id">
                                        <td >{{ project.name }}</td>
                                        <td >{{ project.description }}</td>
                                        <td >{{ project.supervisor }}</td>
                                        <td>
                                            <button @click="deleteProject(project.id)" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                            <button @click="setProject(project.id)" type="button" data-toggle="modal" data-target="#editModal" class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Add Project</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                            <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title ">Add Project</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Project Name <span class="text-danger">*</span></label>
                                    <input type="text" v-model="project.name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-form-label">Project Description</label>
                                    <textarea name="" id="" cols="5" rows="3" v-model="project.description" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-form-label">Assign Supervisor</label>
                                    <select name="" id="" class="form-control" v-model="project.supervisor">
                                        <option disabled  value="">Select User</option>
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.fname + ' ' + user.lname }}</option>
                                    </select>
                                </div>


                            </div>
                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                              <button type="button" @click="save" class="btn btn-primary">Save Project <i class="fa fa-plus"></i> </button>

                                               </div>
                                        </div>
                                    </div>
                    </div>
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Project</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title ">Edit Project</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Project Name <span class="text-danger">*</span></label>
                                    <input type="text" v-model="proj.name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-form-label">Project Description</label>
                                    <textarea name="" id="" cols="5" rows="3" v-model="proj.description" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-form-label">Assign Supervisor</label>
                                    <select name="" id="" class="form-control" v-model="proj.supervisor">
                                        <option disabled  value="">Select User</option>
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.fname + ' ' + user.lname }}</option>
                                    </select>
                                </div>


                            </div>
                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" @click="saveEdit" class="btn btn-primary">Save changes</button>
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
import * as api from './../../api/api'
import { mapState, mapMutations } from 'vuex'
export default {
    data() {
        return {
            edit:false,
            name: '',
            // projects: [],
            prefix: process.env.MIX_API_URL,
            project: {},
            proj: []
        }
    },
    methods: {
        ...mapMutations({
            setProjects: "setProjects",
            setUsers: "setUsers"
        }),
        saveEdit(){
            if(this.project.name == ''){
                return;
            }
            axios.post(this.prefix + `/admin/projects/update/${this.proj.id}`, this.proj)
            .then(response => {
                this.loadProjects()
            });
        },
        setProject(id){
            this.proj = this.projects.filter(proj => proj.id == id)[0]
        },
        loadProjects(){
            api.getProjects().then(response => {
                this.setProjects(response.data)
            })
        },
        deleteProject(id){
            axios.get(this.prefix + `/admin/projects/delete/${id}`)
            .then(response => {
                this.loadProjects()
            });
        },
        loadUsers(){
            api.getUsers().then(response => {
                this.setUsers(response.data)
            })
        },
        save(){
            if(this.project.name == ''){
                return;
            }
            axios.post(this.prefix + '/admin/projects/', this.project)
            .then(response => {
                this.loadProjects()
            });
        }
    },
    computed: {
        ...mapState({
            projects: state => state.projects,
            users: state => state.users
        })
    },
    mounted() {
        this.loadUsers()
    },
}
</script>

<style>

</style>
