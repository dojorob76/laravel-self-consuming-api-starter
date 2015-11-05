<?php

namespace App\Services;

use Auth;
use Illuminate\Http\Response;
use App\Utilities\TokenManager;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class UserAuthentication
{

    use AuthenticatesAndRegistersUsers;

    protected $userRepo;
    protected $tokenManager;

    /**
     * Create a new User Authentication Service instance.
     *
     * @param UserRepositoryInterface $userRepo
     * @param TokenManager $tokenManager
     */
    public function __construct(UserRepositoryInterface $userRepo, TokenManager $tokenManager)
    {
        $this->userRepo = $userRepo;
        $this->tokenManager = $tokenManager;
    }

    /**
     *  Create a new user from a form request and generate a JWT to log them in.
     *
     * @param RegistrationRequest $request
     * @return JsonResponse|string (string = JWT, JsonResponse = JWT Error)
     */
    public function registerUserFromForm(RegistrationRequest $request)
    {
        // Create (register) a new User
        $user = $this->userRepo->createNewUser($request);

        // Attempt to log the new user in via JWT
        $jwt = $this->tokenManager->getJwtFromUser($user);

        return $this->authenticateUser($jwt);
    }

    /**
     * Log a user in through the app log in form using JWT
     *
     * @param LoginRequest $request
     * @param bool $ajax
     * @return array|JsonResponse|Response (string = JWT, JsonResponse = invalid credentials or JWT error)
     */
    public function loginUserFromForm(LoginRequest $request, $ajax = true)
    {
        // Check the user credentials with Laravel Auth
        if (Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();

            // Set the User's token key so that it corresponds with the current CSRF token
            $this->tokenManager->setUserTokenKey($user, $request->token_key);

            // Attempt to generate a JWT for the user
            $jwt = $this->tokenManager->getJwtFromUser($user);

            return $this->authenticateUser($jwt);
        }
        // If the user credentials could not be verified...
        if(! $ajax){
            // For the Laravel non-AJAX implementation, return a response instead of pure JSON
            return response(['error' => 'Invalid Credentials', 'message' => $this->getFailedLoginMessage()], 401);
        }

        return ['error' => 'Invalid Credentials', 'message' => $this->getFailedLoginMessage()];
    }

    /**
     * Set the JWT cookie and Authorization header and redirect the User (for Laravel non-AJAX implementations).
     *
     * @param $jwt (JWT)
     * @return Response (Redirect)
     */
    public function postLogin($jwt)
    {
        // Set a cookie with 'Http Only' set to false so that it can be read by JS
        $cookie = \Cookie::make('jwt', $jwt, 120, '/', env('SESSION_DOMAIN'), false, false);

        //return redirect('/')->header('Authorization', 'Bearer ' . $jwt)->withCookie($cookie);
        return redirect('/')->header('Authorization', 'Bearer ' . $jwt)->withCookie($cookie);
    }

    /**
     * Log a User out of the Laravel App, and invalidate their JWT.
     *
     * @param $user \App\User
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function logoutUser($user){
        // Get the JWT from the User
        $token = $this->tokenManager->getJwtFromUser($user);

        // Invalidate the JWT, and retrieve the removal cookie
        $invalidate = $this->tokenManager->removeToken($token);

        // Log the User out.
        \Auth::logout();

        // Return the JWT removal cookie
        return $invalidate;
    }

    /**
     * Check what was returned from the JWT generation attempt, and return the appropriate response.
     *
     * @param $jwt (JWT attempt response)
     * @return Response|JsonResponse
     */
    private function authenticateUser($jwt)
    {
        // If we received a JsonResponse, return the error
        if ($jwt instanceof JsonResponse) {
            return $jwt;
        }

        // Otherwise, log the User in, and return the JWT
        Auth::login($this->tokenManager->getUserFromToken($jwt));

        return response(['jwtoken' => $jwt], 200);
    }

}