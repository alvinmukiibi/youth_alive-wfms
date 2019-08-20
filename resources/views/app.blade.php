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
        <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script>
            window.authenticated = {{ auth()->check() ? 'true' : 'false' }};
        </script>
    </head>
    <body>
        <div id="app">
           {{-- <main-header></main-header>
                <main-sidebar></main-sidebar> --}}
                <div class="container">
                    <p class="text-primary">Great is He in me than he that is in the world</p>
                    {{-- <router-view></router-view> --}}
                </div>
            {{-- <main-footer></main-footer> --}}
        </div>
        <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
