import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        auth: [],
        errors: [],
    },
    mutations: {
        setAuthUser: (state, data) => {
            state.auth = data
        },
        setErrors: (state, data) => {
            state.errors = data
        }
    },
})
