<?php


use Illuminate\Database\Seeder;

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
                LogsParameterSeeder::class, 
                UserSeeder::class, 
                ApartmentTypeSeeder::class,
                FurnitureTypeSeeder::class,
                RealStateSeeder::class,
                //FurnitureSeeder::class,
                BuildingSeeder::class,
                EmployeeSeeder::class,
            ]
        );
        

    }
}
