@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
            <h2 class="text-center">Register <small>(Laravel)</small></h2>
            <hr>
            @unless($ajaxAuth)
                @include('errors._form-errors')
            @endunless
            <!-- Laravel App Registration Form -->
            <form id="registration-form" method="POST"
                @if($ajaxAuth)
                    action="{{action('AuthenticationController@formRegisterAjax')}}"
                @else
                    action="{{action('AuthenticationController@formRegister')}}"
                @endif
                >
                <input type="hidden" name="token_key" id="token_key" value="{{csrf_token()}}">
                <!-- Name Form Input -->
                <div class="form-group" id="register-name">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <div class="error-list register-name-error-msg"><ul></ul></div>
                </div>

                <!-- Email Form Input -->
                <div class="form-group" id="register-email">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" class="form-control">
                    <div class="error-list register-email-error-msg"><ul></ul></div>
                </div>

                <!-- Password Form Input -->
                <div class="form-group" id="register-password">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <div class="error-list register-password-error-msg"><ul></ul></div>
                </div>

                <!-- Password Form Input -->
                <div class="form-group" id="register-password_confirmation">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-control">
                    <div class="error-list register-password_confirmation-error-msg"><ul></ul></div>
                </div>

                <!-- Registration Form Submit -->
                <button type="submit" class="btn btn-primary ajax-submit">Register</button>
            </form>
        </div>
    </div>
@endsection

@section('postscripts')
    @if($ajaxAuth)
        <script>
            var successCallbacks = [formAjax.setAuthorized];
            formAjax.validate('register-', false, successCallbacks);
        </script>
    @endif
@endsection