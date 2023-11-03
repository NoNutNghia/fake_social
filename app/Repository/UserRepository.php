<?php

namespace App\Repository;

interface UserRepository
{
    public function getUserByEmail($email);
}
