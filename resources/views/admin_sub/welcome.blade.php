@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
            <h1 class="text-center">Welcome!<br><small>(Admin Subdomain)</small></h1>
            <hr>
            <div class="text-center">
                @if(Auth::check())
                    @include('partials._auth-test-links')
                @else
                    <p>Please Log in or Register now.</p>
                    <a class="btn btn-primary" href="{{action('Admin\AuthenticationController@login')}}">Log In</a>
                    <a class="btn btn-default" href="{{action('Admin\AuthenticationController@register')}}">Register</a>
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