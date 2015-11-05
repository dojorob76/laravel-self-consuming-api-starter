<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use App\Http\Requests\LoginRequest;
use App\Services\UserAuthentication;
use App\Http\Controllers\BaseController;
use App\Http\Requests\RegistrationRequest;

class AuthenticationController extends BaseController
{

    protected $userAuth;

    public function __construct(UserAuthentication $userAuth)
    {
        $this->userAuth = $userAuth;
        $this->middleware('guest', ['only' => ['register', 'login']]);
        $this->domain = 'Admin Subdomain';
        $this->ajaxAuth = false;
    }

    /**
     * Display the Laravel App Registration Form.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('authentication/register')
            ->with(['ajaxAuth' => $this->ajaxAuth, 'domain' => $this->domain]);
    }

    /**
     * Display the Laravel App Log In Form.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('authentication/login')
            ->with(['ajaxAuth' => $this->ajaxAuth, 'domain' => $this->domain]);
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
