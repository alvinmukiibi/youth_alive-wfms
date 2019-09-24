<template>
  <div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-success card-outline mt-2">
              <div class="card-body">
                <b-progress :value="25" variant="primary" striped :animated="animate"></b-progress>
                <hr />
                <ul class="list-group list-group-horizontal-xl">
                  <li class="list-group-item">
                    <router-link to="/request/travel/scope">TSoW</router-link>
                  </li>
                  <li class="list-group-item">
                    <router-link to="/request/budget">Budget</router-link>
                  </li>
                  <li class="list-group-item">
                    <router-link to="/request/concept">Concept</router-link>
                  </li>
                  <li class="list-group-item">
                    <router-link to="/request/vehicle">VHR</router-link>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <transition name="slide">
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
import * as api from "../../api/api";
import { mapState, mapMutations } from "vuex";
export default {
  data() {
    return {
      animate: true
    };
  },
  methods: {},
  mounted() {},
  computed: {}
};
</script>

<style>
</style>
