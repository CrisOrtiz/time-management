<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'surname' => $faker->lastName,
        'identity_number' => '123123',
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'business' => $faker->name,
        'guarantor_name' => $faker->name,
        'guarantor_phone' => $faker->phoneNumber,
        'guarantor_address' => $faker->address,
        'latitude' => $faker->latitude(-99, 99),
        'longitude' => $faker->longitude(-99, 99),
        'assigned_to' => \App\Models\User::first()->id,
        'created_by' => \App\Models\User::first()->id
    ];
});
