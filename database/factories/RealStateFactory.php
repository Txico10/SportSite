<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\RealState;
use Faker\Generator as Faker;
$factory->define(
    RealState::class, function (Faker $faker) {
        //$iprog = ['RT', 'RP', 'RC', 'RM', 'RZ'];
        $legal_form = ['Sole proprietorship', 'Business corporation', 'General partnership', 'Limited partnership', 'Cooperative'];
        return [
            'name' => $faker->company,
            'neq' => $faker->randomNumber($nbDigits = 9, $strict = true),
            //'iprog' => $faker->randomElement($iprog),
            //'numref' => $faker->randomNumber($nbDigits = 4, $strict = true),
            'legalform' => $faker->randomElement($legal_form),
            'logo' => 'defaultCompany.png',
        ];
    }
);
