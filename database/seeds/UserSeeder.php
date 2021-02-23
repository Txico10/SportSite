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
                'api_token' => bin2hex(openssl_random_pseudo_bytes(16)),
            ]
        );

        $user2 = User::create(
            [
                'name'      => 'Danize Rosa',
                'email'     => 'danise.rosa@gmail.com',
                'password'  => Hash::make('danize123'),
                'api_token' => bin2hex(openssl_random_pseudo_bytes(16)),
            ]
        );

        $user3 = User::create(
            [
                'name'      => 'Ismael Monteiro',
                'email'     => 'ismael.monteiro@gmail.com',
                'password'  => Hash::make('ismael123'),
                'api_token' => bin2hex(openssl_random_pseudo_bytes(16)),
            ]
        );

        $role1 = Role::find(1);
        $role2 = Role::find(2);
        $role3 = Role::find(3);

        $user1->attachRole($role1);
        $user2->attachRole($role2);
        $user3->attachRole($role3);

        $contact11 = [
            'suite' => '31',
            'num' => '1166',
            'street' => 'Boul. Laird',
            'city' => 'Mont-Royal',
            'region' =>'Quebec',
            'country' => 'Canada',
            'pc' => 'H3R 1Z2',
            'mobile' => '514-625-6663',
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
            'pc' => 'H3R 1Q2',
            'mobile' => '514-625-6684',
            'telephone' => '514-632-5744',
            'type' => 'emergency',
            'name' => 'Colette Geerts',
            'relationship' => 'parent',
        ];

        $contact21 = [
            'suite' => '25',
            'num' => '2266',
            'street' => 'Boul. Graham',
            'city' => 'Mont-Royal',
            'region' =>'Quebec',
            'country' => 'Canada',
            'pc' => 'H3R 1Q2',
            'mobile' => '514-625-6684',
            'telephone' => '514-632-5744',
            'type' => 'primary',
        ];

        $contact31 = [
            'suite' => '15',
            'num' => '2565',
            'street' => 'Boul. Laird',
            'city' => 'Mont-Royal',
            'region' =>'Quebec',
            'country' => 'Canada',
            'pc' => 'H3R 1Z2',
            'mobile' => '514-550-5621',
            'telephone' => '514-522-5214',
            'type' => 'primary',
        ];

        $user1->contacts()->create($contact11);
        $user1->contacts()->create($contact12);
        $user2->contacts()->create($contact21);
        $user3->contacts()->create($contact31);

    }
}
