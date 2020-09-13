<!DOCTYPE html>
<html lang="en">
    <script>
        window.print()
    </script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Budget</title>
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
            <h1 class="display-4">Vehicle/Hotel Request Form</h1>
            {{-- <p class="lead">A Travel Scope of Work (SoW) is required for all YA relatad travels. Staff travelling to carry out the same activity should complete one (joint) SoW. The SoW should be submitted to the Supervisor for review and approval prior to the travel and a copy attached to any advance request related to the trip</p> --}}

          </div>
        @if ($data->vehiclehotel->vehicle)
        <h3>Vehicle</h3>
            <div class="row">
                <div class="col-md-3"><b>Request ID</b></div>
                <div class="col-md-9">{{ $data->identity }}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Departure Date & Time</b></div>
                <div class="col-md-9">{{ $data->vehiclehotel->departure_date }}</div>
            </div>

            <div class="row">
                <div class="col-md-3"><b>Departure Date & Time</b></div>
                <div class="col-md-9">{{ $data->vehiclehotel->return_date }}</div>
            </div>

            <div class="row">
                <div class="col-md-3"><b>Departure Venue</b></div>
                <div class="col-md-9">{{ $data->vehiclehotel->departure_venue }}</div>
            </div>

            <div class="row">
                <div class="col-md-3"><b>Reason</b></div>
                <div class="col-md-9">{{ $data->vehiclehotel->reason }}</div>
            </div>

            <div class="row">
                <div class="col-md-3"><b>Name of Passengers</b></div>
                <div class="col-md-9">{{ $data->vehiclehotel->name_of_passengers }}</div>
            </div>

        @endif
        @if ($data->vehiclehotel->hotel)
            <div class="row">
                <div class="col-md-3"><b>Purpose</b></div>
                <div class="col-md-9">{{ $data->vehiclehotel->purpose }}</div>
            </div>
            <hr>
            <div class="row">

                <div class="col-md-12">
                    <h3>Hotel Booking</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Booking District</th>
                                <th>Check-in Date</th>
                                <th>Check-out Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->vehiclehotel->hotelbooking as $item)
                                <tr>
                                    <td>{{ $item->district }}</td>
                                    <td>{{ $item->check_in_date }}</td>
                                    <td>{{ $item->check_out_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        @endif


    </div>

</body>
</html>
