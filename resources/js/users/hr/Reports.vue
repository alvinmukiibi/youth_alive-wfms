<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reports</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Reports</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <ul class="nav nav-pills">
                  <li class="nav-item">
                    <a class="nav-link active" href="#leave_tracker" data-toggle="tab">
                      <i class="fa fa-address-book-o"></i> Leave Tracker
                    </a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="leave_tracker">
                    <div class="card card-outline card-dark">
                      <div class="card-header">
                        <h3 class="card-title">Staff Leave Statistics</h3>
                      </div>
                      <div class="card-body">
                        <b-table-simple hover small caption-top responsive>
                          <colgroup>
                            <col />
                            <col />
                            <col />
                          </colgroup>
                          <b-thead head-variant="dark">
                            <b-tr>
                              <b-th class="text-center">Name</b-th>
                              <b-th class="text-center">Leaves this month</b-th>
                              <b-th class="text-center">Cumulative Leave Total for the Year</b-th>
                              <b-th class="text-center">Sick</b-th>
                              <b-th class="text-center">Maternity</b-th>
                              <b-th class="text-center">Parternity</b-th>
                              <b-th class="text-center">Study</b-th>
                              <b-th class="text-center">Annual</b-th>
                              <b-th class="text-center">Others</b-th>
                              <b-th class="text-center">Remainining Days</b-th>
                            </b-tr>
                          </b-thead>
                          <b-tbody>
                            <b-tr>
                              <b-td>Francis Bukenya</b-td>
                              <b-td>2</b-td>
                              <b-td>45</b-td>
                              <b-td>2</b-td>
                              <b-td>34</b-td>
                              <b-td>23</b-td>
                              <b-td>1</b-td>
                              <b-td>3</b-td>
                              <b-td>4</b-td>
                              <b-td>3</b-td>
                            </b-tr>
                          </b-tbody>
                        </b-table-simple>
                        <!-- <b-table
                          fixed
                          bordered
                          hover
                          small
                          :items="leaveStats"
                          :fields="fields"
                          :sort-by.sync="sortBy"
                          :sort-desc.sync="sortDesc"
                          responsive="md"
                        ></b-table>-->
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
import * as api from "../../api/api";
import { mapState, mapMutations } from "vuex";
export default {
  data() {
    return {
      sortBy: "staff",
      sortDesc: false,
      fields: [
        { key: "staff", label: "Name", sortable: true },
        {
          key: "leaves_this_month",
          label: "Leaves this month",
          sortable: true
        },
        {
          key: "cumulative_leave_days_this_year",
          label: "Cumulative Leave Total for the Year",
          sortable: true
        },
        {
          key: "total_annual_days_allowed",
          label: "Total Annual Leave Days Allowed",
          sortable: false
        },
        {
          key: "remaining_days",
          label: "Total Annual Leave Days Remaining",
          sortable: true
        }
        // { key: "availability", label: 'status', sortable: false },
        // { key: "pending_leaves", label: "", sortable: false }
      ]
    };
  },
  methods: {
    ...mapMutations({
      setLeaveStats: "setLeaveStats"
    }),
    loadLeaveStats() {
      api.getLeaveStats().then(response => {
        let data = response.data.map(stat => {
          stat.remaining_days =
            stat.total_annual_days_allowed -
            stat.cumulative_leave_days_this_year;
          return stat;
        });
        this.setLeaveStats(data);
      });
    }
  },
  computed: {
    ...mapState({
      leaveStats: state => state.leaveStats
    })
  },
  mounted() {
    this.loadLeaveStats();
  }
};
</script>

<style>
</style>
