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
                        <button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-primary btn-block"><b>Add Asset</b></button>
                    </div>
                    <div class="col-md-10">
                    <div class="card card-success card-outline" >
                        <div class="card-header">
                            <h3 class="card-title">Assets</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>ID #</th>
                                        <th style="width:10px">Qty</th>
                                        <th style="width:120px">Cost /=</th>
                                        <th style="width:100px">Image</th>
                                        <th style="width:100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ass in assets" :key="ass.id">
                                        <td >{{ ass.name }}</td>
                                        <td >{{ ass.identity }}</td>
                                        <td >{{ ass.quantity }}</td>
                                        <td >{{ ass.cost }}</td>
                                        <td >
                                             <img v-if="ass.image"  class="profile-user-img img-fluid img-circle"
                                                            :src="'/storage/assets/' + ass.image"
                                                            alt="Asset image">
                                        </td>
                                        <td>
                                            <button @click="deleteAsset(ass.id)" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                            <button @click="setAsset(ass.id)" type="button" data-toggle="modal" data-target="#editModal" class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil"></i></button>
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
                                            <h5 class="modal-title" id="exampleModalLongTitle">Add Asset</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                            <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title ">Add Asset</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="Deparmtent" class="col-sm-4 col-form-label">Name</label>
                                    <div class="col-md-8">
                                        <input type="text"  v-model="asset.name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Deparmtent" class="col-sm-4 col-form-label">Identity</label>
                                    <div class="col-md-8">
                                        <input type="text"  v-model="asset.identity" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Deparmtent" class="col-sm-4 col-form-label">Quantity</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0"  v-model="asset.quantity" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Deparmtent" class="col-sm-4 col-form-label">Cost (/=)</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0"  v-model="asset.cost" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Deparmtent" class="col-sm-4 col-form-label">Asset Image</label>
                                    <div class="col-md-8">
                                        <input type="file" ref="im" @change="uploadImage"   class="form-control" >
                                    </div>
                                </div>
                            </div>
                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                              <button type="button" @click="save" class="btn btn-primary">Save Asset <i class="fa fa-plus"></i> </button>

                                               </div>
                                        </div>
                                    </div>
                    </div>
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Department</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title ">Edit Department</h3>
                            </div>
                              <div class="card-body">
                                <div class="form-group row">
                                    <label for="Deparmtent" class="col-sm-4 col-form-label">Name</label>
                                    <div class="col-md-8">
                                        <input type="text"  v-model="asse.name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Deparmtent" class="col-sm-4 col-form-label">Identity</label>
                                    <div class="col-md-8">
                                        <input type="text"  v-model="asse.identity" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Deparmtent" class="col-sm-4 col-form-label">Quantity</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0"  v-model="asse.quantity" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Deparmtent" class="col-sm-4 col-form-label">Cost (/=)</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0"  v-model="asse.cost" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Deparmtent" class="col-sm-4 col-form-label">Asset Image</label>
                                    <div class="col-md-8">
                                        <input type="file" ref="imm" @change="uploadImagem"   class="form-control" >
                                    </div>
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
            prefix: process.env.MIX_API_URL,
            asset: {},
            asse: []
        }
    },
    methods: {
        ...mapMutations({
            setAssets: "setAssets",
        }),
        saveEdit(){
            if(this.asse.name == ''){
                return;
            }
            let data = new FormData
                data.append('image', this.asse.image)
                data.append('name', this.asse.name)
                data.append('quantity', this.asse.quantity)
                data.append('identity', this.asse.identity)
                data.append('cost', this.asse.cost)
                axios.post(this.prefix + `/admin/assets/update/${this.asse.id}`, data)
            .then(response => {
                this.loadAssets()
            });
        },
        setAsset(id){
            this.asse = this.assets.filter(asset => asset.id == id)[0]
        },
        loadAssets(){
            api.getAssets().then(response => {
                this.setAssets(response)
            })
        },
        deleteAsset(id){
            axios.get(this.prefix + `/admin/assets/delete/${id}`)
            .then(response => {
                this.loadAssets()
            });
        },
        uploadImage(){
            this.asset.image = this.$refs.im.files[0]
        },
        uploadImagem(){
            this.asse.image = this.$refs.imm.files[0]
        },
        save(){
            if(this.asset.name == ''){
                return;
            }
            let data = new FormData
            data.append('image', this.asset.image)
            data.append('name', this.asset.name)
            data.append('quantity', this.asset.quantity)
            data.append('identity', this.asset.identity)
            data.append('cost', this.asset.cost)
            axios.post(this.prefix + '/admin/assets', data)
            .then(response => {
                this.loadAssets()
            });
        }
    },
    computed: {
        ...mapState({
            assets: state => state.assets,
        })
    },
    mounted() {

    },
}
</script>

<style>

</style>
