<?php

$api = app('Dingo\Api\Routing\Router');
$dispatcher = app('Dingo\Api\Dispatcher');

// Dingo generated router for Version 1 of the app API
$api->version('v1', function($api){

    // Set the namespace for the API_v1-specific routes
    $api->group(['namespace' => 'App\Api\Controllers', 'middleware' => 'cors'], function($api){

        // Routes that do NOT require authentication
        $api->post('form-login', ['as' => 'form-login.post', 'uses' => 'AuthenticationController@formLogin']);
        $api->post('form-register', ['as' => 'form-register.post', 'uses' => 'AuthenticationController@formRegister']);

        // API implementation of the TokenAuth middleware
        $api->group(['middleware' => 'token.auth'], function($api){
            // Example Test TODO: Delete Me
            $api->get('test-auth-two', ['as' => 'test-auth-two.get', 'uses' => function(){
                return ['msg' => 'Your JWT was successfully set, and was authorized via the query
                string on the API domain.'];
            }]);
        });

        // API implementation of the TokenRefresh middleware
        $api->group(['middleware' => 'token.refresh'], function($api){
            // Example Test TODO: Delete Me
            $api->get('test-auth-four', ['as' => 'test-auth-four.get', 'uses' => function(){
                return ['msg' => 'Your JWT was successfully set, and was authorized via the request
                header on the API domain. It has also been refreshed.'];
            }]);
        });

    });

});

Route::get('/', function(){return view('intro');});

Route::get('laravel', 'WelcomeController@welcome');

Route::get('vue', function () {return view('vue');});

// Register through the Laravel App form without using the API and without using AJAX
Route::get('form-register', 'AuthenticationController@register');
Route::post('form-register', 'AuthenticationController@formRegister');

// Register through the Laravel App form using the API (called from the Controller) and AJAX
Route::get('form-register-ajax', 'AuthenticationController@registerAjax');
Route::post('form-register-ajax', 'AuthenticationController@formRegisterAjax');

// Log in through the Laravel App form without using the API and without using AJAX
Route::get('form-login', 'AuthenticationController@login');
Route::post('form-login', 'AuthenticationController@formLogin');

// Log in through the Laravel App form using the API (called from the Controller) and AJAX
Route::get('form-login-ajax', 'AuthenticationController@loginAjax');
Route::post('form-login-ajax', 'AuthenticationController@formLoginAjax');

Route::get('logout', 'AuthenticationController@logout');

// Non-API implementation of the TokenAuth middleware
Route::group(['middleware' => 'token.auth'], function(){
    // Example Test TODO: Delete Me
    Route::get('test-auth-one', ['as' => 'test-auth-one.get', 'uses' => function(){
        return view('tests.test-auth-one');
    }]);
});

// Non-API implementation of the TokenRefresh middleware
Route::group(['middleware' => 'token.refresh'], function(){
    // Example Test TODO: Delete Me
    Route::get('test-auth-three', ['as' => 'test-auth-three.get', 'uses' =>function(){
        return ['msg' => 'Your JWT was successfully set, and was authorized via the request header on the NON-API
        domain. It has also been refreshed.'];
    }]);
});