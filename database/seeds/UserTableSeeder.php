<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //default admin
        $user = new \App\Models\User();
        $user->name = 'AdminName';
        $user->surname = 'AdminSurname';
        $user->username = 'admin';
        $user->password = Hash::make('password');
        $user->user_type = \App\Models\User::ADMIN;
        $user->save();

        //default manager
        $user = new \App\Models\User();
        $user->name = 'ManagerName';
        $user->surname = 'ManagerSurname';
        $user->username = 'manager';
        $user->password = Hash::make('password');
        $user->user_type = \App\Models\User::MANAGER;
        $user->save();

        //default user
        $user = new \App\Models\User();
        $user->name = 'WorkerName';
        $user->surname = 'WorkerSurname';
        $user->preferred_working_hours_per_day = 4;
        $user->username = 'worker';
        $user->password = Hash::make('password');
        $user->user_type = \App\Models\User::WORKER;
        $user->save();
    }
}
