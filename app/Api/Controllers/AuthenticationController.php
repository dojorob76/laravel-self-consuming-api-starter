<?php

namespace App\Api\Controllers;

use App\User;
use App\Utilities\TokenManager;
use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;

class AuthenticationController extends Controller
{
    use Helpers, AuthenticatesAndRegistersUsers;

    /**
     * Create a new Authentication Controller for the app API
     *
     * @param Guard $auth
     * @param TokenManager $tokenManager
     */
    public function __construct(Guard $auth, TokenManager $tokenManager)
    {
        $this->auth = $auth;
        $this->tokenManager = $tokenManager;
    }

    /**
     * Log a User in from the Login form, and return a JWT Token for authorized access.
     *
     * @param Request $request (Email and Password)
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Get the credentials from the request
        $credentials = $request->only('email', 'password');

        // Attempt to log the user in with Laravel Auth
        if($this->auth->attempt($credentials, $request->has( 'remember' ))){

            // Attempt to set a JWT Token on the User (will return JSON errors if unsuccessful)
            $token = $this->tokenManager->getJwtTokenFromUser(Auth::user());

            // Return any errors we may have encountered during token creation.
            if($token instanceof \Response){
                return $token;
            }

            // Otherwise, get the previous URL for redirect on success
            $return_to = $request->session()->previousUrl();

            // All is well. We can return the token, set the header, and store the cookie!
            return response()->json(['jwtoken' => $token, 'referredby' => $return_to])
                ->header('Authorization', 'Bearer ' . $token)
                ->withCookie(cookie('jwt', $token));
        }

        // The User could not be authenticated with the given credentials. Return an error.
        return response()->json(['error' => 'Invalid Credentials',
                                 'message' => $this->getFailedLoginMessage()], 422);

    }

    /**
     * Register a new user from the registration form and generate a new JWT token for them.
     *
     * @param Request $request
     * @return $this
     */
    public function register(Request $request)
    {
        // Validate the request
        $validation = $this->validator($request->all());

        if($validation->fails()){
            return response()->json(['error' => 'Could Not Complete Registration',
                                     'errors' => $validation->getMessageBag()]);
        }

        // Generate a Token Key for the User
        $token_key = $this->tokenManager->setTokenKey();

        // Create the new User
        $new_user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'token_key' => $token_key
        ]);

        // Attempt to set a JWT Token on the User (will return JSON errors if unsuccessful)
        $token = $this->tokenManager->getJwtTokenFromUser($new_user);

        // Return any errors we may have encountered during token creation.
        if($token instanceof \Response){
            return $token;
        }

        // Otherwise, get the previous URL for redirect on success
        $return_to = $request->session()->previousUrl();

        // All is well. We can return the token, set the header, and store the cookie!
        return response()->json(['jwtoken' => $token, 'referredby' => $return_to])
            ->header('Authorization', 'Bearer ' . $token)
            ->withCookie(cookie('jwt', $token));
    }

    public function logout()
    {
        return 'Success! You accessed the logout page, which is protected!';
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);
    }

}
