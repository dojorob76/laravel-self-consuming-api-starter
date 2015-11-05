<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Tymon\JWTAuth\JWTAuth;
use App\Utilities\TokenManager;
use \Symfony\Component\Console\Helper;

class TokenAuth
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

        $cookie = \Cookie::make('jwt', $token, 120, '/', env('SESSION_DOMAIN'), false, false);

        return $next($request)->header('Authorization', 'Bearer ' . $token)->withCookie($cookie);
    }
}
