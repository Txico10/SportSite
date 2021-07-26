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

use App\Models\ApartmentType;
use App\Models\Contact;
use App\Models\FurnitureType;
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
                    
                    $apartmentsType = [
                        '1 1/2'=>'Un et demi', 
                        '2 1/2'=>'Deux et demi', 
                        '3 1/2'=>'Trois et demi',
                        '4 1/2'=>'Quatre et demi',
                        '5 1/2'=>'Cinque et demi',
                    ];

                    foreach ($apartmentsType as $tag => $name) {
                        $real_state->apartmentTypes()->save(
                            factory(ApartmentType::class)->make(
                                [
                                    'tag'=> $tag,
                                    'name'=>$name,
                                ]
                            )
                        );
                        $this->command->info('Apartment type '.$tag.' created.');
                    }

                    $furnituresType = [
                        'refrigerator',
                        'freezer',
                        'oven',
                        'microwave',
                        'washing machine',
                        'dryer',
                        'dishwasher'
                    ];

                    foreach ($furnituresType as $key => $value) {
                        $real_state->furnitureTypes()->save(
                            factory(FurnitureType::class)->make(
                                [
                                    'description'=>$value,
                                ]
                            )
                        );
                        $this->command->info('Furniture type '.$value.' created.');
                    }

                }
            );
    }
}
