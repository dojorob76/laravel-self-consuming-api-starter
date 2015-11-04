### Laravel/Vue Self-Consuming API Starter App

This is a simple starter app for a self-consuming API with subdomains built on the [Laravel 5.1](http://laravel.com/docs/5.1/releases#laravel-5.1.11) framework, incorporating [Vue.js](https://github.com/yyx990803/vue), [JWT Auth](https://github.com/tymondesigns/jwt-auth), [Dingo API](https://github.com/dingo/api), and [CORS](https://github.com/barryvdh/laravel-cors). It includes an example set up that has log in and registration with authentication middleware testing links on each subdomain (more details below).

#### JWT Cross-(sub)Domain Implementation

The JWT is passed across each subdomain using cookies. To keep the JWT secure, there is an additional custom claim added to it that checks against the current CSRF, which we store on the user. (See [this article](https://stormpath.com/blog/where-to-store-your-jwts-cookies-vs-html5-web-storage/) for more information). To implement this, there are 3 custom middlewares in place to authorize and refresh the JWT properly (with the custom claim):

* Route Middlewares (simple customized extensions of the 'jwt.auth', and 'jwt.refresh' middlewares from the [JWT Auth](https://github.com/tymondesigns/jwt-auth/wiki/Authentication) package)
	* token.auth -> app/Http/Middleware/TokenAuth.php
	* token.refresh -> app/Http/Middleware/TokenRefresh.php
* Global Middleware (If Laravel Auth is not set, we check for valid JWT existence and set it if one is found)
	* app/Http/Middleware/LoginUserFromToken.php

#### The Example App

The example app uses 3 subdomains. 'api', 'mobile', and 'admin'. You can have as many subdomains as you want. This is purely for example purposes. Here is how the example app works:

##### The API Subdomain

The 'api' subdomain serves the API. It's paths are contained in a Dingo-generated router in the routes.php file. This allows us to access it from the main domain and other subdomains with the Dingo dispatcher and helpers. See the [Internal Requests](https://github.com/dingo/api/wiki/Internal-Requests) section of the [Dingo Wiki documentation](https://github.com/dingo/api/wiki) for more information on this.

The API Controllers are stored in the app/Api/Controllers directory. 

> **PLEASE NOTE:** All of the app Controllers (main and subdomains) extend a custom Base Controller (at 'app/Http/Controllers/BaseController.php'), so that the Dingo dispatcher and helpers are always available.

##### The Mobile Subdomain

The 'mobile' subdomain serves the Vue.js implementation of the example app, which interacts with the API directly (i.e., does not use Laravel Controllers) via Vue Resource.

The mobile subdomain paths are organized under the ['domain' => 'mobile'] Route group in routes.php

The Vue files themselves can be found in the 'resources/assets/js/vue' directory.

The blade templates utilized for the mobile subdomain are stored in 'resources/views/mobile_sub'. 

##### The Admin Subdomain

The 'admin' subdomain interacts directly with the Laravel app. It is the only part of the app (main and sub-domains) that does not use the API or AJAX for log in and registration. It is  simply meant to serve as an example of how this can be accomplished/integrated easily if necessary.

The admin subdomain paths are organized under the ['domain' => 'admin'] Route group in routes.php

The Controllers for the admin subdomain can be found in the 'app/Http/Controllers/Admin' directory.

The blade templates utilized for the admin subdomain views are located in the 'resources/views/admin_sub' directory.

##### The Main Domain

The main domain is standard Laravel, which interacts with the API via AJAX.

All routes *not* included in Route groups in routes.php belong to the main domain (any route not specifically mentioned in a subdomain's route group will default to these routes as well).

The Controllers and blade templates for the main domain are located in the standard Laravel directories ('app/Http/Controllers', and 'resources/views').

#### Installation:

Clone this repo (https://github.com/dojorob76/laravel-vue-api-starter) into your project directory, then run 'composer install', 'npm install', 'bower install', and 'gulp'. Note: Composer and NPM must already be installed in your environment. Gulp and Bower must be installed (via NPM) before running them as well.

Next, copy .env.example to .env, and install the following keys:

A *Laravel key* will need to be generated with the following command:

    $ php artisan key:generate

A *JWT Auth* key will need to be generated with the following command:

    $ php artisan jwt:generate

The APP_KEY in the .env file should be set to the Laravel key, and the JWT_SECRET in the .env file should be set to the JWT key (this may appear in config/jwt.php - cut and paste it into .env).

#### Included Packages

* Laravel 5.1.11 http://laravel.com/docs/5.1/releases#laravel-5.1.11
* Vue 1.0.* https://github.com/yyx990803/vue
* Vue Resource https://github.com/vuejs/vue-resource
* Dingo API https://github.com/dingo/api
* JWT Auth https://github.com/tymondesigns/jwt-auth
* CORS https://github.com/barryvdh/laravel-cors
* IDE Helper https://github.com/barryvdh/laravel-ide-helper
* Doctrine/Dbal https://github.com/doctrine/dbal
* jQuery 2.1.4 https://github.com/jquery/jquery
* Bootstrap SASS 3.3.5 https://github.com/twbs/bootstrap-sass

Follow the links above for more information on incorporating these packages in your own Laravel apps. Configuration files for jwt, cors, and dingo have been published to the config directory..

**Please Note:** This is a personal project starter, which I have generated for my own use, and am making available to anyone who finds it useful to implement in any manner they deem appropriate. No direct affiliation to Laravel and/or any of the other packages included here is implied. All packages herein are licensed under the [MIT license](http://opensource.org/licenses/MIT).