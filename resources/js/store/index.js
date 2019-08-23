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
    },
})
