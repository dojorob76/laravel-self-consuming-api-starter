@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">

            <h2 class="text-center">Log In<br><small>({{$domain}})</small></h2>

            <hr>

            @include('forms._login-form')

        </div>
    </div>
@endsection

@section('postscripts')

    @if($ajaxAuth)
        <script>
            var successCallbacks = [formAjax.setAuthorized];
            formAjax.validate('login-', false, successCallbacks);
        </script>
    @endif

@endsection