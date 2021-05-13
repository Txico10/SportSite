<?php

use App\Models\Employee;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Employee::all();
        $roles = Role::whereNotIn('id', [1,2,5])->get();
        $val = 0;
        foreach ($employees as $employee) {
            $employee->contacts()->save(factory(App\Models\Contact::class)->make());
            if ($val%5 == 0) {
                $role = $roles->first();
            } else {
                $role = $roles->last();
            }
            $val++;
            //$this->command->info('User '.$employee->pivot->user()->id);
            foreach ($employee->company as $myTest) {
                $myTest->pivot->user->attachRole($role);
            }
        }
    }
}
