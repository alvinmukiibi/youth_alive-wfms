<template>
    <nav class="main-header navbar navbar-expand bg-primary navbar-light border-bottom">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index3.html" class="nav-link">Home <i class="fa fa-home"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Ask for Leave <i class="fa fa-sign-out"></i></a>
            </li>
        </ul>
         <ul class="navbar-nav ml-auto">
            <li class="nav-item ">
                <a class="nav-link" href="#"><i class="fa fa-sign-out"></i><b>Logout</b></a>
            </li>
         </ul>
    </nav>
</template>

<script>
import * as api from '../api/api.js'
export default {
    data() {
        return {

        }
    },
    methods: {
        getAuthUser () {
            api.getAuthUser().then(response => {
                console.log(response.data)
            })
        }
    },
    created() {
        this.getAuthUser();
    }

}
</script>

<style type="css">


</style>
