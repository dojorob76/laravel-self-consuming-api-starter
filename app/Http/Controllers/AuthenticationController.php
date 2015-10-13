<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{

    /**
     * Instantiate the non-api Authentication Controller
     */
    public function __construct()
    {
    }

    public function register(){
        return view('auth.register');
    }
}
