<?php
/** 
 * Employee Factory
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

use App\Models\Employee;
use Faker\Generator as Faker;

$factory->define(
    Employee::class, 
    function (Faker $faker) {
        $gender = $faker->randomElement(['male','female']);
        $my_gender = ['male'=>'M', 'female'=>'F'];
        return [
            'name' => $faker->name($gender),
            'birthdate' => $faker->dateTimeBetween('1960-01-01', '1990-12-12'),
            'nas' => $faker->randomNumber($nbDigits = 9, $strict = true),
            'gender' => $my_gender[$gender],
        ];
    }
);
