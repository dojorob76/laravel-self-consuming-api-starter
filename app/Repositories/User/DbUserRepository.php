<?php

namespace App\Repositories\User;

use App\User;

class DbUserRepository implements UserRepositoryInterface
{

    public function createNewUser($request)
    {
        $new_user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'token_key' => $request->token_key
        ]);

        return $new_user;
    }

    public function findById($id){
        $user = User::findOrFail($id);

        return $user;
    }

}