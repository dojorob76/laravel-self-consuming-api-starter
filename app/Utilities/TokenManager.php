<?php

namespace App\Utilities;

<<<<<<< HEAD
use App\User;
use Illuminate\Encryption\Encrypter;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;
=======
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Encryption\Encrypter;
use Tymon\JWTAuth\Exceptions\JWTException;
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7

class TokenManager
{

<<<<<<< HEAD
=======
    /**
     * Create a new Token Manager instance.
     *
     * @param Encrypter $encrypter
     * @param JWTAuth $auth
     */
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
    public function __construct(Encrypter $encrypter, JWTAuth $auth)
    {
        $this->encrypter = $encrypter;
        $this->auth = $auth;
    }

    /**
<<<<<<< HEAD
     * Get a JWT Token from a User and add the xsrfToken custom claim.
     *
     * @param $user User
     * @return \Illuminate\Http\JsonResponse|string (JWT Token or fail)
     */
    public function getJwtTokenFromUser($user)
=======
     * Get a JWT from a User and add the xsrfToken custom claim in the process.
     *
     * @param $user \App\User
     * @return \Illuminate\Http\JsonResponse|string (JWT or fail)
     */
    public function getJwtFromUser($user)
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
    {
        // Encrypt the User's token key (this is the current app CSRF key)
        $user_key = $this->encrypter->encrypt($user->token_key);

<<<<<<< HEAD
        // Set the encrypted token key as a custom claim (xsrfToken) on the JWT token.
        $xsrf = ['xsrfToken' => $user_key];

        try {
            // Attempt to generate a JWT auth token from the User with the xsrfToken attached.
=======
        // Set the encrypted token key as a custom claim (xsrfToken) on the JWT
        $xsrf = ['xsrfToken' => $user_key];

        try {
            // Attempt to generate a JWT from the User with the xsrfToken as custom claim
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
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
<<<<<<< HEAD
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
=======
     * Refresh the current CSRF Token, store it on the user, then generate and return a new JWT.
     *
     * @param $token (JWT)
     * @param $user \App\User
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function refreshUserToken($token, $user)
    {
        // Reset the current CSRF token
        \Session::regenerateToken();

        // Reset the user's token key to match current CSRF token
        $this->setUserTokenKey($user, csrf_token());

        // Invalidate original JWT
        $this->auth->invalidate($token);

        // Generate a new token for the user
        $refreshed = $this->getJwtFromUser($user);

        return $refreshed;
    }

    /**
     * Compare the current CSRF Token (stored on the user) with the encrypted version stored in the JWT.
     *
     * @param $token
     * @return bool (match = true, mismatch/unavailable keys = false)
     */
    public function compareTokenKeys($token, $user)
    {
        // Get the encrypted CSRF from the JWT
        $jwt_xsrf = $this->getJwtXsrf($token);

        // Get the User's token key
        $csrf = $user->token_key;

        // If either key is not available, we're done here
        if ($jwt_xsrf == null || $csrf == null) {
            return false;
        }

        // Decrypt the JWT xsrfToken
        $decrypted_jwt = $this->encrypter->decrypt($jwt_xsrf);

        // Compare the decrypted JWT key with the CSRF token stored on the user
        $tokens_match = ($decrypted_jwt === $csrf ? true : false);
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7

        return $tokens_match;
    }

    /**
<<<<<<< HEAD
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
=======
     * Set the user's token key so that it corresponds with the current CSRF token
     *
     * @param $user \App\User
     * @param $csrf (Current CSRF Token)
     */
    public function setUserTokenKey($user, $csrf)
    {
        // Update the User's token key to reflect current CSRF token
        $user->token_key = $csrf;
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
        $user->save();
    }

    /**
<<<<<<< HEAD
     * Get the encrypted JWT xsrfToken and the JWT user's token key for comparison.
     *
     * @param $token (JWT token)
     * @return array (user token key and jwt xsrfToken key)
     */
    private function getKeysForComparison($token)
=======
     * Attempt to get and return the user from the JWT, return error responses on failure.
     *
     * @param $token (JWT)
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response|\App\User
     */
    public function getUserFromToken($token)
    {
        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return response('Token Has Expired', $e->getStatusCode());
        } catch (JWTException $e) {
            return response('Token is Invalid', $e->getStatusCode());
        }

        if (!$user) {
            return response('User Not Found', 400);
        }

        return $user;
    }

    /**
     * Invalidate a JWT, then expire and return the cookie containing it.
     *
     * @param $token (JWT)
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function removeToken($token){
        // Invalidate the JWT
        $this->auth->invalidate($token);

        // Expire the JWT Cookie
        $expire = \Cookie::make('jwt', null, -2628000, '/', env('SESSION_DOMAIN'), false, false);

        return $expire;
    }

    /**
     * Get the encrypted JWT xsrfToken if it exists.
     *
     * @param $token (JWT)
     * @return mixed|null (JWT xsrfToken - null if non-existent)
     */
    private function getJwtXsrf($token)
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
    {
        // Get the JWT token payload
        $payload = $this->auth->getPayload($token);

        // Get the encrypted token key from the JWT payload if it exists
<<<<<<< HEAD
        $jwt_key = ($payload['xsrfToken'] ? $payload['xsrfToken'] : null);

        // Get the current CSRF token
        $csrf_key = csrf_token();

        $keys = ['jwt_key' => $jwt_key, 'csrf_key' => $csrf_key];

        return $keys;
=======
        $jwt_xsrf = ($payload['xsrfToken'] ? $payload['xsrfToken'] : null);

        return $jwt_xsrf;
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
    }
}