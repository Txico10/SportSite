<?php

use App\Models\Apartment;
use App\Models\Building;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $buildings = Building::all();
        foreach ($buildings as $building) {
            $building->apartments()->saveMany(
                factory(Apartment::class, 7)->make()
            );
        }
    }
}
