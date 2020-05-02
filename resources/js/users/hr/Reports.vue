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
                        <b-table-simple hover small caption-top bordered responsive>
                          <colgroup>
                            <col />
                          </colgroup>
                          <colgroup>
                            <col />
                            <col />
                            <col />
                            <col />
                            <col />
                            <col />
                            <col />
                          </colgroup>
                          <colgroup>
                            <col />
                            <col />
                            <col />
                            <col />
                            <col />
                            <col />
                            <col />
                          </colgroup>
                          <colgroup>
                            <col />
                          </colgroup>
                          <b-thead>
                            <b-tr>
                              <b-th variant="dark" class="text-center">Name</b-th>
                              <b-th
                                variant="dark"
                                colspan="7"
                                class="text-center"
                              >Leaves taken this year</b-th>
                              <b-th
                                variant="dark"
                                colspan="7"
                                class="text-center"
                              >Leaves remaining this year</b-th>
                              <b-th variant="dark" class="text-center">Year</b-th>
                            </b-tr>
                            <b-tr>
                              <b-th></b-th>
                              <b-th variant="primary">S</b-th>
                              <b-th variant="primary">H</b-th>
                              <b-th variant="primary">M</b-th>
                              <b-th variant="primary">P</b-th>
                              <b-th variant="primary">CO</b-th>
                              <b-th variant="primary">ST</b-th>
                              <b-th variant="primary">A</b-th>
                              <b-th variant="success">S</b-th>
                              <b-th variant="success">H</b-th>
                              <b-th variant="success">M</b-th>
                              <b-th variant="success">P</b-th>
                              <b-th variant="success">CO</b-th>
                              <b-th variant="success">ST</b-th>
                              <b-th variant="success">A</b-th>
                              <b-th></b-th>
                            </b-tr>
                          </b-thead>
                          <b-tbody>
                            <b-tr v-for="stat in leaveStats" :key="stat.staff">
                              <b-td>{{ stat.staff }}</b-td>

                              <b-td
                                variant="danger"
                                v-if="stat.days_taken"
                              >{{ stat.days_taken.Sick }}</b-td>
                              <b-td variant="danger" v-else>0</b-td>
                              <b-td
                                variant="danger"
                                v-if="stat.days_taken"
                              >{{ stat.days_taken.Hospitalization }}</b-td>
                              <b-td variant="danger" v-else>0</b-td>
                              <b-td
                                variant="danger"
                                v-if="stat.days_taken"
                              >{{ stat.days_taken.Maternity }}</b-td>
                              <b-td variant="danger" v-else>0</b-td>
                              <b-td
                                variant="danger"
                                v-if="stat.days_taken"
                              >{{ stat.days_taken.Paternity }}</b-td>
                              <b-td variant="danger" v-else>0</b-td>
                              <b-td
                                variant="danger"
                                v-if="stat.days_taken"
                              >{{ stat.days_taken.Compassionate }}</b-td>
                              <b-td variant="danger" v-else>0</b-td>
                              <b-td
                                variant="danger"
                                v-if="stat.days_taken"
                              >{{ stat.days_taken.Study }}</b-td>
                              <b-td variant="danger" v-else>0</b-td>
                              <b-td
                                variant="danger"
                                v-if="stat.days_taken"
                              >{{ stat.days_taken.Annual }}</b-td>
                              <b-td variant="danger" v-else>0</b-td>
                              <b-td variant="primary">{{ stat.days_remaining.Sick }}</b-td>
                              <b-td variant="primary">{{ stat.days_remaining.Hospitalization }}</b-td>
                              <b-td variant="primary">{{ stat.days_remaining.Maternity }}</b-td>
                              <b-td variant="primary">{{ stat.days_remaining.Paternity }}</b-td>
                              <b-td variant="primary">{{ stat.days_remaining.Compassionate }}</b-td>
                              <b-td variant="primary">{{ stat.days_remaining.Study }}</b-td>
                              <b-td variant="primary">{{ stat.days_remaining.Annual }}</b-td>
                              <b-td variant="secondary">2020</b-td>
                              <!-- <b-td v-else>{{ '2019' }}</b-td> -->
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
          //   stat.remaining_days =
          //     stat.total_annual_days_allowed -
          //     stat.cumulative_leave_days_this_year;
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
