<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    
    return 
    [
        'name' => $faker->name,
        'description' => $faker->word(),
        'price' => $faker->randomFloat(6, 0, 2),
        'quantity' => $faker->randomNumber(5),
        'cover' => $faker->imageUrl,
        'image' => $faker->imageUrl,
        'reference' => $faker->word(3) ."-". $faker->randomNumber(5),
        'slug' => $faker->slug(),
        'tax_id' => 1,
        'status_id' => 1,
        'product_type_id' => 1
    ];

});
