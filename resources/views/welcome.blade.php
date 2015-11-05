<<<<<<< HEAD
<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
            </div>
        </div>
    </body>
</html>
=======
@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
            <h1 class="text-center">Welcome!<br><small>(Main Domain)</small></h1>
            <hr>
            <div class="text-center">
                @if(Auth::check())
                    @include('partials._auth-test-links')
                @else
                    <p>Please Log in or Register now.</p>
                    <a class="btn btn-primary" href="{{action('AuthenticationController@loginAjax')}}">Log In</a>
                    <a class="btn btn-default" href="{{action('AuthenticationController@registerAjax')}}">Register</a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('postscripts')
    @if(Auth::check())
        @include('scripts._auth-test-links')
    @endif
@endsection
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
