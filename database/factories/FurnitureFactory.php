<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Furniture;
use App\Models\FurnitureType;
use Faker\Generator as Faker;

$factory->define(Furniture::class, function (Faker $faker) {
    $furnitureType = FurnitureType::pluck('id');
    $manufacturer = ['whirlpool', 'maytag', 'ge appliances', 'samsung', 'admiral'];
    return [
        'furniture_type_id' => $faker->randomElement($furnitureType),
        'manufacturer' => $faker->randomElement($manufacturer),
        'model' => $faker->bothify('???####??#'),
        'serial' => $faker->bothify('#??######?#'),
        'buy_at' => $faker->dateTimeBetween('-15 years', 'now'),
    ];
});
