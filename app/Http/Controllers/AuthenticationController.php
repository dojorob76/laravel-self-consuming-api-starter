<?php

namespace App\Http\Controllers;

use Dingo\Api\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\UserAuthentication;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Support\MessageBag;

class AuthenticationController extends BaseController
{

    protected $userAuth;

    public function __construct(UserAuthentication $userAuth, Dispatcher $dispatcher)
    {
        $this->userAuth = $userAuth;
        $this->middleware('guest', ['only' => ['register', 'login']]);
        parent::__construct($dispatcher);
    }

    /**
     * Display the Laravel App Registration Form.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        $ajaxAuth = false;

        return view('authentication/register')->with(['ajaxAuth' => $ajaxAuth]);
    }

    /**
     * Display the Laravel App Log In Form.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        $ajaxAuth = false;

        return view('authentication/login')->with(['ajaxAuth' => $ajaxAuth]);
    }

    /**
     * Display the Laravel App Registration Form for AJAX registration.
     *
     * @return \Illuminate\View\View
     */
    public function registerAjax()
    {
        $ajaxAuth = true;

        return view('authentication/register')->with(['ajaxAuth' => $ajaxAuth]);
    }

    /**
     * Display the Laravel App Log In Form for AJAX log in.
     *
     * @return \Illuminate\View\View
     */
    public function loginAjax()
    {
        $ajaxAuth = true;

        return view('authentication/login')->with(['ajaxAuth' => $ajaxAuth]);
    }

    /**
     * @param RegistrationRequest $request
     * @return JsonResponse|Response
     */
    public function formRegister(RegistrationRequest $request){
        $auth = $this->userAuth->registerUserFromForm($request);

        return $this->checkAuth($auth);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse|Response
     */
    public function formLogin(LoginRequest $request){
        $auth = $this->userAuth->loginUserFromForm($request, false);

        return $this->checkAuth($auth);
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

    /**
     * Check the results of the authorization attempt, and return the appropriate response.
     *
     * @param JsonResponse|Response $auth
     * @return JsonResponse|Response
     */
    private function checkAuth($auth)
    {
        $data = json_decode($auth->content());

        $response = '';

        if(isset($data->error)){
            // An error was returned, so let's send it back to the user
            $errors = new MessageBag([$data->error => [$data->message]]);
            $response = redirect()->back()->withErrors($errors);
        }
        elseif(isset($data->jwtoken)){
            // A JWT was returned, so let's use it to run the postLogin function
            $response = $this->userAuth->postLogin($data->jwtoken);
        }
        else{
            // Something is awry, so let's abort
            abort(501);
        }

        return $response;
    }
}
