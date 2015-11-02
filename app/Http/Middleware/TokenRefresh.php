<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use App\Utilities\TokenManager;

class TokenRefresh
{
    protected $auth;

    public function __construct(JWTAuth $auth, TokenManager $tokenManager)
    {
        $this->auth = $auth;
        $this->tokenManager = $tokenManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return response('Token Not Provided', 400);
        }

        $user = $this->tokenManager->getUserFromToken($token);

        if(! $user instanceof User){
            return $user;
        }

        // Since we are using cookies, we need to check the JWT xsrfToken against the csrf stored on the user
        $key_match = $this->tokenManager->compareTokenKeys($token, $user);

        // If keys do not match, invalidate the token and remove it from the cookies
        if($key_match == false){
            // Invalidate the JWT and retrieve the removal cookie
            $invalidate = $this->tokenManager->removeToken($token);

            return response('Token Keys Do Not Match', 401)->withCookie($invalidate);
        }

        // Refresh the CSRF and JWT
        $new_token = $this->tokenManager->refreshUserToken($token, $user);

        // Set a cookie with 'Http only' set to false so that it is accessible to JS as well
        $cookie = \Cookie::make('jwt', $new_token, 120, '/', env('SESSION_DOMAIN'), false, false);

        return $next($request)->header('Authorization', 'Bearer ' . $new_token)->withCookie($cookie);
    }
}
