import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        auth: [],
        errors: [],
        users: [],
        employee: [],
        departments: [],
        designations: [],
        contracts: [],
        roles: [],
        projects: [],
        leaveTypes: [],
        assets: [],
        vendors: [],
        myRequests: [],
        request: [],
        settings: [],
        systemSettings: [],
        usersCount: '',
    },
    mutations: {
        setAuthUser: (state, data) => {
            state.auth = data
        },
        setErrors: (state, data) => {
            state.errors = data
        },
        setUsers: (state, data) => {
            state.users = data
        },
        setCurrentEmployee: (state, data) => {
            state.employee = data
        },
        setDepartments: (state, data) => {
            state.departments = data
        },
        setDesignations: (state, data) => {
            state.designations = data
        },
        setContracts: (state, data) => {
            state.contracts = data
        },
        setRoles: (state, data) => {
            state.roles = data
        },
        setProjects: (state, data) => {
            state.projects = data
        },
        setUsersCount: (state, data) => {
            state.usersCount = data
        },
        setLeaveTypes: (state, data) => {
            state.leaveTypes = data
        },
        setAssets: (state, data) => {
            state.assets = data
        },
        setVendors: (state, data) => {
            state.vendors = data
        },
        setMyRequests: (state, data) => {
            state.myRequests = data
        },
        setRequest: (state, data) => {
            state.request = data
        },
        setSettings: (state, data) => {
            state.settings = data
        },
        setSystemSettings: (state, data) => {
            state.systemSettings = data
        },
    },
})
