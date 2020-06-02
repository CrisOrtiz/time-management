<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\UserAppData;

class EloquentUserRepository implements UserRepositoryInterface
{
    private $user;

    private $userAppData;

    public function __construct(User $user, UserAppData $userAppData)
    {
        $this->user = $user;
        $this->userAppData = $userAppData;
    }

    public function createUser($name, $surname, $email, $password, $userType, $country, $appCode): User
    {
        $user = new $this->user();
        $user->name = $name;
        $user->surname = $surname;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->user_type = $userType;
        $user->country = $country;
        $user->save();

        $user->setupAppData();

        return $user;
    }

    public function findByEmail($email): ?User
    {
        return $this->user->where('email', $email)->first();
    }
}
