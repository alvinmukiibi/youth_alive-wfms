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
Vue.use(VPopover, {
    tooltip: true
})

import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use(CKEditor);

import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);

// import money from 'v-money'
// Vue.use(money, {
//     precision: 0
// })

import store from './store'
import Vue from 'vue'

import MainHeader from './components/MainHeader.vue'
import Sidebar from './components/Sidebar.vue'
Vue.component('main-header', MainHeader);
Vue.component('sidebar', Sidebar);
Vue.component('vueDropzone', vue2Dropzone);

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
