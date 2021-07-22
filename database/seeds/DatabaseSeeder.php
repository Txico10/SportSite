<?php
/** 
 * Database main seeder
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
use Illuminate\Database\Seeder;
/**
 *  Database main seeder extend seeder
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(
            [
                LaratrustSeeder::class,
                UserSeeder::class, 
                ApartmentTypeSeeder::class,
                FurnitureTypeSeeder::class,
                RealStateSeeder::class,
                FurnitureSeeder::class,
                BuildingSeeder::class,
                ApartmentSeeder::class,
                EmployeeSeeder::class,
            ]
        );
        

    }
}
