<?php

use App\Models\Loan;
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

$factory->define(\App\Models\Loan::class, function (Faker $faker) {
    return [
        'date' => now()->subDays(4),
        'end_date' => now()->addDays(10),
        'amount' => 1000,
        'debt' => 1200,
        'interest' => 20,
        'installment_number' => 12,
        'fee' => 100,
        'paid' => Loan::UNPAID,
        'status' => 0,
        'blocked' => 0,
        'glosa' => $faker->sentence,
        'type' => Loan::daily,
        'installment_dates' => "[]",
        'client_id' => null,
        'collection_id' => null,
        'created_by' => null,
        'updated_at_device' => $faker->unixTime,
        'created_at_device' => $faker->unixTime
    ];
});
