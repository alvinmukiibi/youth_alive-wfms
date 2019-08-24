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
                    <div class="col-md-4">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title ">Add Vendor</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor's Name</label>
                                    <input type="text" v-model="vendor.name"  class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor Type</label>
                                    <select class="form-control" name="" id="" v-model="vendor.type">
                                        <option value="Commercial">Commercial</option>
                                        <option value="Normal">Normal</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor's Location</label>
                                    <input type="text" v-model="vendor.location"  class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor's Contact</label>
                                    <input type="text" v-model="vendor.contact"  class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor's Email Address</label>
                                    <input type="email" v-model="vendor.email"  class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Representative's Name</label>
                                    <input type="email" v-model="vendor.representative"  class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor's Logo</label>
                                    <input type="file" @change="uploadImage" ref="logm" class="form-control" id="exampleInputEmail1" >
                                </div>

                                <button type="button" @click="save" class="btn btn-primary btn-flat">Submit</button>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                    <div class="card card-success card-outline" >
                        <div class="card-header">
                            <h3 class="card-title">Vendors</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Location</th>
                                        <th>Contact</th>
                                        <th>Rep</th>
                                        <th>Logo</th>
                                        <th style="width:150px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ven in vendors" :key="ven.id">
                                        <td >{{ ven.name }}</td>
                                        <td >{{ ven.type }}</td>
                                        <td >{{ ven.location }}</td>
                                        <td >{{ ven.contact }}</td>
                                        <td >{{ ven.representative }}</td>
                                        <td >
                                            <img v-if="ven.logo"  class="profile-user-img img-fluid img-circle"
                                                            :src="'/storage/vendors/' + ven.logo"
                                                            alt="Vendor Logo">
                                        </td>

                                        <td>
                                            <button @click="deleteVendor(ven.id)" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                            <button @click="setVendor(ven.id)" type="button" data-toggle="modal" data-target="#modal" class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card card-secondary card-outline">
                                                <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor's Name</label>
                                    <input type="text" v-model="vend.name"  class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor Type</label>
                                    <select name="" id="" class="form-control" v-model="vend.type">
                                        <option value="Commercial">Commercial</option>
                                        <option value="Normal">Normal</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor's Location</label>
                                    <input type="text" v-model="vend.location"  class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor's Contact</label>
                                    <input type="text" v-model="vend.contact"  class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor's Email Address</label>
                                    <input type="email" v-model="vend.email"  class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Representative's Name</label>
                                    <input type="email" v-model="vend.representative"  class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vendor's Logo</label>
                                    <input type="file" @change="uploadImagem" ref="log"  class="form-control" id="exampleInputEmail1" >
                                </div>

                                <!-- <button type="button" @click="saveEdit" class="btn btn-primary btn-flat">Submit</button> -->

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
            prefix: process.env.MIX_API_URL,
            vendor: {},
            vend: []
        }
    },
    methods: {
        ...mapMutations({
            setVendors: 'setVendors'
        }),
        saveEdit(){
            if(this.vend.name == ''){
                return;
            }
             let data = new FormData
                data.append('image', this.vend.image)
                data.append('name', this.vend.name)
                data.append('type', this.vend.type)
                data.append('location', this.vend.location)
                data.append('contact', this.vend.contact)
                data.append('email', this.vend.email)
                data.append('representative', this.vend.representative)
            axios.post(this.prefix + `/admin/vendors/update/${this.vend.id}`, data)
            .then(response => {
                this.loadVendors()
            });
        },
        setVendor(id){
            this.vend = this.vendors.filter(ve => ve.id == id)[0]
        },
        loadVendors(){
            api.getVendors().then(response => {
                this.setVendors(response)
            })
        },
        deleteVendor(id){
            axios.get(this.prefix + `/admin/vendors/delete/${id}`)
            .then(response => {
                this.loadVendors()
            });
        },
        uploadImage(){
            this.vendor.image = this.$refs.logm.files[0]

        },
        uploadImagem(){
            this.vend.image = this.$refs.log.files[0]
        },
        save(){
            if(this.vendor.name == ''){
                return;
            }
            let data = new FormData
            data.append('image', this.vendor.image)
            data.append('name', this.vendor.name)
            data.append('type', this.vendor.type)
            data.append('location', this.vendor.location)
            data.append('contact', this.vendor.contact)
            data.append('email', this.vendor.email)
            data.append('representative', this.vendor.representative)

            api.saveVendor(data).then(response => {
                this.loadVendors()
            })
        }
    },
    computed: {
        ...mapState({
            vendors: state => state.vendors
        })
    },
    mounted() {

    },
}
</script>

<style>

</style>
