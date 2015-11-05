<?php

namespace App\Http\Middleware;

<<<<<<< HEAD
use App\Utilities\TokenManager;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWTAuth;
=======
use App\User;
use Closure;
use Tymon\JWTAuth\JWTAuth;
use App\Utilities\TokenManager;
use \Symfony\Component\Console\Helper;
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7

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
<<<<<<< HEAD
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
=======
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
<<<<<<< HEAD
            // The token was not in the header or query string, so let's check if it is stored in the Cookies
            if (!$token = $request->cookies->get('jwt')) {
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

        if (!$user) {
            return response('User Not Found', 404);
        }

        // Since we are storing jwt in cookies, we also need to check the xsrfToken against the User's token key.
        $key_match = $this->tokenManager->compareTokenKeys($token);
        // If keys do not match, invalidate the token
        if ($key_match == null || $key_match == false) {
            $this->auth->invalidate($token);

            return response('Token Keys Do Not Match', 401);
        }

        // Store the token in the Cookies, and set the Headers for the next request.
        return $next($request)->withCookie(cookie('jwt', $token))->header('Authorization', 'Bearer ' . $token);
    }
}
=======
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
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
