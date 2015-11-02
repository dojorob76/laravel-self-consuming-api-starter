<?php

namespace App\Http\Middleware;

use Auth;
use JWTAuth;
use Closure;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginUserFromToken
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If we do not have a logged in user, check for an authorized JWT
        if (!Auth::check()) {
            // If there is a JWT cookie, grab it
            if ($request->hasCookie('jwt')) {
                $jwt = $request->cookie('jwt');
                // If the JWT is not null, and is too long to be an error message, try to retrieve a user from it
                if ($jwt != null && strlen($jwt) > 35) {
                    try {
                        $user = JWTAuth::toUser($jwt);
                    } catch (JWTException $e) {
                        $user = null;
                    }
                    // If the JWT was valid, and a user was returned from it, log them in
                    if ($user instanceof User) {
                        Auth::login($user);
                    }
                }
            }
        }

        return $next($request);
    }
}
