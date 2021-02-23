<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RealStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $real_states = factory('App\Models\RealState', 25)
            ->create()
            ->each(
                function ($real_state) {
                    $real_state->contact()
                        ->save(factory(App\Models\Contact::class)->make());
                    
                    $real_state->buildings()->saveMany(
                        factory(App\Models\Building::class, 4)
                            ->make(),
                    );
                    for ($i=0; $i < 5; $i++) { 
                        $start_date = Carbon::now()->addMonth(rand(-1, -12))->format('Y-m-d');
                        $end_date = Carbon::now()->addMonth(rand(12, 24))->format('Y-m-d');
                        $real_state->employees()->attach(
                            factory(App\Models\Employee::class)->create()->id,
                            [
                                'user_id' => factory(App\Models\User::class)->create()->id,
                                'start_date' => $start_date,
                                'end_date' => $end_date,
                                'status' => 'FT'
                            ]
                        );
                    }
                }
            );
    }
}
