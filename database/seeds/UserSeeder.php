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
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
/**
 *  Livewire Users component
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
        $user1 = User::create(
            [
                'name'      => 'Stefan Monteiro',
                'email'     => 'stefanmonteiro@gmail.com',
                'password'  => Hash::make('stefan123'),
                'api_token' => bin2hex(openssl_random_pseudo_bytes(32)),
            ]
        );

        $role1 = Role::find(1);
        
        $user1->attachRole($role1);

        $contact11 = [
            'suite' => '31',
            'num' => '1166',
            'street' => 'Boul. Laird',
            'city' => 'Mont-Royal',
            'region' =>'Quebec',
            'country' => 'Canada',
            'pc' => 'H5R7Z3',
            'mobile' => '514-665-6463',
            'telephone' => '514-632-5214',
            'type' => 'primary',
        ];

        $contact12 = [
            'suite' => '25',
            'num' => '2266',
            'street' => 'Boul. Graham',
            'city' => 'Mont-Royal',
            'region' =>'Quebec',
            'country' => 'Canada',
            'pc' => 'H7R9Q5',
            'mobile' => '514-625-6684',
            'telephone' => '514-632-5744',
            'type' => 'emergency',
            'name' => 'Colette Perron',
            'relationship' => 'parent',
        ];
        
        $user1->contacts()->create($contact11);
        $user1->contacts()->create($contact12);
    }
}
