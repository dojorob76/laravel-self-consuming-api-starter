<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
<<<<<<< HEAD
=======

>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
<<<<<<< HEAD
=======
        \App\Http\Middleware\LoginUserFromToken::class,
        'Barryvdh\Cors\HandleCors',
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
<<<<<<< HEAD
        'csrf' => \App\Http\Middleware\VerifyCsrfToken::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'token.auth' => \App\Http\Middleware\TokenAuth::class
=======
        'csrf'       => \App\Http\Middleware\VerifyCsrfToken::class,
        'auth'       => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'token.auth' => \App\Http\Middleware\TokenAuth::class,
        'token.refresh' => \App\Http\Middleware\TokenRefresh::class,
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
    ];
}
