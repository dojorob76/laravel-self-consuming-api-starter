@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
            <h2 class="text-center">Log In <small>(Laravel)</small></h2>
            <hr>
            @unless($ajaxAuth)
                @include('errors._form-errors')
            @endunless
            <div class="alert alert-danger single-error hidden">
                <strong>Whoops!</strong> <span class="error-msg"></span>
            </div>
            <!-- Laravel App Log In Form -->
            <form id="login-form" method="POST"
                @if($ajaxAuth)
                    action="{{action('AuthenticationController@formLoginAjax')}}"
                @else
                    action="{{action('AuthenticationController@formLogin')}}"
                @endif
                >
                <input type="hidden" name="token_key" id="token_key" value="{{csrf_token()}}">
                <!-- Email Form Input -->
                <div class="form-group" id="login-email">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" class="form-control">
                    <div class="error-list login-email-error-msg"><ul></ul></div>
                </div>
                <!-- Password Form Input -->
                <div class="form-group" id="login-password">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <div class="error-list login-password-error-msg"><ul></ul></div>
                </div>
                <!-- Log In Form Submit -->
                <button type="submit" class="btn btn-primary ajax-submit">Log In</button>
            </form>
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