<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use App\Models\RealState;
use Faker\Generator as Faker;
$factory->define(
    RealState::class, function (Faker $faker) {
        //$iprog = ['RT', 'RP', 'RC', 'RM', 'RZ'];
        $legal_form = ['Sole proprietorship', 'Business corporation', 'General partnership', 'Limited partnership', 'Cooperative'];
        $name = $faker->company;
        return [
            'name' => $name,
            'neq' => $faker->randomNumber($nbDigits = 9, $strict = true),
            //'iprog' => $faker->randomElement($iprog),
            //'numref' => $faker->randomNumber($nbDigits = 4, $strict = true),
            'legalform' => $faker->randomElement($legal_form),
            'slug'=>Str::of($name)->slug('-'),
            'logo' => 'defaultCompany.png',
        ];
    }
);
