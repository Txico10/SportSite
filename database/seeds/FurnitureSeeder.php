<?php
/** 
 * Furniture seeder
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

use App\Models\Furniture;
use App\Models\RealState;
use Illuminate\Database\Seeder;
/**
 *  Furniture seeder extend seeder
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class FurnitureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $real_estates = RealState::with('furnitureTypes')->get();

        foreach ($real_estates as $real_estate) {
            foreach ($real_estate->furnitureTypes as $furnitureType) {
                $furnitureType->furnitures()->createMany(
                    factory(Furniture::class, 5)->make()->toArray()
                );
            }
        }  
    }
}
