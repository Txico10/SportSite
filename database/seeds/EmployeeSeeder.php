<?php
/** 
 * Employee seeder
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
use App\Models\Employee;
use App\Models\RealState;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
/**
 *  Employee seeder extend seeder
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $real_estates = RealState::all();
        $roles = Role::whereNotIn('id', [1,5])->get();

        foreach ($real_estates as $real_estate) {
            
            //$team = Team::where('name', $real_estate->id)->first();
            

            factory(Employee::class, 5)->create()->each(
                function ($employee, $key) use ($real_estate, $roles) {
                    
                    $employee->contact()->save(factory(Contact::class)->make());

                    switch($key) {
                    case 0: 
                        $role = $roles[0]; 
                        break;
                    case 1:
                        $role = $roles[1];
                        break;
                    default:
                        $role = $roles[2];
                    }

                    $user = factory(User::class)->create(
                        [
                            'name'=> $employee->name,
                            'email' => $employee->contact->email,
                        ]
                    );
                    
                    $user->attachRole($role, $real_estate->id);

                    $real_estate->employees()->attach(
                        $employee->id,
                        [
                            'user_id' => $user->id,
                            'start_date' => Carbon::now()->addMonth(rand(-1, -12)),
                            'end_date' => Carbon::now()->addMonth(rand(12, 24)),
                            'status' => 'FT'
                        ]
                    );
                    //$this->command->info('Company:'.$real_estate->name.' Employee: '.$employee->name.' - '.$employee->gender.' created.');
                }
            );
        }
    }
}
