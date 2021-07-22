<?php
/** 
 * User seeder
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
use App\Models\Role;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Database\Seeder;

/**
 *  User seeder extend seeder
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create(
            [
                'name'      => 'Stefan Monteiro',
                'email'     => 'stefanmonteiro@gmail.com',
                'password'  => bcrypt('stefan123'),
            ]
        );

        $user->contact()->save(factory(Contact::class)->make());
        
        $role = Role::where('name', 'superadministrator')->first();
        
        $user->attachRole($role);
    }
}
