<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index3.html" class="brand-link">
      <img src="/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"> <b>YOUTH</b>ALIVE </span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img :src="'/storage/users/' + auth.profile_picture" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth.fname + ' ' + auth.lname }}</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="/profile" class="nav-link">
              <i class="nav-icon fa fa-user"></i>
              <p>
                My Profile
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/home" class="nav-link active">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-hand-grab-o"></i>
              <p>
                Requests
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>New <span class="right badge badge-danger">2</span></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Confirmed <span class="right badge badge-danger">8</span></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Approved <span class="right badge badge-danger">9</span></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Declined <span class="right badge badge-danger">0</span></p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-minus-circle"></i>
              <p>
                Leave
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Pending <span class="right badge badge-danger">2</span></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Approved <span class="right badge badge-danger">8</span></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Declined <span class="right badge badge-danger">9</span></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Canceled <span class="right badge badge-danger">0</span></p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fa fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script>

import * as api from '../api/api.js'
import { mapState, mapMutations } from 'vuex'
export default {
    data(){
        return {

        }
    },
    computed: {
        ...mapState({
            auth: state => state.auth
        })

    }
}
</script>

<style scoped>

</style>
