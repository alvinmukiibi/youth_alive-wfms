import Dashboard from './components/Dashboard.vue'
import Profile from './components/Profile.vue'
import Employees from './users/hr/Employees.vue'
import Employee from './users/hr/Employee.vue'


const routes = [
    { path: '/', component:  Dashboard},
    { path: '/home', component:  Dashboard},
    { path: '/profile', component:  Profile},
    { path: '/employees', component:  Employees},
    { path: '/view/employee', component:  Employee},

]

export default routes;
