require('./bootstrap');

window.Vue = require('vue');

import VueRouter from "vue-router"
import routes from './routes'
Vue.use(VueRouter)

import store from './store'
import Vue from 'vue'

import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap'

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const router = new VueRouter({
    history: false,
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    store,
    router
});
