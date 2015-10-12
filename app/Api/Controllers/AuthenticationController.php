<?php

namespace App\Api\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class AuthenticationController extends Controller
{
    use Helpers, AuthenticatesAndRegistersUsers;

    public function __construct(Guard $guard, JWTAuth $auth)
    {
        $this->guard = $guard;
        $this->auth = $auth;
    }

    public function login(Request $request)
    {
        // Get the credentials from the request
        $credentials = $request->only('email', 'password');

        if($this->guard->attempt($credentials, $request->has( 'remember' ))){
            $user = Auth::user();

            try{
                if(! $token = $this->auth->fromUser($user)){
                    return response()->json(['error' => 'Could Not Generate Token From User'], 401);
                }
            }
            catch(JWTException $e){
                // Something went wrong when attempting to encode the token
                return response()->json(['error' => 'Could Not Create Token'], 500);
            }

            // Get the previous URL for redirect on success
            $return_to = $request->session()->previousUrl();

            // All is well. Let's return the token!
            return response()->json(['jwttoken' => $token, 'referredby' => $return_to])->header('Authorization',
                'Bearer ' . $token)->withCookie(cookie('jwt', $token));
        }

        return response()->json(['error' => 'Invalid Credentials', 'message' => $this->getFailedLoginMessage()], 422);

    }

    public function register(Request $request)
    {
        // Get the previous URL for redirect on success
        $return_to = $request->session()->previousUrl();

        return ['baz' => 'bar', 'bar' => 'foo'];
    }

    public function logout()
    {
        return 'Success! You accessed the logout page, which is protected!';
    }
}
