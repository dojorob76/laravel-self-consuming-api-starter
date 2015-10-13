@extends('webapp')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
            <h2 class="text-center">Register</h2>
            <hr>
            <form action="{{$dingo_v1->route('register.post')}}" id="registration-form">
                <!-- Name Form Input -->
                <div class="form-group" id="register-name">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <div class="errlist register-name-error-msg"><ul></ul></div>
                </div>

                <!-- Email Form Input -->
                <div class="form-group" id="register-email">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" class="form-control">
                    <div class="errlist register-email-error-msg"><ul></ul></div>
                </div>

                <!-- Password Form Input -->
                <div class="form-group" id="register-password">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <div class="errlist register-password-error-msg"><ul></ul></div>
                </div>

                <!-- Password Form Input -->
                <div class="form-group" id="register-password_confirmation">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    <div class="errlist register-password_confirmation-error-msg"><ul></ul></div>
                </div>

                <!-- Registration Form Submit -->
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
@endsection