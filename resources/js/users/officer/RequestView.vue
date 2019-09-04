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
              <li class="breadcrumb-item active">Request</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    View Request
                                    <div class="callout callout-info">
                                        <h6> <i class="fa fa-info"></i> Note: To edit, click on the field and type. Note that you can only edit a request that has not been approved by anyone</h6>
                                    </div>
                                </h3>
                            </div>
                             <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="inputEmail4">Activity Type  <span class="text-danger">*</span> </label>

                                                        <input type="text" v-if="!dropDown" @click="dropDown = true"  v-model="request.activity_type" class="form-control">
                                                        <select  v-else name="" id="" class="form-control" v-model="editRequest.activity_type" >
                                                            <option value="">Select Activity Type</option>
                                                            <option value="Meeting">Meeting</option>
                                                            <option value="Talk Show">Talk Show</option>
                                                            <option value="Workshop">Workshop</option>
                                                            <option value="Training">Training</option>
                                                            <option value="Vehicle">Vehicle</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Vendor</label>
                                                        <input v-if="!dropDown2" @click="dropDown2 = true" type="text"  v-model="request.vendor.name" class="form-control">
                                                        <select v-else name="" id="" class="form-control" v-model="editRequest.vendor_id"  >
                                                            <option v-for="vendor in vendors" :key="vendor.id" :value="vendor.id">{{ vendor.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4">Date Required <span class="text-danger">*</span></label>
                                                        <input type="text" v-if="!dropDown4" @click="dropDown4 = true"  v-model="request.delivery_date" class="form-control"  id="inputPassword4" >
                                                        <input type="date" v-else  v-model="editRequest.delivery_date" class="form-control"  id="inputPassword4" >
                                                    </div>
                                                </div>

                                                <div class="form-row" v-if="request.assets.length > 0">
                                                    <div class="form-group col-md-3">
                                                        <label for="inputEmail4"> Asset/Service Name  <span class="text-danger">*</span> </label>
                                                         <input type="text" v-if="!dropDown3" @click="dropDown3 = true" v-model="request.assets[0].name"  class="form-control" id="inputPassword4" >
                                                        <select v-else name="" id="" class="form-control" v-model="editRequest.asset_id" >
                                                            <option v-for="ass in assets" :key="ass.id" :value="ass.id">{{ ass.name }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="inputPassword4">Qty <span class="text-danger">*</span></label>
                                                        <input type="number" min='0' v-model="request.assets[0].quantity"  class="form-control" id="inputPassword4" >
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="inputPassword4">Unit Cost <span class="text-danger">*</span></label>
                                                        <input type="number" min='0' v-model="request.assets[0].unit_cost"   class="form-control" id="inputPassword4" >
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="inputPassword4">Total Cost </label>
                                                        <input type="text" v-model="request.assets[0].total_cost"    class="form-control" id="inputPassword4" >
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="inputPassword4">A little more explanation... </label>
                                                        <input type="text" v-model="request.assets[0].comments"  class="form-control" id="inputPassword4" >
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4">Requestor's comments</label>
                                                        <textarea class="form-control" v-model="request.trail.requestor_comments"  cols="5" rows="2"></textarea>
                                                    </div>
                                                </div>
                                                <div v-if="addAttachments == false" class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <button @click="addAttachments = true" class="btn btn-outline-secondary"> <b>Add More attachments</b> <i class="fa fa-file"></i> </button>
                                                    </div>
                                                </div>
                                                <div v-if="addAttachments" class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4">Add Attachments</label>
                                                        <input multiple="multiple" type="file" ref="att" @change="uploadFiles" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-row" v-if="request.attachments.length > 0">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4">Attachments</label><br>
                                                     <ul class="mailbox-attachments clearfix">
                                                            <li v-for="att in request.attachments" :key="att.id" >
                                                            <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                            <div class="mailbox-attachment-info" >
                                                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-download"></i>    Download</a>
                                                                    <!-- <span class="mailbox-attachment-size">
                                                                    1,245 KB
                                                                <a href="#" class="btn btn-default btn-sm float-right"><i class="fa fa-cloud-download"></i></a>
                                                                </span> -->
                                                            </div>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                </div>
                                                 <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Approval Type</th>
                                                                    <th>Status</th>
                                                                    <th>Date</th>
                                                                    <th>Done by</th>
                                                                    <th>Comments</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-if="request.trail.accountant_approval != 0">
                                                                    <td >Project Accountant</td>
                                                                    <td v-if="request.trail.accountant_approval == 1"> <button class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>  </td>
                                                                    <td v-else><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                                                                    <td>{{ request.trail.acc_appro_date }}</td>
                                                                    <td>{{ request.trail.accountant }}</td>
                                                                    <td>{{ request.trail.acc_comments }}</td>
                                                                </tr>
                                                                <tr v-if="request.trail.level_one_approval != 0">
                                                                    <td >L1</td>
                                                                    <td v-if="request.trail.level_one_approval == 1"> <button class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>  </td>
                                                                    <td v-else><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                                                                    <td>{{ request.trail.level_one_date }}</td>
                                                                    <td>{{ request.trail.level_one_approver }}</td>
                                                                    <td>{{ request.trail.level_one_comments }}</td>
                                                                </tr>
                                                                <tr v-if="request.trail.finance_approval != 0 && request.trail.finance_approval != null">
                                                                    <td >FM</td>
                                                                    <td v-if="request.trail.finance_approval == 1"> <button class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>  </td>
                                                                    <td v-else><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                                                                    <td>{{ request.trail.finance_approval_date }}</td>
                                                                    <td>{{ request.trail.finance_approver }}</td>
                                                                    <td>{{ request.trail.finance_appro_comments }}</td>
                                                                </tr>
                                                                <tr v-if="request.trail.level_two_approval != 0 && request.trail.level_two_approval != null">
                                                                    <td >L2</td>
                                                                    <td v-if="request.trail.level_two_approval == 1"> <button class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>  </td>
                                                                    <td v-else><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                                                                    <td>{{ request.trail.level_two_date }}</td>
                                                                    <td>{{ request.trail.level_two_approver }}</td>
                                                                    <td>{{ request.trail.level_two_comments }}</td>
                                                                </tr>
                                                                <tr v-if="request.trail.level_three_approval != 0 && request.trail.level_three_approval != null">
                                                                    <td >L3</td>
                                                                    <td v-if="request.trail.level_three_approval == 1"> <button class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>  </td>
                                                                    <td v-else><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
                                                                    <td>{{ request.trail.level_three_date }}</td>
                                                                    <td>{{ request.trail.level_three_approver }}</td>
                                                                    <td>{{ request.trail.level_three_comments }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                      
                                                    </div>
                                                </div>
                                                 <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                      <button @click="save"  class="btn btn-primary btn-block"> <b>SAVE REQUEST</b> </button>
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
            addAttachments: false,
            dropDown: false,
            dropDown1: false,
            dropDown2: false,
            dropDown3: false,
            dropDown4: false,
            editRequest: {
                activity_type: null,
                vendor_id: null,
                delivery_date: null,
                asset_id: null,
            },
            data: new FormData
        }
    },
    methods: {
        ...mapMutations({

        }),
        uploadFiles(){
            let files = this.$refs.att.files
            for(let i = 0; i < files.length; i++){
                this.data.append('attachments[]', files[i])
            }
        },
        save(){
            this.data.append('activity_type', this.editRequest.activity_type)
            this.data.append('vendor_id', this.editRequest.vendor_id)
            this.data.append('delivery_date', this.editRequest.delivery_date)
            this.data.append('asset_id', this.editRequest.asset_id)
            if(this.request.assets.length > 0){
                this.data.append('quantity', this.request.assets[0].quantity)
                this.data.append('unit_cost', this.request.assets[0].unit_cost)
                this.data.append('comments', this.request.assets[0].comments)
            }
            this.data.append('requestor_comments', this.request.trail.requestor_comments)

            api.saveRequest(this.data, this.request.id).then(response => {
                console.log(response.data);
            })


        }
    },
    computed: {
        ...mapState({
            request: state => state.request,
            vendors: state => state.vendors,
            assets: state => state.assets,

        })

    },
    mounted() {

    },
}
</script>

<style>

</style>
