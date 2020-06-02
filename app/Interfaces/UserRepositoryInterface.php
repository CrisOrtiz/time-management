<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface {
    public function findByEmail($email): ?User;
    public function createUser($name, $surname, $email, $password, $userType, $country, $appCode): User;
}
