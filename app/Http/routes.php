<?php

$api = app('Dingo\Api\Routing\Router');
$dispatcher = app('Dingo\Api\Dispatcher');

// Dingo generated router for Version 1 of the app API
$api->version('v1', function($api){

    // Set the namespace for the API_v1-specific routes
    $api->group(['namespace' => 'App\Api\Controllers', 'middleware' => 'cors'], function($api){

        // Routes that do NOT require authentication
        $api->post('login', ['as' => 'login.post', 'uses' => 'AuthenticationController@login']);
        $api->post('register', ['as' => 'register.post', 'uses' => 'AuthenticationController@register']);

        // Routes that DO require (JWT) authentication
        $api->group(['middleware' => 'token.auth'], function($api){
            $api->get('test-auth-one', ['as' => 'test-one.get', 'uses' => function(){
                return view('tests.test-auth-one');
            }]);
        });

    });

});

Route::get('/', function () {
    return view('main');
});

Route::get('register', 'AuthenticationController@register');

Route::group(['middleware' => 'token.auth'], function(){
    Route::get('/test-auth-two', ['as' => 'test-two.get', 'uses' => function(){
        return view('tests.test-auth-two');
    }]);
});