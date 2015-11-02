<?php

namespace App\Http\Controllers;

use Dingo\Api\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Services\UserAuthentication;
use App\Http\Requests\RegistrationRequest;

class AuthenticationController extends BaseController
{

    protected $userAuth;

    public function __construct(UserAuthentication $userAuth, Dispatcher $dispatcher)
    {
        $this->userAuth = $userAuth;
        $this->middleware('guest', ['only' => ['registerAjax', 'loginAjax']]);
        $this->domain = 'Main Domain';
        $this->ajaxAuth = true;
        parent::__construct($dispatcher);
    }

    /**
     * Display the Laravel App Registration Form for AJAX registration.
     *
     * @return \Illuminate\View\View
     */
    public function registerAjax()
    {
        return view('authentication/register')
            ->with(['ajaxAuth' => $this->ajaxAuth, 'domain' => $this->domain]);
    }

    /**
     * Display the Laravel App Log In Form for AJAX log in.
     *
     * @return \Illuminate\View\View
     */
    public function loginAjax()
    {
        return view('authentication/login')
            ->with(['ajaxAuth' => $this->ajaxAuth, 'domain' => $this->domain]);
    }

    /**
     * Create/register a new user through the registration form and attempt to log them in via JWT using AJAX.
     *
     * @param RegistrationRequest $request
     * @return JsonResponse|Response
     */
    public function formRegisterAjax(RegistrationRequest $request)
    {
        return $this->dispatcher->post('form-register', $request->all());
    }

    /**
     * Attempt to log a user in through the log in form via JWT using AJAX.
     *
     * @param LoginRequest $request
     * @return JsonResponse|Response
     */
    public function formLoginAjax(LoginRequest $request)
    {
        return $this->dispatcher->post('form-login', $request->all());
    }

    /**
     * Log a User out of the Laravel App.
     *
     * @param Request $request
     * @return $this Redirect w/ Cookie
     */
    public function logout(Request $request){
        $user = $request->user();

        // Log the User out, invalidate their JWT, and retrieve the JWT removal cookie
        $invalidate = $this->userAuth->logoutUser($user);

        return redirect()->back()->withCookie($invalidate);
    }
}
