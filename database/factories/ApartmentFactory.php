<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Apartment;
use App\Models\ApartmentType;
use Faker\Generator as Faker;
use Faker\Factory as LocalFaker;

$factory->define(Apartment::class, function (Faker $faker) {

    $apartmentType = ApartmentType::pluck('id');
    return [
        'apartment_type_id' => $faker->randomElement($apartmentType),
        'description' => $faker->paragraph(1),
        'number'=> $faker->unique(true)->numberBetween(1, 7),
    ];
});
