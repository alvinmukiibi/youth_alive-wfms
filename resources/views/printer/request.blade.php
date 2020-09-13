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
            <h1 class="display-4">Program Request</h1>
            {{-- <p class="lead">A Travel Scope of Work (SoW) is required for all YA relatad travels. Staff travelling to carry out the same activity should complete one (joint) SoW. The SoW should be submitted to the Supervisor for review and approval prior to the travel and a copy attached to any advance request related to the trip</p> --}}

          </div>

            <div class="row">
                <div class="col-md-3"><b>Request ID</b></div>
                <div class="col-md-9">{{ $data->identity }}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Requested By</b></div>
                <div class="col-md-9">{{ $data->requestor->fname . ' ' . $data->requestor->lname  }}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Date of request</b></div>
                <div class="col-md-9">{{ $data->created_at }}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Project</b></div>
                <div class="col-md-9">{{ $data->project->name }}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Activity</b></div>
                <div class="col-md-9">{{ $data->activity_type }}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Department</b></div>
                <div class="col-md-9">{{ $data->department->name }}</div>
            </div>
            <div class="row">
                <div class="col-md-3"><b>Documents Filled</b></div>
                {{-- <div class="col-md-9">{{ $data->identity }}</div> --}}
            </div>
            <div class="row">
            <div class="col-md-12">
                <h3>Approval Trail</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Approver</th>
                            <th>Date of Approval</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->trail->accountant_approval != 0)
                        <tr>
                            @if ($data->trail->accountant_approval == 1)
                            <td >
                                <button class="btn btn-sm btn-success">
                                  <i class="fa fa-check"></i>
                                </button>
                              </td>
                            @else
                            <td >
                                <button class="btn btn-sm btn-danger">
                                  <i class="fa fa-times"></i>
                                </button>
                              </td>
                            @endif


                          <td>{{ $data->trail->acc_appro_date }}</td>
                          <td>{{ $data->trail->accountant }}</td>
                          <td>{{ $data->trail->acc_comments }}</td>
                        </tr>
                        @endif
                        @if ($data->trail->level_one_approval != 0)
                        <tr >
                            @if ($data->trail->level_one_approval == 1)
                            <td >
                                <button class="btn btn-sm btn-success">
                                  <i class="fa fa-check"></i>
                                </button>
                              </td>
                            @else
                            <td >
                                <button class="btn btn-sm btn-danger">
                                  <i class="fa fa-times"></i>
                                </button>
                              </td>
                            @endif


                          <td>{{ $data->trail->level_one_date }}</td>
                          <td>{{ $data->trail->level_one_approver }}</td>
                          <td>{{ $data->trail->level_one_comments }}</td>
                        </tr>
                        @endif
                        @if ($data->trail->finance_approval != 0 && $data->trail->finance_approval != null)
                        <tr

                        >
                            @if ($data->trail->finance_approval == 1)
                                <td>
                                    <button class="btn btn-sm btn-success">
                                    <i class="fa fa-check"></i>
                                    </button>
                                </td>
                            @else
                            <td>
                                <button class="btn btn-sm btn-danger">
                                  <i class="fa fa-times"></i>
                                </button>
                              </td>
                            @endif


                          <td>{{ $data->trail->finance_approval_date }}</td>
                          <td>{{ $data->trail->finance_approver }}</td>
                          <td>{{ $data->trail->finance_appro_comments }}</td>
                        </tr>
                        @endif
                        @if ($data->trail->level_two_approval != 0 && $data->trail->level_two_approval != null)
                        <tr

                        >
                        @if ($data->trail->level_two_approval == 1)
                        <td >
                            <button class="btn btn-sm btn-success">
                              <i class="fa fa-check"></i>
                            </button>
                          </td>
                        @else
                        <td >
                            <button class="btn btn-sm btn-danger">
                              <i class="fa fa-times"></i>
                            </button>
                          </td>
                        @endif



                          <td>{{ $Data->trail->level_two_date }}</td>
                          <td>{{ $Data->trail->level_two_approver }}</td>
                          <td>{{ $Data->trail->level_two_comments }}</td>
                        </tr>
                        @endif
                        @if ($data->trail->level_three_approval != 0 && $data->trail->level_three_approval != null)


                        <tr
                        >
                        @if ($data->trail->level_three_approval == 1)
                        <td >
                            <button class="btn btn-sm btn-success">
                              <i class="fa fa-check"></i>
                            </button>
                          </td>
                        @else
                        <td >
                            <button class="btn btn-sm btn-danger">
                              <i class="fa fa-times"></i>
                            </button>
                          </td>
                        @endif


                          <td>{{ $data->trail->level_three_date }}</td>
                          <td>{{ $data->trail->level_three_approver }}</td>
                          <td>{{ $data->trail->level_three_comments }}</td>
                        </tr>
                        @endif
                      </tbody>

                </table>
            </div>
        </div>




    </div>

</body>
</html>
