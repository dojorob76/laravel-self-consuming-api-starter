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

    });

});

Route::get('/test', function(){
    $test = ['test' => 'testing'];

    return response()->json(['test' => 'testing']);
});