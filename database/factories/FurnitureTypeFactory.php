<?php
/** 
 * Apartment Type Factory
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

/** 
 * Factory
 * 
 * @var \Illuminate\Database\Eloquent\Factory $factory 
 * */

use App\Models\FurnitureType;
use Faker\Generator as Faker;

$factory->define(
    FurnitureType::class, 
    function (Faker $faker) {
        return [
            'type' =>'A',
        ];
    }
);
