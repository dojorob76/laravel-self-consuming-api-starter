### Laravel/Vue Self Consuming API Starter App

This is a simple starter app for a self-consuming API with subdomains built on the Laravel 5.1 framework,
incorporating Vue.js, JWT Auth, Dingo API, and CORS. It comes with an example set up with log in and registration on
each subdomain, where the JWT is passed across each subdomain using cookies. To keep the JWT secure, there is an
additional custom claim added to it that checks against the current CSRF, which we store on the user. To implement
this, there are 3 custom middlewares in place to authorize and refresh the JWT properly (with the custom claim).

The example app assumes 3 subdomains. 'api', 'mobile', and 'admin'. You can have as many subdomains as you want. This
 is purely for example purposes.

#### Installation:

Clone this repo (https://github.com/dojorob76/laravel-vue-api-starter) into your project directory, then run
'composer install', 'npm install', 'bower install', and 'gulp'. Note: Composer and NPM must already be installed
in your environment. Gulp and Bower must be installed (via NPM) before running them as well.

Next, copy .env.example to .env, and run the following commands:

A Laravel key will need to be generated with the following command:

    $ php artisan key:generate

A JWT Auth key will need to be generated with the following command:

    $ php artisan jwt:generate

The APP_KEY in the .env file should be set to the Laravel key, and the JWT_SECRET in the .env file should be set to
the JWT key (this may appear in config/jwt.php - cut and paste it into .env).

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

Follow the links above for more information on incorporating these packages in your own Laravel apps. No
configuration is included here, but configuration files for jwt, cors, and dingo have been published to the config
directory for convenience.

**Please Note:** This is a personal project starter, which I have generated for my own use, and am making available
to anyone who finds it useful to implement in any manner they deem appropriate. No direct affiliation to Laravel and/or
any of the other packages included here is implied. All packages herein are licensed under the
[MIT license](http://opensource.org/licenses/MIT)