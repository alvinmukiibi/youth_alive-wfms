<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Youth Alive | Work Flow Management System') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
        <!-- Styles -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @guest
            @yield('content')
        @else
        <body>
            <div id="app">
                <div class="wrapper">
                    <main-header></main-header>
                    <sidebar></sidebar>
                    <div class="content-wrapper">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        @endguest

        <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbMYsP3CALSRD9seXN8tEvJn5_TJnMX6s&libraries=places&callback=initAutocomplete"></script>
        <script src="{{ asset('js/app.js') }}"></script>

        {{-- <script src="https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=-33.8670522,151.1957362&radius=500&types=food&name=harbour&key=AIzaSyDmrlgKKtAadaQsMRSZY_KM4ZbHmUvpSwE"></script> --}}
    </body>
</html>
