<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Youth Alive | Work Flow Management System') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ asset('adminlte/plugins/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script>
            window.authenticated = {{ auth()->check() ? 'true' : 'false' }};
        </script>
    </head>
    <body class="hold-transition sidebar-mini">
        <div id="app">
            <div class="wrapper">
                <main-header></main-header>
                <sidebar></sidebar>
                <div class="content-wrapper">
                    <router-view></router-view>
                </div>

            </div>
        </div>
        <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
