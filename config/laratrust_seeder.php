<?php
/** 
 * Laratrust Seed
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before 
     * running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadministrator' => [
            'profile' => 'c,r,u,d',
            'adminMenu'=> 'r',
            'users' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'allCompanies'=> 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'confugurationMenu'=>'r',
            'apartmentType'=>'c,r,u,d',
            'furnitureType'=>'c,r,u,d',
            'companyMenu' => 'r',
            'company' => 'c,r,u,d',
            'building' => 'c,r,u,d',
            'apartment' => 'c,r,u,d',
            'furniture' => 'c,r,u,d',
            'employee' => 'c,r,u,d',
            'leaseMenu' => 'c,r,u,d',
            'lease'=>'c,r,u,d',
            'tenant'=>'c,r,u,d',
            'payment'=>'c,r,u,d',
            'manteinanceMenu'=>'r',
            'ticket'=>'c,r,u,d',
            'communication'=> 'c,r,u,d',
        ],
        'administrator' => [
            'profile' => 'c,r,u,d',
            'adminMenu'=> 'r',
            'users' => 'r',
            'roles' => 'r',
            'permissions' => 'r',
            'confugurationMenu'=>'r',
            'apartmentType'=>'c,r,u,d',
            'furnitureType'=>'c,r,u,d',
            'companyMenu' => 'r',
            'company' => 'r,u',
            'building' => 'c,r,u,d',
            'apartment' => 'c,r,u,d',
            'furniture' => 'c,r,u,d',
            'employee' => 'c,r,u,d',
            'leaseMenu' => 'r',
            'lease'=>'c,r,u,d',
            'tenant'=>'c,r,u,d',
            'payment'=>'c,r,u,d',
            'manteinanceMenu'=>'r',
            'ticket'=>'c,r,u,d',
            'communication'=> 'c,r,u,d',
        ],
        'manager' => [
            'profile' => 'r,u',
            'companyMenu' => 'r',
            'company' => 'r,u',
            'building' => 'c,r,u,d',
            'apartment' => 'c,r,u,d',
            'furniture' => 'c,r,u,d',
            'employee' => 'c,r,u,d',
            'leaseMenu' => 'r',
            'lease'=>'c,r,u,d',
            'tenant'=>'c,r,u,d',
            'payment'=>'c,r,u,d',
            'manteinanceMenu'=>'r',
            'ticket'=>'c,r,u,d',
            'communication'=> 'c,r,u,d'
        ],
        'janitor' => [
            'profile' => 'r,u',
            'companyMenu' => 'r',
            'building' => 'r',
            'apartment' => 'r',
            'furniture' => 'c,r,u',
            'leaseMenu' => 'r',
            'lease'=>'r',
            'tenant'=>'r',
            'manteinanceMenu'=>'r',
            'ticket'=>'c,r,u,d',
            'communication'=> 'r'
        ],
        'tenant' => [
            'profile' => 'r,u',
            'leaseMenu' => 'r',
            'lease'=>'r',
            'payment'=>'c,r,u,d',
            'manteinanceMenu'=>'r',
            'ticket'=>'c,r,u,d',
            'communication'=> 'r'
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
