<?php
/** 
 * Building seeder
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

use App\Models\Apartment;
use App\Models\Building;
use App\Models\Contact;
use App\Models\RealState;
use Illuminate\Database\Seeder;
/**
 *  Building seeder extend seeder
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $real_states = RealState::all();

        foreach ($real_states as $real_state) {
            
            $real_state->buildings()->saveMany(
                factory(Building::class, 4)->create(['real_state_id'=>$real_state->id])->each(
                    function ($building) { 
                        $building->contact()->save(factory(Contact::class)->make(['suite' => null]));
                    }
                )
            );

        }
    }
}
