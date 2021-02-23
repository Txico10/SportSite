<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;

$factory->define(
    Contact::class, 
    function (Faker $faker) {
        return [
            'suite' => $faker->secondaryAddress,
            'num' => $faker->buildingNumber,
            'street' => $faker->streetSuffix.' '.$faker->streetName,
            'city' => $faker->city,
            'region' => 'Quebec',
            'country' => 'Canada',
            'pc' => $faker->postcode,
            'telephone' => $faker->phoneNumber,
            'mobile'  => $faker->phoneNumber,
            'email' =>$faker->companyEmail,
            'type' => 'primary',
        ];
    }
);
