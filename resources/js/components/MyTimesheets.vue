<template>
  
              <div >
                <div class="form-group row">
                  <!-- <label
                    v-if="auth.department='Human Resource' && auth.roles.includes('manager')"
                    for="inputPassword"
                    class="col-sm-2 col-form-label"
                  >Select Staff</label>
                  <div
                    v-if="auth.department='Human Resource' && auth.roles.includes('manager')"
                    class="col-sm-4"
                  >
                    <select class="form-control">
                      <option value></option>
                    </select>
                  </div>-->
                  <label for="inputPassword" class="col-sm-2 col-form-label">Select Month</label>
                  <div class="col-sm-4">
                    <vue-monthly-picker
                      alignment="center"
                      :monthLabels="months"
                      v-model="period"
                      :max="moment(currentDate, 'YYYY-MM')"
                    ></vue-monthly-picker>
                  </div>
                </div>

                <b-table-simple small bordered caption-top responsive>
                  <caption>YOUTH ALIVE UGANDA - TIMESHEET <b-spinner variant="primary" v-if="spinner" type="grow" label="Spinning"></b-spinner></caption>
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
                    <col />
                  </colgroup>
                  <b-thead>
                    <b-tr>
                      <b-th variant="dark" colspan="2">Name</b-th>
                      <b-td variant="light" colspan="12">{{ auth.fname + ' ' + auth.lname }}</b-td>
                      <b-th variant="dark" colspan="5">Designation</b-th>
                      <b-td
                        variant="light"
                        colspan="16"
                      >{{ auth.designation + ', ' + auth.department_acronym }}</b-td>
                    </b-tr>
                  
                    <b-tr>
                     
                      <b-th colspan="2">Project</b-th>
                      <b-td variant="dark" v-for="day in month" :key="day + 300">{{ day }}</b-td>
                      <b-th>Total</b-th>
                      <b-th>%</b-th>
                    </b-tr>
                    <b-tr v-if="timesheet && timesheet.scheduled">
                      <b-th colspan="2" variant="secondary">Scheduled Hours</b-th>
                      <b-td v-for="day in month" :key="day + 140">
                        <input
                          type="text"
                          @change="saveSch(day, timesheet.scheduled['sch__' + day])"
                          v-model="timesheet.scheduled['sch__' + day]"
                          class="center"
                        />
                      </b-td>
                      <b-th>{{ timesheet.statistics.scheduled_hours }}</b-th>
                      <b-th></b-th>
                    </b-tr>
                  </b-thead>
                  <b-tbody v-if="timesheet && timesheet.projects">
                    <b-tr v-for="project in timesheet.projects" :key="project.project_id">
                      <b-td colspan="2">{{ project.name }}</b-td>
                      <b-td v-for="day in month" :key="day">
                        <input
                          type="text"
                          @change="save(day, project[day], project.project_id)"
                          v-model="project[day]"
                          class="center"
                        />
                      </b-td>
                      <b-td>{{ project.sub_total ? project.sub_total : 0 }}</b-td>
                      <b-th>{{ getPercentage(project) }}%</b-th>
                    </b-tr>
                    <b-tr>
                      <b-th colspan="2">Total</b-th>
                      <b-th v-for="day in month" :key="day + 90">{{ sumOfDay(day) }}</b-th>
                      <b-th>{{total}}</b-th>
                      <b-th>100%</b-th>
                    </b-tr>
                  </b-tbody>
                  <b-tbody v-else>
                    <b-tr>
                      <b-th
                        class="text-center"
                        :colspan=" 4 + month.length"
                        variant="danger"
                      >No records found!</b-th>
                    </b-tr>
                  </b-tbody>
                </b-table-simple>
                <hr class="primary" style="height:20px;" />

                <b-table-simple
                  v-if="timesheet && timesheet.statistics"
                  small
                  bordered
                  caption-top
                  responsive
                >
                  <caption>TIMESHEET STATISTICS</caption>
                  <colgroup>
                    <col style="width:40%" />
                    <col style="width:30%" />
                    <col style="width:30%" />
                  </colgroup>
                  <b-tbody>
                    <b-tr>
                      <b-th class="text-left" variant="dark">Scheduled Hours</b-th>
                      <b-th>A</b-th>
                      <b-td>{{ timesheet.statistics.scheduled_hours }}</b-td>
                    </b-tr>
                    <b-tr>
                      <b-th class="text-left" variant="dark">Worked Hours</b-th>
                      <b-th>B</b-th>
                      <b-td>{{ timesheet.statistics.worked_hours }}</b-td>
                    </b-tr>
                    <b-tr>
                      <b-th class="text-left" variant="dark">
                        Overtime Hours:
                        <small>
                          <i>**Non-professional Staff**</i>
                        </small>
                      </b-th>
                      <b-th>C</b-th>
                      <b-td>
                        <input
                          type="text"
                          @change="saveOvertime"
                          v-model="timesheet.statistics.overtime_hours"
                          class="center"
                        />
                      </b-td>
                    </b-tr>
                    <b-tr>
                      <b-th class="text-left" variant="dark">Total Worked Hours</b-th>
                      <b-th>[B + C]</b-th>
                      <b-td>{{ timesheet.statistics.total_hours_worked }}</b-td>
                    </b-tr>
                    <b-tr>
                      <b-th class="text-left" variant="dark">Percentage Time</b-th>
                      <b-th>[B + C] / A * 100</b-th>
                      <b-th class="text-left">{{ timesheet.statistics.percentage_time.toFixed(1) }}%</b-th>
                    </b-tr>
                  </b-tbody>
                </b-table-simple>
                <hr />

                <button
                  v-if="currentDateIsTimesheetDate"
                  class="btn btn-primary pull-right btn-flat"
                >
                  <b>Submit Timesheet</b>
                </button>
              </div>
          
