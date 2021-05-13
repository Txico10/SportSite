<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    $gender = $faker->randomElement(['M','F']);
    return [
        'name' => $faker->name($gender),
        'birthdate' => $faker->dateTimeBetween('1960-01-01', '1990-12-12'),
        //'nas' => $faker->randomNumber($nbDigits = 9, $strict = true),
        'gender' => $gender,
    ];
});
