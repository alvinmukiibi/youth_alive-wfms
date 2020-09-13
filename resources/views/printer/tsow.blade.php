<!DOCTYPE html>
<html lang="en">
    <script>
        window.print()
    </script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Travel Scope of Work</title>
    <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
        <!-- Styles -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ asset('adminlte/plugins/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
        <!-- <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}"> -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
        <style>
            .centero {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width:200px;
                height:200px;
              }
        </style>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <div class="row">
            <img class="centero"  src="{{ asset('images/logo.png') }}" alt="">
        </div>
        <br>
        <div class="jumbotron">
            <h1 class="display-4">Travel Scope of Work</h1>
            <p class="lead">A Travel Scope of Work (SoW) is required for all YA relatad travels. Staff travelling to carry out the same activity should complete one (joint) SoW. The SoW should be submitted to the Supervisor for review and approval prior to the travel and a copy attached to any advance request related to the trip</p>

          </div>
        <div class="row">
            <div class="col-md-3"><b>Name of Travellers</b></div>
            <div class="col-md-9">{{ $data->travellers }}</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3"><b>Project</b></div>
            <div class="col-md-9">{{ $data->programrequest->project->name }}</div>
        </div>
        <div class="row">
            <div class="col-md-3"><b>Date</b></div>
            <div class="col-md-9">{{ $data->date_of_activity }}</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3"><b>Departure Point</b></div>
            <div class="col-md-9">{{ $data->departure_point }}</div>
        </div>
        <div class="row">
            <div class="col-md-3"><b>Destination</b></div>
            <div class="col-md-9">{{ $data->destination }}</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3"><b>Departure Date</b></div>
            <div class="col-md-9">{{ $data->departure_date }}</div>
        </div>
        <div class="row">
            <div class="col-md-3"><b>Return Date</b></div>
            <div class="col-md-9">{{ $data->return_date }}</div>
        </div>
        <div class="row">
            <div class="col-md-3"><b>Travel Objectives</b></div>
            <div class="col-md-9">{{ $data->objectives }}</div>
        </div>
        <div class="row">
            <div class="col-md-3"><b>Activities</b></div>
            <div class="col-md-9">{{ $data->activities }}</div>
        </div>
        <div class="row">
            <div class="col-md-3"><b>Kep People to be met</b></div>
            <div class="col-md-9">{{ $data->key_people_to_be_met }}</div>
        </div>
        <div class="row">
            <div class="col-md-3"><b>Expected deliverables</b></div>
            <div class="col-md-9">{{ $data->expected_deliverables }}</div>
        </div>
        <hr>
    </div>

</body>
</html>
