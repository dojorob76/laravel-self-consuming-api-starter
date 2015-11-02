<?php

namespace App\Http\Controllers;

use Dingo\Api\Dispatcher;
use Dingo\Api\Routing\Helpers;

class BaseController extends Controller
{

    use Helpers;

    protected $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Get the properly formatted (Dingo Dispatcher) request with JWT in the header.
     *
     * @param $path (route URL - relative, i.e., '/my-route')
     * @param $request \Illuminate\Http\Request
     * @return mixed Dingo dispatcher call with header
     */
    public function getRequestWithToken($path, $request)
    {
        $jwt = $this->setJwtHeader($request);

        $requested = $this->dispatcher->header('Authorization', $jwt)->get($path);

        return $requested;
    }

    /**
     * Get the JWT from the session cookie if it exists and format it in Authorization Header format.
     *
     * @param $request \Illuminate\Http\Request
     * @return null|string
     */
    public function setJwtHeader($request)
    {
        $token = $request->cookie('jwt');
        $jwt = ($token == null ? null : 'Bearer ' . $token);

        return $jwt;
    }

    /**
     * Get the JWT from the session cookie if it exists and return it in Query string format.
     *
     * @param $request \Illuminate\Http\Request
     * @return null|string
     */
    public function setJwtQuery($request){
        $token = $request->cookie('jwt');
        $jwt = ($token == null ? null : 'token=' . $token);

        return $jwt;
    }
}
