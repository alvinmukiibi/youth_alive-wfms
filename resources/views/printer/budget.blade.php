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
            <h1 class="display-4">Travel Scope Budget</h1>
            {{-- <p class="lead">A Travel Scope of Work (SoW) is required for all YA relatad travels. Staff travelling to carry out the same activity should complete one (joint) SoW. The SoW should be submitted to the Supervisor for review and approval prior to the travel and a copy attached to any advance request related to the trip</p> --}}

          </div>
        <div class="row">
            <div class="col-md-3"><b>Activity</b></div>
            <div class="col-md-9">{{ $data->activity }}</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3"><b>Activity Date</b></div>
            <div class="col-md-9">{{ $data->date }}</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3"><b>Destination</b></div>
            <div class="col-md-9">{{ $data->destination }}</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3"><b>Purpose</b></div>
            <div class="col-md-9">{{ $data->purpose }}</div>
        </div>
        <hr>
        <div class="row">

            <div class="col-md-12">
                <h3>Items</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Item</th>
                            <th>Units</th>
                            <th>Frequency</th>
                            <th>Unit Cost</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->travelscopebudgetitem as $item)
                            <tr>
                                <td>{{ $item->no }}</td>
                                <td>{{ $item->item }}</td>
                                <td>{{ $item->units }}</td>
                                <td>{{ $item->frequency }}</td>
                                <td>{{ $item->unit_cost }}</td>
                                <td>{{ $item->sub_total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3"><b>Comment</b></div>
            <div class="col-md-9">{{ $data->comments }}</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h3>Contacts</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Position</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->travelscopebudgetcontact as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->contact }}</td>
                                <td>{{ $item->position }}</td>
                                <td>{{ $item->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
