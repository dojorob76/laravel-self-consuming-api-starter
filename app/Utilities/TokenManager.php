<?php

namespace App\Utilities;

use App\User;
use Illuminate\Encryption\Encrypter;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class TokenManager
{

    public function __construct(Encrypter $encrypter, JWTAuth $auth)
    {
        $this->encrypter = $encrypter;
        $this->auth = $auth;
    }

    /**
     * Get a JWT Token from a User and add the xsrfToken custom claim.
     *
     * @param $user User
     * @return \Illuminate\Http\JsonResponse|string (JWT Token or fail)
     */
    public function getJwtTokenFromUser($user)
    {
        // Encrypt the User's token key (this is the current app CSRF key)
        $user_key = $this->encrypter->encrypt($user->token_key);

        // Set the encrypted token key as a custom claim (xsrfToken) on the JWT token.
        $xsrf = ['xsrfToken' => $user_key];

        try {
            // Attempt to generate a JWT auth token from the User with the xsrfToken attached.
            if (!$token = $this->auth->fromUser($user, $xsrf)) {
                return response()->json(['error' => 'Could Not Generate Token From User'], 401);
            }
        } catch (JWTException $e) {
            // Something went wrong when attempting to encode the token
            return response()->json(['error' => 'Could Not Create Token'], 500);
        }

        return $token;
    }

    /**
     * @param $token (JWT token)
     * @return bool|null (match = true, mismatch = false, null if either key is not available)
     */
    public function compareTokenKeys($token)
    {
        // Get the encrypted key from the JWT Token and the current app CSRF token
        $keys = $this->getKeysForComparison($token);

        $jwt_key = $keys['jwt_key'];
        $csrf_key = $keys['csrf_key'];

        // If either key is not available, we're done here.
        if ($jwt_key == null || $csrf_key == null) {
            return null;
        }

        // Decrypt the JWT xsrfToken
        $decrypted_jwt = $this->encrypter->decrypt($jwt_key);

        // Compare the decrypted JWT key with the CSRF token
        $tokens_match = ($decrypted_jwt === $csrf_key ? true : false);

        return $tokens_match;
    }

    /**
     * Reset the User's token key so that it corresponds with the current CSRF token
     *
     * @param $user User
     * @param $request \Illuminate\Http\Request
     */
    public function resetUserTokenKey($user, $request)
    {
        // Get the current CSRF Token returned from the log in form
        $token_key = $request->token_key;

        // Update the User's token key to reflect current CSRF token
        $user->token_key = $token_key;
        $user->save();
    }

    /**
     * Get the encrypted JWT xsrfToken and the JWT user's token key for comparison.
     *
     * @param $token (JWT token)
     * @return array (user token key and jwt xsrfToken key)
     */
    private function getKeysForComparison($token)
    {
        // Get the JWT token payload
        $payload = $this->auth->getPayload($token);

        // Get the encrypted token key from the JWT payload if it exists
        $jwt_key = ($payload['xsrfToken'] ? $payload['xsrfToken'] : null);

        // Get the current CSRF token
        $csrf_key = csrf_token();

        $keys = ['jwt_key' => $jwt_key, 'csrf_key' => $csrf_key];

        return $keys;
    }
}