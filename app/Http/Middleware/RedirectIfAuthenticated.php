<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfAuthenticated
{
<<<<<<< HEAD
=======

>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
<<<<<<< HEAD
     * @param  Guard  $auth
=======
     * @param  Guard $auth
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
<<<<<<< HEAD
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
=======
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
<<<<<<< HEAD
            return redirect('/home');
=======
            return redirect('/');
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
        }

        return $next($request);
    }
}
