<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function createNewUser($request);

    public function findById($id);

}