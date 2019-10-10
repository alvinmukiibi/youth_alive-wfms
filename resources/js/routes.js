import Dashboard from './components/Dashboard.vue'
import Profile from './components/Profile.vue'
import Employees from './users/hr/Employees.vue'
import Employee from './users/hr/Employee.vue'
import Contracts from './users/admin/Contracts.vue'
import Departments from './users/admin/Departments.vue'
import Designations from './users/admin/Designations.vue'
import Assets from './users/admin/Assets.vue'
import Projects from './users/admin/Projects.vue'
import LeaveTypes from './users/admin/LeaveTypes.vue'
import Vendors from './users/admin/Vendors.vue'
import Request from './users/officer/Request.vue'
import RequestView from './users/officer/RequestView.vue'
import Leaves from './users/officer/Leaves.vue'
import Settings from './components/Settings.vue'
import Reports from './users/hr/Reports.vue'
import ActivityReport from './users/officer/ActivityReport'
import VehicleRequest from './users/officer/VHR'
import ConceptNote from './users/officer/ConceptNote'
import TravelScope from './users/officer/TravelScope'
import TravelReport from './users/officer/TravelReport'
import Budget from './users/officer/Budget'
import Container from './users/officer/Container'
import ApprovalTrail from './users/officer/ApprovalTrail'
import Mailbox from './components/Mailbox.vue'
import Timesheet from './components/Timesheet.vue'

const routes = [{
        path: '/',
        component: Dashboard
    },
    {
        path: '/home',
        component: Dashboard
    },
    {
        path: '/profile',
        component: Profile
    },
    {
        path: '/employees',
        component: Employees
    },
    {
        path: '/view/employee',
        component: Employee
    },
    {
        path: '/contracts',
        component: Contracts
    },
    {
        path: '/departments',
        component: Departments
    },
    {
        path: '/designations',
        component: Designations
    },
    {
        path: '/assets',
        component: Assets
    },
    {
        path: '/projects',
        component: Projects
    },
    {
        path: '/leavetypes',
        component: LeaveTypes
    },
    {
        path: '/vendors',
        component: Vendors
    },
    {
        path: '/requests',
        component: Request
    },
    {
        path: '/view/request',
        component: RequestView
    },
    {
        path: '/leave',
        component: Leaves
    },
    {
        path: '/mailbox',
        component: Mailbox
    },
    {
        path: '/settings',
        component: Settings
    },
    {
        path: '/reports',
        component: Reports
    },
    {
        path: '/request/activity/report',
        component: ActivityReport
    },
    {
        path: '/request/travel/report',
        component: TravelReport
    },
    {
        path: '/request/make',
        component: Container,
        children: [{
                path: '/request/budget',
                component: Budget
            }, {
                path: '/request/travel/scope',
                component: TravelScope
            }, {
                path: '/request/concept',
                component: ConceptNote
            }, {
                path: '/request/vehicle',
                component: VehicleRequest
            }, {
                path: '/request/trail',
                component: ApprovalTrail
            },


        ]
    },
    {
        path: '/timesheet',
        component: Timesheet
    },
]

export default routes;
