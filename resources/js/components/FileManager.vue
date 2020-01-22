<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Document Manager</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Document Manager
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-outline card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Document Manager</h3>
                            </div>
                            <div class="card-body">
                                <div id="fm" style="height:400px">
                                    <file-manager
                                        :settings="settings"
                                    ></file-manager>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            settings: {
                headers: {},
                windowsConfig: 2
            }
        };
    }
};
</script>

<style></style>
