require('./bootstrap');

window.Vue = require('vue');

import VueRouter from "vue-router"
import routes from './routes'
Vue.use(VueRouter)


import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import VPopover from 'vue-js-popover'
Vue.use(VPopover, { tooltip: true })

import store from './store'
import Vue from 'vue'

import MainHeader from './components/MainHeader.vue'
import Sidebar from './components/Sidebar.vue'
Vue.component('main-header', MainHeader);
Vue.component('sidebar', Sidebar);

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
