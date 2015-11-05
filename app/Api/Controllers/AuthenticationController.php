<?php

namespace App\Api\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\UserAuthentication;
use App\Http\Controllers\BaseController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;

class AuthenticationController extends BaseController
{

    protected $userAuth;

    public function __construct(UserAuthentication $userAuth)
    {
        $this->userAuth = $userAuth;
    }

    /**
     * Create/register a new user through the registration form and attempt to log them in via JWT.
     *
     * @param RegistrationRequest $request
     * @return JsonResponse|Response
     */
    public function formRegister(RegistrationRequest $request)
    {
        return $this->userAuth->registerUserFromForm($request);
    }

    /**
     * Attempt to log a user in through the log in form via JWT.
     *
     * @param LoginRequest $request
     * @return JsonResponse|Response
     */
    public function formLogin(LoginRequest $request)
    {
        //return response()->json($this->userAuth->loginUserFromForm($request));
        return $this->userAuth->loginUserFromForm($request);
    }

}
