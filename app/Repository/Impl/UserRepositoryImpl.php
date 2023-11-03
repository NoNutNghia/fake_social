<?php

namespace App\Repository\Impl;

use App\Enum\StatusUserEnum;
use App\Models\User;
use App\Repository\UserRepository;

class UserRepositoryImpl implements UserRepository
{

    private User $user;
    /**
     */
    public function __construct()
    {
        $this->user = new User();
    }

    public function getUserByEmail($email)
    {
        try {
            return $this->user->where('email', $email)->first();
        } catch (\Exception $e) {
            return false;
        }
    }
}
