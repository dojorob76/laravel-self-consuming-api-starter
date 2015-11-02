@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
            <h1 class="text-center">Welcome!
                <small>(Laravel)</small>
            </h1>
            <hr>
            <div class="text-center">
                @if(Auth::check())
                    <p>You are logged in!</p>
                    <a class="btn btn-default"
                       href="{{route('test-auth-one.get', $jwtQuery)}}">
                        NON-API Query String
                    </a>
                    <a class="btn btn-default ajax-link query"
                       href="{{$dingo_v1->route('test-auth-two.get', $jwtQuery)}}">
                        API Query String
                    </a>
                    <a class="btn btn-default ajax-link refresh"
                       href="{{route('test-auth-three.get')}}">
                        NON-API Header Refresh
                    </a>
                    <a class="btn btn-default ajax-link refresh"
                       href="{{$dingo_v1->route('test-auth-four.get')}}">
                        API Header Refresh
                    </a>
                    <hr>
                    <p class="test-message">
                        Click the buttons to test the JWT using the Authorization header and/or Query string on
                        different domains.
                    </p>
                    <h6 class="text-center">Hello, {{Auth::user()->name}}</h6>
                @else
                    <p>Please Log in or Register now.</p>
                    <a class="btn btn-primary" href="{{action('AuthenticationController@login')}}">Log In</a>
                    <a class="btn btn-primary" href="{{action('AuthenticationController@loginAjax')}}">AJAX Log In</a>
                    <a class="btn btn-default" href="{{action('AuthenticationController@register')}}">Register</a>
                    <a class="btn btn-default" href="{{action('AuthenticationController@registerAjax')}}">AJAX Register</a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('postscripts')
    <script>
        $('.ajax-link').on('click', function(e){

            var response = $('.test-message');

            if($(this).hasClass('refresh')){
                var refresh = true;
            }

            $.ajax({
                url: $(this).attr('href')
            })
                .done(function(data, textStatus, jqXHR){
                    response.text(data.msg);
                    if(refresh){
                        formAjax.setCookieFromHeader(data, textStatus, jqXHR);
                        location.reload(); // Reload page to update the header and cookie token variables
                    }
                })
                .fail(function(data, textStatus, jqXHR){
                    response.text(data.responseText + '. You are being logged out.');
                    location.replace('/logout');
                });

            e.preventDefault();
        });
    </script>
@endsection