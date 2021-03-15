<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;
use Faker\Factory as LocalFaker;

$factory->define(
    Contact::class, 
    function (Faker $faker) {
        //$localizedFaker = LocalFaker::create("en_CA");
        return [
            'suite' => $faker->secondaryAddress,
            'num' => $faker->buildingNumber,
            'street' => $faker->streetSuffix.' '.$faker->streetName,
            'city' => $faker->city,
            'region' => $faker->province,
            //'region' => 'Quebec',
            'country' => 'CAN',
            'pc' => $faker->postcode,
            'telephone' => $faker->phoneNumber,
            'mobile'  => $faker->phoneNumber,
            'email' =>$faker->companyEmail,
            'type' => 'primary',
        ];
    }
);
