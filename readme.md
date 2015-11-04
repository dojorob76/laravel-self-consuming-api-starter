### Laravel/Vue Self Consuming API Starter App

This is a simple starter app for Laravel 5.1 incorporating Vue.js, JWT Auth, Dingo API, and CORS.

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
the JWT key.

#### Included Packages

* Vue https://github.com/yyx990803/vue
* Vue Resource https://github.com/vuejs/vue-resource
* Dingo API https://github.com/dingo/api
* JWT Auth https://github.com/tymondesigns/jwt-auth
* CORS https://github.com/barryvdh/laravel-cors
* IDE Helper https://github.com/barryvdh/laravel-ide-helper
* Doctrine/Dbal https://github.com/doctrine/dbal
* jQuery https://github.com/jquery/jquery
* Bootstrap SASS https://github.com/twbs/bootstrap-sass

Follow the links above for more information on incorporating these packages in your own Laravel apps. No
configuration is included here, but configuration files for jwt, cors, and dingo have been published to the config
directory for convenience.

**Please Note:** This is a personal project starter, which I have generated for my own use, and am making available
to anyone who finds it useful to implement in any manner they deem appropriate. No direct affiliation to Laravel and/or
any of the other packages included here is implied. All packages herein are licensed under the
[MIT license](http://opensource.org/licenses/MIT)