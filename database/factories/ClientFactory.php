<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber(),
        'email' => $faker->safeEmail,
        'address' => $faker->address(),
        'zip_code' => rand(1000,9000) . '-' . str_pad(rand(0,999), 3, '0', STR_PAD_LEFT),
        'city' => $faker->city(),
        'vat' => str_pad(rand(1,999999999), 9, '0', STR_PAD_LEFT)
    ];
});
