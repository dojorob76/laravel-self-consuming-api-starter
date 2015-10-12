<?php


Route::get('/', function () {
    return view('main');
});

$api = app('Dingo\Api\Routing\Router');

// Dingo generated router for Version 1 of the MMh API
$api->version('v1', function($api){

    // Set the namespace for the API_v1-specific routes
    $api->group(['namespace' => 'App\Api\Controllers', 'middleware' => 'cors'], function($api){

        // Routes that do NOT require authentication
        $api->post('login', ['as' => 'login.post', 'uses' => 'AuthenticationController@login']);
        $api->post('register', ['as' => 'register.post', 'uses' => 'AuthenticationController@register']);

        // Routes that DO require (JWT) authentication
        $api->group(['middleware' => 'token.auth'], function($api){
            $api->get('test-auth-one', function(){
                return 'You have successfully authorized via JWT on Test Route One. Try
                <a href="http://mmh.app/test-auth-two">Test Route Two</a> next to test persistence.';
            });
        });

    });

});

Route::get('/test', function(\Illuminate\Http\Request $request){
    $cookies = $request->cookies->get('jwt');

    var_dump($cookies);
});

Route::group(['middleware' => 'token.auth'], function(){
    Route::get('/test-auth-two', function(){
        return 'You have successfully authorized via JWT on Test Route Two. You are now on a separate domain.
            Try <a href="http://api.mmh.app/test-auth-one">Test Route One</a> again to further test persistence.';
    });
});