</template>

<script>
import * as api from "../api/api";
import { mapState, mapMutations } from "vuex";
import VueMonthlyPicker from "vue-monthly-picker";
export default {
  data() {
    return {
      spinner: false,
      overtime: 0,
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
      timesheet: null
    };
  },
  methods: {
    ...mapMutations({}),
    sumOfDay(day) {
      let sum = 0;
      if (this.timesheet.projects) {
        this.timesheet.projects.forEach(proj => {
          if (proj[day]) {
            sum += proj[day];
          }
        });
      }
      return sum;
    },
    getPercentage(project) {
      let value = (project.sub_total / this.total) * 100;
      if (Number.isNaN(value)) {
        return 0;
      }
      let percentage = value.toFixed(1);
      return percentage;
    },
    saveOvertime() {
      if (!this.timesheet.statistics.overtime_hours) {
        this.showToast("warning", "Error", "Please enter a value");
      }
      let data = {
        value: this.timesheet.statistics.overtime_hours,
        timesheet: this.timesheet.id
      };
      api.saveOvertime(data).then(response => {
        this.loadValues(this.period.format("YYYY-MM"));
        this.showToast("primary", "Notification", "Saved!");
      });
    },
    saveSch(day, value) {
      if (!value) {
        this.showToast("warning", "Error", "Please enter a value");
      }
      let data = {
        field: "sch__" + day,
        value: value,
        timesheet: this.timesheet.id
      };
      api.saveSch(data).then(response => {
        this.loadValues(this.period.format("YYYY-MM"));
        this.showToast("primary", "Notification", "Saved!");
      });
    },
    save(field, value, project) {
      if (!value) {
        this.showToast("warning", "Error", "Please enter a value");
        return;
      }
      if (!this.period) {
        this.showToast("warning", "Error", "Please select a month explicitly");
        return;
      }

      let month = this.period.format("MM");
      let year = this.period.format("YYYY");
      let data = {
        value: value,
        project_id: project,
        month: month,
        year: year,
        field: field
      };
      api.saveTimesheet(data).then(response => {
        this.loadValues(this.period.format("YYYY-MM"));
        this.showToast("success", "Notification", "Saved");
      });
    },
    showToast(variant, title, body) {
      this.$bvToast.toast(body, {
        title: title,
        variant: variant,
        solid: true
      });
    },
    loadValues(date) {
      this.spinner = true;
      api.getTimesheet({ date: date }).then(response => {
        this.timesheet = response.data;
        this.spinner = false;
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
    },
    loadCurrentMonth() {
      this.loadValues(this.currentDate);
    }
  },
  computed: {
    ...mapState({
      auth: state => state.auth
    }),
    currentDate() {
      let year = new Date().getFullYear();
      let month = new Date().getMonth() + 1;
      return year + "-" + month;
    },
    currentDateIsTimesheetDate() {
      if (this.period) {
        let currentDate = this.currentDate;
        let period = this.period.format("YYYY-MM");

        if (currentDate == period) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    },
    total() {
      let sum = 0;
      if (this.timesheet) {
        this.timesheet.projects.forEach(proj => {
          if (proj.sub_total) {
            sum += proj.sub_total;
          }
        });
      }
      return sum;
    }
  },
  watch: {
    period(newValue, oldValue) {
      this.month = this.getDaysInMonth(
        newValue.format("MM"),
        newValue.format("YYYY")
      );
      this.loadValues(newValue.format("YYYY-MM"));
    },
    total(newValue, oldValue) {
      if (newValue) {
        let data = {
          worked_hours: newValue,
          timesheet: this.timesheet.id
        };
        api.saveWorkedHours(data).then(response => {
          this.loadValues(this.period.format("YYYY-MM"));
        });
      }
    }
  },
  mounted() {
    this.loadCurrentMonth();
  },
  components: {
    VueMonthlyPicker
  }
};
</script>

<style>
input[type="text"] {
  border: none;
  background-color: none;
  outline: 0;
  width: 25px;
}

input[type="text"]:focus {
  border: none;
  background-color: none;
  outline: 0;
}
</style>
