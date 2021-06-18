<?php

use App\Models\FurnitureType;
use Illuminate\Database\Seeder;

class FurnitureTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $furnituresType = [
            [
                'type' => 'A',
                'description' => 'refrigerator',
            ],
            [
                'type' => 'A',
                'description' => 'freezer',
            ],
            [
                'type' => 'A',
                'description' => 'oven',
            ],
            [
                'type' => 'A',
                'description' => 'microwave',
            ],
            [
                'type' => 'A',
                'description' => 'washing machine',
            ],
            [
                'type' => 'A',
                'description' => 'dryer',
            ],
            [
                'type' => 'A',
                'description' => 'dishwasher',
            ],
        ];

        foreach ($furnituresType as $key => $value) {
            FurnitureType::create($value);
            $this->command->info('Type '.$value['description'].' created.');
        }
    }
}
