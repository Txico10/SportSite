<?php

use App\Models\Apartment;
use App\Models\ApartmentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;


class ApartmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $apartmentTypes = [
            [
                'name' => 'Un et demi',
                'tag' => '1 1/2',
                'description' => 'Mon 1 1/2',
            ],
            [
                'name' => 'Deux et demi',
                'tag' => '2 1/2',
                'description' => 'Mon 1 1/2',
            ],
            [
                'name' => 'Trois et demi',
                'tag' => '3 1/2',
                'description' => 'Mon 3 1/2',
            ],
            [
                'name' => 'Quatre et demi',
                'tag' => '4 1/2',
                'description' => 'Mon 4 1/2',
            ],
            [
                'name' => 'Cinque et demi',
                'tag' => '5 1/2',
                'description' => 'Mon 5 1/2',
            ],
        ]
        ;
        
        foreach ($apartmentTypes as $key => $value) {
            ApartmentType::create($value);
            $this->command->info('Type '.$value['name'].' created.');
        }

    }
}
