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
                                                    <li class="nav-item"><a @click="getMyRequests" class="nav-link active" href="#new" data-toggle="tab">My Requests <span v-if="spin1"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a>  </li>
                                                    <!-- <li class="nav-item"><a class="nav-link" href="#approved" data-toggle="tab">Approval Trail</a></li> -->
                                                    <!-- <li class="nav-item"><a class="nav-link" href="#declined" data-toggle="tab">Declined</a></li> -->
                                                    <li @click="loadProjectRequests" v-if="auth.is_accountant" class="nav-item"><a class="nav-link" href="#projectrequests" data-toggle="tab">Project Requests <span v-if="spin2"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a></li>
                                                    <li @click="loadLevel1Requests" v-if="stateLoaded && auth.roles.includes('manager')" class="nav-item"><a class="nav-link" href="#level1requests" data-toggle="tab">Supervisor Requests <span v-if="spin3"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a></li>
                                                    <li @click="loadFMRequests" v-if="stateLoaded && auth.roles.includes('manager') && auth.department == 'Finance and Operations'" class="nav-item"><a class="nav-link" href="#fmrequests" data-toggle="tab">Pending Financial Approval <span v-if="spin4"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a></li>
                                                    <li @click="loadDirectorRequests" v-if="stateLoaded && auth.roles.includes('director')"  class="nav-item"><a class="nav-link" href="#directorrequests" data-toggle="tab">Pending Director Approval <span v-if="spin5"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a></li>
                                                    <li @click="loadEDRequests" v-if="stateLoaded && auth.designation == 'Executive Director'" class="nav-item"><a class="nav-link" href="#edrequests" data-toggle="tab">Pending ED Approval <span v-if="spin6"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></a></li>
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
                                                                    <b-td v-if="req.trail.accountant_approval == 0 && req.status != 2">
                                                                        <button @click="cancelRequest(req.id)" class="btn btn-sm btn-outline-danger">Cancel</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.trail.level_three_approval == 1">
                                                                        <button :disabled="disabled" class="btn btn-sm btn-success">Fully Approved</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.status == 2">
                                                                        <button :disabled="disabled"  class="btn btn-sm btn-secondary">Cancelled</button>
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
                                                                    <b-td v-if="req.trail.accountant_approval == 0">
                                                                        <button @click="sendToken(req.id, 'proj')" type="button" class="btn btn-outline-success btn-sm">
                                                                            Approve <span v-if="spin7"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        </button>
                                                                        <button @click="sendDecToken(req.id, 'proj')"    class="btn btn-outline-danger btn-sm">Decline <span v-if="spin8"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                                                    </b-td>
                                                                    <b-td v-if="req.trail.accountant_approval == 1">
                                                                        <button class="btn btn-success btn-sm btn-flat"> <i class="fa fa-check"></i> Approved</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.trail.accountant_approval == 2">
                                                                        <button class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-times"></i> Declined</button>
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
                                                                    <b-td v-if="req.trail.level_one_approval == 0">
                                                                        <button @click="sendToken(req.id, 'lev1')" type="button" class="btn btn-outline-success btn-sm">
                                                                            Approve <span v-if="spin7"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        </button>
                                                                        <button @click="sendDecToken(req.id, 'lev1')"    class="btn btn-outline-danger btn-sm">Decline <span v-if="spin8"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                                                    </b-td>
                                                                    <b-td v-if="req.trail.level_one_approval == 1">
                                                                        <button class="btn btn-success btn-sm btn-flat"> <i class="fa fa-check"></i> Approved</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.trail.level_one_approval == 2">
                                                                        <button class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-times"></i> Declined</button>
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
                                                                     <b-td v-if="req.requestor_type == 'officer' && req.trail.finance_approval == 0">
                                                                         <button @click="sendToken(req.id, 'finm')" type="button" class="btn btn-outline-success btn-sm">
                                                                            Approve <span v-if="spin7"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        </button>
                                                                        <button @click="sendDecToken(req.id, 'finm')"    class="btn btn-outline-danger btn-sm">Decline <span v-if="spin8"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                                                        <!-- <button @click="approveFMRequest(req.id)" class="btn btn-outline-success btn-sm">Approve</button>
                                                                        <button @click="setDataBag(req.id, 'finance_approval')" data-toggle="modal" data-backdrop="false" data-dismiss="modal"  data-target="#exampleModal" class="btn btn-outline-danger btn-sm">Decline</button> -->
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'officer' && req.trail.finance_approval == 1">
                                                                        <button class="btn btn-success btn-sm btn-flat"> <i class="fa fa-check"></i> Approved</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'officer' && req.trail.finance_approval == 2">
                                                                        <button class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-times"></i> Declined</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'manager' && req.trail.level_two_approval == 0">
                                                                        <button @click="sendToken(req.id, 'finm')" type="button" class="btn btn-outline-success btn-sm">
                                                                            Approve <span v-if="spin7"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        </button>
                                                                        <button @click="sendDecToken(req.id, 'finm')"    class="btn btn-outline-danger btn-sm">Decline <span v-if="spin8"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                                                       
                                                                        <!-- <button @click="approveFMRequest(req.id)" class="btn btn-outline-success btn-sm">Approve</button>
                                                                        <button @click="setDataBag(req.id, 'finance_approval')" data-toggle="modal" data-backdrop="false" data-dismiss="modal"  data-target="#exampleModal" class="btn btn-outline-danger btn-sm">Decline</button> -->
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'manager' && req.trail.level_two_approval == 1">
                                                                        <button class="btn btn-success btn-sm btn-flat"> <i class="fa fa-check"></i> Approved</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'manager' && req.trail.level_two_approval == 2">
                                                                        <button class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-times"></i> Declined</button>
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
                                                                    <b-td v-if="req.requestor_type == 'officer' && req.trail.level_two_approval == 0">
                                                                         <button @click="sendToken(req.id, 'lev2')" type="button" class="btn btn-outline-success btn-sm">
                                                                            Approve <span v-if="spin7"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        </button>
                                                                        <button @click="sendDecToken(req.id, 'lev2')"    class="btn btn-outline-danger btn-sm">Decline <span v-if="spin8"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                                                       
                                                                        <!-- <button @click="approveDirectorRequest(req.id)" class="btn btn-outline-success btn-sm">Approve</button>
                                                                        <button @click="setDataBag(req.id, 'level_two_approval')" data-toggle="modal" data-backdrop="false" data-dismiss="modal"  data-target="#exampleModal" class="btn btn-outline-danger btn-sm">Decline</button> -->
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'officer' && req.trail.level_two_approval == 1">
                                                                        <button class="btn btn-success btn-sm btn-flat"> <i class="fa fa-check"></i> Approved</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'officer' && req.trail.level_two_approval == 2">
                                                                        <button class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-times"></i> Declined</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'manager' && req.trail.level_one_approval == 0">
                                                                         <button @click="sendToken(req.id, 'lev2')" type="button" class="btn btn-outline-success btn-sm">
                                                                            Approve <span v-if="spin7"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        </button>
                                                                        <button @click="sendDecToken(req.id, 'lev2')"    class="btn btn-outline-danger btn-sm">Decline <span v-if="spin8"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                                                       
                                                                        <!-- <button @click="approveDirectorRequest(req.id)" class="btn btn-outline-success btn-sm">Approve</button>
                                                                        <button @click="setDataBag(req.id, 'level_two_approval')" data-toggle="modal" data-backdrop="false" data-dismiss="modal"  data-target="#exampleModal" class="btn btn-outline-danger btn-sm">Decline</button> -->
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'manager' && req.trail.level_one_approval == 1">
                                                                        <button class="btn btn-success btn-sm btn-flat"> <i class="fa fa-check"></i> Approved</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'manager' && req.trail.level_one_approval == 2">
                                                                        <button class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-times"></i> Declined</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'director' && req.trail.level_one_approval == 0">
                                                                         <button @click="sendToken(req.id, 'lev2')" type="button" class="btn btn-outline-success btn-sm">
                                                                            Approve <span v-if="spin7"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        </button>
                                                                        <button @click="sendDecToken(req.id, 'lev1')"    class="btn btn-outline-danger btn-sm">Decline <span v-if="spin8"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                                                       
                                                                        <!-- <button @click="approveDirectorRequest(req.id)" class="btn btn-outline-success btn-sm">Approve</button>
                                                                        <button @click="setDataBag(req.id, 'level_one_approval')" data-toggle="modal" data-backdrop="false" data-dismiss="modal"  data-target="#exampleModal" class="btn btn-outline-danger btn-sm">Decline</button> -->
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'director' && req.trail.level_one_approval == 1">
                                                                        <button class="btn btn-success btn-sm btn-flat"> <i class="fa fa-check"></i> Approved</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'director' && req.trail.level_one_approval == 2">
                                                                        <button class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-times"></i> Declined</button>
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
                                                                    <b-td v-if="req.requestor_type != 'director' && req.trail.level_three_approval == 0">
                                                                        <button @click="sendToken(req.id, 'lev3')" type="button" class="btn btn-outline-success btn-sm">
                                                                            Approve <span v-if="spin7"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        </button>
                                                                        <button @click="sendDecToken(req.id, 'lev3')"    class="btn btn-outline-danger btn-sm">Decline <span v-if="spin8"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                                                       
                                                                        <!-- <button @click="approveEDRequest(req.id)" class="btn btn-outline-success btn-sm">Approve</button>
                                                                        <button @click="setDataBag(req.id, 'level_three_approval')" data-toggle="modal" data-backdrop="false" data-dismiss="modal"  data-target="#exampleModal" class="btn btn-outline-danger btn-sm">Decline</button> -->
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type != 'director' && req.trail.level_three_approval == 1">
                                                                        <button class="btn btn-success btn-sm btn-flat"> <i class="fa fa-check"></i> Approved</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type != 'director' && req.trail.level_three_approval == 2">
                                                                        <button class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-times"></i> Declined</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'director' && req.trail.level_two_approval == 0">
                                                                       <button @click="sendToken(req.id, 'lev3')" type="button" class="btn btn-outline-success btn-sm">
                                                                            Approve <span v-if="spin7"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        </button>
                                                                        <button @click="sendDecToken(req.id, 'lev3')"    class="btn btn-outline-danger btn-sm">Decline <span v-if="spin8"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
                                                                        <!-- <button @click="approveEDRequest(req.id)" class="btn btn-outline-success btn-sm">Approve</button>
                                                                        <button @click="setDataBag(req.id, 'level_three_approval')" data-toggle="modal" data-backdrop="false" data-dismiss="modal"  data-target="#exampleModal" class="btn btn-outline-danger btn-sm">Decline</button> -->
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'director' && req.trail.level_two_approval == 1">
                                                                        <button class="btn btn-success btn-sm btn-flat"> <i class="fa fa-check"></i> Approved</button>
                                                                    </b-td>
                                                                    <b-td v-if="req.requestor_type == 'director' && req.trail.level_two_approval == 2">
                                                                        <button class="btn btn-danger btn-sm btn-flat"> <i class="fa fa-times"></i> Declined</button>
                                                                    </b-td>
                                                                </b-tr>
                                                            </b-tbody>
                                                        </b-table-simple>
                                                      </div>
                                                </div>
                                              </div>
                                        </div>


                                    </div>
                                    <div class="modal fade" id="tokenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Enter Token</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card card-outline card-success">
                                                                               <div class="card-body">
                                                                                    <div class="form-group row" >
                                                                                <label for="" class="col-sm-4 col-form-label">Token</label>
                                                                                <div class="col-md-8">
                                                                                    <input v-model="approvalBag.token" type="text" placeholder="e.g. 567G" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                               </div>

                                                                           </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="button" @click="confirm" class="btn btn-primary">Confirm</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="tokenDecModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Enter Token</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card card-outline card-success">
                                                                               <div class="card-body">
                                                                                    <div class="form-group row" >
                                                                                <label for="" class="col-sm-4 col-form-label">Token</label>
                                                                                <div class="col-md-8">
                                                                                    <input v-model="approvalBag.token" type="text" placeholder="e.g. 567G" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                               </div>

                                                                           </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="button" @click="decline" class="btn btn-danger">Decline</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Comments</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card card-outline-primary">
                                                                <div class="card-header">
                                                                    <h3 class="card-title">
                                                                        Comments
                                                                    </h3>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <textarea name="" v-model="bag.comments" id="" cols="3" rows="3" class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button @click="declineProjectrequest" type="button" class="btn btn-primary">Continue</button>
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
                                                            <option v-for="project in filtered_projects" :key="project.id" :value="project.id">{{ project.name }}</option>
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
             bag: {
                request_id: null,
                field: null,
                comments: null,
            },
            approvalBag: {
                approvalType: '',
                request_id: null,
                token: null
            },
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
            spin7: false,
            spin8: false,
            spin9: false,
            spin10: false,
            spin11: false,
            bucket: null,
            disabled: true
        }
    },
    methods: {
         ...mapMutations({
             setRequest: "setRequest",
             setMyRequests: "setMyRequests",
             setErrors: "setErrors",
             setProjects: "setProjects"
        }),
        confirm(){
            
                api.checkAndInvalidateToken(this.approvalBag).then(response => {
                    if(!response.success){
                         this.setErrors(response.data.error)
                         this.showToast('danger', 'Error', this.errors)
                         return
                    } 
                   
                    if(this.approvalBag.approvalType == 'proj'){
                        this.approveProjectrequest(this.approvalBag.request_id)
                    }
                    if(this.approvalBag.approvalType == 'lev1'){
                        this.approveLevel1Request(this.approvalBag.request_id)
                    }
                    if(this.approvalBag.approvalType == 'finm'){
                        this.approveFMRequest(this.approvalBag.request_id)
                    }
                    if(this.approvalBag.approvalType == 'lev2'){
                        this.approveDirectorRequest(this.approvalBag.request_id)
                    }
                    if(this.approvalBag.approvalType == 'lev3'){
                        this.approveEDRequest(this.approvalBag.request_id)
                    }
                    this.approvalBag.token = null
                    this.approvalBag.approvalType = ''
                    this.showToast('success', 'Notification', 'Success')
                })
            
        },
        decline(){
                api.checkAndInvalidateToken(this.approvalBag).then(response => {
                    if(!response.success){
                         this.setErrors(response.data.error)
                         return
                    } 
                    this.approvalBag.token = null
                    this.approvalBag.approvalType = ''
                    $('#tokenModal').modal('hide')
                    $('#exampleModal').modal('show')
                })
            
        },
        sendToken(id, ty){
            this.approvalBag.approvalType = ty
            this.approvalBag.request_id = id
            let data = {
                request_id: id,
                ty: ty
            }
            this.spin7 = true
            api.sendToken(data).then(response => {
                this.spin7 = false
                this.showToast('primary', 'Token', 'Token has been generated and sent, check your email and retrieve token')
                $('#tokenModal').modal('show')
            })
        },
        showToast(variant, title, body){
             this.$bvToast.toast(body, {
                title: title,
                variant: variant,
                solid: true
        })
        },
        setDataBag(id, type){
            this.bag.request_id = id
            this.bag.field = type
        },
        sendDecToken(id, ty){
            if(ty == 'proj'){
                this.setDataBag(id, 'accountant_approval')
            }
            if(ty == 'lev1'){
                this.setDataBag(id, 'level_one_approval')
            }
            if(ty == 'finm'){
                this.setDataBag(id, 'finance_approval')
            }
            if(ty == 'lev2'){
                this.setDataBag(id, 'level_two_approval')
            }
            
            this.approvalBag.approvalType = ty
            this.approvalBag.request_id = id
            let data = {
                request_id: id,
                ty: ty
            }
            this.spin8 = true
            api.sendToken(data).then(response => {
                this.spin8 = false
                this.showToast('primary', 'Token', 'Token has been generated and sent, check your email and retrieve token')
                $('#tokenDecModal').modal('show')
            })
        },
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
                 this.showToast('success', 'Notification', 'Saved!! Please fill the documents on the next page')
                this.$router.push('/request/make')
                
            })
        },
         cancelRequest(id){
            api.cancelRequest(id).then(response => {
                this.getMyRequests()
                 this.showToast('success', 'Notification', response.message)
            })
         },
         declineProjectrequest(){
            api.declineRequest(this.bag).then(response => {
                $('#tokenModal').modal('hide');
                $('#exampleModal').modal('toggle');
                 this.showToast('success', 'Notification', 'success')
            })
         },
        approveLevel1Request(req){
            api.giveLevel1Approval(req).then(response => {
                 $('#tokenModal').modal('hide');
                this.loadLevel1Requests();
            })
        },
        approveDirectorRequest(req){
            api.giveDirectorApproval(req).then(response => {
                 $('#tokenModal').modal('hide');
                this.loadDirectorRequests();
            })
        },
        approveEDRequest(req){
            api.giveEDApproval(req).then(response => {
                 $('#tokenModal').modal('hide');
                this.loadEDRequests();
            })
        },
        approveFMRequest(req){
            api.givefMApproval(req).then(response => {
                 $('#tokenModal').modal('hide');
                this.loadFMRequests();
            })
        },
         approveProjectrequest(req){
            api.giveAccountantApproval(req).then(response => {
                $('#tokenModal').modal('hide');
                this.loadProjectRequests();
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
                 this.spin5 = false
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
        getProjects(){
            api.getProjects().then(response => {
            this.setProjects(response.data);
          });
        }
    },
    computed: {
         ...mapState({
             auth: state => state.auth,
             myRequests: state => state.myRequests,
             projects: state => state.projects,
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
        filtered_projects(){
            // if you are not HQ staff, you can only make a request on a project you are attached to
            if(this.auth.duty_station.includes('Kampala') ){
                return this.projects
            }else{
                let arr = []
                this.projects.forEach(proj => {
                    if(this.auth.projects.includes(proj.name)){
                        arr.push(proj)
                    }
                })
                return arr

            }
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
        this.getProjects()


    },
    watch: {
        // vendor_id(newVal, oldVal){
        //     if(newVal != undefined){
        //         this.vendor_location = this.vendors.filter(vendor => vendor.id == newVal)[0]['location']
        //     }
        // },
    },
}
</script>

<style >

</style>
