@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
            <h1 class="text-center">
                Laravel/Vue Self Consuming API Intro
                @if(Auth::check()) <br><small>(You are currently Logged In)</small> @endif
            </h1>
            <hr>
            <ul class="list-inline text-center">
                <li><a class="btn btn-lg btn-default" href="/laravel">Use Laravel</a></li>
                <li><a class="btn btn-lg btn-default" href="/vue">Use Vue</a></li>
            </ul>
            <hr>
            <h4>About This App</h4>
            <p>
                <a href="http://laravel.com/docs/5.1">Laravel 5.1</a> |
                <a href="https://github.com/vuejs/vue">Vue.js [1.0.*]</a> |
                <a href="https://github.com/vuejs/vue-resource">Vue Resource</a> |
                <a href="https://github.com/dingo/api">DingoAPI</a> |
                <a href="https://github.com/tymondesigns/jwt-auth">tymondesigns/jwt-auth</a> |
                <a href="https://github.com/barryvdh/laravel-cors">barryvdh/laravel-cors</a>
            </p>
        </div>
    </div>
@endsection