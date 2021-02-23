<?php

use App\Models\Building;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $buildings = Building::all();

        foreach ($buildings as $key => $building) {
            $building->contact()->save(factory(App\Models\Contact::class)->make(['suite' => null]));
            $building->apartments()->saveMany(
                factory(App\Models\Apartment::class, 7)->make(),
            );
        }
    }
}
