<?php

namespace App\Utilities;


use Illuminate\Encryption\Encrypter;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class TokenManager {

    public function __construct(Encrypter $encrypter, JWTAuth $auth)
    {
        $this->encrypter = $encrypter;
        $this->auth = $auth;
    }

    /**
     * Get a JWT Token from a User.
     *
     * @param $user
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function getJwtTokenFromUser($user){
        // Encrypt the User's token key
        $user_key = $this->encrypter->encrypt($user->token_key);
        // Set the encrypted token key as a custom claim (xsrfToken) on the JWT token.
        $xsrf = ['xsrfToken' => $user_key];

        try{
            // Attempt to generate a JWT auth token from the User with the xsrfToken attached.
            if(! $token = $this->auth->fromUser($user, $xsrf)){
                return response()->json(['error' => 'Could Not Generate Token From User'], 401);
            }
        }
        catch(JWTException $e){
            // Something went wrong when attempting to encode the token
            return response()->json(['error' => 'Could Not Create Token'], 500);
        }

        return $token;
    }

    /**
     * Set random Token Key for a User, which will be compared with JWT custom claims for security.
     *
     * @return string
     */
    public function setTokenKey(){
        $length = rand(17, 43);
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $key = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++ $i) {
            $key .= $keyspace[rand(0, $max)];
        }

        return $key;
    }
}