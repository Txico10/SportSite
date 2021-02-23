<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Building;
use Faker\Generator as Faker;

$factory->define(Building::class, function (Faker $faker) {
    $lot = "1";
    for ($i = 0 ; $i<2; $i++) {
        $lot1 = $faker->randomNumber($nbDigit = 3, $strict = true);
        $lot = $lot." ".$lot1;
    }
    return [
        'lot' => $lot,
        'description' => $faker->text(200),
    ];
});
