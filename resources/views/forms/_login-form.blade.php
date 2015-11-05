@unless($ajaxAuth)
    @include('forms.errors._form-request-errors')
@endunless

@include('forms.errors._single-error')

<!-- Laravel App Log In Form -->
<form id="login-form" method="POST"
    @if($ajaxAuth)
        action="{{action('AuthenticationController@formLoginAjax')}}"
    @else
        action="{{action('Admin\AuthenticationController@formLogin')}}"
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