<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class WelcomeController extends BaseController
{

    public function __construct()
    {
        //
    }

    public function welcome(Request $request){

        $jwtQuery = $this->setJwtQuery($request);

        return view('welcome')->with([
            'jwtQuery' => $jwtQuery
        ]);
    }

    public function adminWelcome(Request $request){

        $jwtQuery = $this->setJwtQuery($request);

        return view('admin_sub.welcome')->with([
            'jwtQuery' => $jwtQuery
        ]);
    }
}
