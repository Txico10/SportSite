<?php

use App\Models\LogsParameter;
use Illuminate\Database\Seeder;

class LogsParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = ['assign', 'withdraw', 'reparation', 'communication'];
        $icons = ['assign' =>'fas fa-sign-in-alt', 'withdraw'=>'fas fa-sign-out-alt', 'reparation'=>'fas fa-hammer', 'communication'=> 'fas fa-comments'];

        foreach ($titles as $title) {
            LogsParameter::create(
                [
                    'title'=> $title,
                    'icon'=>$icons[$title],
                ]
            );
        }
    }
}
