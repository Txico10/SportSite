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
                UserSeeder::class, 
                ApartmentTypeSeeder::class,
                RealStateSeeder::class,
                BuildingSeeder::class,
                EmployeeSeeder::class,
            ]
        );
        

    }
}
