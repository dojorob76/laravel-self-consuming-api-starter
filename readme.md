## Laravel/Vue Self-Consuming API Starter App

This is a simple starter app for a self-consuming API with subdomains built on the [Laravel 5.1](http://laravel.com/docs/5.1/releases#laravel-5.1.11) framework, incorporating [Vue.js](https://github.com/yyx990803/vue), [JWT Auth](https://github.com/tymondesigns/jwt-auth), [Dingo API](https://github.com/dingo/api), and [CORS](https://github.com/barryvdh/laravel-cors). It includes an example set up that has log in and registration with authentication middleware testing links on each subdomain (more details below).


----------


#### JWT Cross-(sub)Domain Implementation

The JWT is passed across each subdomain using cookies. To keep the JWT secure, there is an additional custom claim added to it that checks against the current CSRF, which we store on the user. (See [this article](https://stormpath.com/blog/where-to-store-your-jwts-cookies-vs-html5-web-storage/) for more information). To implement this, there are 3 custom middlewares in place to authorize and refresh the JWT properly (with the custom claim):

* Route Middlewares (simple customized extensions of the 'jwt.auth', and 'jwt.refresh' middlewares from the [JWT Auth](https://github.com/tymondesigns/jwt-auth/wiki/Authentication) package)
	* token.auth -> app/Http/Middleware/TokenAuth.php
	* token.refresh -> app/Http/Middleware/TokenRefresh.php
* Global Middleware (If Laravel Auth is not set, we check for valid JWT existence and set it if one is found)
	* app/Http/Middleware/LoginUserFromToken.php


----------


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

The APP_KEY in the .env file should automatically get set to the Laravel key, but you will need to copy/paste the JWT
 key to the .env file JWT_SECRET variable (replace 'GenerateMe').

If you would like to make use of the [barryvdh IDE Helper](https://github.com/barryvdh/laravel-ide-helper) (which I 
highly recommend), run the following commands:

    $ php artisan clear-compiled
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

**If you are not using 'mobile' and 'admin' as Subdomains:**

The example app is configured to use 'api', 'mobile', and 'admin' as subdomains. If your subdomain names are different, you will need to do a little more configuration if you want to test things out with the initial test set up. If you are already using 'mobile' and 'admin', or if you do not want to use the included test set up, you can safely ignore this section.

First, we have a custom global view composer that makes the Dingo Dispatcher and various domain routes available to us from every view. You will need to update this file to match your custom subdomain names.

Go to 'app\Http\ViewComposers\GlobalComposer' to update the `$mobile_route`, and `$admin_route` variables to match your custom set up.

These variables are used in the following files:

* 'resources/views/all/intro.blade.php'
* 'resources/views/all/test-auth-one.blade.php'

...so you will need to update them there as well.

Finally, you will need to change the Route Groups in routes.php from '['domain' => 'admin']' and '['domain' => 'mobile']' to whatever your custom subdomain names actually are.


----------

#### Start Testing

Before you can begin testing the app with the example set-up, you will need to migrate your database, which means you
 will need to have your database set up. Instructions for this can be found in the [Laravel Documentation]
 (http://laravel.com/docs/5.1/database),
 but for the purposes of testing the app, I recommend simply generating a SQLite DB by running the following command:
 
     $ touch storage/database.sqlite
     
 (You can easily delete this later)
 
 When you have a database ready, migrate it with the command:
 
     $ php artisan migrate
 
 Now you can open the app in your browser, and visit the test pages. (Register a User first.) When you're finished 
 testing, just remove the pages you don't want/need, and keep on building.
 
 **NOTE:** If you are going to extend/change your User model, just be sure to leave the 'token_key' field alone if 
 you will continue to use JWT as it is set up here. You will find all the code that is being used to make this 
 version of authentication work in the 'app/Repositories', 'app/Services', and 'app/Utilities' directories.

----------

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