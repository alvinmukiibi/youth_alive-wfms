<template>
  <div>
    <div class="form-row d-print-none" >
      <div class="form-group col-md-6">
        <label for="inputEmail4">Select Staff</label>
        <select v-model="staff" class="form-control">
          <option
            v-for="user in users"
            :key="user.id"
            :value="user.id"
          >{{ user.fname + ' ' + user.lname }}</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Select Month</label>
        <vue-monthly-picker
          alignment="center"
          :monthLabels="months"
          v-model="period"
          :max="moment(currentDate, 'YYYY-MM')"
        ></vue-monthly-picker>
      </div>
    </div>
    <div class="form-row d-print-none">
      <button @click="loadTimesheet" class="btn btn-primary btn-flat btn-block">
        <b>Load</b>
      </button>
    </div>
    <b-table-simple small bordered caption-top responsive>
      <caption>
        YOUTH ALIVE UGANDA - TIMESHEET
        <b-spinner variant="primary" v-if="spinner" type="grow" label="Spinning"></b-spinner>
      </caption>
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
      <b-thead v-if="user">
        <b-tr>
          <b-th variant="dark" colspan="2">Name</b-th>
          <b-td variant="light" colspan="12">{{ user.fname + ' ' + user.lname }}</b-td>
          <b-th variant="dark" colspan="5">Designation</b-th>
          <b-td variant="light" colspan="16">{{ user.designation + ', ' + user.department_acronym }}</b-td>
        </b-tr>

        <b-tr>
          <b-th colspan="2">Project</b-th>
          <b-td variant="dark" v-for="day in month" :key="day + 300">{{ day }}</b-td>
          <b-th>Total</b-th>
          <b-th>%</b-th>
        </b-tr>
        <b-tr v-if="timesheet">
          <b-th colspan="2" variant="secondary">Scheduled Hours</b-th>
          <b-td v-for="day in month" :key="day + 140">
            <input type="text" @keypress="onlyNumber" readonly v-model="timesheet.scheduled['sch__' + day]" class="center" />
          </b-td>
          <b-th>{{ timesheet.statistics.scheduled_hours }}</b-th>
          <b-th></b-th>
        </b-tr>
      </b-thead>
      <b-tbody v-if="timesheet && timesheet.projects">
        <b-tr v-for="project in timesheet.projects" :key="project.project_id">
          <b-td colspan="2">{{ project.name }}</b-td>
          <b-td v-for="day in month" :key="day">
            <input type="text" @keypress="onlyNumber" readonly v-model="project[day]" class="center" />
          </b-td>
          <b-td>{{ project.sub_total ? project.sub_total : 0 }}</b-td>
          <b-th>{{ getPercentage(project) }}%</b-th>
        </b-tr>
        <b-tr>
          <b-th colspan="2">Total</b-th>
          <b-th v-for="day in month" :key="day + 90">{{ sumOfDay(day) }}</b-th>
          <b-th>{{ total }}</b-th>
          <b-th>100%</b-th>
        </b-tr>
      </b-tbody>
      <b-tbody v-else>
        <b-tr>
          <b-th class="text-center" :colspan=" 4 + month.length" variant="light">No records found!</b-th>
        </b-tr>
      </b-tbody>
    </b-table-simple>
    <hr class="primary" style="height:20px;" />

    <b-table-simple v-if="timesheet && timesheet.statistics" small bordered caption-top responsive>
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
              @keypress="onlyNumber"
              readonly
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
    <button @click="print()" class="btn btn-sm btn-primary d-print-none">PRINT</button>
    <hr />
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
      staff: null,
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
      timesheet: [],
      user: null,
      month: []
    };
  },
  methods: {
    ...mapMutations({
      setSubs: "setSubs"
    }),
    getPercentage(project) {
      let value = (project.sub_total / this.total) * 100;
      if (Number.isNaN(value)) {
        return 0;
      }
      let percentage = value.toFixed(1);
      return percentage;
    },
    print(){
        window.print()
    },
    onlyNumber ($event) {
        let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
        if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
            $event.preventDefault();
        }
    },
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
    loadTimesheet() {
      this.spinner = true;
      if (!this.staff) {
        this.showToast("danger", "Error", "Please select staff");
        this.spinner = false;
        return;
      }
      if (!this.period) {
        this.showToast("danger", "Error", "Please select a month");
        this.spinner = false;
        return;
      }
      let data = {
        staff: this.staff,
        period: this.period.format("YYYY-MM")
      };
      api.loadTimesheet(data).then(response => {
        this.timesheet = response.data.timesheet;
        this.user = response.data.staff;
        this.spinner = false;
      });
    },
    loadSuboordinates() {
      api.getSuboordinates().then(response => {
        this.setSubs(response.data);
      });
    },
    showToast(variant, title, body) {
      this.$bvToast.toast(body, {
        title: title,
        variant: variant,
        solid: true
      });
    }
  },
  watch: {
    period(newValue, oldValue) {
      this.month = this.getDaysInMonth(
        newValue.format("MM"),
        newValue.format("YYYY")
      );
    }
  },
  computed: {
    ...mapState({
      auth: state => state.auth,
      users: state => state.subs
    }),
    currentDate() {
      let year = new Date().getFullYear();
      let month = new Date().getMonth() + 1;
      return year + "-" + month;
    },
    total() {
      let sum = 0;
      if (this.timesheet.projects) {
        this.timesheet.projects.forEach(proj => {
          if (proj.sub_total) {
            sum += proj.sub_total;
          }
        });
      }
      return sum;
    }
  },
  mounted() {
    this.loadSuboordinates();
  },
  components: {
    VueMonthlyPicker
  }
};
</script>

<style scoped>
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
