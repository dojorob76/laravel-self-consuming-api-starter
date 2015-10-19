<?php

$api = app('Dingo\Api\Routing\Router');
$dispatcher = app('Dingo\Api\Dispatcher');

// Dingo generated router for Version 1 of the app API
$api->version('v1', function($api){

    // Set the namespace for the API_v1-specific routes
    $api->group(['namespace' => 'App\Api\Controllers', 'middleware' => 'cors'], function($api){

        // Routes that do NOT require authentication

        // Routes that DO require (JWT) authentication
        $api->group(['middleware' => 'token.auth'], function($api){
            //
        });

    });

});

Route::get('/', function () {
    return view('welcome');
});