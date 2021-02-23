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
            'users' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'company' => 'c,r,u,d',
            'building' => 'c,r,u,d',
            'apartment' => 'c,r,u,d',
            'furniture' => 'c,r,u,d',
            'employee' => 'c,r,u,d',
            'client' => 'c,r,u,d',
            'adminMenu' => 'r',
            'companyMenu' => 'r',
            'leaseMenu' => 'r',
        ],
        'administrator' => [
            'users' => 'c,r,u,d',
            'roles' => 'r',
            'permissions' => 'r',
            'company' => 'c,r,u,d',
            'building' => 'r,u',
            'apartment' => 'r,u',
            'furniture' => 'r,u',
            'employee' => 'c,r,u,d',
            'adminMenu' => 'r',
            'companyMenu' => 'r',
            'leaseMenu' => 'r',
        ],
        'manager' => [
            'users' => 'r',
            'company' => 'c,r,u,d',
            'building' => 'c,r,u,d',
            'apartment' => 'c,r,u,d',
            'furniture' => 'c,r,u,d',
            'employee' => 'c,r,u,d',
            'leaseMenu' => 'r',
            'companyMenu' => 'r'
        ],
        'janitor' => [
            'building' => 'r',
            'apartment' => 'r',
            'furniture' => 'c,r,u,d',
            'leaseMenu' => 'r',
            'companyMenu' => 'r',
        ],
        'tenant' => [
            'profile' => 'r,u',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
