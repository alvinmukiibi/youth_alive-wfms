<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Timesheet</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">Timesheet</li>
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
                <h3 class="card-title">Timesheet</h3>
              </div>
              <div class="card-body">
                <b-table-simple hover small bordered caption-top responsive>
                  <caption>YOUTH ALIVE UGANDA - TIMESHEET</caption>
                  <colgroup>
                    <col style="width:120px" />
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
                  </colgroup>
                  <colgroup>
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                    <col />
                  </colgroup>
                  <b-thead>
                    <b-tr>
                      <b-th variant="dark" colspan="2">Name</b-th>
                      <b-th variant="success" colspan="12">{{ auth.fname + ' ' + auth.lname }}</b-th>
                      <b-th variant="dark" colspan="5">Designation</b-th>
                      <b-th variant="success" colspan="15">{{ auth.designation }}</b-th>
                    </b-tr>
                    <b-tr>
                      <b-th variant="primary" class="text-center" colspan="4">Period</b-th>

                      <b-th variant="primary" class="text-center" colspan="6">
                        <vue-monthly-picker
                          alignment="center"
                          :monthLabels="months"
                          v-model="period"
                        ></vue-monthly-picker>
                      </b-th>
                      <b-th variant="primary" class="text-center" :colspan="month.length + 3"></b-th>
                    </b-tr>
                    <b-tr>
                      <b-th>Date</b-th>
                      <b-th>Project</b-th>
                      <b-td
                        variant="dark"
                        class="text-center"
                        v-for="day in month"
                        :key="day"
                      >{{ day }}</b-td>
                      <b-th>Total</b-th>
                    </b-tr>
                    <b-tr>
                      <b-th colspan="2" variant="secondary">Scheduled Hours</b-th>
                      <b-td
                        class="text-center"
                        v-for="day in month"
                        variant="secondary"
                        :key="day"
                      >8</b-td>
                      <b-th>176</b-th>
                    </b-tr>
                  </b-thead>
                  <b-tbody>
                    <b-tr v-for="project in timesheet.projects" :key="project">
                      <b-td colspan="2">{{ project.name }}</b-td>
                      <b-td v-for="day in month" :key="day">
                        <input type="text" v-model="project[day]" class="form-control" />
                      </b-td>
                      <b-td></b-td>
                    </b-tr>
                    <b-tr>
                      <b-th colspan="2">Total</b-th>
                      <b-th v-for="day in month" :key="day"></b-th>
                      <b-th variant="success">176</b-th>
                    </b-tr>
                  </b-tbody>
                </b-table-simple>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import * as api from "../api/api";
import { mapState, mapMutations } from "vuex";
import VueMonthlyPicker from "vue-monthly-picker";
export default {
  data() {
    return {
      form: false,
      months: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
      ],
      period: null,
      month: this.getDaysInMonth(
        new Date().getMonth() + 1,
        new Date().getFullYear()
      ),
      timesheet: []
    };
  },
  methods: {
    ...mapMutations({}),
    loadValues(date) {
      api.getTimesheet({ date: date }).then(response => {
        this.timesheet = response.data;
      });
    },
    getDaysInMonth(month, year) {
      month--;
      var date = new Date(year, month, 1);
      var days = [];
      while (date.getMonth() === month) {
        var tmpDate = new Date(date);
        var weekDay = tmpDate.getDay();
        var day = tmpDate.getDate();
        if (weekDay % 6) {
          days.push(day);
        }
        date.setDate(date.getDate() + 1);
      }
      return days;
    }
  },
  computed: {
    ...mapState({
      auth: state => state.auth
    })
  },
  watch: {
    period(newValue, oldValue) {
      this.month = this.getDaysInMonth(
        newValue.format("MM"),
        newValue.format("YYYY")
      );
      this.loadValues(newValue.format("YYYY-MM"));
    }
  },
  mounted() {},
  components: {
    VueMonthlyPicker
  }
};
</script>

<style>
</style>
