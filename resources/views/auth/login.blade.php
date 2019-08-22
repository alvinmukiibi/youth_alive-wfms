@extends('layouts.layout')

@section('content')
    <body class="hold-transition login-page" style="background-image: url('images/background-photo.jpg'); background-size: cover; background-position: 'center'; background-repeat: 'no-repeat'">
        <div id="app">
            <div class="login-box mt-5" >
                <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="login-logo">
                    <img src="{{ asset('images/logo.png') }}" width="50%"  />
                    <a href=""><b>YOUTH</b>ALIVE</a>
                </div>
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">
                            Sign in to start your session
                        </p>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control {{$errors->has('email')?'is-invalid':''}}" value="" name="email" placeholder="Email">

                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control {{$errors->has('password')?'is-invalid':''}}" value="" name="password" placeholder="Password">

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
