<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;
use PragmaRX\Countries\Package\Countries;

$factory->define(
    Contact::class, 
    function (Faker $faker) {
        $myCountry = "CAN";
        
        $countryCities = Countries::where('cca3', $myCountry)->first()
            ->hydrate('cities')
            ->cities
            ->pluck('nameascii')
            ->toArray();
        
        $myCity = $faker->randomElement($countryCities);
        
        $myRegion =  Countries::where('cca3', $myCountry)->first()
            ->hydrateCities()
            ->cities
            ->where('nameascii', $myCity)
            ->first()
            ->adm1name;
        
        return [
            'suite' => $faker->secondaryAddress,
            'num' => $faker->buildingNumber,
            'street' => $faker->streetSuffix.' '.$faker->streetName,
            'city' => $myCity,
            'region' => utf8_decode($myRegion),
            'country' => $myCountry,
            'pc' => trim($faker->postcode),
            'telephone' => $faker->phoneNumber,
            'mobile'  => $faker->phoneNumber,
            'email' =>$faker->companyEmail,
            'type' => 'primary',
        ];
    }
);
