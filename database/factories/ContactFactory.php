<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;
use PragmaRX\Countries\Package\Countries as Countries;

$factory->define(
    Contact::class, 
    function (Faker $faker, Countries $countries) {
        return [
            'suite' => $faker->secondaryAddress,
            'num' => $faker->buildingNumber,
            'street' => $faker->streetSuffix.' '.$faker->streetName,
            'city' => $faker->city,
            'region' => 'Quebec',
            'country' => 'CAN',
            'pc' => $faker->postcode,
            'telephone' => $faker->phoneNumber,
            'mobile'  => $faker->phoneNumber,
            'email' =>$faker->companyEmail,
            'type' => 'primary',
        ];
    }
);
