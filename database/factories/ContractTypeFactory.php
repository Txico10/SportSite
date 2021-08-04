<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ContractType;
use Faker\Generator as Faker;

$factory->define(ContractType::class, function (Faker $faker) {
    return [
        'tag' => '',
        'name' => '',
        //'description' => ''
    ];
});
