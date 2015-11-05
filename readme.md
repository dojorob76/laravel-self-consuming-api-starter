### Laravel Starter App

This is a simple starter app for Laravel 5.1 incorporating Vue.js, JWT Tokens, Dingo API, and CORS. Front end packages
include Bootstrap SASS, Select2 (with Bootstrap theme), and FontAwesome.

To install: Clone this repo (https://github.com/dojorob76/laravel-restful-starter-app.git) into your project
directory, then run 'composer install', 'npm install', 'bower install', and 'gulp'. Note: Composer and NPM must
already be installed in your environment. Gulp and Bower must be installed (via NPM) before running them as well.

A boilerplate Vue file and app.blade.php file are included for convenience.

#### Included Packages

<<<<<<< HEAD
* Vue https://github.com/yyx990803/vue
* Vue Resource https://github.com/vuejs/vue-resource
* Dingo API https://github.com/dingo/api
* JWT Auth https://github.com/tymondesigns/jwt-auth
* CORS https://github.com/barryvdh/laravel-cors
* JS-Cookie https://github.com/js-cookie/js-cookie/tree/v2.0.3#readme
* IDE Helper https://github.com/barryvdh/laravel-ide-helper
* Doctrine/Dbal https://github.com/doctrine/dbal
* jQuery https://github.com/jquery/jquery
* Bootstrap SASS https://github.com/twbs/bootstrap-sass
* Select2 https://select2.github.io/
* Font Awesome https://fortawesome.github.io/Font-Awesome/
* Select2 Bootstrap styles https://fk.github.io/select2-bootstrap-css/
=======
#### JWT Cross-(sub)Domain Implementation

The JWT is passed across each subdomain using cookies. To keep the JWT secure, there is an additional custom claim added to it that checks against the current CSRF, which we store on the user. (See [this article](https://stormpath.com/blog/where-to-store-your-jwts-cookies-vs-html5-web-storage/) for more information). To implement this, there are 3 custom middlewares in place to authorize and refresh the JWT properly (with the custom claim):

* Route Middlewares (simple customized extensions of the 'jwt.auth', and 'jwt.refresh' middlewares from the [JWT Auth](https://github.com/tymondesigns/jwt-auth/wiki/Authentication) package)
	* token.auth -> app/Http/Middleware/TokenAuth.php
	* token.refresh -> app/Http/Middleware/TokenRefresh.php
* Global Middleware (If Laravel Auth is not set, we check for valid JWT existence and set it if one is found)
	* app/Http/Middleware/LoginUserFromToken.php


----------


#### The Example App

The example app uses 3 subdomains. 'api', 'mobile', and 'admin'. You can have as many subdomains as you want. This is
purely for example purposes. The main domain, mobile subdomain, and admin subdomain each offer an example of a
different way to interact with the API. Here, specifically, is how the example app works:

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


----------
### Installation:

**Before you install:**
Make sure that your development environment is set up with subdomains. Those instructions are beyond the scope of this document, but here is an example of how this would work with a [Homestead Vagrant box](http://laravel.com/docs/5.1/homestead):

For the purposes of this example, we will pretend that your dev files are stored on your computer in C:/Dev (replace this with the correct path), and that your dev app will be called app.test with an 'api' subdomain, a 'mobile' subdomain, and an 'admin' subdomain (replace these with your custom names).

In your Homestead.yaml file...

    folders:
        -map: C:/Dev
         to: /home/vagrant/Code

    sites:
        -map: app.test
         to: /home/vagrant/Code/app/public
        -map: api.app.test
         to: /home/vagrant/Code/app/public
        -map: mobile.app.test
         to: /home/vagrant/Code/app/public
        -map: admin.app.test
         to: /home/vagrant/Code/app/public

In your 'hosts' file ('/private/etc/hosts' on Mac, 'C:/Windows/System32/drivers/etc/hosts' on Windows)...

    192.168.10.10 app.test
    192.168.10.10 api.app.test
    192.168.10.10 mobile.app.test
    192.168.10.10 admin.app.test
*(make sure that '192.168.10.10' matches the 'ip:' line at the top of your Homestead.yaml file)*

Then: `vagrant provision`

> **IMPORTANT:** If you want to use the initial example set-up to test the JWT authentication across subdomains, you will need to have **at least three subdomains** in your dev environment.
> Optionally, for the easiest (least amount of configuration) implementation, you should call these 3 subdomains 'api', 'mobile', and 'admin'.

**Once Your Dev Environment is Properly Configured:**

Clone this repo (https://github.com/dojorob76/laravel-vue-api-starter) into your project directory, then run `composer install`, `npm install`, `bower install`, and `gulp`. 
**Note**: Composer and NPM must already be installed in your environment. Gulp and Bower must be installed (via NPM) before running them as well.

Next, copy .env.example to a new file called .env in the same directory, and install the following keys:

A *Laravel key* will need to be generated with the following command:

    $ php artisan key:generate

A *JWT Auth* key will need to be generated with the following command:

    $ php artisan jwt:generate

The APP_KEY in the .env file should be set to the Laravel key, and the JWT_SECRET in the .env file should be set to the JWT key (this may appear in config/jwt.php - cut and paste it into .env).

If you would like to make use of the [barryvdh IDE Helper](https://github.com/barryvdh/laravel-ide-helper) (which I highly recommend), run the following command:

    $ php artisan ide-helper:generate

Next, in the .env file, you will need to declare your Dingo API settings in accordance with the instructions found in the [Wiki Documentation, Configuration Section](https://github.com/dingo/api/wiki/Configuration), as well as your domain settings which are used as global variables in various files. 

Once again, for the purposes of this example, we will pretend that your dev app is called 'app.test', and your subdomains are 'api', 'mobile', and 'admin' (replace these with your custom names). So, as an example:

    API_STANDARDS_TREE-x
    API_SUBTYPE=app
    API_DOMAIN=api.app.test
    API_VERSION=v1
    API_NAME=App API
    ...
    ...
    ...

    SESSION_DOMAIN=.app.test
    APP_MAIN=app.test

These variables also need to be declared for use with Vue and AJAX. To do this, go to 'resources/assets/js/custom/app-globals.js' and change the following lines to match the variables set in .env. 

So, change:

    rootApiPath : 'YOUR-API-PATH-HERE'
To:

    rootApiPath : 'http://api.app.test'
And change:
    
    appDomain : 'YOUR-APP(SESSION)-DOMAIN-HERE'
To:

    appDomain: '.app.test'

*The above assumes our example settings ('app.test', 'api.app.test', etc.). Again, you will need to replace these with your actual settings.
>>>>>>> Updates to Read Me

Follow the links above for more information on incorporating these packages in your own Laravel apps. No
configuration is included here, but configuration files for jwt, cors, and dingo have been published to the config
directory for convenience.

**Please Note:** This is a personal project starter, which I have generated for my own use, and am making available
to anyone who finds it useful to implement in any manner they deem appropriate. No direct affiliation to Laravel and/or
any of the other packages included here is implied. Everything herein is licensed under the MIT license.

## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
