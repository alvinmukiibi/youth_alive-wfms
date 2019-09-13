@extends('layouts.layout')

@section('content')
    <body class="hold-transition login-page" style="background-image: url('images/background-photo.jpg'); background-size: cover; background-position: 'center'; background-repeat: 'no-repeat'">
        <div id="app">
            <div class="login-box mt-5" >
                <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="login-logo">
                    <img src="{{ asset('images/logo.png') }}" width="50%"  />
                    <a style="text-decoration: none" href="{{ url('/login') }}"><b class="text-primary" style="font-weight:700">YOUTH</b><b class="text-warning">ALIVE</b></a>
                </div>
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">
                            Log in
                        </p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="row">
                            <div class="col-12">
                              <button type="submit" class="btn btn-primary btn-block"> <i class="fa fa-sign-in"></i> Sign In</button>
                            </div>
                        </div>
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{session('error')}}
                        </div>
                        @endif
                        @if(session('info'))
                            <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{session('info')}}
                            </div>
                        @endif
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{$error}}
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                </form>
                </div>
        </div>
    </body>
@endsection
