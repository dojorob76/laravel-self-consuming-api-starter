<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWTAuth;

class TokenAuth
{
    protected $auth;

    public function __construct(JWTAuth $auth){
        $this->auth = $auth;
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
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            // The token was not in the header or query string, so let's check if it is stored in the Cookies
            if(! $token = $request->cookies->get('jwt')){
                return response('Token Not Provided', 400);
            }
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return response('Token Expired', $e->getStatusCode());
        } catch (JWTException $e) {
            return response('Token Invalid', $e->getStatusCode());
        }

        if (! $user) {
            return response('User Not Found', 404);
        }

        // Store the token in the Cookies, and set the Headers for the next request.
        return $next($request)->withCookie(cookie('jwt', $token))->header('Authorization', 'Bearer ' . $token);
    }
}