<?php
/** 
 * Real Estate seeder
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

use App\Models\Contact;
use App\Models\RealState;
use App\Models\Team;

use Illuminate\Database\Seeder;
/**
 *  Real Estate seeder extend seeder
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class RealStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(RealState::class, 20)->create()
            ->each(
                function ($real_state) {
                    
                    $team = Team::create(
                        [
                            'name'=> strval($real_state->id), 
                            'display_name'=> $real_state->name
                        ]
                    );

                    $real_state->contact()->save(factory(Contact::class)->make());
                    
                }
            );
    }
}
