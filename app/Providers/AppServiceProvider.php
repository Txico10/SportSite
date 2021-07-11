<?php
/** 
 * App service provider
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
/**
 *  AppServiceProvider Class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param Dispatcher $events listening event
     * 
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        //Database settings
        Schema::defaultStringLength(191);
            
        // Menu bilder
        $events->listen(
            BuildingMenu::class, function (BuildingMenu $event) {
                // Add some items to the menu...
                $companyID = DB::table('employee_contracts')
                    ->where('user_id', Auth::id())
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->value('real_state_id');
                //dd($company);
                $event->menu->add(
                    [
                        'header' => 'ADMIN MANAGEMENT',
                        'permission' => 'adminMenu-read'
                    ]
                );
                $event->menu->add(
                    [
                        'key' => 'role',
                        'text' => 'Roles',
                        'route'  => 'admin.role',
                        'icon' => 'fas fa-fw fa-briefcase',
                        'permission' => 'roles-read',
                    ],
                );
                $event->menu->addBefore(
                    'role', 
                    [
                        'key' => 'user',
                        'text' => 'Users',
                        'route'  => 'admin.users',
                        'icon' => 'fas fa-fw fa-users',
                        'permission' => 'users-read',
                        'label_color' => 'success',
                    ]
                );
                $event->menu->addAfter(
                    'role', 
                    [
                        'key' => 'enterprises',
                        'text' => 'Clients',
                        'route'  => 'admin.clients',
                        'icon' => 'fas fa-fw fa-list',
                        'permission' => 'company-read',
                    ]
                );
                if (!empty($companyID)) {
                    $event->menu->add(
                        [
                            'header' => 'REAL STATE MANAGEMENT', 'permission' => 'companyMenu-read',
                        ]
                    );
                    $event->menu->add(
                        [
                            'key' => 'real_state',
                            'text' => 'My Company',
                            'route'  => ['company.profile',["id" => $companyID]],
                            'icon' => 'fas fa-fw fa-info',
                            'permission' => 'company-read',
                        ],
                    );
                    $event->menu->add(
                        [
                            'key' => 'employees',
                            'text' => 'Employees',
                            'icon' => 'fas fa-fw fa-user-tie',
                            'permission' => 'employee-read',
                            'submenu' => [
                                [
                                    'text' => 'All Employees',
                                    'classes' => 'ml-4',
                                    'route'  => ['company.employees', ["id" => $companyID]],
                                    'icon' => 'fas fa-fw fa-users',
                                    'permission' => 'employee-read',
                                ],
                                [
                                    'text' => 'New Employee',
                                    'classes' => 'ml-4',
                                    'route'  => ['company.employees.create', ["id" => $companyID]],
                                    'icon' => 'fas fa-fw fa-user-plus',
                                    'permission' => 'employee-create',
                                ],
                            ]
                        ],
                    );
                    $event->menu->add(
                        [
                            'key' => 'buildings',
                            'text' => 'Buildings',
                            'route'  => ['company.buildings', ["id" => $companyID]],
                            'icon' => 'fas fa-fw fa-building',
                            'permission' => 'building-read',
                        ],
                    );
                    $event->menu->add(
                        [
                            'key' => 'apartments',
                            'text' => 'Apartments',
                            'route'  => ['company.apartments', ["id" => $companyID]],
                            'icon' => 'fas fa-fw fa-home',
                            'permission' => 'apartment-read',
                        ],
                    );
                    $event->menu->add(
                        [
                            'key' => 'furnitures',
                            'text' => 'Furnitures',
                            'route'  => ['company.furnitures', ["id" => $companyID]],
                            'icon' => 'fas fa-fw fa-chair',
                            'permission' => 'furniture-read',
                        ],
                    );
                    $event->menu->add(
                        [
                            'header' => 'LEASE MANAGEMENT', 
                            'permission' => 'leaseMenu-read'
                        ],
                    );
                    $event->menu->add(
                        [
                            'key' => 'tenats',
                            'text' => 'Tenants',
                            'url'  => '#',
                            'icon' => 'fas fa-fw fa-users',
                        ],
                    );
                    $event->menu->add(
                        [
                            'key' => 'bail',
                            'text' => 'Bail',
                            'url'  => '#',
                            'icon' => 'fas fa-fw fa-file-contract',
                        ],
                    );
                    $event->menu->add(
                        [
                            'key' => 'tickets',
                            'text' => 'Tickets',
                            'url'  => '#',
                            'icon' => 'fas fa-fw fa-ticket-alt',
                        ],
                    );
                    $event->menu->add(
                        [
                            'key' => 'payments',
                            'text' => 'Payments',
                            'url'  => '#',
                            'icon' => 'fas fa-fw fa-money-check-alt',
                        ],
                    );

                }
            }
        );
    }
}
