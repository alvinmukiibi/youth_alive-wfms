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
                    <router-link
                      to="/request/trail"
                      :class="{ 'boldened': isActive('/request/trail') }"
                    >Approval Trail & Attachments</router-link>
                  </li>
                  <li v-for="document in documents" :key="document.acr" class="list-group-item">
                    <router-link
                      :to="document.route"
                      :class="{ 'boldened': isActive(document.route) }"
                    >
                      {{ document.name }}
                      <span
                        v-if="spinner"
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"
                      ></span>
                    </router-link>
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
      animate: true,
      spinner: false,
      docs: [
        {
          acr: "bgt",
          route: "/request/budget",
          name: "TSoW Budget",
          submitted: false
        },
        {
          acr: "vhr",
          route: "/request/vehicle",
          name: "Vehicle & Hotel Request",
          submitted: false
        },
        {
          acr: "tsw",
          route: "/request/travel/scope",
          name: "Travel Scope",
          submitted: false
        },
        {
          acr: "cpt",
          route: "/request/concept",
          name: "Concept Note",
          submitted: false
        }
      ]
    };
  },
  methods: {
    ...mapMutations({
      setRequest: "setRequest"
    }),
    isActive(route) {
      if (this.$route.path == route) {
        return true;
      }
      return false;
    },
    initialiseRequest() {
      // console.log(this.documents);
    },
    updateRequestThatDocIsCompleted(acr) {
      // get request doc_completion_status, parse it to object, update doc acr to true, stringify it and save it to db
      let status = JSON.parse(this.request.doc_completion_status);
      status.forEach(obj => {
        if (obj.doc == acr) {
          obj.status = true;
        }
      });
      let newStatus = JSON.stringify(status);
      api
        .updateRequestThatDocIsCompleted({
          doc_completion_status: newStatus,
          request_id: this.request.id
        })
        .then(response => {
          this.setRequest(response.data);
          JSON.parse(this.request.doc_completion_status).forEach(mydoc => {
            if (!mydoc.status) {
              let r = this.documents.filter(d => d.acr == mydoc.doc)[0][
                "route"
              ];
              this.$router.push(r);
              return;
            }
          });
        });
    }
  },
  mounted() {
    this.initialiseRequest();
    // redirection mechanism, when a doc is submitted, notify the parent, when the parent
    // gets to know, it flags the doc as submitted and routes to the next unsubmitted doc
    this.$on("formSubmitted", param => {
      this.documents.filter(doc => {
        if (doc.acr == param) {
          this.updateRequestThatDocIsCompleted(doc.acr);
          doc.submitted = true;
        }
      });
      // go to state, get the status object, parse it, iterate it, if there is a doc whose status is false, route to it, if there is none, route to audit trail
      // let status = this.

      //   this.documents.forEach(docu => {
      //     if (!docu.submitted) {
      //       this.$router.push(docu.route);
      //     }
      //   });
    });
  },
  computed: {
    ...mapState({
      request: state => state.request
    }),
    documents() {
      let docus = JSON.parse(this.request.documents);
      return this.docs.filter(doc => {
        if (docus.includes(doc.acr)) {
          return doc;
        }
      });
    }
  }
};
</script>

<style>
.boldened {
  font-weight: 700;
  text-decoration: none;
  color: green;
}
</style>
